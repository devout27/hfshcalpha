<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purposals extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->kick_out();
		$this->player_id = $this->session->userdata('players_id');
		$this->player = new Player($this->player_id);
		$this->player->touch();
		$this->data['player'] = $this->player->player;
		$this->data['player']['unread'] = $this->player->get_unread();
		$this->data['online_players'] = $this->player->get_online_count();
		$this->load->model('horse');
        $this->load->model('purposal');
		$this->load->model('privileges');
		$this->data['privileges'] = $this->privileges->get();
		$this->data['page']['title'] = "Hurricane Farm";
	}
	public function index(){
		$this->data['page']['title'] = "Manage Purposals";				
		if($this->input->post('search')){
			$this->data['search'] = $this->horse->search($_POST);
		}
		$this->load->view('layout/header', $this->data);
		$this->load->view('horses/index', $this->data);
		if($this->input->post('search')){
			$this->load->view('partials/horse-search', $this->data['search']);
		}
		$this->load->view('layout/footer');
	}
	public function managePurposals()
	{				
		if ($this->input->is_ajax_request()) {   	
           
			$res = $this->purposal->getMyPurposalsList($this->data['player']['players_id'],$_POST);
            $i = $_POST['start'];
			foreach($res as $v){
                $i++;
				$horse = '<a href="/horses/view/'.$v["join_horse_id"].'">'.'#'.generateId($v['join_horse_id']).' '.$v['join_horses_name'].'</a>';
				$info = "<p><b>Member Id:</b> ".$v['join_players_id']."<br><b>Name:</b> ".$v['join_players_username']."<br><b>Email:</b> ".$v['email']."<br><b>Phone Number: </b>".$v['phone_number']."</p>";
                $title = $v['title'];
				$description = $v['description'];
				$price = '$'.$v['price'];
				$data[] = array($i,$info,$horse,$title,$description,$price,dateFormate($v['created']));
			}
			$output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->purposal->countAll($this->data['player']['players_id'],$_POST),
                "recordsFiltered" => $this->purposal->countFiltered($this->data['player']['players_id'],$_POST),
                "data" => $data
            );
            echo json_encode($output);exit;
		}else{
			$this->data['page']['title'] = "Manage Horses Sale Purposals";
			$this->data['dataTableElement'] = 'dt-my-purposals-list';
			$this->data['dataTableURL'] = base_url('manage-sale-purposals');
			$this->load->view('layout/header', $this->data);
			$this->load->view('horses/managePurposals',$this->data);
			$this->load->view('layout/footer');
		}
		
	}

}