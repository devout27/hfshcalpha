<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logins extends Adminlogin_Controller
{
	public $class_name='';
	function __construct()
	{
		parent::__construct();
		$this->class_name='super-admin/'.ucfirst(strtolower($this->router->fetch_class())).'/';
		$this->load->helper('form');
	}

	public function index()
	{
		
		$this->data['page_title'] = 'Login';
		$this->load->model('Admin_Model');
		if($this->input->post()){

			$this->load->library('form_validation');
			$set_rules=$this->Admin_Model->config_login;
			$this->form_validation->set_rules($set_rules);
			$this->form_validation->set_error_delimiters('<div class="form_vl_error">', '</div>');
			if($this->form_validation->run()===TRUE)
			{
            
				$data['username']=$this->input->post('username');
				$data['password']=$this->input->post('password');
				$LoginUser=$this->Admin_Model->checkAdminLogin($data);
                			
				if (count($LoginUser) > 0)
				{					
					  $this->session->set_userdata(array(
                        "adminLoginId" => $LoginUser['players_id'],
                        "name" => $LoginUser['players_username']
                      ));
					  redirect('/super-admin/dashboard');
				}
				else
				{
				    $this->session->set_flashdata('message_error','Username or password is incorrect');
				}
			}
		}
	    $this->render($this->class_name.'index');
	}

	public function forgotPassword()
	{   
	    $this->data['page_title'] = 'Forgot Password';
		if($this->input->post()){
              
			$this->load->library('form_validation');
			$this->load->model('Admin_Model');
			$set_rules=$this->Admin_Model->config_forgot_password;
			$this->form_validation->set_rules($set_rules);
			$this->form_validation->set_error_delimiters('<div class="form_vl_error">', '</div>');
		    $postData['email']=$this->input->post('email');
			if($this->form_validation->run()===TRUE)
			{

				$adminData=$this->Admin_Model->getDataByEmailId($postData['email']);
				
				if(!empty($adminData)){
					$url=base_url().'super-admin/reset-password/'.base64_encode($adminData['players_id']);
					$sn = SITE_NAME;
					$subject='Reset Password';
					$name=$adminData['players_nickname'];
					$body='<div class="top-info" style="margin-top: 25px;text-align: left;">
						<span style="font-size: 17px; letter-spacing: 0.5px; line-height: 28px; word-spacing: 0.5px;">
							Dear '.$name.',
						<br>
							You have successfully forgot password  your '.SITE_NAME.' admin account. Please click on the link bellow to for reset password.
						</span>
					</div>
					<div style="margin: 25px 0px;"><a style="font-size: 14px;text-transform: uppercase;color: #000;font-weight: 600;padding: 10px 30px;border-radius: 3px;border: none;background: #00a9d0;cursor: pointer;text-decoration: none;" href="'.$url.'">Visit Website</a>
					</div>';
					send_email($data['players_nickname'],$postData['email'], $subject, $body);
					$this->session->set_flashdata('message_success','Please check your mail reset password link send your email id.');
					$this->data['success'] =true;
				}else{

				   $this->session->set_flashdata('message_error','This email address does not exist in any account');

				}

			}else{
				  $this->session->set_flashdata('message_error','Missing information.');
			}
	    }

	    $this->render($this->class_name.'forgot_password');
	}

	public function ResetPassword($id=null)
	{

	    $this->data['page_title'] = 'Reset Password';
		$this->load->model('Admin_Model');
		$id=base64_decode($id);
		$userData=$this->Admin_Model->getAdminDataById($id);
		if(empty($userData)){

			$this->session->set_flashdata('message_error','invalid reset password token');
			redirect('super-admin');
		}

		if($this->input->post()){

			$this->load->library('form_validation');
			$this->load->model('Admin_Model');
			$set_rules=$this->Admin_Model->config_reset_password;
			$this->form_validation->set_rules($set_rules);
			$this->form_validation->set_error_delimiters('<div class="form_vl_error">', '</div>');
			$player = $this->db->query('SELECT PASSWORD(?) AS players_password', array($this->input->post('password')))->row_array();
		    $postData['password']=$player['players_password'];
			$postData['players_id']=$id;
			if($this->form_validation->run()===TRUE)
			{
				if($this->Admin_Model->saveAdmin($postData)){				   
				   $this->session->set_flashdata('message_success','Your Password change has been successfully login new password.');
                   redirect('super-admin');
				}else{
					$this->session->set_flashdata('message_error','Your Password change has been unsuccessfully.');
				}

			}else{
				  $this->session->set_flashdata('message_error','Missing information.');
			}
	    }
	    $this->render($this->class_name.'reset_password');
	}
}
