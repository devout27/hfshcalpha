<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct(){
        parent::__construct();
	}

	public function is_logged_in(){

	}

	//---------------------------------------------------------------------
	//-- Validation Callback Functions -- ideally these would
	//-- be in a Model or Library, but I am not sure how CI handles that.
	//---------------------------------------------------------------------

	public function username_unique($username) {
		$exists = $this->db->query('
			SELECT COUNT(*) AS rows2
			FROM players
			WHERE players_username = ?
		', array($username))->row_array();

		if ($exists['rows2'] > 0) {
			$this->form_validation->set_message('username_unique', 'The %s you entered is already taken.');
		}

		return $exists['rows2'] == 0;
	}

	public function email_unique($email) {
		$exists = $this->db->query('
			SELECT COUNT(*) AS rows2
			FROM players
			WHERE players_email = ?
		', array($email))->row_array();

		if ($exists['rows2'] > 0) {
			$this->form_validation->set_message('email_unique', 'The %s you entered is already taken.');
		}

		return $exists['rows2'] == 0;
	}


    public function house_validate($value){
    	$houses = array('Milton', 'King', 'Eclipse');
    	if(!in_array($value, $houses)){
    		$this->form_validation->set_message('house_validate', 'Invalid house.');
    		return false;
    	}
    	return true;
    }

    public function date_valid($date){
    	//mm/dd/yyyy
	    $month = (int) substr($date, 0, 2);
	    $day = (int) substr($date, 3, 2);
	    $year = (int) substr($date, 6, 4);
	    if(!checkdate($month, $day, $year)){
    		$this->form_validation->set_message('date_valid', 'Please use MM/DD/YYYY format.');
	    	return false;
	    }
	    return true;
	}

	public function kick_out(){
		if(!$this->session->userdata('players_id')){
			//echo site_url('../welcome');exit;
			redirect('../');
		}
	}

	public function recaptcha($str = ''){
		$google_url="https://www.google.com/recaptcha/api/siteverify";
		$secret='6LdjjicTAAAAALco-mNiDmTLpTL5YxRo-Qp5m2uF';
		$ip=$_SERVER['REMOTE_ADDR'];
		$url=$google_url."?secret=".$secret."&response=".$str."&remoteip=".$ip;
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
		$res = curl_exec($curl);
		curl_close($curl);
		$res= json_decode($res, true);

		//reCaptcha success check
		if($res['success']){
			return TRUE;
		}else{
			$this->form_validation->set_message('recaptcha', 'The reCAPTCHA field is telling me that you are a robot. Shall we give it another try?');
			return FALSE;
		}
	}

	public function myError($error, $die = 0){
		$this->player = new Player($this->session->userdata('players_id'));
		if(!is_array($error)){
			$error = array($error);
		}
		if($die === 1){
			$this->load->view('layout/header', array($this->data['player'], $this->data['alerts']));
			$this->load->view("game/error", array('errors' => $error));
			$this->load->view("layout/footer");
			return;
		}else{
			$this->load->view("game/error", array('errors' => $error));
		}
	}

}
