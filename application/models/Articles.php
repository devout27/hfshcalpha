<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Articles extends CI_Model {

	function __construct(){
		$this->data['player_id'] = $this->session->userdata('players_id');
	}

	function get_article($id){
		return $this->db->query("SELECT * FROM articles WHERE articles_id=?", array($id))->row_array();
	}

	function save_article($id, $post){
		$this->load->model('privileges');
		$article = self::get_article($id);

		//first, check if this article is locked & user has privs
		$privileges = $this->privileges->get();

		if($article['articles_locked'] == 1){
			$errors['articles_locked'] = "Article is locked and cannot be edited.";
		}
		if($article['articles_admin'] == 1 AND !$privileges['privileges_articles']){
			$errors['articles_admin'] = "Article may only be edited by admins.";
		}
		if($article['join_id'] AND in_array($article['articles_type'], array('Business', 'Association', 'Club'))){
			//check if player owns this CAB. If not, error!
			$cab = $this->db->query("SELECT * FROM cabs WHERE cab_id=? AND cabs_disabled=0", array($article['join_id']))->row_array();
			if($this->data['players_id'] != $cab['join_players_id']){
				$errors['articles_owner'] = "You do not own this content and may not edit it.";
			}
		}

		if(count($errors) > 0){
			return array('errors' => $errors, 'bank_id' => $check['bank_checks_to_id']);
		}
		//save it
		$post['articles_content'] = $this->security->xss_clean($post['articles_content']);
		$this->db->query("UPDATE articles SET articles_content=? WHERE articles_id=? LIMIT 1", array($post['articles_content'], $id));

		//return the good news
		return array('errors' => $errors, 'notice' => 'Edited!');
	}


	function get_articles(){
		//get pages (not CAB pages)
		return $this->db->query("SELECT * FROM articles WHERE articles_type='Admin' AND articles_id!=1")->result_array();
	}

	function delete_article($id){
		$this->db->query("DELETE FROM articles WHERE articles_type='Admin' AND articles_id=? AND articles_id!=1", array($id));
		return array('errors' => $errors, 'notice' => 'Article deleted.');
	}

	public function create($data){
		$CI =& get_instance();

		$exists = $CI->db->query("SELECT articles_id FROM articles WHERE articles_name=? AND articles_type='Admin' LIMIT 1", array(trim($data['articles_name'])))->result_array();
		if(count($exists) > 0){
			$errors['articles_name'] = "There is already an article with this title.";
		}
		if(count(trim($data['articles_name'])) < 1){
			$errors['articles_name'] = "Please provide a name for this article.";
		}


		if(count($errors) > 0){
			return array('errors' => $errors);
		}

		$data['articles_content'] = $CI->security->xss_clean($data['articles_content']);

		$CI->db->query("INSERT INTO articles(articles_name, articles_content, articles_type) VALUES(?, ?, 'Admin')", array($data['articles_name'], $data['articles_content']));
		$article_id = $CI->db->insert_id();

		return array('errors' => $errors, 'notice' => 'Your article has been saved.', 'article_id' => $article_id);
	}
}
