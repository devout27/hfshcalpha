<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auto extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->data['page']['title'] = "Crons";
		/*if(!$this->input->is_cli_request()){
			echo "Invalid request.";
			exit;
		}*/
		//$this->load->model('autos');
		$this->load->model('autos');
	}

	public function index(){
		//empty
	}



	public function bank_transfers(){
		$this->logs->log_ip(0, 'Cron: Start Bank Transfers');
		$this->autos->bank_transfers();
		$this->logs->log_ip(0, 'Cron: End Bank Transfers');
	}

	public function statement(){
		//update interest on loans, savings. Award stipend based on tier
		$this->logs->log_ip(0, 'Cron: Start Bank Statements');
		$this->autos->statement();
		$this->logs->log_ip(0, 'Cron: End Bank Statements');
	}

	public function auctions(){
		$this->logs->log_ip(0, 'Cron: Start Auctions');
		$this->autos->auctions();
		$this->logs->log_ip(0, 'Cron: End Auctions');
	}

	public function retire(){
		//mark old horses as deceased. retire sounds better than "kill old guys" ;)
		$this->logs->log_ip(0, 'Cron: Start Retirement');
		$this->autos->retire();
		$this->logs->log_ip(0, 'Cron: End Retirement');
	}



	public function run_events(){
		$this->logs->log_ip(0, 'Cron: Start  Events');
		$this->autos->run_events();
		$this->logs->log_ip(0, 'Cron: End Events');
	}

}