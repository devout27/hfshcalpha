<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Game extends MY_Controller {

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
		//$this->data['player']['cabs'] = $this->player->get_cabs();
		//pre($this->data['player']);exit;

		//$current_page = $this->router->fetch_method();
		$this->data['errors'] = $this->session->flashdata('errors');
		$this->data['post'] = $this->session->flashdata('post');
		$this->data['page']['title'] = "Hurricane Farm";
	}

	public function index(){
		$this->data['page']['title'] = "News";
		$this->load->model('articles');
		$this->data['article'] = $this->articles->get_article(1);


		$this->load->view('layout/header', $this->data);
		$this->load->view('game/index', $this->data);
		$this->load->view('layout/footer');
	}

	public function search(){
		$this->data['page']['title'] = "Search Players";

		if($this->input->post('search')){
			$this->data['search'] = $this->player->search($_POST);
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('game/search', $this->data);				
		if($this->input->post('search')){
			$this->load->view('partials/player-search', $this->data['search']);
		}
		$this->load->view('layout/footer');
	}

	public function view_message($id){
		$this->data['page']['title'] = "View Message";
		$this->load->model('messages');
		$this->data['msgs'] = $this->messages->get($id);
		$this->messages->mark_read($id);
		$this->data['msg_inbox_unread'] = $this->messages->get_unread();

		//ensure message is owned by player (either sender or receiver)
		if($this->data['msgs'][0]['messages_to'] != $this->session->userdata('players_id') AND $this->data['msgs'][0]['messages_sender'] != $this->session->userdata('players_id')){

			$this->session->set_flashdata('notice', "Invalid message.");
			redirect('game/messages');
		}
		$this->load->view('layout/header', $this->data);
		$this->load->view('game/messages-view', $this->data);
		$this->load->view('layout/footer');
	}

	public function msg_reply($id){
		$this->data['page']['title'] = "View Message";
		$this->load->model('messages');
		$this->data['msgs'] = $this->messages->get($id);
		//pre($this->session->userdata('players_id'));
		//pre($this->input->post());exit;

		//ensure message is owned by player (either sender or receiver)
		if(($this->data['msgs'][0]['messages_to'] != $this->session->userdata('players_id') AND $this->data['msgs'][0]['messages_sender'] != $this->session->userdata('players_id')) || !$this->input->post('respond')){
			$this->session->set_flashdata('notice', "Invalid message.");
			redirect('game/messages');
		}

		if($this->input->post('respond')){
			$errors = $this->messages->respond($id, $_POST);
			if(count($errors) > 0){
				$this->session->set_flashdata('notice', "There was a problem sending your message.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $errors);
				redirect('game/messages#compose');
			}
		}else{
			$this->session->set_flashdata('notice', "Message not sent.");
			redirect('game/messages/view/' .$id);
		}
	}


	public function messages(){
		$this->data['page']['title'] = "Messages";
		$this->load->model('messages');
		$this->data['msg_inbox'] = $this->messages->get_all();
		$this->data['msg_sent'] = $this->messages->get_sent();
		$this->data['msg_inbox_unread'] = $this->messages->get_unread();
		$this->data['notices'] = $this->messages->get_notices();
		$this->data['notices_unread'] = $this->messages->get_unread_notices();
		//pre($this->data['msg_inbox']);

		$this->data['notices'] = $this->load->view('partials/msg-notices', array('notices' => $this->data['notices']), TRUE);
		$this->data['inbox'] = $this->load->view('partials/msg-inbox', array('msgs' => $this->data['msg_inbox']), TRUE);
		$this->data['sent'] = $this->load->view('partials/msg-sent', array('msgs' => $this->data['msg_sent']), TRUE);
		$this->data['compose'] = $this->load->view('partials/msg-compose', NULL, TRUE);

		if($this->input->post('send_message')){
			$errors = $this->messages->send($_POST);
			if(count($errors) > 0){
				$this->session->set_flashdata('notice', "There was a problem sending your message.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $errors);
				redirect('game/messages#compose');
			}
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('game/messages', $this->data);
		$this->load->view('layout/footer');
		$this->messages->mark_notices_read();
	}


	public function quit(){
		$this->data['profile'] = new Player($this->session->userdata('players_id'));
		$this->data['profile'] = $this->data['profile']->player;
		$id = $this->data['profile']['players_id'];
		$this->data['page']['title'] = "Quit Game";

		if($this->input->post('quit_now')){
			$errors = $this->player->quit($this->data['player'], $_POST);
			if(count($errors['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem requesting deletion.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $errors['errors']);
				//pre($errors['errors']);exit;
				redirect('game/quit');
			}
			$this->session->set_flashdata('notice', "Deletion requested.");
			redirect('game/quit');
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('game/quit', $this->data);
		$this->load->view('layout/footer');
	}


	public function cancel_quit(){
		$this->player->cancel_quit($this->session->userdata('players_id'));
		$this->session->set_flashdata('notice', "Request removed.");
		redirect('game/profile');
	}

	public function update_profile(){
		$this->data['profile'] = new Player($this->session->userdata('players_id'));
		$this->data['profile'] = $this->data['profile']->player;
		$id = $this->data['profile']['players_id'];
		$this->data['page']['title'] = "Update Profile";


		if($this->input->post('update_profile')){
			//update the player's profile

			$this->form_validation->set_rules(array(
				array(
					'field' => 'players_nickname',
					'label' => 'Nickname',
					'rules' => 'required|strip_tags|min_length[3]|max_length[25]'
				),
				array(
					'field' => 'players_banner',
					'label' => 'Banner',
					'rules' => 'valid_url'
				),
				array(
					'field' => 'players_about',
					'label' => 'About',
					'rules' => 'xss_clean'
				),
			));

			if ($this->form_validation->run() !== false) {
				$data = $this->input->post();

				$allowed_fields = array(
					'players_nickname',
					'players_banner',
					'players_about',
				);
				$update_data = filter_keys($data, $allowed_fields);
				$this->db->where('players_id', $this->session->userdata('players_id'));
				$this->db->update('players', $update_data);

				$this->session->set_flashdata('notice', "Your profile has been updated!");
				redirect('game/profile');
			}

			foreach($_POST AS $v => $e){
				$e = form_error($v);
				if($e){
					$errors[$v] = $e;
				}
			}

		}


		if($this->input->post('change_email')){
			$this->form_validation->set_rules(array(
				array(
					'field' => 'current_email',
					'label' => 'Current Email',
					'rules' => 'required|valid_email'
				),
				array(
					'field' => 'new_email',
					'label' => 'New Email',
					'rules' => 'required|valid_email|callback_email_unique'
				),
				array(
					'field' => 'confirm_email',
					'label' => 'Confirm New Email',
					'rules' => 'required|matches[new_email]|valid_email|callback_email_unique'
				),
			));

			//verify current email
			if($this->input->post('current_email') != $this->data['profile']['players_email']){
				$errors['current_email'] = "Invalid email.";
			}


			if ($this->form_validation->run() !== false AND count($errors) < 1) {
				$data['players_email'] = $this->input->post('new_email');

				$allowed_fields = array(
					'players_email',
				);
				$update_data = filter_keys($data, $allowed_fields);
				$this->db->where('players_id', $this->session->userdata('players_id'));
				$this->db->update('players', $update_data);

				$this->session->set_flashdata('notice', "Your email has been updated!");
				redirect('game/profile');

			}
			foreach($_POST AS $v => $e){
				$e = form_error($v);
				if($e){
					$errors[$v] = $e;
				}
			}
		}




		if($this->input->post('change_password')){
			$this->form_validation->set_rules(array(
				array(
					'field' => 'current_password',
					'label' => 'Current Password',
					'rules' => 'required'
				),
				array(
					'field' => 'new_password',
					'label' => 'New Password',
					'rules' => 'required|min_length[6]'
				),
				array(
					'field' => 'confirm_password',
					'label' => 'Confirm Password',
					'rules' => 'required|matches[new_password]'
				),
			));

			//verify current password
			$check_hash = player::get_hash($_POST['current_password']);
			if($check_hash['my_hash'] !== $this->data['profile']['players_password']){
				$errors['current_password'] = "Invalid password.";
			}


			if ($this->form_validation->run() !== false AND count($errors) < 1) {
				$this->db->query("UPDATE players SET players_password=PASSWORD(?) WHERE players_id=? LIMIT 1", array($this->input->post('new_password'), $this->session->userdata('players_id')));
				$this->session->set_flashdata('notice', "Your password has been updated!");
				redirect('game/profile');
			}

			foreach($_POST AS $v => $e){
				$e = form_error($v);
				if($e){
					$errors[$v] = $e;
				}
			}
		}

		if($_POST AND $errors){
			$this->session->set_flashdata('notice', "There was a problem updating your profile.");
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('game/profile-update', array('errors' => $errors, 'profile' => $this->data['profile']));
		$this->load->view('layout/footer');
	}
	public function stables($id)
	{
		$this->load->model('stables');
		$this->load->model('privileges');
		$this->data['stable'] = new Stables($id);
		$this->data['stable'] = $this->data['stable']->stable;
		//pre($this->data['stable']);exit;
		$this->data['page']['title'] = "Stable";
		$this->data['privileges'] = $this->privileges->get();
		//pre($this->data['player']['privileges']);exit;
		if(!$this->data['stable']['stables_id']){
			$this->session->set_flashdata('notice', "Invalid Stable.");
			redirect('game/profile/search');
		}
		$this->data['page']['title'] = $this->data['stable']['stables_name'] . " #" . $this->data['stable']['stables_id'];
		$this->load->view('layout/header', $this->data);
		$this->load->view('city/stables-view', $this->data);
		$this->load->view('layout/footer');
	}
	public function profile($id = null){
		$this->data['profile'] = new Player($id ?: $this->session->userdata('players_id'));
		$this->data['profile'] = $this->data['profile']->player;
		//$this->data['profile']['horses'] = Player::get_owned_horses($this->data['profile']['players_id']);
		$this->data['profile']['stables'] = Player::get_stables($this->data['profile']['players_id']);
		$this->data['profile']['cabs'] = Player::get_cabs($this->data['profile']['players_id']);
		$this->data['profile']['events'] = Player::get_events($this->data['profile']['players_id'], array('only_recent' => 1));
		$id = $this->data['profile']['players_id'];

		if($this->data['profile']['players_pending'] == 1 || !$this->data['profile']['players_id']){
				$this->session->set_flashdata('notice', "Invalid account.");
				redirect('game/profile');
		}

		$this->data['page']['title'] = $this->data['profile']['players_nickname'];

		$this->load->view('layout/header', $this->data);
		$this->load->view('game/profile', array('errors' => $errors, 'profile' => $this->data['profile'], 'player' => $this->data['player']));
		$this->load->view('layout/footer');
	}




	public static function horses($id = null){
		$this->data['page']['title'] = "Horses";
		$this->load->view('layout/header', $this->data);
		$this->load->view('game/horses', array('errors' => $errors, 'horses' => $this->data['horses']));
		$this->load->view('layout/footer');
	}


	public function inventory()
	{   
		$this->data['class_name']="/game/";
        if ($this->input->is_ajax_request()) {			
			$this->load->model('Inventory_Model');
			$res = $this->Inventory_Model->getInventorysList($this->session->userdata('players_id'),$_POST);
            $sub_page_view_url="viewInventory";
            $sub_page_url = 'addEditInventory';
            $sub_page_delete_url = 'deleteInventory';
            $result=[];			
            $i=$_POST['start'];
			foreach($res as $v){
                $i++;      		    
                $id = $v['itemid'];
                $info = '<b>'.$v['itemname'].'</b><br/><p><small>'.$v['itemdesc'].'</p></small>';
				$action = '<div class="action-btns row">';
                $action .= '<a class="btn btn-primary btn-sm col-md-6 col-sm-12" href="'.$this->data['class_name'].$sub_page_url."/".$v['itemid'].'" title="Edit"><i class="las la-edit"></i></a>';
                $url = $this->data['class_name'].$sub_page_delete_url."/".$v['itemid'];
                $msg = "Are you sure you want to delete this Inventory Item?";
                $action .='<a href="javascript:void(0)" msg="'.$msg.'" url="'.$url.'" title="delete" class="btn btn-primary  btn-sm col-md-6  col-sm-12 my-del-btn"><i class="las la-trash"></i></a>';
                $action .='</div>';
				$img = '<img src="'.getInventoryItemImage($v['itemimg']).'" class="img-thumbnail">';
				$result[] = array($i,$id,$info,$v['itemtype'],$v['itemrarity'],$img,dateFormate($v['created']),$action);
			}
			$output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->Inventory_Model->countAll($this->session->userdata('players_id'),$_POST),
                "recordsFiltered" => $this->Inventory_Model->countFiltered($this->session->userdata('players_id'),$_POST),
                "data" => $result
            );
            echo json_encode($output);exit;
		}else{
			$this->data['page']['title'] = "Inventory Items List";					
			$this->data['sub_page_url'] = $this->data['class_name'].'addEditInventory';
			$this->data['sub_page_title'] = 'Create Inventory Item';
            $this->data['dataTableElement'] = 'inventoryItemsList';
			$this->data['profile'] = new Player($this->session->userdata('players_id'));
			$this->data['profile'] = $this->data['profile']->player;
            $this->data['dataTableURL'] = $this->data['class_name'].'inventory';
			$this->data['errors'] = $this->session->flashdata('errors');
			$this->load->view('layout/header', $this->data);
			$this->load->view('game/inventory', $this->data);
			$this->load->view('layout/footer');
		}
	}			
	public function addEditInventory($id=false)
    {
		$this->class_name="/game/";
		$this->data['class_name']="/game/";
		$this->load->model('Inventory_Model');	
        if($id){
            $postData = $this->Inventory_Model->getInventoryDataById($id);
            if(empty($postData))
            {
                $this->session->set_flashdata('message_error','Inventory Item Not Found.');
                redirect($this->class_name.'inventory');
            }            
			if($this->session->userdata('players_id') != $postData['join_players_id'])
			{
				$this->session->set_flashdata('message_error',"You Can't Edit this Inventory Item.");
                redirect($this->class_name.'inventory');
			}
            $this->data['page']['title'] = $postData['itemname'] . " #" . $postData['itemid'];                        
        }else
        {            
			$this->data['page']['title'] = 'Create Inventory Item';
            $postData=[];
        }
        $this->load->helper('form');
        $this->data['main_page_url'] =  $this->data['BASE_URL'].$this->class_name;        
		
        if($this->input->post()){
			
            $this->load->library('form_validation');
            $set_rules = $this->Inventory_Model->config_add;
            if(!empty($postData['itemid']))
            {
                $set_rules = $this->Inventory_Model->config_edit;
            }
			
            $this->form_validation->set_rules($set_rules);
            if($this->form_validation->run()===TRUE)
			{
                $_POST['itemid']=$id;
                unset($_POST['submit']);
                $response = $this->Inventory_Model->saveInventory($_POST);
                if($response)
                {
                    $this->session->set_flashdata('message_success',$this->data['page']['title'].' Updated Successfully.');
                }else
                {
                    $this->session->set_flashdata('message_error',$this->data['page']['title'].' Updated Unsuccessfully.');
                }
                redirect($this->class_name.'inventory');
            }else{                    
                $this->session->set_flashdata('message_error','Missing information.');
				$this->session->set_flashdata('errors',$this->form_validation->error_array());				
            }            
        }
        $this->data['errors'] = $this->session->flashdata('errors');		
        $this->data['postData'] = $postData;
        $this->load->view('layout/header', $this->data);
		$this->load->view('game/addEditInventory', $this->data);
		$this->load->view('layout/footer');
    }
	public function deleteInventory($id)
	{
		$this->class_name = "/game/";
		$this->load->model('Inventory_Model');
		$postData = $this->Inventory_Model->getInventoryDataById($id);
		if(empty($postData))
		{
			$this->session->set_flashdata('message_error','Inventory Item Not Found.');
			redirect($this->class_name.'inventory');
		}            
		if($this->session->userdata('players_id') != $postData['join_players_id'])
		{
			$this->session->set_flashdata('message_error',"You Can't Edit this Inventory Item.");
			redirect($this->class_name.'inventory');
		}else
		{
			$page_title='Inventory Item Deleted';
			$this->load->model(['Player']);
			if($this->Inventory_Model->deleteInventory($id)==1)
			{
			    $this->session->set_flashdata('message_success',$page_title.' Successfully.');
			}
			else
			{
			    $this->session->set_flashdata('message_error',$page_title.' Unsuccessfully.');
			}			
			redirect($this->class_name.'inventory');
		}
	}
}