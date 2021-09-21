<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */


	public function __construct(){
		parent::__construct();
		$this->load->model('passwords');
	}

	public function index()
	{
		$this->load->view('layout/header-outside');
		$this->load->view('welcome/welcome_message');
		$this->load->view('layout/footer-outside');
	}

	public function tos()
	{
		$this->load->view('layout/header-outside');
		$this->load->view('welcome/tos');
		$this->load->view('layout/footer-outside');
	}


	public function register()
	{
		$this->data['page_title'] = "Register";
		$this->data['errors'] = array();
		$this->load->model('player');
		$this->load->library('form_validation');
		$this->data['questions'] = $this->db->query('SELECT questions_id, questions_question FROM questions ORDER BY questions_id ASC')->result_array();

		$this->form_validation->set_rules(array(
			array(
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'required|valid_email|callback_email_unique'
			),
			/*array(
				'field' => 'email2',
				'label' => 'Confirm Email',
				'rules' => 'required|matches[email]|valid_email|callback_email_unique'
			),*/
			array(
				'field' => 'username',
				'label' => 'Username',
				'rules' => 'required|min_length[4]|max_length[20]|callback_username_unique'
			),
			array(
				'field' => 'password2',
				'label' => 'Confirm Password',
				'rules' => 'required|matches[password]'
			),
			array(
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'required|min_length[6]'
			),
			array(
				'field' => 'nickname',
				'label' => 'nickname',
				'rules' => 'required|min_length[2]'
			),
			array(
				'field' => 'dob',
				'label' => 'Date of Birth',
				'rules' => 'required|callback_date_valid'
			),

		));

		if($_POST){
			//-- validate security questions
			$questions = $this->input->post('questions');
			$answers = $this->input->post('answers');

			//pre($_POST);exit;

			//if one question is changed, they all must be
			$questions_count = count($this->data['questions']);
			foreach((array)$questions AS $i => $q){
				if(strlen(trim($answers[$i])) < 3){
					$this->data['errors']['answers['.$i.']'] = 'Answer is required.';
				}
			}
		}


		if($this->form_validation->run() !== false){
			//$data = $_POST;
			//echo "We done here.";exit;

			$data['players_username'] = $_POST['username'];
			$data['players_email'] = $_POST['email'];
			$data['players_nickname'] = $_POST['nickname'];

			//email new password to user
			$player = $this->db->query('
				SELECT PASSWORD(?) AS players_password
			', array(
				$this->input->post('password')
			))->row_array();
			$data['players_password'] = $player['players_password'];


			$this->db->insert('players', $data);
			$players_id = $this->db->insert_id();

			//security question & answer
			$insert_qa = array();
			foreach($questions AS $i => $q){
				//setup the db insertion
				$insert_qa []= '(?, ?, ?)';
				$params []= $players_id;
				$params []= $q;
				$params []= $answers[$i];
			}
			$this->db->query('INSERT INTO players_x_questions(join_players_id, join_questions_id, players_x_questions_answer) VALUES ' . implode(', ', $insert_qa), $params);


			// send a nice thank you email
			$sn = SITE_NAME;
			$subject = "Welcome to $sn";
			$body = "Welcome, " . $data['players_nickname'] ."! You have successfully applied to join the game. A member of the team will review your application and be in touch. Please make sure that you've written down your username and password (case sensitive) in a safe place.";
			$this->player->send_email($data['players_nickname'], $data['players_email'], $subject, $body);
			redirect('welcome/register_success');
		}else{
			foreach ($this->form_validation->get_errors() as $field => $errormsg){
				$this->data['errors'][$field] = $errormsg;
			}
		}



		$this->load->view('layout/header-outside');
		$this->load->view('welcome/register', $this->data);
		$this->load->view('layout/footer-outside');
	}

	public function register_success(){
		$this->load->view('layout/header-outside');
		$this->load->view('welcome/register_success');
		$this->load->view('layout/footer-outside');
	}



	public function logout(){
		$this->session->sess_destroy();
		redirect('');
	}

	public function login(){
		$this->data['page_title'] = "Login";

		if($this->session->userdata('players_id')){
			redirect('game');
		}

		if($this->input->post('username')){
			$errors = array();

			$player = $this->db->query('
				SELECT * FROM players
				WHERE players_username = ? AND players_password = PASSWORD(?)
			', array(
				$this->input->post('username'), $this->input->post('password')
			))->row_array();

			if($player['players_pending']){
				$errors['username'] = "Application pending.";
			}elseif(!$player['players_id']){
				$errors['username'] = 'Invalid username or password.';
			}

			if(count($errors) == 0){
				// we're in!
				$this->session->set_userdata('players_id', $player['players_id']);

				//update last login
				$this->player->touch($player['players_id']);
				$this->logs->log_ip($player['players_id']);
				redirect('game');
			}

			$this->data['errors'] = $errors;
		}

		$this->load->view('layout/header-outside');
		$this->load->view('welcome/welcome_message', $this->data);
		$this->load->view('layout/footer-outside');
	}



}
