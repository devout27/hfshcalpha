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
			$data = [];
			foreach($res as $v){
        $i++;
				$horse = '<a href="/horses/view/'.$v["join_horse_id"].'">'.'#'.generateId($v['join_horse_id']).' '.$v['join_horses_name'].'</a>';
				$info = "<p><b>Name:</b>#".$v['join_players_id'].' '.$v['join_players_username']."<br><b>Email:</b>".$v['email']."</p>";
        $title = $v['title'];				
				$price = '$'.$v['price'];				
				$aconfirm = "return confirm('Are you sure want to accept this proposal and transfer this horse to #".$v['join_players_id'].' '.$v['join_players_username']." player?')";
				$rconfirm = "return confirm('Are you sure want to reject this purposal?')";
				$action = '<div class="row justify-content-center"><div class="col-md-6"><a class="accept-btn" onclick="'.$aconfirm.'" href="'.base_url('purposals/update/'.$v['id'].'/accept').'"><i class="las la-check-circle"></i></a></div> <div class="col-md-6"><a  onclick="'.$rconfirm.'" class="reject-btn" href="'.base_url('purposals/update/'.$v['id'].'/reject').'"><i class="las la-times-circle"></i></a></div></div>';
				$data[] = array($i,$info,$horse,$title,$price,dateFormate($v['created']),$action);
			}
			$output = array("draw" => $_POST['draw'],"recordsTotal" => $this->purposal->countAll($this->data['player']['players_id'],$_POST),"recordsFiltered" => $this->purposal->countFiltered($this->data['player']['players_id'],$_POST),"data" => $data);
      echo json_encode($output);exit;
		}else{
			$this->data['page']['title'] = "My Horses for Sale";
			$this->data['dataTableElement'] = 'dt-my-purposals-list';
			$this->data['dataTableURL'] = base_url('manage-sale-purposals');
			$this->load->view('layout/header', $this->data);
			$this->load->view('horses/managePurposals',$this->data);
			$this->load->view('layout/footer');
		}
	}
	public function update($id,$action)
	{
		if($purposal = $this->purposal->getPurposal($id))
		{
			if($purposal->join_horse_owner_id == $this->data['player']['players_id'])
			{
				if($action == "accept")
				{
					$this->data['horse'] = new Horse($purposal->join_horse_id);
					$this->data['horse'] = $this->data['horse']->horse;
					$response = $this->horse->transfer($this->data['player'], $this->data['horse'], ['recipient'=>'Member','players_id'=>$purposal->join_players_id]);
					if(count($response['errors']) > 0){
						$this->session->set_flashdata('notice', "There was a problem transferring the Horse because ".reset($response['errors']));
					}else{
						$this->purposal->delete($purposal->id);
						$this->session->set_flashdata('notice', "Proposal accepted and Horse transferred successfully.");
					}
				}elseif($action == "reject" && $this->purposal->delete($purposal->id))
				{
					$notice = "Sorry! your sale proposal for <a href=/horses/view/" . $purposal->join_horse_id . ">" . $purposal->join_horses_name . " #" . generateId($purposal->join_horse_id) . "</a> rejected by horse owner.";
					$CI =& get_instance();
					$CI->db->query("INSERT INTO notices(notices_body, join_players_id) VALUES(?,?)", array($notice, $purposal->join_players_id));
					$this->session->set_flashdata('notice', "Proposal rejected successfully.");
				}else
				{
					$this->session->set_flashdata('notice', "Missing Information.");		
				}
			}
		}else
		{
			$this->session->set_flashdata('notice', "Proposal not found.");
		}		
		return redirect(base_url('manage-sale-purposals'));
	}
}