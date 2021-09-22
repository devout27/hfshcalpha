<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends Admin_Controller
{
	public $class_name='';
	function __construct()
	{
		parent::__construct();
		$this->class_name='super-admin/'.ucfirst(strtolower($this->router->fetch_class())).'/';
		$this->data['class_name']= $this->class_name;
	}
    public function changePassword(){
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('Admin_Model');
		$this->data['page_title'] = 'Change Password';
		$loginUserData=$this->session->get_userdata();
		$adminLoginId=$loginUserData['adminLoginId'];
		$postData=$this->Admin_Model->getAdminDataById($adminLoginId);		
		if( $this->input->post() ){ 						
			$set_rules=$this->Admin_Model->config_change_password;
			$this->form_validation->set_rules($set_rules);
			$this->form_validation->set_error_delimiters('<div class="form_vl_error">', '</div>');			
			if(!empty($id)){				
			   $postData['id']=$id;
			}			
			$currentPasswordCheck = 'failed';
			$this->load->model('Member_Model');			
			if($this->Member_Model->getPassword($this->input->post('current_password')) == $postData['players_password']){
				$currentPasswordCheck = 'passed';				
			}		   
			
			if($this->form_validation->run()===TRUE && $currentPasswordCheck=='passed')
			{    
				$saveData['players_password'] = $this->Member_Model->getPassword($this->input->post('new_password'));	
				$saveData['players_id'] = $adminLoginId;				
				if($this->Admin_Model->saveAdmin($saveData)){
				   	$this->session->set_flashdata('message_success','Your Password change has been successfully login new password.');
				 	$this->logout();
				}else{
					$this->session->set_flashdata('message_error','Your Password change has been unsuccessfully.');
				}
				
				
			}else{ 
				   $errors = $this->form_validation->error_array();
				   if($currentPasswordCheck=='failed'){
					$errors['current_password'] = 'Wrong current password.';    
	 			   }    
				   
				   $this->session->set_flashdata('errors',$errors);  
				   $this->session->set_flashdata('message_error','Missing information.');
			}

			$this->data['postData'] = $this->input->post();
	    }
		
	   
		$this->render($this->class_name.'change_password');
		
    }
	
	public function logout()
	{	
		$this->session->unset_userdata('adminLoginId');
		$this->session->unset_userdata('name');
		$this->session->unset_userdata('role');
		redirect('super-admin');

	}
}
