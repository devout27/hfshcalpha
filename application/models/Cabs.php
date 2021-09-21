<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cabs extends CI_Model {

	function __construct($cabs_id = NULL){
		$this->data['player_id'] = $this->session->userdata('players_id');
		if($cabs_id){
			$this->cabs = $this->db->query('SELECT
				c.*, p.players_nickname, DATE_FORMAT(p.players_last_active, "%M %D, %Y at %l:%i %p") AS players_last_active
				FROM cabs c
				LEFT JOIN players p ON p.players_id=c.join_players_id
				WHERE c.cabs_id = ? LIMIT 1
			', array($cabs_id))->row_array();
			$this->cabs['events'] = $this->db->query("SELECT * FROM events WHERE join_cabs_id=?", $this->cabs['cabs_id'])->result_array();
			foreach((array)$this->cabs['events'] AS $k => $v){
				if($v['events_pending'] == 0){
					$this->cabs['events'][$k]['events_status_english'] = "Confirmed";
				}elseif($v['events_pending'] == 1){
					$this->cabs['events'][$k]['events_status_english'] = "Planning";
				}elseif($v['events_pending'] == 2){
					$this->cabs['events'][$k]['events_status_english'] = "Pending";
				}elseif($v['events_pending'] == -1){
					$this->cabs['events'][$k]['events_status_english'] = "Run";
				}
				$this->cabs['events'][$k]['cabs_name'] = $this->cabs['cabs_name'];
			}
		}
	}


	function get($params = NULL){
		return $this->db->query("SELECT * FROM cabs WHERE cabs_id=?", array($id))->row_array();
	}

	function get_all($params = NULL){
		if($params['cabs_type']){
			$cabs = $this->db->query("SELECT * FROM cabs WHERE cabs_pending=0 AND cabs_disabled=0 AND cabs_type='Association' ORDER BY cabs_type ASC, cabs_name ASC")->result_array();
		}else{
			$cabs = $this->db->query("SELECT * FROM cabs WHERE cabs_pending=0 AND cabs_disabled=0 ORDER BY cabs_type ASC, cabs_name ASC")->result_array();
		}
		//pre($cabs);exit;

		//normalize
		if($params['normalize']){
			foreach((array)$cabs AS $cab){
				$cabs2[$cab['cabs_id']] = $cab['cabs_type'] . ': ' . $cab['cabs_name'];
			}
			$cabs = $cabs2;
			unset($cabs2);
		}
		return $cabs;
	}

	function save($player, $cab, $data){
		$this->load->model('privileges');
		$this->data['privileges'] = $this->privileges->get();
		if($cab['cabs_disabled'] == 1){
			$errors['cabs_disabled'] = "CAB is disabled and cannot be edited.";
		}
		if($cab['cabs_pending'] == 1){
			$errors['cabs_pending'] = "CAB is pending and cannot be edited.";
		}
		if($cab['join_players_id'] != $player['players_id'] AND !$this->data['privileges']['privileges_cabs']){
			$errors['cabs_owner'] = "You do not own this CAB and may not edit it.";
		}

		if(count($errors) > 0){
			return array('errors' => $errors);
		}
		//save it
		$data['cabs_content'] = $this->security->xss_clean($data['cabs_content']);
		$this->db->query("UPDATE cabs SET cabs_content=? WHERE cabs_id=? LIMIT 1", array($data['cabs_content'], $cab['cabs_id']));

		//return the good news
		return array('errors' => $errors, 'notice' => 'CAB edited.');
	}




	public static function admin_get_pending(){
		$CI =& get_instance();
		return $CI->db->query("SELECT c.*, p.players_nickname FROM cabs c LEFT JOIN players p ON p.players_id=c.join_players_id  WHERE c.cabs_pending=1 ORDER BY c.cabs_id ASC")->result_array();
	}


	public static function admin_enable($id){
		$CI =& get_instance();
		$cab = $CI->db->query("SELECT * FROM cabs WHERE cabs_id=?", array($id))->row_array();
		$notice = "Your CAB has been enabled.";
		$CI->db->query("INSERT INTO notices(notices_body, join_players_id) VALUES(?,?)", array($notice, $cab['join_players_id']));
		$CI->db->query("UPDATE cabs SET cabs_disabled=0 WHERE cabs_id=?", array($id));
		return true;
	}

	public static function admin_disable($id){
		$CI =& get_instance();
		$cab = $CI->db->query("SELECT * FROM cabs WHERE cabs_id=?", array($id))->row_array();
		$notice = "Your CAB has been disabled.";
		$CI->db->query("INSERT INTO notices(notices_body, join_players_id) VALUES(?,?)", array($notice, $cab['join_players_id']));
		$CI->db->query("UPDATE cabs SET cabs_disabled=1 WHERE cabs_id=?", array($id));
		return true;
	}

	public static function admin_accept($data){
		$CI =& get_instance();
		$cab = $CI->db->query("SELECT * FROM cabs WHERE cabs_id=?", array($data['cabs_id']))->row_array();
		$notice = "Your CAB has been accepted.";
		$CI->db->query("INSERT INTO notices(notices_body, join_players_id) VALUES(?,?)", array($notice, $cab['join_players_id']));
		$CI->db->query("UPDATE cabs SET cabs_pending=0 WHERE cabs_id=?", array($data['cabs_id']));
		return true;
	}

	public static function admin_reject($data){
		$CI =& get_instance();
		$cab = $CI->db->query("SELECT * FROM cabs WHERE cabs_id=?", array($data['cabs_id']))->row_array();
		$notice = "Your CAB has been rejected.";
		$CI->db->query("INSERT INTO notices(notices_body, join_players_id) VALUES(?,?)", array($notice, $cab['join_players_id']));
		$CI->db->query("DELETE FROM cabs WHERE cabs_id=? AND cabs_pending=1 LIMIT 1", array($data['cabs_id']));
		return true;
	}


	public static function create($player, $data){
		$CI =& get_instance(); //allow us to use the db...
		if(!in_array($data['cabs_type'], array('Business', 'Association', 'Club'))){
			$errors['cabs_type'] = "Invalid CAB type.";
		}
		if(!trim($data['cabs_name'])){
			$errors['cabs_name'] = "A name is required.";
		}

		if(count($errors) > 0){
			return array('errors' => $errors);
		}

		//save it
		$data['join_players_id'] = $player['players_id'];
		$data['cabs_name'] = $CI->security->xss_clean($data['cabs_name']);
		$data['cabs_content'] = "This is a brand new CAB. Please allow the owner time to put up a page :)";
		$data['cabs_pending'] = 1;
		$allowed_fields = array(
			'join_players_id',
			'cabs_name',
			'cabs_type',
			'cabs_content',
			'cabs_pending',
		);
		$create_data = filter_keys($data, $allowed_fields);
		$CI->db->query("INSERT INTO cabs(join_players_id, cabs_name, cabs_type, cabs_content, cabs_pending) VALUES(?, ?, ?, ?, ?)", $create_data);

		//return the good news
		return array('errors' => $errors, 'notice' => 'CAB is now pending.');
	}

	public static function search($player, $data = NULL){
		$CI =& get_instance(); //allow us to use the db...
		$selects = $joins = $wheres = $params = array();

		//pre($data);exit;

        $selects = array(
            'c.*',
            'p.players_nickname',
        );

        $joins[] = 'LEFT JOIN players p ON p.players_id=c.join_players_id';

		//---------- WHERES --------------
		if($data['cabs_id']){
			$wheres [] = "cabs_id=?";
			$params [] = $data['cabs_id'];
		}
		if($data['cabs_owner']){
			if((int)$data['cabs_owner'] > 0){
				$wheres [] = "join_players_id=?";
				$params [] = $data['cabs_owner'];
			}else{
				$wheres [] = "players_nickname LIKE ?";
				$params [] = '%' . $data['cabs_owner'] . '%';
			}
		}
		if($data['cabs_name']){
			$wheres [] = "cabs_name LIKE ?";
			$params [] = '%' . $data['cabs_name'] . '%';
		}
		if($data['cabs_type']){
			$wheres []= "cabs_type=?";
			$params []= $data['cabs_type'];
		}
		if($data['cabs_type2']){
			$count = 0;

			if($data['cabs_type2']['business']){
				$params [] = 'Business';
				$count++;
			}
			if($data['cabs_type2']['club']){
				$params [] = 'Club';
				$count++;
			}
			if($data['cabs_type2']['association']){
				$params [] = 'Association';
				$count++;
			}
			for($i=0;$i<$count;$i++){
				$ors []= "cabs_type=?";
			}
			$wheres []= "(" . implode(" OR ", $ors) . ")";
			$count = 0;
		}

		if($data['cabs_pending']){
			$wheres [] = "cabs_pending=1";
		}else{
			$wheres [] = "cabs_pending=0";
		}
		if($data['cabs_disabled']){
			$wheres [] = "cabs_disabled=1";
		}else{
			$wheres [] = "cabs_disabled=0";
		}


		//prevent sql injection or other tampering
		if(strtolower($data['by']) == "desc"){
			$data['by'] = "DESC";
		}else{
			$data['by'] = "ASC";
		}
		$orderby = $order . ' ' . $data['by'];

		if(count($wheres) > 0){
			$wheres = 'WHERE ' . implode(' AND ', $wheres);
		}else{
			$wheres = "";
		}


		//---------- ACTUAL QUERY --------------
		$cabs = $CI->db->query('
			SELECT '. implode(', ', $selects) .'
			FROM cabs AS c
			'. implode("\n", $joins) .'
			'. $wheres .'
		', $params)->result_array();
		//pre($data);
		//pre($CI->db->last_query());exit;

        return $cabs;
	}


}
