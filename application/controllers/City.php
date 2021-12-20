<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class City extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->kick_out();
		$this->player_id = $this->session->userdata('players_id');
		$this->player = new Player($this->player_id);
		$this->player->touch();
		$this->data['player'] = $this->player->player;
		$this->data['player']['unread'] = $this->player->get_unread();
		$this->data['online_players'] = $this->player->get_online_count();
		$this->load->model('bank');
		$this->load->model('cabs');
		$this->load->model('auction');
		$this->data['page']['title'] = "City";
	}


	public function index(){
		$this->load->view('layout/header', $this->data);
		$this->load->view('city/index', $this->data);
		$this->load->view('layout/footer');
	}

	public function colosseum($type = ""){
		$this->data['page']['title'] = "The Colosseum";
		$this->data['auctions'] = Auction::get_auctions();
		$horses = Auction::get_auctions(array('type' => $type));
		$this->data['accounts'] = Bank::get_accounts($this->session->userdata('players_id'));
		$this->data['type'] = $type;
		$this->data['bank_accounts'] = Bank::list_accounts_dropdown($this->session->userdata('players_id'), 'bank_id', NULL, NULL, NULL, 'Checking');

		if($this->input->post('bid')){
			$response = Auction::bid($this->player->player, $_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem placing the bid.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
				redirect('city/colosseum/' . $type);
			}
			$this->session->set_flashdata('notice', "Bid placed.");
			redirect('city/colosseum/' . $type);
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('city/colosseum', $this->data);
		if($type){
			$this->load->view('partials/auctions', array('horses' => $horses, 'errors' => $this->session->flashdata('errors'), 'post' => $this->session->flashdata('post'), 'player' => $this->data['player']));
		}
		$this->load->view('layout/footer');
	}




	public function credits(){
		$this->data['page']['title'] = "Credits";
		$this->load->model('articles');
		$this->data['article'] = $this->articles->get_article(13);

		$this->load->view('layout/header', $this->data);
		$this->load->view('city/credits', $this->data);
		$this->load->view('layout/footer');
	}

	public function humane(){
		$this->data['page']['title'] = "Humane Society";
		$this->load->model('articles');
		$this->load->model('horse');
		$this->data['article'] = $this->articles->get_article(15);

		$params = array(
				'join_players_id' => HUMANE_ID,
				'horses_adoptable' => 1,
			);
		$this->data['search'] = $this->horse->search($params);

		$this->load->view('layout/header', $this->data);
		$this->load->view('city/humane', $this->data);
		$this->load->view('layout/footer');
	}

	public function bank(){ 
		$this->data['page']['title'] = "Grand Bank";
		$this->data['accounts'] = Bank::get_accounts($this->session->userdata('players_id'));
		$this->data['membership'] = array(
				'Less than 2 months',
				'2 to 6 months',
				'6 to 12 months',
				'1 to 3 years',
				'4 plus years',
			);

		$this->load->view('layout/header', $this->data);
		$this->load->view('city/bank', array('data' => $this->data, 'post' => $this->session->flashdata('post'), 'errors' => $this->session->flashdata('errors')));
		$this->load->view('layout/footer');
	}


	public function bank_account($id){  
		//TODO: allow admins to view all bank accounts
		$this->data['page']['title'] = "Statement";
		$account = new Bank($id);
		$this->data['account'] = $this->bank->get($id);

		if($this->data['account']['join_players_id'] != $this->session->userdata('players_id')){
			$this->session->set_flashdata('notice', "You don't own this account.");
			if(!$this->data['player']['privileges']['privileges_bank']){
				redirect('city/bank');
			}
		}elseif($this->data['account']['bank_status'] == "Pending"){
			$this->session->set_flashdata('notice', "Account is currently pending.");
			redirect('city/bank');
		}elseif($this->data['account']['bank_status'] == "Closed"){
			$this->session->set_flashdata('notice', "Account is closed.");
			redirect('city/bank');
		}
     


		if($this->input->post('update_bank_details')){
			$response = Bank::edit_account($this->player->player, $this->data['account'], $_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem updating the bank account.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
				redirect('city/bank/' . $id);
			}
			$this->session->set_flashdata('notice', "Account updated.");
			redirect('city/bank/' . $id);
		}

		$this->data['page']['title'] = $this->data['account']['bank_type'] . " Statement: " . $this->data['account']['bank_nickname'] . " #" . $this->data['account']['bank_id'];

      
		$this->load->view('layout/header', $this->data);
		if($this->data['account']['bank_type'] == "Checking"){
			$this->load->view('city/bank-checking', $this->data);
		}elseif($this->data['account']['bank_type'] == "Savings"){
			$this->load->view('city/bank-savings', $this->data);
		}elseif($this->data['account']['bank_type'] == "Business"){
			$this->load->view('city/bank-business', $this->data);
		}elseif($this->data['account']['bank_type'] == "Loan"){
			$this->load->view('city/bank-loan', $this->data);
		}

		$this->load->view('layout/footer');
	}

	public function open_account(){ 
		if($this->input->post('open_savings')){
			$response = $this->bank->open_savings($this->player->player);
		
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem opening your savings account.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}
		}elseif($this->input->post('open_business')){
			$response = $this->bank->open_business($this->player->player);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem opening your business account.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}
		}elseif($this->input->post('apply_loan')){ 
			$response = $this->bank->apply_loan($this->player->player, $_POST); 
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem processing your loan application.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}
		}
		redirect('city/bank');
	}

	public function transfer($id = null){ 
		$this->data['transfers'] = $this->bank->get_recurring($this->player->player);
		$this->data['page']['title'] = "Transfer Money";
		if($this->input->post('transfer_money')){
			$response = $this->bank->transfer($this->player->player, $_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem transferring the money.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}
			if($this->input->post('transfer_recurring') == "No"){
				redirect('city/bank/' . $response['bank_id'] ?: $id);
			}else{
				redirect('city/bank/transfer/');
			}
		}

		for($i=1; $i<32; $i++){
			if($i < 10){$i2 = "0" . $i;
			}else{$i2 = $i;}
			$this->data['days'][$i2] = $i2;
			if($i < 13){
				$this->data['months'][$i2] = $i2;
			}
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('city/bank-transfer', $this->data);
		$this->load->view('layout/footer');
	}

	public function process_check($id){ 
		$response = $this->bank->process_check($this->player->player, $id, $_POST['action']);
		if(count($response['errors']) > 0){
			$this->session->set_flashdata('notice', "There was a problem processing the check.");
			$this->session->set_flashdata('post', $_POST);
			$this->session->set_flashdata('errors', $response['errors']);
		}
		$this->session->set_flashdata('notice', $response['notice']);
		redirect('city/bank/' . $response['bank_id'] ?: '');
	}

	public function cancel_transfer($id){
		$response = $this->bank->cancel_transfer($this->player->player, $id);
		if(count($response['errors']) > 0){
			$this->session->set_flashdata('notice', "There was a problem canceling the transfer.");
			$this->session->set_flashdata('post', $_POST);
			$this->session->set_flashdata('errors', $response['errors']);
		}
		$this->session->set_flashdata('notice', $response['notice']);
		redirect('city/bank/transfer');
	}



	public function clubs($id = NULL){
		$_POST['cabs_type2']['association'] = 1;
		$_POST['cabs_type2']['club'] = 1;
		$_POST['cabs_type2']['business'] = 0;
		//$this->input->post('cabs_type') = array('association' => 1, 'club' => 1, 'business' => 0);

		$this->data['page']['title'] = "Clubs & Associations";
		if($this->input->post('search')){
			$this->data['search'] = $this->cabs->search($this->player->player, $_POST);
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('city/clubs', $this->data);
		if($this->input->post('search')){
			$this->load->view('partials/cabs-search', $this->data['search']);
		}
		$this->load->view('layout/footer');
	}

	public function shops($id = NULL){
		$_POST['cabs_type2']['association'] = 0;
		$_POST['cabs_type2']['club'] = 0;
		$_POST['cabs_type2']['business'] = 1;

		$this->data['page']['title'] = "Shops & Businesses";
		if($this->input->post('search')){
			$this->data['search'] = $this->cabs->search($this->player->player, $_POST);
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('city/shops', $this->data);
		if($this->input->post('search')){
			$this->load->view('partials/cabs-search', $this->data['search']);
		}
		$this->load->view('layout/footer');
	}


	public function online($qty = 1, $interval = "HOUR"){
		$this->data['page']['title'] = "Online Players";
		$this->data['online'] = $this->player->get_online($qty, $interval);

		$this->load->view('layout/header', $this->data);
		$this->load->view('city/online', $this->data);
		$this->load->view('layout/footer');
	}

	public function ideal_dreams(){ 
		$this->data['page']['title'] = "Ideal Dreams";
		$this->data['online'] = $this->player->get_online(1, $interval);

		$this->load->view('layout/header', $this->data);
		$this->load->view('city/online', $this->data);
		$this->load->view('layout/footer');
	}



	public function stable($id = NULL){
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


	public function stables_edit($id){
		$this->load->model('stables');
		$this->load->model('privileges');
		$this->data['stable'] = new Stables($id);
		$this->data['stable'] = $this->data['stable']->stable;
		$this->data['page']['title'] = "Stable";
		$this->data['privileges'] = $this->privileges->get();

		if(!$this->data['stable']['stables_id']){
			$this->session->set_flashdata('notice', "Invalid Stable.");
			redirect('game/profile/search');
		}


		if($this->input->post('save')){
			$response = $this->cabs->save($this->data['player'], $this->data['cabs'], $_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem editing the CAB.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "CAB updated.");
			}
			redirect('city/stable/' . $id);
		}

		$this->data['page']['title'] = $this->data['stable']['stables_name'] . " #" . $this->data['stable']['stables_id'];

		$this->load->view('layout/header', $this->data);
		$this->load->view('city/stables-edit', $this->data);
		$this->load->view('layout/footer');
	}


	public function view_cabs($id){
		$this->data['cabs'] = new Cabs($id);
		$this->data['cabs'] = $this->data['cabs']->cabs;
		$this->data['page']['title'] = "CABs";
		$this->load->model('privileges');
		$this->data['privileges'] = $this->privileges->get();

		//pre($this->data['player']['privileges']);exit;

		if(!$this->data['cabs']['cabs_id']){
			$this->session->set_flashdata('notice', "Invalid CAB.");
			redirect('city/clubs');
		}elseif($this->data['cabs']['cabs_pending'] AND !$this->data->player['privileges']['privileges_cabs']){
			$this->session->set_flashdata('notice', "CAB is pending.");
			redirect('city/clubs');
		}elseif($this->data['cabs']['cabs_disabled'] AND !$this->data['player']['privileges']['privileges_cabs']){
			$this->session->set_flashdata('notice', "CAB is disabled.");
			redirect('city/clubs');
		}

		$this->data['page']['title'] = $this->data['cabs']['cabs_name'] . " #" . $this->data['cabs']['cabs_id'];

		$this->load->view('layout/header', $this->data);
		$this->load->view('city/cabs-view', $this->data);
		$this->load->view('layout/footer');
	}

	public function edit_cabs($id){
		$this->data['cabs'] = new Cabs($id);
		$this->data['cabs'] = $this->data['cabs']->cabs;
		$this->data['page']['title'] = "CABs";
		$this->load->model('privileges');
		$this->data['privileges'] = $this->privileges->get();

		if(!$this->data['cabs']['cabs_id']){
			$this->session->set_flashdata('notice', "Invalid CAB.");
			redirect('city/clubs');
		}elseif($this->data['cabs']['cabs_pending']){
			$this->session->set_flashdata('notice', "CAB is pending.");
			redirect('city/clubs');
		}elseif($this->data['cabs']['cabs_disabled']){
			$this->session->set_flashdata('notice', "CAB is disabled.");
			redirect('city/clubs');
		}elseif($this->data['cabs']['join_players_id'] != $this->data['player']['players_id'] AND !$this->data['privileges']['privileges_cabs']){
			$this->session->set_flashdata('notice', "You cannot edit this CAB.");
			redirect('city/clubs');
		}

		$this->data['page']['title'] = $this->data['cabs']['cabs_name'] . " #" . $this->data['cabs']['cabs_id'];

		if($this->input->post('save')){
			$response = $this->cabs->save($this->data['player'], $this->data['cabs'], $_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem editing the CAB.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "CAB updated.");
			}
			redirect('city/cabs/view/' . $id);
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('city/cabs-edit', $this->data);
		$this->load->view('layout/footer');
	}


	public function events_create($id = null){
		$this->data['page']['title'] = "Create Event";
		$this->load->model('privileges');
		$this->load->model('events');
		$this->data['cab_id'] = $id;
		$this->data['errors'] = $this->session->flashdata('errors');
		$this->data['post'] = $this->session->flashdata('post');

		$this->data['privileges'] = $this->privileges->get();
		$my_associations = $this->cabs->search($player, array('cabs_type' => 'Association', 'cabs_owner' => $this->data['player']['players_id']));
		$my_associations = flatten_array_set_index('cabs_id', 'cabs_name', $my_associations);
		$this->data['host_list'] = array('0' => 'Self') + $my_associations;
		$this->data['events_classlist'] = $this->events->get_classlists(array('cabs_ids' => $this->data['host_list']));
		$this->data['events_classlist'] = flatten_array_set_index('classlists_id', 'classlists_name', $this->data['events_classlist']);



		if($this->input->post('create_event')){
			$response = $this->events->create_event($this->data['player'], $this->data['host_list'], $this->data['events_classlist'], $_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem creating the Event.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
				redirect('city/events/create/' . $id);
			}else{
				$this->session->set_flashdata('notice', "Event created.");
				redirect('city/events/view/' . $response['event_id']);
			}
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('city/events-create', $this->data);
		$this->load->view('layout/footer');
	}


	public function events_edit($id = null){
		$this->data['page']['title'] = "Edit Event";
		$this->load->model('privileges');
		$this->load->model('events');
		$this->data['event'] = new Events($id);
		$this->data['event'] = $this->data['event']->event;
		$this->data['errors'] = $this->session->flashdata('errors');
		$this->data['post'] = $this->session->flashdata('post');

		$this->data['privileges'] = $this->privileges->get();


		if(
			(!$this->data['privileges']['privileges_events'] AND $this->data['player']['players_id'] != $this->data['event']['join_players_id'])
			|| ($this->data['privileges']['privileges_events'] AND $this->data['event']['events_pending'] == 0)
			|| ($this->data['player']['players_id'] == $this->data['event']['join_players_id']
					AND ((!$this->data['privileges']['privileges_events'] AND $this->data['event']['events_pending'] != 1)
						|| ($this->data['privileges']['privileges_events'] AND $this->data['event']['events_pending'] == 0)
						)
					)){
			$this->session->set_flashdata('notice', "You may not edit this event.");
			redirect('city/events/view/' . $id);
		}

		if($this->data['event']['events_pending'] < 1){
			$this->session->set_flashdata('notice', "This event may no longer be edited.");
			redirect('city/events/view/' . $id);
		}

		if($this->input->post('edit_event') || $this->input->post('finalize_event') || $this->input->post('approve_event')){
			$response = $this->events->edit_event($this->data['player'], $this->data['event'], $_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem editing the Event.");
				$this->session->set_flashdata('post', $_POST);				
				$this->session->set_flashdata('errors', $response['errors']);
				redirect('city/events/edit/' . $id);
			}else{
				if($this->input->post('finalize_event')){
					$response = $this->events->finalize_event($this->data['player'], $this->data['event']);
					$this->session->set_flashdata('notice', "Event finalized and submitted for approval.");
					redirect('city/events/view/' . $id);
				}elseif($this->input->post('approve_event') AND $this->data['privileges']['privileges_events']){
					$response = $this->events->admin_approve_event($this->data['player'], $this->data['event']);
					$this->session->set_flashdata('notice', "Event approved.");
					redirect('city/events/view/' . $id);
				}
				$this->session->set_flashdata('notice', "Event edited.");
				redirect('city/events/edit/' . $id);
			}
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('city/events-edit', $this->data);
		$this->load->view('layout/footer');
	}



	public function events_cancel($id = null){
		$this->load->model('privileges');
		$this->load->model('events');
		$this->data['event'] = new Events($id);
		$this->data['event'] = $this->data['event']->event;

		$this->data['privileges'] = $this->privileges->get();


		if(
			(!$this->data['privileges']['privileges_events'] AND $this->data['player']['players_id'] != $this->data['event']['join_players_id'])
			|| ($this->data['privileges']['privileges_events'] AND $this->data['event']['events_pending'] == 0)
			|| ($this->data['player']['players_id'] == $this->data['event']['join_players_id']
					AND ((!$this->data['privileges']['privileges_events'] AND $this->data['event']['events_pending'] != 1)
						|| ($this->data['privileges']['privileges_events'] AND $this->data['event']['events_pending'] == 0)
						)
					)){
			$this->session->set_flashdata('notice', "You may not cancel this event.");
			redirect('city/events/view/' . $id);
		}

		if($this->data['event']['events_pending'] < 1){
			$this->session->set_flashdata('notice', "This event may no longer be canceled.");
			redirect('city/events/view/' . $id);
		}

		$response = $this->events->cancel_event($id);
		if(count($response['errors']) > 0){
			$this->session->set_flashdata('notice', "There was a problem canceling the event.");
			$this->session->set_flashdata('post', $_POST);
			$this->session->set_flashdata('errors', $response['errors']);
			redirect('city/events/edit/' . $id);
		}
		$this->session->set_flashdata('notice', "Event canceled.");
		redirect('city/events');
	}

	public function events(){
		$this->load->model('Events');
		$this->data['profile'] = new Player($this->session->userdata('players_id'));
		$this->data['profile'] = $this->data['profile']->player;
		$res = $this->Events->getCalendarEvents($this->data['profile']['players_events_weekly_limit']);		
		$result=[];
		$race_results=[];
		foreach($res[0] as $v){			
			if($v['events_pending']==0)
			{
				if($v['events_type']=="Race")
				{					
					array_push($race_results,['entity'=>$v['events_id'],'summary'=>'Event Name : '.$v['events_name'].'<br>Event Type : '.$v['events_type'].'<br> Event Owner : '.$v['players_nickname'],'startDate'=>$v['events_date1'],'endDate'=>$v['events_date1']]);
				}else
				{
					array_push($result,['entity'=>$v['events_id'],'summary'=>'Event Name : '.$v['events_name'].'<br>Event Type : '.$v['events_type'].'<br> Event Owner : '.$v['players_nickname'],'startDate'=>$v['events_date1'],'endDate'=>$v['events_date1']]);
				}
			}
		}	
		foreach($res[1] as $v){						
			if($v['events_pending']==0)
			{
				if($v['events_type']=="Race")
				{					
					array_push($race_results,['entity'=>$v['events_id'],'summary'=>'Event Name : '.$v['events_name'].'<br>Event Type : '.$v['events_type'].'<br> Event Owner : '.$v['players_nickname'],'startDate'=>$v['events_date2'],'endDate'=>$v['events_date2']]);
				}else
				{
					array_push($result,['entity'=>$v['events_id'],'summary'=>'Event Name : '.$v['events_name'].'<br>Event Type : '.$v['events_type'].'<br> Event Owner : '.$v['players_nickname'],'startDate'=>$v['events_date2'],'endDate'=>$v['events_date2']]);
				}				
			}			
		}	
		foreach($res[2] as $v){
			if($v['events_type']=="Race")
			{					
				array_push($race_results,['entity'=>$v['events_id'],'summary'=>'Event Name : '.$v['events_name'].'<br>Event Type : '.$v['events_type'].'<br> Event Owner : '.$v['players_nickname'],'startDate'=>$v['events_date3'],'endDate'=>$v['events_date3']]);
			}else
			{
				array_push($result,['entity'=>$v['events_id'],'summary'=>'Event Name : '.$v['events_name'].'<br>Event Type : '.$v['events_type'].'<br> Event Owner : '.$v['players_nickname'],'startDate'=>$v['events_date3'],'endDate'=>$v['events_date3']]);
			}				
		}			
		$this->data['CalendarEventsList']=json_encode($result);		
		$this->data['CalendarRaceEventsList']=json_encode($race_results);
		$this->data['page']['title'] = "Event House";
		$this->load->model('privileges');
		$this->load->model('events');
		$this->load->model('articles');
		$this->data['article'] = $this->articles->get_article(8);
		$this->load->view('layout/header', $this->data);
		$this->load->view('city/event-house', $this->data);
		$this->load->view('layout/footer');
	}
	public function events_view($id){
		$this->data['page']['title'] = "Event Details";
		$this->load->model('privileges');
		$this->load->model('events');
		$this->data['event'] = new Events($id);
		$this->data['event'] = $this->data['event']->event;

		if(!$this->data['event']['events_id']){
			$this->session->set_flashdata('notice', "Invalid event.");
			redirect('city/events');
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('city/events-view', $this->data);
		$this->load->view('layout/footer');
	}

	public function events_classes_view($id){
		$this->data['page']['title'] = "Class Details";
		$this->load->model('privileges');
		$this->load->model('events');
		$this->load->model('horse');
		$this->data['class'] = $this->events->get_class($id);
		$this->data['event'] = new Events($this->data['class']['join_events_id']);
		$this->data['event'] = $this->data['event']->event;

		$search = array(
				'join_players_id' => $this->data['player']['players_id'],
				'min_age' => $this->data['class']['events_x_classes_min_age'],
				'max_age' => $this->data['class']['events_x_classes_max_age'],
			);
		$this->data['horses'] = $this->horse->search($search);

		$this->load->view('layout/header', $this->data);
		$this->load->view('city/events-classes-view', $this->data);
		$this->load->view('layout/footer');
	}


	public function create_cab(){
		$this->data['page']['title'] = "Create a CAB";
		$pending_cabs = Cabs::search($this->data['player'], array('cabs_owner' => $this->data['player']['players_id'], 'cabs_pending' => 1));
		if(count($pending_cabs) > 0){
			$this->session->set_flashdata('notice', "You already have a pending CAB.");
			redirect('city/clubs');
		}
		if($this->input->post('create')){
			$response = $this->cabs->create($this->data['player'], $_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem creating the CAB.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Your CAB has been submitted. You will be notified if it's accepted.");
			}
			redirect('city/clubs');
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('city/cabs-create', $this->data);
		$this->load->view('layout/footer');
	}

	public function articles_view($id){
		$this->load->model('articles');
		$this->data['article'] = $this->articles->get_article($id);

		$this->data['page']['title'] = $this->data['article']['articles_name'];
		$this->load->view('layout/header', $this->data);
		$this->load->view('city/articles', $this->data);
		$this->load->view('layout/footer');
	}




	public function vet(){
		$this->load->model('horse');
		$this->data['page']['title'] = "Veterinary Office";
		if($this->data['player']['players_vet']){
			$this->data['appts'] = Player::get_vet_appts();
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

		}elseif($this->input->post('perform') AND $this->data['player']['players_vet']){
			$response = Player::perform_vet($_POST['horse_appointments_id']);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem performing the appointment.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Appointment completed.");
				redirect('city/vet');
			}

		}elseif($this->input->post('reject') AND $this->data['player']['players_vet']){
			$response = Player::reject_vet($_POST['horse_appointments_id']);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem rejecting the appointment.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Rejected.");
				redirect('city/vet');
			}
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('city/vet', $this->data);
		$this->load->view('layout/footer');
	}


	public function farrier(){
		$this->load->model('horse');
		$this->data['page']['title'] = "Farrier Office";
		if($this->data['player']['players_vet']){
			$this->data['appts'] = Player::get_farrier_appts();
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

		}elseif($this->input->post('perform') AND $this->data['player']['players_farrier']){
			$response = Player::perform_farrier($_POST['horse_appointments_id']);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem performing the appointment.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Appointment completed.");
				redirect('city/farrier');
			}

		}elseif($this->input->post('reject') AND $this->data['player']['players_farrier']){
			$response = Player::reject_farrier($_POST['horse_appointments_id']);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('notice', "There was a problem rejecting the appointment.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
			}else{
				$this->session->set_flashdata('notice', "Rejected.");
				redirect('city/farrier');
			}
		}

		$this->load->view('layout/header', $this->data);
		$this->load->view('city/farrier', $this->data);
		$this->load->view('layout/footer');
	}


















	public function ajax($method){
		if($method == "update-class"){
			//update the class in the event
			$this->load->model('events');
			$response = $this->events->edit_class($this->data['player'], $_POST);
			if(!$response['errors']){
				echo "1";
			}else{
				echo $response['errors'];
				pre($response);
			}
		}elseif($method == "enter-class"){
			//enter horse in class if eligible
			$this->load->model('events');
			$response = $this->events->enter_class($this->data['player'], $_POST);
			if(!$response['errors']){
				echo "1";
			}else{
				echo implode('<br/>', $response['errors']);
			}
		}
	}

}