<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stables extends Admin_Controller
{
    public $class_name='';
	function __construct()
	{
		parent::__construct();
		$this->class_name='super-admin/'.ucfirst(strtolower($this->router->fetch_class())).'/';
        $this->data['class_name'] = $this->class_name;        
        $this->data['BASE_URL'] = BASE_URL;        
        $this->load->model('Stable_Model');        
	}
	public function index($players_id=null)
	{   
        $sub_page_url = 'addEdit';
        $sub_page_title = 'Create Stable';
        if ($this->input->is_ajax_request()) {
			$res = $this->Stable_Model->getStablesList($players_id,$_POST);
            $sub_page_view_url="view";
            
            $result=[];
            $i=$_POST['start'];
			foreach($res as $v){
                $i++;
				$action = '<div class="action-btns">';                
                $action .= '<a class="view-btn" href="'.BASE_URL.$this->data['class_name'].$sub_page_url."/".$v['stables_id'].'" title="Edit"><i class="las la-edit"></i></a>';
                $action .='</div>';
				$status = $v['stables_boarding_public']==1 ? '<span class="badge badge-success pb-1">Public</span>' : '<span class="badge badge-success pb-1">Private</span>';				
                $id ='<a href="'.BASE_URL.$this->data['class_name'].$sub_page_view_url."/".$v['stables_id'].'" title="View">'.generateId($v['stables_id']).'</a>';
                $v['players_nickname'] = $v['players_nickname']  ? '<a href="'.$this->data['BASE_URL_ADMIN'].'Members/'.$sub_page_view_url."/".$v['join_players_id'].'" title="View">'.$v['players_nickname'].'</a>' : 'N/A';
                $v['stables_boarding_fee'] = ($v['stables_boarding_public']) ? '$'.$v['stables_boarding_fee'].' per month':'No Public Boarding';
				$result[] = array($i,$id,$v['stables_name'],$v['players_nickname'],$v['stables_boarding_fee'],$status,dateFormate($v['created']),$action);
			}
			$output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->Stable_Model->countAll($players_id,$_POST),
                "recordsFiltered" => $this->Stable_Model->countFiltered($players_id,$_POST),
                "data" => $result
            );
            echo json_encode($output);exit;
		}else{
			$this->data['page_title'] = 'Stables List';
            $this->data['dataTableElement'] = 'myStablesList';
            $this->data['sub_page_url'] = $sub_page_url;
            $this->data['sub_page_title'] = $sub_page_title;
            $this->data['dataTableURL'] = BASE_URL.$this->data['class_name'];
		    $this->render($this->class_name.'index');
		}        
	}
    public function view($id)
    {
        if (!is_numeric($id)) {
            redirect($this->class_name);
        }
        $this->data['page_title'] = 'Stable Details';
        $this->data['main_page_url'] =  $this->data['BASE_URL'].$this->class_name;
        $this->data['stable'] = $this->Stable_Model->getStableDataById($id);
        if(empty($this->data['stable']))
        {
            $this->session->set_flashdata('message_error','Stable Not Found.');
            redirect($this->class_name);
        }
        $this->data['stable']['amenties']=$this->Stable_Model->getAmenitiesDataByStableId($id);
        $this->render($this->class_name.'view');
    }

    public function addEdit($id=false)
    {
        $this->load->model('Stable_Model');	
        $this->load->model('Player');
        if($id){
            $postData = $this->Stable_Model->getStableDataById($id);
            if(empty($postData))
            {
                $this->session->set_flashdata('message_error','Stable Not Found.');
                redirect($this->class_name.'stables');
            }
            $this->data['page']['title'] = $postData['stables_name'] . " #" . $postData['stables_id'];
        }else
        {            
			$this->data['page']['title'] = 'Create Stable';
            $postData=[];
        }
        
        $this->load->helper('form');
        $this->data['players'] = $this->Player->get_all_players();
        $this->data['main_page_url'] =  $this->data['BASE_URL'].$this->class_name;
        if($this->input->post()){			
            $this->load->library('form_validation');
			$this->data['page']['title']="Stable Created";
            $set_rules = $this->Stable_Model->admin_config_add;
            if(!empty($postData['stables_id']))
            {
				$this->data['page']['title']="Stable Updated";
                $set_rules = $this->Stable_Model->admin_config_edit;
            }
            $this->form_validation->set_rules($set_rules);            
            if($this->form_validation->run() === TRUE)
            {                
                unset($_POST['submit']);
                unset($_POST['action']);
                $_POST['players_nickname'] = new Player($_POST['join_players_id']);
                $_POST['players_email'] = $_POST['players_nickname']->player['players_email'];
                $_POST['players_nickname'] = $_POST['players_nickname']->player['players_nickname'];
                $response = $this->Stable_Model->saveStable($_POST);
                if($response)
                {
                    $this->session->set_flashdata('message_success',$this->data['page']['title'].' Successfully.');
                }else
                {
                    $this->session->set_flashdata('message_error',$this->data['page']['title'].' Unsuccessfully.');
                }
                redirect($this->class_name);
            }else{                    
				$postData = $_POST;                
                $this->session->set_flashdata('message_error','Missing information.');
				$this->session->set_flashdata('errors',$this->form_validation->error_array());				
            }
        }
        $this->data['errors'] = $this->session->flashdata('errors');
        $this->data['postData'] = $postData;    
        $this->render($this->class_name . 'addEdit');
    }    
}