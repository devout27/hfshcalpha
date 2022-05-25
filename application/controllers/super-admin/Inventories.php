<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventories extends Admin_Controller
{
    public $class_name='';
	function __construct()
	{
		parent::__construct();
		$this->class_name='super-admin/'.ucfirst(strtolower($this->router->fetch_class())).'/';
        $this->data['class_name'] = $this->class_name;        
        $this->load->model('Inventory_Model');
	}
	public function index($stable_id=null)
	{   
        if ($this->input->is_ajax_request()) {
			$this->load->model('Inventory_Model');
			$res = $this->Inventory_Model->getInventorysList(true,$_POST);
            $sub_page_view_url="view";
            $sub_page_url = 'addEdit';
            $sub_page_delete_url = 'delete';
            $result=[];			
            $i=$_POST['start'];
			foreach($res as $v){
                $i++;      		    
                $id = $v['itemid'];
                $info = '<b>'.$v['itemname'].'</b><br/><p><small>'.$v['itemdesc'].'</p></small>';
				$action = '<div class="action-btns row">';
                $action .= '<a class="btn btn-primary btn-sm col-md-6 col-sm-12" href="'.BASE_URL.$this->data['class_name'].$sub_page_url."/".$v['itemid'].'" title="Edit"><i class="las la-edit"></i></a>';
                $url = BASE_URL.$this->data['class_name'].$sub_page_delete_url."/".$v['itemid'];
                $msg = "Are you sure you want to delete this Inventory Item?";
                $action .='<a href="javascript:void(0)" msg="'.$msg.'" url="'.$url.'" title="delete" class="btn btn-primary  btn-sm col-md-6  col-sm-12 my-del-btn"><i class="las la-trash"></i></a>';
                $action .='</div>';
				$img = '<img src="'.getInventoryItemImage($v['itemimg']).'" class="img-thumbnail">';
				$result[] = array($i,$id,$v['players_nickname'],$info,$v['itemtype'],$v['itemrarity'],$img,dateFormate($v['created']),$action);
			}
			$output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->Inventory_Model->countAll(true,$_POST),
                "recordsFiltered" => $this->Inventory_Model->countFiltered(true,$_POST),
                "data" => $result
            );
            echo json_encode($output);exit;            
		}else{
			$this->data['page_title'] = 'Inventories List';
			$this->data['sub_page_title'] = 'Create Inventory';
            $this->data['dataTableElement'] = 'inventoriesList';
            $this->data['dataTableURL'] = BASE_URL.$this->data['class_name'];
		    $this->render($this->class_name.'index');
		}        
	}    
    public function view($id)
    {
        if (!is_numeric($id)) {
            redirect($this->class_name);
        }
        $this->data['page_title'] = 'Inventory Details';
        $this->data['main_page_url'] =  $this->data['BASE_URL'].$this->class_name;
        $this->data['amenity'] = $this->Inventory_Model->getInventoryDataById($id);
        if(empty($this->data['amenity']))
        {
            $this->session->set_flashdata('message_error','Inventory Not Found.');
            redirect($this->class_name);
        }        
        $this->render($this->class_name.'view');
    }
    public function addEdit($id=false)
    {
        $this->load->model('Inventory_Model');	
        $this->load->model('Player');	
        if($id){
            $postData = $this->Inventory_Model->getInventoryDataById($id);
            if(empty($postData))
            {
                $this->session->set_flashdata('message_error','Inventory Item Not Found.');
                redirect($this->class_name.'inventory');
            }
            $this->data['page']['title'] = $postData['itemname'] . " #" . $postData['itemid'];
        }else
        {            
			$this->data['page']['title'] = 'Create Inventory Item';
            $postData=[];
        }
        
        $this->load->helper('form');
        $this->data['players'] = $this->Player->get_all_players();
        $this->data['main_page_url'] =  $this->data['BASE_URL'].$this->class_name;
        if($this->input->post()){			
            $this->load->library('form_validation');
			$this->data['page']['title']="Inventory Item Created";
            $set_rules = $this->Inventory_Model->admin_config_add;
            if(!empty($postData['itemid']))
            {
				$this->data['page']['title']="Inventory Item Updated";
                $set_rules = $this->Inventory_Model->admin_config_edit;
            }
            $this->form_validation->set_rules($set_rules);
            
            if($this->form_validation->run()===TRUE)
            {                
                unset($_POST['submit']);
                $_POST['players_nickname'] = new Player($_POST['join_players_id']);
                $_POST['players_nickname'] = $_POST['players_nickname']->player['players_nickname'];                
                $response = $this->Inventory_Model->saveInventory($_POST);
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
    public function delete($id)
    {	 
        if(is_numeric($id)){
			$page_title='Inventory Deleted';
			$this->load->model(['Inventory_Model']);
			$this->Inventory_Model->deleteInventory($id) == 1 ? $this->session->set_flashdata('message_success',$page_title.' Successfully.') : $this->session->set_flashdata('message_error',$page_title.' Unsuccessfully.');
		}else{
			$this->session->set_flashdata('message_error','Missing information.');
	    }
		redirect($this->class_name);
    }
}