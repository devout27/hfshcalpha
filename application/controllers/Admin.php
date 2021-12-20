<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->kick_out();
		$this->player->touch();
		$this->player_id = $this->session->userdata('players_id');
		$this->player = new Player($this->player_id);
		$this->player->touch();
		$this->data['player'] = $this->player->player;
		$this->data['player']['unread'] = $this->player->get_unread();
		$this->data['online_players'] = $this->player->get_online_count();
		if($this->data['player']['players_admin'] == 0){
			$this->session->set_flashdata('notice', "This area is for administrators only.");
			//redirect('game/profile');
		}
		$this->load->model('articles');
		$this->load->model('privileges');
		$this->load->model('horse');
		$this->load->model('bank');
		$this->load->model('cabs');
		$this->load->model('events');
		$this->data['privileges'] = $this->privileges->get();

		$this->data['errors'] = $this->session->flashdata('errors');
		$this->data['post'] = $this->session->flashdata('post');
		$this->data['page']['title'] = "Hurricane Farms";
	}

	public function index(){
		$this->data['page']['title'] = "Admin";
		$this->data['page']['hide_logo'] = 1;
		$this->load->model('stables');
		$this->data['articles'] = $this->articles->get_articles();
		$this->data['vets'] = $this->player->get_vets();
		$this->data['farriers'] = $this->player->get_farriers();
		$this->data['pending_applications'] = $this->player->admin_get_pending();
		$this->data['pending_deletions'] = $this->player->admin_get_pending_delete();
		$this->data['pending_horse_registration'] = $this->horse->admin_get_registration();
		$this->data['pending_horse_breedings'] = $this->horse->admin_get_breedings();
		$this->data['pending_horse_import'] = $this->horse->admin_get_import();
		$this->data['pending_horse_export'] = $this->horse->admin_get_export();
		$this->data['pending_bank_applications'] = count($this->bank->admin_get_pending()) + count($this->bank->admin_get_pending_bank());
		$this->data['pending_cabs_applications'] = $this->cabs->admin_get_pending();
		$this->data['pending_events'] = $this->events->admin_get_pending();
		$this->data['pending_orders'] = $this->stables->admin_get_pending();
		$this->data['admins'] = $this->player->get_admins();


		$this->load->view('layout/header', $this->data);
		$this->load->view('admin/index', $this->data);
		$this->load->view('layout/footer');
	}


	public function stables_packages(){
		$this->data['page']['title'] = "Admin - Stable Packages";
		$this->data['page']['hide_logo'] = 1;
		$this->load->model('stables');

		if(!$this->data['player']['privileges']['privileges_stables']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}


		if($this->input->post('new_package')){
			$response = $this->stables->admin_add_package($_POST);
			//pre($response);exit;
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem adding the package.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
				redirect('admin/stables/packages/');
				//pre($response);
			}else{
				$this->session->set_flashdata('notice', "Package added.");
				redirect('admin/stables/packages/view/' . $response['stables_packages_id']);
			}
		}


		$this->data['packages'] = $this->stables->get_packages();

		$this->load->view('layout/header', $this->data);
		$this->load->view('admin/stables-packages', $this->data);
		$this->load->view('layout/footer');
	}


	public function stables_packages_view($id){
		$this->data['page']['title'] = "Admin - Package Details";
		$this->data['page']['hide_logo'] = 1;
		$this->load->model('stables');

		if(!$this->data['player']['privileges']['privileges_stables']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		$this->data['amenities'] = $this->stables->get_amenities();
		$this->data['package'] = $this->stables->get_package($id);
		if(!$this->data['package']['stables_packages_id']){
			$this->session->set_flashdata('notice', "Invalid package.");
			redirect('admin/stables/packages');
		}


		if($this->input->post('update_package')){
			$response = $this->stables->admin_update_package($id, $_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem saving the package.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Package updated.");
			}
			redirect('admin/stables/packages/view/' . $id);

		}elseif($this->input->post('save_amenities')){
			$response = $this->stables->admin_update_package_amenities($id, $_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem saving the package's amenities.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Package amenities updated.");
			}
			redirect('admin/stables/packages/view/' . $id);
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('admin/stables-packages-view', $this->data);
		$this->load->view('layout/footer');
	}

	public function stables_packages_delete($id){
		$this->data['page']['title'] = "Admin - Package Details";
		$this->data['page']['hide_logo'] = 1;
		$this->load->model('stables');

		if(!$this->data['player']['privileges']['privileges_stables']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		$response = $this->stables->admin_delete_package($id);
		if(count($response['errors']) > 0){
			$this->session->set_flashdata('notice', "There was a problem deleting the package.");
			$this->session->set_flashdata('post', $_POST);
			$this->session->set_flashdata('errors', $response['errors']);
			pre($response);
		}else{
			$this->session->set_flashdata('notice', "Package deleted.");
		}
		redirect('admin/stables/packages');
	}

	public function stables_amenities(){
		$this->data['page']['title'] = "Admin - Stable Amenities";
		$this->data['page']['hide_logo'] = 1;
		$this->load->model('stables');

		if(!$this->data['player']['privileges']['privileges_stables']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		if($this->input->post('add_amenity')){
			$response = $this->stables->admin_add_amenity($_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem adding the amenity.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
				redirect('admin/stables/amenities/');
				//pre($response);
			}else{
				$this->session->set_flashdata('notice', "Amenity added.");
			redirect('admin/stables/amenities/view/' . $response['amenities_id']);
			}
		}

		$this->data['amenities'] = $this->stables->get_amenities();

		$this->load->view('layout/header', $this->data);
		$this->load->view('admin/stables-amenities', $this->data);
		$this->load->view('layout/footer');
	}

	public function stables_amenities_view($id){
		$this->data['page']['title'] = "Admin - Amenity Details";
		$this->data['page']['hide_logo'] = 1;
		$this->load->model('stables');

		if(!$this->data['player']['privileges']['privileges_stables']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		$this->data['amenity'] = $this->stables->get_amenity($id);
		$this->data['amenities_owned'] = $this->stables->count_amenities($id);
		if(!$this->data['amenity']['amenities_id']){
			$this->session->set_flashdata('notice', "Invalid amenity.");
			redirect('admin/stables/amenities');
		}

		if($this->input->post('update_amenity')){
			$response = $this->stables->admin_update_amenity($id, $_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem saving the amenity.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
				//pre($response);
			}else{
				$this->session->set_flashdata('notice', "Amenity updated.");
			}
			redirect('admin/stables/amenities/view/' . $id);

		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('admin/stables-amenities-view', $this->data);
		$this->load->view('layout/footer');
	}

	public function stables_amenities_delete($id){
		$this->data['page']['title'] = "Admin - Amenity Details";
		$this->data['page']['hide_logo'] = 1;
		$this->load->model('stables');

		if(!$this->data['player']['privileges']['privileges_stables']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		$response = $this->stables->admin_delete_amenity($id);
		if(count($response['errors']) > 0){
			$this->session->set_flashdata('notice', "There was a problem deleting the amenity.");
			$this->session->set_flashdata('post', $_POST);
			$this->session->set_flashdata('errors', $response['errors']);
			pre($response);
		}else{
			$this->session->set_flashdata('notice', "Amenity deleted. The rumblings were felt across all of " . SITE_NAME . " as the " . $response . " copies of this amenity were destroyed.");
		}
		redirect('admin/stables/amenities');
	}



	public function events_pending(){
		if(!$this->data['player']['privileges']['privileges_events']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}
		$this->data['page']['title'] = "Admin - Events";
		$this->data['page']['hide_logo'] = 1;
		$this->data['pending_events'] = $this->events->admin_get_pending();
		$this->load->view('layout/header', $this->data);
		$this->load->view('admin/events-pending', $this->data);
		$this->load->view('layout/footer');
	}


	public function events_classlists(){
		if(!$this->data['player']['privileges']['privileges_events']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		$this->data['page']['title'] = "Admin - Classlists";
		$this->data['page']['hide_logo'] = 1;
		$this->data['classlists'] = $this->events->get_classlists(array('get_classes' => 1));
		$this->data['cabs'] = $this->cabs->get_all(array('normalize' => 1, 'cabs_type' => 'Association'));

		$this->load->view('layout/header', $this->data);
		$this->load->view('admin/events-classlists', $this->data);
		$this->load->view('layout/footer');
	}


	public function events_classlists_view($id){
		if(!$this->data['player']['privileges']['privileges_events']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		$this->data['page']['title'] = "Admin - Classlist Details";
		$this->data['page']['hide_logo'] = 1;
		$this->data['errors'] = $this->session->flashdata('errors');
		$this->data['post'] = $this->session->flashdata('post');
		$this->data['classlist'] = $this->events->get_classlist($id);
		$this->data['divisions'] = $this->events->get_divisions($id) ?: array();
		$this->data['cabs'] = $this->cabs->get_all(array('normalize' => 1, 'cabs_type' => 'Association'));
		$this->data['breeds'] = $this->horse->get_breeds();
		$this->data['disciplines'] = $this->horse->get_disciplines();
		$this->data['breeds_types'] = $this->horse->get_breeds_types();



		if($this->input->post('save_classlist')){
			$response = $this->events->admin_save_classlist($this->data['player'], $this->data['cabs'], $id, $_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem saving the classlist.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Classlist updated.");
			}
			redirect('admin/events/classlists/view/' . $id);
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('admin/events-classlist', $this->data);
		$this->load->view('layout/footer');
	}


	public function events_classlists_delete($id){
		if(!$this->data['player']['privileges']['privileges_events']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		$response = $this->events->admin_delete_classlist($id);
		if(count($response['errors']) > 0){
			$this->session->set_flashdata('notice', "There was a problem deleting the classlist.");
			$this->session->set_flashdata('post', $_POST);
			$this->session->set_flashdata('errors', $response['errors']);
			redirect('admin/events/classlists/view/' . $id);
		}else{
			$this->session->set_flashdata('notice', "Classlist deleted.");
		}
		redirect('admin/events/classlists/');
	}


	public function log(){
		$this->data['page']['title'] = "Admin - Activity Log";
		$this->data['page']['hide_logo'] = 1;
		//		$this->logs->log_ip($player['players_id']);

		if($this->input->post('search')){
			$this->data['search'] = $this->logs->search($_POST);
			//pre($this->data['search']);exit;
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('admin/logs', $this->data);
		if($this->input->post('search')){
			$this->load->view('partials/admin-log-search', array('logs' => $this->data['search']));
		}
		$this->load->view('layout/footer');
	}

	public function news(){
		$this->data['page']['title'] = "Admin - News";
		$this->data['article'] = $this->articles->get_article(1);

		if(!$this->data['player']['privileges']['privileges_news']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		if($this->input->post('save')){
			$response = $this->articles->save_article(1, $_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem saving the News.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "News updated.");
			}
			redirect('admin/news');
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('admin/news', $this->data);
		$this->load->view('layout/footer');
	}

	public function articles_add(){
		$this->data['page']['title'] = "Admin - Articles";

		if(!$this->data['player']['privileges']['privileges_articles']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		if($this->input->post('create')){
			$response = $this->articles->create($_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem creating the article.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
				redirect('admin/articles/add');
			}else{
				$this->session->set_flashdata('notice', "Article created.");
			}
			redirect('admin/articles/' . $response['article_id']);
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('admin/article-new', $this->data);
		$this->load->view('layout/footer');
	}

	public function articles_view($id){
		$this->data['page']['title'] = "Admin - News";
		$this->data['article'] = $this->articles->get_article($id);

		if(!$this->data['player']['privileges']['privileges_articles']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		if($id == 1){
			$this->session->set_flashdata('notice', "You cannot edit the News through the Article Editor.");
			redirect('admin');
		}
		if(!$this->data['article']['articles_id']){
			$this->session->set_flashdata('notice', "Invalid article.");
			redirect('admin');
		}

		if($this->input->post('save')){
			$response = $this->articles->save_article($id, $_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem saving the article.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Article updated.");
			}
			redirect('admin/articles/' . $id);
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('admin/article-view', $this->data);
		$this->load->view('layout/footer');
	}

	public function articles_delete($id){
		if(!$this->data['player']['privileges']['privileges_articles']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		if($id == 1){
			$this->session->set_flashdata('notice', "You cannot edit the News through the Article Editor.");
			redirect('admin');
		}

		$response = $this->articles->delete_article($id, $_POST);
		if(count($response['errors']) > 0){
			$this->session->set_flashdata('notice', "There was a problem deleting the article.");
			$this->session->set_flashdata('post', $_POST);
			$this->session->set_flashdata('errors', $response['errors']);
		}else{
			$this->session->set_flashdata('notice', "Article deleted.");
		}
		redirect('admin/');
	}


	public function add_mod(){
		$this->data['page']['title'] = "Admin - Add Admin";
		$this->data['post'] = $this->session->flashdata('post');
		$this->data['errors'] = $this->session->flashdata('errors');

		if(!$this->data['player']['privileges']['privileges_admin']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		if($this->input->post('add')){
			$response = $this->player->add_admin($_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem adding a new admin.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Admin added.");
			}
			redirect('admin/mods/edit/' . $this->input->post('players_id'));
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('admin/mod-add', $this->data);
		$this->load->view('layout/footer');
	}


	public function edit_mod($id){
		$this->data['page']['title'] = "Admin - Edit Admin";
		$this->data['post'] = $this->session->flashdata('post');
		$this->data['errors'] = $this->session->flashdata('errors');

		if(!$this->data['player']['privileges']['privileges_admin']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		$this->data['admin'] = new Player($id);
		$this->data['admin'] = $this->data['admin']->player;


		if($this->input->post('edit')){
			$response = $this->player->edit_admin($id, $_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem updating the admin.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Admin updated.");
			}
			redirect('admin/mods/edit/' . $id);
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('admin/mod-edit', $this->data);
		$this->load->view('layout/footer');
	}

	public function delete_mod($id){
		if(!$this->data['player']['privileges']['privileges_admin']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		if($id){
			$response = $this->player->delete_admin($id);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem removing the admin.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Admin removed.");
			}
			redirect('admin/');
		}
	}



	public function horse_breeds(){
		$this->data['page']['title'] = "Admin - Modify Breeds, etc.";
		$this->data['post'] = $this->session->flashdata('post');
		$this->data['errors'] = $this->session->flashdata('errors');

		if(!$this->data['player']['privileges']['privileges_horses']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		$this->data['breeds'] = $this->horse->get_breeds();
		$this->data['base_colors'] = $this->horse->get_base_colors();
		$this->data['base_patterns'] = $this->horse->get_base_patterns();
		$this->data['lines'] = $this->horse->get_lines();
		$this->data['disciplines'] = $this->horse->get_disciplines();
		$this->data['restricted_names'] = $this->horse->get_restricted_names();


		if($this->input->post('a_breed')){
			$response = $this->horse->admin_add_breed($_POST);
			if(count($response['errors']) > 0){
				//pre($response);exit;
				$this->session->set_flashdata('notice', "There was a problem adding the breed.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Breed added.");
			}
			redirect('admin/horses/breeds');
		}elseif($this->input->post('r_breed')){
			$response = $this->horse->admin_remove_breed($_POST);
			if(count($response['errors']) > 0){
				//pre($response);exit;
				$this->session->set_flashdata('notice', "There was a problem removing the breed.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Breed removed. " . $response['affected'] . " horses affected.");
			}
			redirect('admin/horses/breeds');

		}elseif($this->input->post('a_discipline')){
			$response = $this->horse->admin_add_discipline($_POST);
			if(count($response['errors']) > 0){
				//pre($response);exit;
				$this->session->set_flashdata('notice', "There was a problem adding the discipline.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Discipline added.");
			}
			redirect('admin/horses/breeds');
		}elseif($this->input->post('r_discipline')){
			$response = $this->horse->admin_remove_discipline($_POST);
			if(count($response['errors']) > 0){
				//pre($response);exit;
				$this->session->set_flashdata('notice', "There was a problem removing the discipline.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Discipline removed. " . $response['affected'] . " horses affected.");
			}
			redirect('admin/horses/breeds');

		}elseif($this->input->post('a_base')){
			$response = $this->horse->admin_add_base_color($_POST);
			if(count($response['errors']) > 0){
				//pre($response);exit;
				$this->session->set_flashdata('notice', "There was a problem adding the base color.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Base color added.");
			}
			redirect('admin/horses/breeds');
		}elseif($this->input->post('r_base')){
			$response = $this->horse->admin_remove_base_color($_POST);
			if(count($response['errors']) > 0){
				//pre($response);exit;
				$this->session->set_flashdata('notice', "There was a problem removing the base color.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Base color removed. " . $response['affected'] . " horses affected.");
			}
			redirect('admin/horses/breeds');

		}elseif($this->input->post('a_pattern')){
			$response = $this->horse->admin_add_pattern($_POST);
			if(count($response['errors']) > 0){
				//pre($response);exit;
				$this->session->set_flashdata('notice', "There was a problem adding the pattern.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Pattern added.");
			}
			redirect('admin/horses/breeds');
		}elseif($this->input->post('r_pattern')){
			$response = $this->horse->admin_remove_pattern($_POST);
			if(count($response['errors']) > 0){
				//pre($response);exit;
				$this->session->set_flashdata('notice', "There was a problem removing the pattern.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Pattern removed. " . $response['affected'] . " horses affected.");
			}
			redirect('admin/horses/breeds');


		}elseif($this->input->post('a_line')){
			$response = $this->horse->admin_add_line($_POST);
			if(count($response['errors']) > 0){
				//pre($response);exit;
				$this->session->set_flashdata('notice', "There was a problem adding the line.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Line added.");
			}
			redirect('admin/horses/breeds');
		}elseif($this->input->post('r_line')){
			$response = $this->horse->admin_remove_line($_POST);
			if(count($response['errors']) > 0){
				//pre($response);exit;
				$this->session->set_flashdata('notice', "There was a problem removing the line.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Line removed. " . $response['affected'] . " horses affected.");
			}
			redirect('admin/horses/breeds');


		}elseif($this->input->post('a_restricted_name')){
			$response = $this->horse->admin_add_restricted($_POST);
			if(count($response['errors']) > 0){
				//pre($response);exit;
				$this->session->set_flashdata('notice', "There was a problem adding the name restriction.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Name restriction added.");
			}
			redirect('admin/horses/breeds');
		}elseif($this->input->post('r_restricted_name')){
			$response = $this->horse->admin_remove_restricted($_POST);
			if(count($response['errors']) > 0){
				//pre($response);exit;
				$this->session->set_flashdata('notice', "There was a problem removing the name restriction.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Name restriction removed.");
			}
			redirect('admin/horses/breeds');
		}


		$this->load->view('layout/header', $this->data);
		$this->load->view('admin/horse-breeds', $this->data);
		$this->load->view('layout/footer');
	}





	public function horse_genes(){
		$this->data['page']['title'] = "Admin - Genetics";
		$this->data['post'] = $this->session->flashdata('post');
		$this->data['errors'] = $this->session->flashdata('errors');

		if(!$this->data['player']['privileges']['privileges_horses']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		$this->data['genes'] = $this->horse->get_genes();
		$this->data['genes_normalized'] = $this->horse->get_genes_normalized();
		$this->data['genes_categories'] = $this->horse->get_genes_categories();
		/*$this->data['base_patterns'] = $this->horse->get_base_patterns();
		$this->data['lines'] = $this->horse->get_lines();
		$this->data['disciplines'] = $this->horse->get_disciplines();
		$this->data['restricted_names'] = $this->horse->get_restricted_names();*/


		if($this->input->post('a_gene')){
			$response = $this->horse->admin_add_gene($_POST);
			if(count($response['errors']) > 0){
				//pre($response);exit;
				$this->session->set_flashdata('notice', "There was a problem adding the gene.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Gene added.");
			}
			redirect('admin/horses/genes');

		}elseif($this->input->post('r_gene')){
			$response = $this->horse->admin_remove_gene($_POST);
			if(count($response['errors']) > 0){
				//pre($response);exit;
				$this->session->set_flashdata('notice', "There was a problem removing the gene.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Gene removed. " . $response['affected'] . " horses affected.");
			}
			redirect('admin/horses/genes');

		}elseif($this->input->post('a_category')){
			$response = $this->horse->admin_add_gene_category($_POST);
			if(count($response['errors']) > 0){
				//pre($response);exit;
				$this->session->set_flashdata('notice', "There was a problem adding the gene category.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Gene category added.");
			}
			redirect('admin/horses/genes');
		}elseif($this->input->post('r_category')){
			$response = $this->horse->admin_remove_gene_category($_POST);
			if(count($response['errors']) > 0){
				//pre($response);exit;
				$this->session->set_flashdata('notice', "There was a problem removing the gene category.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Gene category removed. " . $response['affected'] . " genes affected.");
			}
			redirect('admin/horses/genes');

		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('admin/horse-genes', $this->data);
		$this->load->view('layout/footer');
	}



	public function horse_genes_edit($id){
		$this->data['page']['title'] = "Admin - Edit Gene";
		$this->data['post'] = $this->session->flashdata('post');
		$this->data['errors'] = $this->session->flashdata('errors');

		if(!$this->data['player']['privileges']['privileges_horses']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		$this->data['gene'] = $this->horse->get_gene($id);
		$this->data['genes_categories'] = $this->horse->get_genes_categories();
		$this->data['gene']['blueprints'] = $this->horse->get_blueprints_by_gene_id($id);
		$this->data['gene']['genes_required'] = $this->data['gene']['genes_required'] ? 'SELECTED' : '';

		if(!$this->data['gene']['genes_name']){
			$this->session->set_flashdata('notice', "Invalid Gene.");
			redirect('admin/horses/genes');
		}

		if($this->input->post('save')){
			$response = $this->horse->admin_edit_gene($id, $_POST);
			if(count($response['errors']) > 0){
				//pre($response);exit;
				$this->session->set_flashdata('notice', "There was a problem editing the gene.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Gene edited.");
			}
			redirect('admin/horses/genes/edit/' . $id);
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('admin/horse-genes-edit', $this->data);
		$this->load->view('layout/footer');
	}



	public function horse_gene_blueprints(){
		$this->data['page']['title'] = "Admin - Blueprints";
		$this->data['post'] = $this->session->flashdata('post');
		$this->data['errors'] = $this->session->flashdata('errors');

		if(!$this->data['player']['privileges']['privileges_horses']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		$this->data['blueprints'] = $this->horse->get_blueprints();
		$this->data['blueprints_normalized'] = $this->horse->get_blueprints_normalized();
		$this->data['genes_categories'] = $this->horse->get_genes_categories();


		if($this->input->post('a_blueprint')){
			$response = $this->horse->admin_add_blueprint($_POST);
			if(count($response['errors']) > 0){
				//pre($response);exit;
				$this->session->set_flashdata('notice', "There was a problem adding the blueprint.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Blueprint added.");
			}
			redirect('admin/horses/genes/blueprints');

		}elseif($this->input->post('r_blueprint')){
			$response = $this->horse->admin_remove_blueprint($_POST);
			if(count($response['errors']) > 0){
				//pre($response);exit;
				$this->session->set_flashdata('notice', "There was a problem removing the blueprint.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Blueprint removed.");
			}
			redirect('admin/horses/genes/blueprints');
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('admin/horse-genes-blueprints', $this->data);
		$this->load->view('layout/footer');
	}





	public function horse_gene_blueprints_edit($id){
		$this->data['page']['title'] = "Admin - Edit Blueprint";
		$this->data['post'] = $this->session->flashdata('post');
		$this->data['errors'] = $this->session->flashdata('errors');

		if(!$this->data['player']['privileges']['privileges_horses']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}


		$this->data['blueprint'] = $this->horse->get_blueprint($id);
		$this->data['blueprint']['genes_blueprints_special'] = $this->data['blueprint']['genes_blueprints_special'] ? 'SELECTED' : '';
		$this->data['genes'] = $this->horse->get_genes(array('join_genes_categories_name' => $this->data['blueprint']['join_genes_categories_name']));
		$this->data['genes_categories'] = $this->horse->get_genes_categories();

		if(!$this->data['blueprint']['genes_blueprints_name']){
			$this->session->set_flashdata('notice', "Invalid Blueprint.");
			redirect('admin/horses/genes/blueprints');
		}

		if($this->input->post('save')){
			$response = $this->horse->admin_edit_blueprint($id, $_POST, $this->data['blueprint']);
			if(count($response['errors']) > 0){
				//pre($response);exit;
				$this->session->set_flashdata('notice', "There was a problem editing the blueprint.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Blueprint edited.");
			}
			redirect('admin/horses/genes/blueprints/edit/' . $id);
		}elseif($this->input->post('save_genes')){
			$response = $this->horse->admin_edit_blueprint_genes($id, $this->data['genes'], $_POST);
			if(count($response['errors']) > 0){
				//pre($response);exit;
				$this->session->set_flashdata('notice', "There was a problem editing the blueprint genes.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Blueprint genes edited.");
			}
			redirect('admin/horses/genes/blueprints/edit/' . $id);
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('admin/horse-genes-blueprints-edit', $this->data);
		$this->load->view('layout/footer');
	}


	public function horse_search(){
		$this->data['page']['title'] = "Admin - Search Horse Owner Log";
		$this->data['post'] = $this->session->flashdata('post');
		$this->data['errors'] = $this->session->flashdata('errors');

		if(!$this->data['player']['privileges']['privileges_horses']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		$this->data['breeds'] = $this->horse->get_breeds();
		$this->data['base_colors'] = $this->horse->get_base_colors();
		$this->data['base_patterns'] = $this->horse->get_base_patterns();
		$this->data['lines'] = $this->horse->get_lines();
		$this->data['disciplines'] = $this->horse->get_disciplines();

		if($this->input->post('search')){
			$this->data['search'] = $this->horse->search_owners($_POST);
			//pre($this->data['search']);exit;
		}


		$this->load->view('layout/header', $this->data);
		$this->load->view('admin/horse-search', $this->data);
		if($this->input->post('search')){
			$this->load->view('partials/admin-horse-search', array('owners' => $this->data['search']));
		}
		$this->load->view('layout/footer');
	}


	public function horse_breed(){
		$this->data['page']['title'] = "Admin - Breed Requests";
		$this->data['post'] = $this->session->flashdata('post');
		$this->data['errors'] = $this->session->flashdata('errors');
		$this->data['breedings'] = Horse::admin_get_breedings();
		$this->data['breeds'] = $this->horse->get_breeds();
		/*$this->data['base_colors'] = $this->horse->get_base_colors();
		$this->data['base_patterns'] = $this->horse->get_base_patterns();*/
		$this->data['lines'] = $this->horse->get_lines();
		$this->data['disciplines'] = $this->horse->get_disciplines();
		$allowed = array(
				'breeds' => $this->data['breeds'],
				/*'base_colors' => $this->data['base_colors'],
				'base_patterns' => $this->data['base_patterns'],*/
				'lines' => $this->data['lines'],
				'disciplines' => $this->data['disciplines']
			);

		if(!$this->data['player']['privileges']['privileges_horses']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		if($this->input->post('accept')){
			$response = $this->horse->admin_accept_breeding($_POST, $this->player_id, $allowed);
			if(count($response['errors']) > 0){
				pre($response);exit;
				$this->session->set_flashdata('notice', "There was a problem accepting the request.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Breeding accepted.");
			}
			redirect('admin/horses/breed');

		}elseif($this->input->post('reject')){
			$response = $this->horse->admin_reject_breeding($_POST, $this->player_id);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem rejecting the request.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Rejected.");
			}
			redirect('admin/horses/breed');
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('admin/horse-breed', $this->data);
		$this->load->view('layout/footer');
	}

	public function horse_import(){
		$this->data['page']['title'] = "Admin - Import Horse";
		$this->data['post'] = $this->session->flashdata('post');
		$this->data['errors'] = $this->session->flashdata('errors');
		$this->data['horses'] = Horse::admin_get_import();

		if(!$this->data['player']['privileges']['privileges_horses']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}


		if($this->input->post('accept')){
			$response = $this->horse->accept_import($_POST, $this->player_id);
			if(count($response['errors']) > 0){
				//pre($response);exit;
				$this->session->set_flashdata('notice', "There was a problem importing the horse.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
				//pre($response);exit;
			}else{
				$this->session->set_flashdata('notice', "Horse imported.");
			}
			redirect('admin/horses/import');

		}elseif($this->input->post('reject')){
			$response = $this->horse->reject_import($_POST, $this->player_id);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem rejecting the request.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Rejected.");
			}
			redirect('admin/horses/import');
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('admin/horse-import', $this->data);
		$this->load->view('layout/footer');
	}

	public function horse_export(){
		$this->data['page']['title'] = "Admin - Export Horse";
		$this->data['post'] = $this->session->flashdata('post');
		$this->data['errors'] = $this->session->flashdata('errors');
		$this->data['horses'] = Horse::admin_get_export();

		if(!$this->data['player']['privileges']['privileges_horses']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		if($this->input->post('accept')){
			$response = $this->horse->accept_export($_POST, $this->player_id);
			if(count($response['errors']) > 0){
				//pre($response);exit;
				$this->session->set_flashdata('notice', "There was a problem exporting the horse.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Horse exported.");
			}
			redirect('admin/horses/export');

		}elseif($this->input->post('reject')){
			$response = $this->horse->reject_export($_POST, $this->player_id);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem rejecting the horse.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Rejected.");
			}
			redirect('admin/horses/export');
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('admin/horse-export', $this->data);
		$this->load->view('layout/footer');
	}

	public function horse_register(){
		$this->data['page']['title'] = "Admin - Register Horse";
		$this->data['post'] = $this->session->flashdata('post');
		$this->data['errors'] = $this->session->flashdata('errors');
		$this->data['breeds'] = $this->horse->get_breeds();
		$this->data['base_colors'] = $this->horse->get_base_colors();
		$this->data['base_patterns'] = $this->horse->get_base_patterns();
		$this->data['lines'] = $this->horse->get_lines();
		$this->data['disciplines'] = $this->horse->get_disciplines();
		$this->data['horses'] = Horse::admin_get_registration();

		$allowed = array(
				'breeds' => $this->data['breeds'],
				'base_colors' => $this->data['base_colors'],
				'base_patterns' => $this->data['base_patterns'],
				'lines' => $this->data['lines'],
				'disciplines' => $this->data['disciplines']
			);

		if(!$this->data['player']['privileges']['privileges_horses']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		if($this->input->post('accept')){
			$response = $this->horse->register_horse($_POST, $allowed, $this->player_id);
			if(count($response['errors']) > 0){
				//pre($response);exit;
				$this->session->set_flashdata('notice', "There was a problem registering the horse.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Horse registered.");
			}
			redirect('admin/horses/register');
		}elseif($this->input->post('reject')){
			$response = $this->horse->reject_horse($_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem rejecting the horse.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Rejected.");
			}
			redirect('admin/horses/register');
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('admin/horse-register', $this->data);
		$this->load->view('layout/footer');

	}


	public function member_manage($id){
		if(!$this->data['player']['privileges']['privileges_members']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}
		$this->data['accounts'] = Bank::get_accounts($id);
		$this->data['page']['title'] = "Admin - Member Management";
		$this->data['post'] = $this->session->flashdata('post');
		$this->data['errors'] = $this->session->flashdata('errors');
		$this->data['page']['hide_logo'] = 1;

		$this->data['profile'] = new Player($id);
		$this->data['profile'] = $this->data['profile']->player;

		if($this->input->post('update_credits')){
			$response = $this->player->admin_update_credits($_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem editing the player's credits.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Credits updated.");
			}
			redirect('admin/members/manage/' . $id);
		}elseif($this->input->post('update_profile')){
			$response = $this->player->admin_update_profile($_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem updating the player's profile.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Profile updated.");
			}
			redirect('admin/members/manage/' . $id);
		}elseif($this->input->post('remove_player')){
			$response = $this->player->admin_remove($_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem removing the player.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
				redirect('admin/members/manage/' . $id);
			}else{
				$this->session->set_flashdata('notice', "Player removed.");
			}
			redirect('admin');
		}


		$this->load->view('layout/header', $this->data);
		$this->load->view('admin/member-manage', $this->data);
		$this->load->view('layout/footer');
	}

	public function member_remove($id){
		if(!$this->data['player']['privileges']['privileges_members']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		$this->data['page']['title'] = "Admin - Remove Member";
		$this->data['post'] = $this->session->flashdata('post');
		$this->data['errors'] = $this->session->flashdata('errors');
		$this->data['page']['hide_logo'] = 1;

		$this->load->view('layout/header', $this->data);
		$this->load->view('admin/member-remove', $this->data);
		$this->load->view('layout/footer');
	}




	public function member_vets(){
		if(!$this->data['player']['privileges']['privileges_members']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		$this->data['page']['title'] = "Admin - Vets";
		$this->data['post'] = $this->session->flashdata('post');
		$this->data['errors'] = $this->session->flashdata('errors');
		$this->data['page']['hide_logo'] = 1;
		$this->data['vets'] = $this->player->get_vets();

		$this->load->view('layout/header', $this->data);
		$this->load->view('admin/member-vets', $this->data);
		$this->load->view('layout/footer');
	}


	public function add_vet(){
		$this->data['post'] = $this->session->flashdata('post');
		$this->data['errors'] = $this->session->flashdata('errors');

		if(!$this->data['player']['privileges']['privileges_members']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		if($this->input->post('add')){
			$response = $this->player->add_vet($_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem adding a new vet.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
				//pre($response);exit;
			}else{
				$this->session->set_flashdata('notice', "Vet added.");
			}
		}

		redirect('admin/members/vets');
	}

	public function delete_vet($id){
		if(!$this->data['player']['privileges']['privileges_members']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		if($id){
			$response = $this->player->delete_vet($id);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem removing the vet.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Vet removed.");
			}
			redirect('admin/members/vets');
		}
	}



	public function member_farriers(){
		if(!$this->data['player']['privileges']['privileges_members']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		$this->data['page']['title'] = "Admin - Farriers";
		$this->data['post'] = $this->session->flashdata('post');
		$this->data['errors'] = $this->session->flashdata('errors');
		$this->data['page']['hide_logo'] = 1;
		$this->data['vets'] = $this->player->get_farriers();

		$this->load->view('layout/header', $this->data);
		$this->load->view('admin/member-farriers', $this->data);
		$this->load->view('layout/footer');
	}


	public function add_farrier(){
		$this->data['post'] = $this->session->flashdata('post');
		$this->data['errors'] = $this->session->flashdata('errors');

		if(!$this->data['player']['privileges']['privileges_members']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		if($this->input->post('add')){
			$response = $this->player->add_farrier($_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem adding a new farrier.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
				//pre($response);exit;
			}else{
				$this->session->set_flashdata('notice', "Farrier added.");
			}
		}

		redirect('admin/members/farriers');
	}

	public function delete_farrier($id){
		if(!$this->data['player']['privileges']['privileges_members']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		if($id){
			$response = $this->player->delete_farrier($id);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem removing the farrier.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Farrier removed.");
			}
			redirect('admin/members/farriers');
		}
	}



	public function member_delete(){
		if(!$this->data['player']['privileges']['privileges_members']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		$this->data['page']['title'] = "Admin - Member Deletion Requests";
		$this->data['page']['hide_logo'] = 1;
		$this->data['accounts'] = $this->player->admin_get_pending_delete();

		$this->load->view('layout/header', $this->data);
		$this->load->view('admin/member-deletions', $this->data);
		$this->load->view('layout/footer');
	}



	public function member_applications(){
		if(!$this->data['player']['privileges']['privileges_members']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		$this->data['page']['title'] = "Admin - Member Applications";
		$this->data['page']['hide_logo'] = 1;
		$this->data['pending_applications'] = $this->player->admin_get_pending();

		$this->load->view('layout/header', $this->data);
		$this->load->view('admin/member-applications', $this->data);
		$this->load->view('layout/footer');
	}

	public function member_applications_process(){
		if(!$this->data['player']['privileges']['privileges_members']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		$this->data['post'] = $this->session->flashdata('post');
		$this->data['errors'] = $this->session->flashdata('errors');

		if($this->input->post('accept')){
			$response = $this->player->accept_member($_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem accepting the application.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Member accepted.");
			}

		}elseif($this->input->post('reject')){
			$response = $this->player->reject_member($_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem rejecting the application.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Member REJECTED.");
			}
		}
		redirect('admin/members/applications');
	}





	public function bank_applications(){
		if(!$this->data['player']['privileges']['privileges_bank']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		$this->data['page']['title'] = "Admin - Bank Applications";
		$this->data['page']['hide_logo'] = 1;
		$this->data['bank_applications'] = $this->bank->admin_get_pending();
		//  echo "<pre>"; print_r($this->data['bank_applications']);
		$this->data['bank_accounts'] = $this->bank->admin_get_pending_bank();
		//  echo "<pre>"; print_r($this->data['bank_accounts']); die('diii');
		$this->load->view('layout/header', $this->data);
		$this->load->view('admin/bank-applications', $this->data);
		$this->load->view('layout/footer');
	}

	public function bank_applications_process(){
		if(!$this->data['player']['privileges']['privileges_bank']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		if($this->input->post('accept')){
			$response = $this->bank->admin_accept_application($_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem accepting the application.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Bank account application accepted.");
			}

		}elseif($this->input->post('reject')){
			$response = $this->bank->admin_reject_application($_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem rejecting the application.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Bank account application REJECTED.");
			}
		}
		redirect('admin/bank/applications');
	}

	public function bank_applications_loan_process(){ 
		if(!$this->data['player']['privileges']['privileges_bank']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		$this->data['post'] = $this->session->flashdata('post');
		$this->data['errors'] = $this->session->flashdata('errors');

		if($this->input->post('accept')){
			$response = $this->bank->admin_accept_loan_application($_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem accepting the application.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Loan accepted.");
			}

		}elseif($this->input->post('reject')){
			$response = $this->bank->admin_reject_loan_application($_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem rejecting the application.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Loan REJECTED.");
			}
		}
		redirect('admin/bank/applications');
	}



	public function bank_loans(){
		if(!$this->data['player']['privileges']['privileges_bank']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		$this->data['page']['title'] = "Admin - Bank Loans";
		$this->data['page']['hide_logo'] = 1;
		$this->data['bank_loans'] = $this->bank->admin_get_overdue_loans();

		$this->load->view('layout/header', $this->data);
		$this->load->view('admin/bank-loans', $this->data);
		$this->load->view('layout/footer');
	}

	public function bank_transfer(){
		$this->data['page']['title'] = "Transfer Money";
		if(!$this->data['player']['privileges']['privileges_bank']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		if($this->input->post('admin_transfer_money')){
			$response = $this->bank->admin_transfer($_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem transferring the money.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Transfer complete.");
			}
			redirect('admin/bank/transfer');
		}


		$this->load->view('layout/header', $this->data);
		$this->load->view('/admin/bank-transfer', $this->data);
		$this->load->view('layout/footer');
	}

	public function bank_search(){
		$this->data['page']['title'] = "Search Bank Accounts";
		if(!$this->data['player']['privileges']['privileges_bank']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		if($this->input->post('search')){
			$this->data['accounts'] = $this->bank->search($_POST);
		}


		$this->load->view('layout/header', $this->data);
		$this->load->view('/admin/bank-search', $this->data);
		if($this->input->post('search')){
			$this->load->view('partials/bank-search', $this->data);
		}
		$this->load->view('layout/footer');
	}


	public function adoptathon(){
		$this->data['page']['title'] = "Award Adoptathon Credits";
		if(!$this->data['player']['privileges']['privileges_members']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		if($this->input->post('award')){
			$response = $this->player->admin_adoptathon($_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem awarding the credits.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Adoptathon credits awarded.");
			}
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('/admin/adoptathon', $this->data);
		$this->load->view('layout/footer');
	}



	public function bank_search_transactions(){
		$this->data['page']['title'] = "Search Bank Transactions";
		if(!$this->data['player']['privileges']['privileges_bank']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		if($this->input->post('search')){
			$this->data['transactions'] = $this->bank->search_transactions($_POST);
		}


		$this->load->view('layout/header', $this->data);
		$this->load->view('/admin/bank-search-transactions', $this->data);
		if($this->input->post('search')){
			$this->load->view('partials/bank-search-transactions', $this->data);
		}
		$this->load->view('layout/footer');
	}



	public function cabs_pending(){
		$this->data['page']['title'] = "Pending CABs";
		if(!$this->data['player']['privileges']['privileges_cabs']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}
		$this->data['applications'] = $this->cabs->admin_get_pending();

		$this->load->view('layout/header', $this->data);
		$this->load->view('/admin/cabs-pending', $this->data);
		$this->load->view('layout/footer');
	}

	public function cabs_process(){
		$this->data['page']['title'] = "Pending CABs";
		if(!$this->data['player']['privileges']['privileges_cabs']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}

		if($this->input->post('accept')){
			$response = $this->cabs->admin_accept($_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem accepting the CAB.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "CAB accepted.");
			}

		}elseif($this->input->post('reject')){
			$response = $this->cabs->admin_reject($_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem rejecting the CAB.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "CAB successfully REJECTED.");
			}
		}
		redirect('admin/cabs/pending');
	}

	public function cabs_disable($id){
		if(!$this->data['player']['privileges']['privileges_cabs']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}
		$response = $this->cabs->admin_disable($id);
		if(count($response['errors']) > 0){
			$this->session->set_flashdata('notice', "There was a problem disabling the CAB.");
			$this->session->set_flashdata('post', $_POST);
			$this->session->set_flashdata('errors', $response['errors']);
		}else{
			$this->session->set_flashdata('notice', "CAB successfully disabled.");
		}
		redirect('city/cabs/view/' . $id);
	}

	public function cabs_enable($id){
		if(!$this->data['player']['privileges']['privileges_cabs']){
			$this->session->set_flashdata('notice', "You don't have permission to access this.");
			redirect('admin');
		}
		$response = $this->cabs->admin_enable($id);
		if(count($response['errors']) > 0){
			$this->session->set_flashdata('notice', "There was a problem enabling the CAB.");
			$this->session->set_flashdata('post', $_POST);
			$this->session->set_flashdata('errors', $response['errors']);
		}else{
			$this->session->set_flashdata('notice', "CAB successfully enabled.");
		}
		redirect('city/cabs/view/' . $id);
	}






	public function ajax($method){
		if($method == "create-classlist"){
			if(!$this->data['player']['privileges']['privileges_events']){
				$this->session->set_flashdata('notice', "You don't have permission to access this.");
				redirect('admin');
			}

			//update the class in the event
			$cabs = $this->cabs->get_all(array('normalize' => 1, 'cabs_type' => 'Association'));
			$response = $this->events->admin_create_classlist($this->data['player'], $cabs, $_POST);
			if(!$response['errors']){
				echo $response['classlists_id'];
			}else{
				echo $response['errors'];
				pre($response);
			}
		}elseif($method == "update-class"){
			if(!$this->data['player']['privileges']['privileges_events']){
				$this->session->set_flashdata('notice', "You don't have permission to access this.");
				redirect('admin');
			}

			//update the class in the event
			$response = $this->events->admin_edit_class($_POST);
			if(!$response['errors']){
				$response['success'] = 1;
				echo json_encode($response);
			}else{
				echo json_encode($response['errors']);
			}
		}elseif($method == "delete-class"){
			if(!$this->data['player']['privileges']['privileges_events']){
				$this->session->set_flashdata('notice', "You don't have permission to access this.");
				redirect('admin');
			}

			//update the class in the event
			$response = $this->events->admin_delete_class($_POST);
			if(!$response['errors']){
				echo json_encode($response);
			}else{
				echo json_encode($response['errors'] = 'Invalid class.');
			}

		}elseif($method == "update-division"){
			if(!$this->data['player']['privileges']['privileges_events']){
				$this->session->set_flashdata('notice', "You don't have permission to access this.");
				redirect('admin');
			}

			//update the class in the event
			$response = $this->events->admin_edit_division($_POST);
			if(!$response['errors']){
				$response['success'] = 1;
				echo json_encode($response);
			}else{
				echo json_encode($response['errors']);
			}
		}elseif($method == "delete-division"){
			if(!$this->data['player']['privileges']['privileges_events']){
				$this->session->set_flashdata('notice', "You don't have permission to access this.");
				redirect('admin');
			}

			//update the class in the event
			$response = $this->events->admin_delete_division($_POST);
			if(!$response['errors']){
				echo json_encode($response);
			}else{
				echo json_encode($response['errors'] = 'Invalid division.');
			}
		}
	}

}