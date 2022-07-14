<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Horses extends MY_Controller {

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
		$this->data['page']['title'] = "Search Horses";
		$this->data['breeds'] = $this->horse->get_breeds();
		$this->data['base_colors'] = $this->horse->get_base_colors();
		$this->data['base_patterns'] = $this->horse->get_base_patterns();
		$this->data['lines'] = $this->horse->get_lines();
		$this->data['disciplines'] = $this->horse->get_disciplines();
        if($this->input->get('search')){ $this->data['search'] = $this->horse->search($_GET); }
		$this->data['searchDataTableEntity'] = @$_GET['show_all'] ? "show-all-results" : "dt-horses-search";
		$this->load->view('layout/header', $this->data);
		$this->load->view('horses/index', $this->data);
		if($this->input->get('search')){
			$this->load->view('partials/horse-search', $this->data); 
		}
		$this->load->view('layout/footer');
	}
	public function manageHorses()
	{				
		if ($this->input->is_ajax_request()) {   	
			$res = $this->horse->getMyHorsesList($this->data['player']['players_id'],$_POST);
			$data = [];
			foreach($res as $v){                
				$name = $v['horses_competition_title'].' '.$v['horses_breeding_title'].' '.$v['horses_name'];
				$action = '<a href="/horses/view/'.$v["horses_id"].'">View</a>';
				$vetFerr = $v['horses_vet'].' '.$v['horses_farrier'];
				$status = $v['horses_pending']==1 ? '<span class="badge badge-danger pb-1">Pending</span>' : '<span class="badge badge-success pb-1">Approved</span>';
				$stable = $v['stables_name'];
				$i = generateId($v["horses_id"]);				
				$data[] = array($i,$name,$stable,$v['horses_birthyear'],$v['horses_color'],$v['horses_breed'],$v['horses_gender'],$v['horses_hs'],$v['horses_fs'],$vetFerr,$status,$action);
			}			
			$output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->horse->countAll($this->data['player']['players_id'],$_POST),
                "recordsFiltered" => $this->horse->countFiltered($this->data['player']['players_id'],$_POST),
                "data" => $data
            );
            echo json_encode($output);exit;			
		}else{			
			$this->data['post'] = $_POST;
			$this->data['breeds'] = $this->horse->get_breeds();
			$this->data['lines'] = $this->horse->get_lines();
			$this->data['disciplines'] = $this->horse->get_disciplines();
            $this->data['base_colors'] = $this->horse->get_base_colors();
            $this->data['base_patterns'] = $this->horse->get_base_patterns();
			$this->data['requests'] = Horse::get_breeding_requests(false,$this->data['player']['players_id']);
			$this->data['page']['title'] = "Manage Horses";
			$this->data['dataTableElement'] = 'dt-my-horses-list';
			$this->data['dataTableURL'] = base_url('manage-horses');
			$this->data['stables'] = Player::get_stables($this->data['profile']['players_id']);			
			$this->load->view('layout/header', $this->data);
			$this->load->view('horses/manageHorses',$this->data);
			$this->load->view('layout/footer');
		}
		
	}
	public function manageHorsesVetAndFarrier($type="farrier")
	{
		if ($this->input->is_ajax_request()) {   	
			$res = $this->horse->getMyVetHorsesList($this->data['player']['players_id'],$type);
			$html = "";
			if(count($res) > 1)
			{				
				$html = "<div class='form-input-container row'>";
				foreach ($res as $key => $horse) {								
					$html .= "<div class='col-md-3'><div class='form-check form-check-inline'>
								<input class='form-check-input' type='checkbox' id='inlineCheckbox".$horse['horses_id']."' value='".$horse['horses_id']."' checked name='horses[]'>
								<label class='form-check-label' for='inlineCheckbox".$horse['horses_id']."'>".$horse['horses_name']."</label>
							</div>
						</div>";
				}
				$html .= "</div>";
			}
			echo $html;die;
		}elseif($this->input->server('REQUEST_METHOD') === 'POST'){						
			if(@$_POST['appointment'] !== "Required Annual Care" && @$_POST['appointment'] !== "Disaster Care Package" &&  @$_POST['appointment'] !== "Basic Care" &&  @$_POST['appointment'] !== "Performance/Race Package")
			{	
				$this->session->set_flashdata('notice', "Please select an appointment.");
			}elseif($type=="vet" && count($_POST['horses']) > 0){
				$error = false;
				foreach ($_POST['horses'] as $key => $horse_id) {					
					$horse = new Horse($horse_id);
					$this->horse->vet($this->data['player'],$horse->horse,$_POST);
				}
			}elseif($type=="farrier" && count($_POST['horses']) > 0){
				foreach ($_POST['horses'] as $key => $horse_id) {
					$horse = new Horse($horse_id);
					$this->horse->farrier($this->data['player'],$horse->horse,$_POST);
				}
			}else
			{
				$this->session->set_flashdata('notice', "Please select atleast one horse.");
			}			
			$this->data['post'] = $_POST;
			$this->data['type'] = $type;
			$this->data['page']['title'] = "Manage Horses ".ucFirst($type);
			$this->load->view('layout/header', $this->data);
			$this->load->view('horses/manage-horses-vet-and-farrier',$this->data);
			$this->load->view('layout/footer');
		}else{
			$this->data['post'] = $_POST;
			$this->data['type'] = $type;
			$this->data['page']['title'] = "Manage Horses ".ucFirst($type);		
			$this->load->view('layout/header', $this->data);
			$this->load->view('horses/manage-horses-vet-and-farrier',$this->data);
			$this->load->view('layout/footer');
		}		
	}	
	public function register(){			
		$this->data['player']['today_adoption'] = $this->horse->getTodayAdoption($this->player->player_id);
		$this->data['page']['title'] = "Register Horse";
		$this->data['breeds'] = $this->horse->get_breeds();
		$this->data['base_colors'] = $this->horse->get_base_colors();
		$this->data['base_patterns'] = $this->horse->get_base_patterns();
		$this->data['lines'] = $this->horse->get_lines();
		$this->data['disciplines'] = $this->horse->get_disciplines();
		$this->data['my_stables'] = $this->horse->getMyStables($this->data['player']['players_id']);
		$allowed = array(
				'breeds' => $this->data['breeds'],
				'base_colors' => $this->data['base_colors'],
				'base_patterns' => $this->data['base_patterns'],
				'lines' => $this->data['lines'],
				'disciplines' => $this->data['disciplines']
			);


		if($this->input->post('create')){					
			$response = $this->horse->register($this->player, $_POST, $allowed);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem creating your horse.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
				redirect('horses/register');
			}
			redirect('horses/register');
		}		
		$this->load->view('layout/header', $this->data);
		$this->load->view('horses/register', $this->data);
		$this->load->view('layout/footer');
	}


	public function adopt($id, $payment){
		$this->data['horse'] = new Horse($id);
		$this->data['horse'] = $this->data['horse']->horse;

		$response = $this->horse->adopt($this->data['player'], $this->data['horse'], $payment);
		if(count($response['errors']) > 0){
			$this->session->set_flashdata('notice', "There was a problem adopting the horse.");
			$this->session->set_flashdata('errors', $response['errors']);
		}else{
			$this->session->set_flashdata('notice', "Horse Adopted!");
		}
		redirect('horses/view/' . $id);
	}

	public function import($id){
		$this->load->model('bank');
		$this->data['accounts'] = Bank::get_accounts($this->session->userdata('players_id'));
		$this->data['horse'] = new Horse($id);
		$this->data['horse'] = $this->data['horse']->horse;

		if($this->input->post('confirm')){
			$response = $this->horse->import($this->player, $this->data['horse'], $_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem importing the horse.");
				//$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
				redirect('horses/import/' . $id);
			}
			redirect('horses/view/' . $id);

		}

		$this->data['page']['title'] = "Import " . $this->data['horse']['horses_name'] . " #" . generateId($this->data['horse']['horses_id']);
		$this->load->view('layout/header', $this->data);
		$this->load->view('horses/import', $this->data);
		$this->load->view('layout/footer');
	}

	public function breed($id){		
		$this->data['horse'] = new Horse($id);
		$this->data['horse'] = $this->data['horse']->horse;
		$this->data['breeds'] = $this->horse->get_breeds();
		$this->data['lines'] = $this->horse->get_lines();
		$this->data['disciplines'] = $this->horse->get_disciplines();
		$this->data['mares'] = Horse::get_breedable_mares($this->session->userdata('players_id'));
		$this->data['stallions'] = Horse::get_breedable_stallions($this->session->userdata('players_id'));
		$this->data['requests'] = Horse::get_breeding_requests($this->data['horse'],$this->session->userdata('players_id'));///////ak
		$this->data['base_colors'] = $this->horse->get_base_colors();
		$this->data['base_patterns'] = $this->horse->get_base_patterns();
		$allowed = array(
				'breeds' => $this->data['breeds'],
				'base_colors' => $this->data['base_colors'],
				'base_patterns' => $this->data['base_patterns'],
				'lines' => $this->data['lines'],
				'disciplines' => $this->data['disciplines']
		);
		$is_breeable = $this->data['horse']['horses_gender'] == "Stallion" ? Horse::is_breedable($id,true)  : Horse::is_breedable($id);
		if(!$this->data['horse']['horses_id']){
			$this->session->set_flashdata('notice', "Invalid horse.");
			redirect('manage-horses');
		}elseif($this->data['horse']['horses_pending']){
			$this->session->set_flashdata('notice', "Horse is pending registration.");
			redirect('manage-horses');
		}elseif(!$is_breeable){
			$this->session->set_flashdata('notice', "Horse isn't breedable.");
			redirect('horses/view/' . $id);
		}
		if($this->input->post('breed')){
			if(isset($_POST['stallion_id']))
			{
				$response = $this->horse->submit_mare_breed_request($this->player, $this->data['horse'], $_POST, $allowed);
			}else
			{
				$response = $this->horse->submit_breed_request($this->player, $this->data['horse'], $_POST, $allowed);
			}
			if(count($response['errors']) > 0){				
				$this->session->set_flashdata('notice', "There was a problem submitting the breeding request.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
				redirect($_SERVER['HTTP_REFERER']);
			}
			redirect($_SERVER['HTTP_REFERER']);
		}elseif($this->input->post('reject_temporarily')){
			$response = $this->horse->reject_breed_request($this->player, $this->data['horse'], $_POST, true);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem in rejecting the breeding request.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
				redirect($_SERVER['HTTP_REFERER']);
			}
			$this->session->set_flashdata('notice', "Rejected.");
			redirect($_SERVER['HTTP_REFERER']);
		}elseif($this->input->post('reject_permanently')){
			$response = $this->horse->reject_breed_request($this->player, $this->data['horse'], $_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem rejecting the breeding request.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
				redirect($_SERVER['HTTP_REFERER']);
			}
			$this->session->set_flashdata('notice', "Rejected.");
			redirect($_SERVER['HTTP_REFERER']);
		}elseif($this->input->post('resend_breeding_request')){
			$response = $this->horse->accept_breed_request($this->player, $this->data['horse'], $_POST, true);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem in resending your breeding request. because ".$response['errors'][0]);
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
				redirect($_SERVER['HTTP_REFERER']);
			}
			$this->session->set_flashdata('notice', "Your breeding request has been resend successfully.");
			redirect($_SERVER['HTTP_REFERER']);
		}elseif($this->input->post('accept')){
			$response = $this->horse->accept_breed_request($this->player, $this->data['horse'], $_POST);
			if(count($response['errors']) > 0){				
				$this->session->set_flashdata('notice', "There was a problem accepting the request.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
				redirect($_SERVER['HTTP_REFERER']);
			}
			$this->session->set_flashdata('notice', "Accepted.");
			redirect($_SERVER['HTTP_REFERER']);
		}
		/*check...
			-is stallion available for breeding?
			-tell player to submit check to owner
			-is stallion of proper age for breeding
			-is mare of proper age for breeding
			-create notice of breeding request
			-owner can accept/reject pending requests
			--if accepted, create pending horse
		*/

		$this->data['page']['title'] = "Breed to Horse " . $this->data['horse']['horses_name'] . " #" . generateId($this->data['horse']['horses_id']);
		$this->load->view('layout/header', $this->data);
		$this->load->view('horses/breed', $this->data);
		$this->load->view('layout/footer');

	}
	public function breeding($action,$breeding_id)
	{
		if($action == "accept" && !empty($breeding_id))
		{			
			$breeding = $this->horse->get_breeding_request($breeding_id);
			if(@$breeding['receiver_player_id'])
			{
				$player = new Player($breeding['receiver_player_id']);
				$player = $player->player;
				$horse = new Horse($id);
				$horse = $horse->horse;
				$breeding['horses_name'] = $breeding['horses_breedings_name'];
				$breeding['horses_owner'] = $breeding['horses_breedings_owner'];
				$breeding['horses_gender'] = $breeding['horses_breedings_gender'];
				$breeding['disciplines'] = $breeding['horses_breedings_disciplines'];
				$breeding['horses_birthyear'] = $breeding['horses_birthyear'];
				$breeding['horses_breed'] = $breeding['horses_breedings_breed'];
				$breeding['horses_breed2'] = $breeding['horses_breedings_breed2'];
				$breeding['horses_color'] = $breeding['horses_breedings_color'];
				$breeding['horses_pattern'] = $breeding['horses_breedings_pattern'];
				$breeding['horses_line'] = $breeding['horses_breedings_line'];
				$breeding['horses_breedings_id'] = $breeding['horses_breedings_id'];
				$response = $this->horse->accept_breed_request($player, $horse, $breeding);
				if(count($response['errors']) > 0){
					$this->session->set_flashdata('notice', "There was a problem accepting the request. because ".array_values($response['errors'])[0]);
					$this->session->set_flashdata('errors', $response['errors']);
					redirect($_SERVER['HTTP_REFERER']);
				}else
				{
					$this->session->set_flashdata('notice', "Breeding request accepted.");
				}
			}			
		}elseif($action == "reject" &&  !empty($breeding_id)){
			$breeding = $this->horse->get_breeding_request($breeding_id);
			if(@$breeding['receiver_player_id'])
			{
				$player = new Player($breeding['receiver_player_id']);
				$player = $player->player;
				$horse = new Horse($id);
				$horse = $horse->horse;
				$response = $this->horse->reject_breed_request($player, $horse, $breeding);
				if(count($response['errors']) > 0){
					$this->session->set_flashdata('notice', "There was a problem rejecting the request.");				
					$this->session->set_flashdata('errors', $response['errors']);
					redirect($_SERVER['HTTP_REFERER']);
				}else
				{
					$this->session->set_flashdata('notice', "Breeding request Rejected.");
				}
				
			}
		}else
		{
			$this->session->set_flashdata('notice', "Missing Information.");
		}		
		redirect('manage-horses');
	}
	public function view_offspring_genes($id){
		$this->data['horse1'] = new Horse($id);
		$this->data['horse1'] = $this->data['horse1']->horse;
		$this->data['horse2'] = new Horse($_POST['horses_id']);
		$this->data['horse2'] = $this->data['horse2']->horse;
		$this->data['page']['title'] = "Possible Foal Genetic Material: " . $this->data['horse1']['horses_name'] . " #" . generateId($this->data['horse1']['horses_id']) ." x " . $this->data['horse2']['horses_name'] . " #" . generateId($this->data['horse2']['horses_id']);
		$this->data['genes'] = Horse::sample_genes($id, $this->data['horse1']['genes'], $_POST['horses_id'], $this->data['horse2']['genes']);
		//unset($this->data['horse1'], $this->data['horse2']);

		$this->load->view('layout/header', $this->data);
		$this->load->view('horses/horses-breed-sample', $this->data);
		$this->load->view('layout/footer');
	}

	public function view($id){
		$this->data['horse'] = new Horse($id);
		$this->data['horse'] = $this->data['horse']->horse;
		if(!$this->data['horse']['horses_id']){
			$this->session->set_flashdata('notice', "Invalid horse.");
			redirect('horses');
		}elseif($this->data['horse']['horses_pending']){
			$this->session->set_flashdata('notice', "Horse is pending registration.");
			redirect('horses');
		}
		if($status = Horse::get_horses_vet_status($id))
		{
			$this->data['horse']['horses_vet'] = $status;	
		}
		if($status = Horse::get_horses_farrier_status($id))
		{
			$this->data['horse']['horses_farrier'] = $status;	
		}
		$this->data['horses'] = Horse::get_horses_dropdown($this->session->userdata('players_id'));		
		$this->data['page']['title'] = $this->data['horse']['horses_name'] . " #" . generateId($this->data['horse']['horses_id']);
		$this->load->view('layout/header', $this->data);
		$this->load->view('horses/view', $this->data);
		$this->load->view('layout/footer');
	}

	public function auction($id){
		$this->load->model('auction');
		$this->load->model('bank');
		$this->data['horse'] = new Horse($id);
		$this->data['horse'] = $this->data['horse']->horse;
		if(!$this->data['horse']['horses_id']){
			$this->session->set_flashdata('notice', "Invalid horse.");
			redirect('horses');
		}elseif($this->data['horse']['horses_pending']){
			$this->session->set_flashdata('notice', "Horse is pending registration.");
			redirect('horses');
		}elseif($this->data['horse']['horses_sale']){
			$this->session->set_flashdata('notice', "Horse is listed for sale. It may not be auctioned while it is for sale.");
			redirect('horses/view/' . $id);
		}

		$auctioned = $this->db->query("SELECT join_horses_id FROM auctions WHERE join_horses_id=? AND auctions_end>=NOW()", array($id))->num_rows();
		if($auctioned >= 1){
			$this->session->set_flashdata('notice', "Horse is already available for auction.");
			redirect('horses/view/' . $id);
		}

		$this->data['page']['title'] = "Auction " . $this->data['horse']['horses_name'] . " #" . generateId($this->data['horse']['horses_id']);


		if($this->input->post('auction')){
			$response = $this->auction->auction($this->data['player'], $this->data['horse'], $_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem auctioning the Horse.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
				redirect('horses/auction/' . $id);
			}else{
				$this->session->set_flashdata('notice', "Horse is now listed for auction.");
			}
			redirect('horses/view/' . $id);
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('horses/auction', $this->data);
		$this->load->view('layout/footer');
	}

	public function update($id){		
		$this->data['horse'] = new Horse($id);
		$this->data['horse'] = $this->data['horse']->horse;
		$this->data['page']['title'] = "Update Horse";
		$this->data['breeds'] = $this->horse->get_breeds();
		$this->data['base_colors'] = $this->horse->get_base_colors();
		$this->data['my_stables'] = $this->horse->getMyStables($this->data['player']['players_id']);
		$this->data['base_patterns'] = $this->horse->get_base_patterns();
		$this->data['lines'] = $this->horse->get_lines();
		$this->data['disciplines'] = $this->horse->get_disciplines();
		$this->data['genes'] = $this->horse->get_genes();
		$allowed = array(
				'breeds' => $this->data['breeds'],
				'base_colors' => $this->data['base_colors'],
				'base_patterns' => $this->data['base_patterns'],
				'lines' => $this->data['lines'],
				'disciplines' => $this->data['disciplines'],				
			);

		if(!$this->data['horse']['horses_id']){
			$this->session->set_flashdata('notice', "Invalid horse.");
			redirect('horses');
		}elseif($this->data['horse']['horses_pending']){
			$this->session->set_flashdata('notice', "Horse is pending registration.");
			redirect('horses');
		}

		$this->data['page']['title'] = $this->data['horse']['horses_name'] . " #" . generateId($this->data['horse']['horses_id']);

		if($this->input->post('update')){
			$response = $this->horse->update($this->data['player'], $this->data['horse'], $_POST, $allowed);
			if(count($response['errors']) > 0){
				//pre($response);exit;
				$this->session->set_flashdata('notice', "There was a problem editing the horse.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
				redirect('horses/update/' . $id);
			}else{
				$this->session->set_flashdata('notice', "Horse updated.");
			}
			redirect('horses/view/' . $id);
		}elseif($this->input->post('update_genes')){
			$response = $this->horse->update_genes($this->data['player'], $this->data['horse'], $_POST, $this->data['genes']);
			if(count($response['errors']) > 0){
				//pre($response);exit;
				$this->session->set_flashdata('notice', "There was a problem editing the genes.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
				redirect('horses/update/' . $id);
			}else{
				$this->session->set_flashdata('notice', "Genes updated.");
			}
			redirect('horses/view/' . $id);
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('horses/update', $this->data);
		$this->load->view('layout/footer');
	}

	/* public function buy($id){				
		$this->data['horse'] = new Horse($id);
		$this->data['horse'] = $this->data['horse']->horse;
		$this->data['page']['title'] = "Update Horse";
		$this->data['breeds'] = $this->horse->get_breeds();
		$this->data['base_colors'] = $this->horse->get_base_colors();
		$this->data['base_patterns'] = $this->horse->get_base_patterns();
		$this->data['lines'] = $this->horse->get_lines();
		$this->data['disciplines'] = $this->horse->get_disciplines();
		$this->data['genes'] = $this->horse->get_genes();		
		if(!$this->data['horse']['horses_id']){
			$this->session->set_flashdata('notice', "Invalid horse.");
			redirect('horses');
		}elseif($this->data['horse']['horses_pending']){
			$this->session->set_flashdata('notice', "Horse is pending registration.");
			redirect('horses');
		}
		$this->data['page']['title'] = $this->data['horse']['horses_name'] . " #" . generateId($this->data['horse']['horses_id']);
		if($this->input->post('submit')){
			if($this->data['horse']['horses_sale']==0)
			{				
				$this->session->set_flashdata('notice', "Horse is not available For Sale.");
			}else{
				
				$response = $this->purposal->SavePurposal($this->data['player'], $this->data['horse'], $_POST);
				if(count($response['errors']) > 0){					
					$this->session->set_flashdata('notice', "There was a problem for submitting your purposal.");
					$this->session->set_flashdata('post', $_POST);
					$this->session->set_flashdata('errors', $response['errors']);				
				}else{
					$this->session->set_flashdata('notice', "Proposal Sent Successfully.");
					redirect('horses/view/' . $id);
				}			
			}
		}
		$this->load->view('layout/header', $this->data);
		$this->load->view('horses/buy', $this->data);
		$this->load->view('layout/footer');
	} */

	public function buy($id){				
		$this->data['horse'] = new Horse($id);
		$this->data['horse'] = $this->data['horse']->horse;
		if(!$this->data['horse']['horses_id']){
			$this->session->set_flashdata('notice', "Invalid horse.");
			redirect('horses');
		}elseif($this->data['horse']['horses_pending']){
			$this->session->set_flashdata('notice', "Horse is pending registration.");
			redirect('horses');
		}
		if($this->data['horse']['horses_sale']==0)
		{				
			$this->session->set_flashdata('notice', "Horse is not available For Sale.");
		}else{
			if($this->purposal->checkPurposalAlreadySent($this->data['horse']['horses_id'],$this->data['horse']['join_players_id'],$this->data['player']['players_id']))
			{
				$this->session->set_flashdata('notice', "You have already sent proposal for this horse.");
			}else
			{				
				$data = [
					'title'=>$this->player->player['players_nickname'].' want to purchase your horse.',
					'email'=>$this->player->player['players_email'],
					'join_horses_name'=>$this->data['horse']['horses_name'],
					'join_players_username'=>$this->data['player']['players_nickname'],
					'join_players_id'=>$this->data['player']['players_id'],
					'join_horse_owner_id'=>$this->data['horse']['join_players_id'],
					'join_horse_id'=>$this->data['horse']['horses_id'],
					'price' => $this->data['horse']['horses_sale_price'],
					'description'=>'',
				];
				$response = $this->purposal->SavePurposal($this->data['player'], $this->data['horse'],$data);
				$this->session->set_flashdata('notice', "Proposal Sent Successfully.");
			}
		}		
		redirect('horses/view/' . $id);
	}

	public function transfer($id){
		$this->data['horse'] = new Horse($id);
		$this->data['horse'] = $this->data['horse']->horse;
		$this->data['page']['title'] = "Transfer Horse";
		$this->data['recipients'] = array('Member', 'Humane Society', 'Retirement Home', 'Cemetery', 'Export');

		if(!$this->data['horse']['horses_id']){
			$this->session->set_flashdata('notice', "Invalid horse.");
			redirect('horses');
		}elseif($this->data['horse']['horses_pending']){
			$this->session->set_flashdata('notice', "Horse is pending registration.");
			redirect('horses');
		}

		if($this->input->post('transfer')){
			$response = $this->horse->transfer($this->data['player'], $this->data['horse'], $_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem transferring the Horse.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Horse transferred.");
				redirect('horses/view/' . $id);
			}
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('horses/transfer', $this->data);
		$this->load->view('layout/footer');
	}

	public function vet($id){
		$this->data['horse'] = new Horse($id);
		$this->data['horse'] = $this->data['horse']->horse;
		$this->data['page']['title'] = "Veterinary Office";

		if(!$this->data['horse']['horses_id']){
			$this->session->set_flashdata('notice', "Invalid horse.");
			redirect('horses');
		}elseif($this->data['horse']['horses_pending']){
			$this->session->set_flashdata('notice', "Horse is pending registration.");
			redirect('horses');
		}

		if($this->input->post('vet')){
			$response = $this->horse->vet($this->data['player'], $this->data['horse'], $_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem setting up the appointment.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Horse has an appointment with the Vet.");
				redirect('horses/view/' . $id);
			}
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('horses/vet', $this->data);
		$this->load->view('layout/footer');
	}


	public function farrier($id){
		$this->data['horse'] = new Horse($id);
		$this->data['horse'] = $this->data['horse']->horse;
		$this->data['page']['title'] = "Farrier Office";

		if(!$this->data['horse']['horses_id']){
			$this->session->set_flashdata('notice', "Invalid horse.");
			redirect('horses');
		}elseif($this->data['horse']['horses_pending']){
			$this->session->set_flashdata('notice', "Horse is pending registration.");
			redirect('horses');
		}

		if($this->input->post('farrier')){
			$response = $this->horse->farrier($this->data['player'], $this->data['horse'], $_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem setting up the appointment.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Horse has an appointment with the Farrier.");
				redirect('horses/view/' . $id);
			}
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('horses/farrier', $this->data);
		$this->load->view('layout/footer');
	}
	
}