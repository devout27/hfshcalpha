<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Packages extends Admin_Controller
{
    public $class_name='';
	function __construct()
	{
		parent::__construct();
		$this->class_name='super-admin/'.ucfirst(strtolower($this->router->fetch_class())).'/';
        $this->data['class_name'] = $this->class_name;        
        $this->load->model('StablePackage_Model');
	}
	public function index($stable_id=null)
	{   
        if ($this->input->is_ajax_request()) {
			$res = $this->StablePackage_Model->getPackagesList($stable_id,$_POST);
            $sub_page_view_url="view";
            $sub_page_url = 'addEdit';
            $sub_page_delete_url = 'delete';
            $result=[];
            $i=$_POST['start'];
			foreach($res as $v){
                $i++;      		    
                $id ='<a href="'.BASE_URL.$this->data['class_name'].$sub_page_view_url."/".$v['stables_packages_id'].'" title="View">'.$v['stables_packages_id'].'</a>';
                $info = '<b>'.$v['stables_packages_name'].'</b><br/><p><small>'.$v['stables_packages_description'];
				$action = '<div class="action-btns">';                
                $action .= '<a class="view-btn" href="'.BASE_URL.$this->data['class_name'].$sub_page_url."/".$v['stables_packages_id'].'" title="Edit"><i class="las la-edit"></i></a>';
                $url = BASE_URL.$this->data['class_name'].$sub_page_delete_url."/".$v['stables_packages_id'];
                $msg = "Are you sure you want to delete this Stable Package?";
                $action .='<a href="javascript:void(0)" msg="'.$msg.'" url="'.$url.'" title="delete" class="delete-btn my-del-btn"><i class="las la-trash"></i></a>';
                $action .='</div>';                
				$result[] = array($i,$info,'$'.$v['stables_packages_cost'],'$'.$v['stables_packages_cost_usd'],$v['stables_packages_available'],dateFormate($v['stables_packages_created']),$action);
			}
			$output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->StablePackage_Model->countAll($stable_id,$_POST),
                "recordsFiltered" => $this->StablePackage_Model->countFiltered($stable_id,$_POST),
                "data" => $result
            );
            echo json_encode($output);exit;
		}else{
			$this->data['page_title'] = 'Packages List';
			$this->data['sub_page_title'] = 'Create Package';
            $this->data['dataTableElement'] = 'packagesList';
            $this->data['dataTableURL'] = BASE_URL.$this->data['class_name'];
		    $this->render($this->class_name.'index');
		}        
	}
    public function view($id)
    {
        if (!is_numeric($id)) {
            redirect($this->class_name);
        }
        $this->data['page_title'] = 'Package Details';
        $this->data['main_page_url'] =  $this->data['BASE_URL'].$this->class_name;
        $this->data['package'] = $this->StablePackage_Model->getPackageDataById($id);
        if(empty($this->data['package']))
        {
            $this->set_flashdata('message_error','Package Not Found.');
            redirect($this->class_name);
        }        
        $this->render($this->class_name.'view');
    }
    public function addEdit($id=false)
    {
        if ($id) {
            $postData = $this->StablePackage_Model->getPackageDataById($id);
            if(empty($postData))
            {
                $this->set_flashdata('message_error','Package Not Found.');
                redirect($this->class_name);
            }            
            $this->data['page_title'] = $postData['stables_packages_name'] . " #" . $postData['stables_packages_id'];
            $this->data['dataTableElement'] = 'packageAmenitiesList';
            $this->data['dataTableURL'] = $this->data['BASE_URL_ADMIN'].'amenitiesList/'.$id;
        }else
        {
            $this->data['dataTableElement'] = 'packageAmenitiesList';
            $this->data['dataTableURL'] = $this->data['BASE_URL_ADMIN'].'amenitiesList';
			$this->data['page_title'] = 'Create Package';
            $postData=[];
        }
        $this->load->helper('form');
        $this->data['main_page_url'] =  $this->data['BASE_URL'].$this->class_name;
        $this->load->model('StablePackage_Model');        
        if($this->input->post()){            
            $this->load->library('form_validation');
            $set_rules = $this->StablePackage_Model->config_add;
            if(!empty($postData['stables_packages_id']))
            {
                $set_rules = $this->StablePackage_Model->config_edit;
            }                   
            $this->form_validation->set_rules($set_rules);
            $this->form_validation->set_error_delimiters('<div class="form-error">','</div>');
            if($this->form_validation->run()===TRUE)
			{
                $_POST['stables_packages_id']=$id;
                unset($_POST['submit']);                
                $errors = [];        
                if(count($errors) > 0)
                {
                    $this->data['errors'] = $errors;
                    $this->data['postData'] = $_POST;    
                    return $this->render($this->class_name . 'addEdit');
                }
                $amenitiesData = $_POST['quantity'];                
                unset($_POST['quantity']);                                
                unset($_POST['packageAmenitiesList_length']);                                
                $response = $this->StablePackage_Model->savePackage($_POST,$amenitiesData);
                if($response)
                {
                    $this->session->set_flashdata('message_success',$this->data['page_title'].' Updated Successfully.');
                }else
                {
                    $this->session->set_flashdata('message_error',$this->data['page_title'].' Updated Unsuccessfully.');
                }
                redirect($this->class_name);
            }else{                    
                $this->session->set_flashdata('message_error','Missing information.');
            }
            $this->session->set_flashdata('errors',$this->form_validation->error_array());            
        }        
        $this->data['errors'] = $this->session->flashdata('errors');
        $this->data['postData'] = $postData;    
        $this->render($this->class_name . 'addEdit');
    }
    public function delete($id)
    {	 
        if(is_numeric($id)){
			$page_title='Package Deleted';
			$this->load->model(['StablePackage_Model']);
			$this->StablePackage_Model->deletePackage($id) == 1 ? $this->session->set_flashdata('message_success',$page_title.' Successfully.') : $this->session->set_flashdata('message_error',$page_title.' Unsuccessfully.');
		}else{
			$this->session->set_flashdata('message_error','Missing information.');
	    }
		redirect($this->class_name);
    }
}