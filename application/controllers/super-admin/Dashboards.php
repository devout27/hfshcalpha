<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboards extends Admin_Controller
{
    public $class_name='';
	function __construct()
	{
		parent::__construct();
		$this->class_name='super-admin/'.ucfirst(strtolower($this->router->fetch_class())).'/';
	}
	public function index()
	{   $this->data['page_title'] = 'Dashboards';
		$this->data['usersCount']=$this->db->get('players')->num_rows();
		$this->data['memberAdminCount']=$this->db->where('players_admin',1)->get('players')->num_rows();
		$this->data['adminsCount']=$this->db->where('players_super_admin',1)->get('players')->num_rows();
		$this->data['pendingUsersCount']=$this->db->where('players_pending',1)->get('players')->num_rows();	    
		$this->data['acceptedUsersCount']=$this->db->where('players_pending',0)->where('players_admin',0)->get('players')->num_rows();	    		
		$this->render($this->class_name.'index');
	}
}

