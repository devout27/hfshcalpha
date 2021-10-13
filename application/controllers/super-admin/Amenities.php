<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Amenities extends Admin_Controller
{
    public $class_name='';
	function __construct()
	{
		parent::__construct();
		$this->class_name='super-admin/'.ucfirst(strtolower($this->router->fetch_class())).'/';
        $this->data['class_name'] = $this->class_name;        
        $this->load->model('Amenity_Model');
	}
	public function index($stable_id=null)
	{   
        if ($this->input->is_ajax_request()) {
			$res = $this->Amenity_Model->getAmenitiesList($stable_id,$_POST);
            $sub_page_view_url="view";
            $sub_page_url = 'addEdit';
            $sub_page_delete_url = 'delete';
            $result=[];
            $i=$_POST['start'];
			foreach($res as $v){
                $i++;
      		    $img = '<img src="'.getAmenityPic($v['amenities_picture']).'" height="50">';
                $id ='<a href="'.BASE_URL.$this->data['class_name'].$sub_page_view_url."/".$v['amenities_id'].'" title="View">'.$v['amenities_id'].'</a>';
                $info = '<b>'.$v['amenities_name'].'</b><br/><p><small>'.$v['amenities_description'];
				$action = '<div class="action-btns">';
                $action .= '<a class="view-btn" href="'.BASE_URL.$this->data['class_name'].$sub_page_view_url."/".$v['amenities_id'].'" title="View"><i class="las la-eye"></i></a>';
                $action .= '<a class="view-btn" href="'.BASE_URL.$this->data['class_name'].$sub_page_url."/".$v['amenities_id'].'" title="Edit"><i class="las la-edit"></i></a>';
                $url = BASE_URL.$this->data['class_name'].$sub_page_delete_url."/".$v['amenities_id'];
                $msg = "Are you sure you want to delete this Stable Amenity?";
                $action .='<a href="javascript:void(0)" msg="'.$msg.'" url="'.$url.'" title="delete" class="delete-btn my-del-btn"><i class="las la-trash"></i></a>';
                $action .='</div>';
				$result[] = array($i,$img,$info,'$'.$v['amenities_cost'],$v['amenities_type'],$v['amenities_stalls'],$v['amenities_acres'],dateFormate($v['ameneties_created']),$action);
			}
			$output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->Amenity_Model->countAll($stable_id,$_POST),
                "recordsFiltered" => $this->Amenity_Model->countFiltered($stable_id,$_POST),
                "data" => $result
            );
            echo json_encode($output);exit;
		}else{
			$this->data['page_title'] = 'Amenities List';
			$this->data['sub_page_title'] = 'Create Amenity';
            $this->data['dataTableElement'] = 'amenitiesList';
            $this->data['dataTableURL'] = BASE_URL.$this->data['class_name'];
		    $this->render($this->class_name.'index');
		}        
	}
    public function amenitiesList($id = false)
    {
            $res = $this->Amenity_Model->getAmenitiesList($stable_id,$_POST);            
            $result=[];
            $i=$_POST['start'];
			foreach($res as $v){
                $i++;
      		    $img = '<img src="'.getAmenityPic($v['amenities_picture']).'" height="50">';
                $value=$this->Amenity_Model->getPackageAmenityQty($id,$v['amenities_id']);
                $info = '<b>'.$v['amenities_name'].'</b><br/><p><small>'.$v['amenities_description'];
				$action = '<div class="form-group"><input name="quantity['.$v['amenities_id'].']" type="number" class="form-control" value="'.$value.'"/></div>';
				$result[] = array($img,$info,'$'.$v['amenities_cost'],$v['amenities_type'],$v['amenities_stalls'],$v['amenities_acres'],$action);
			}
			$output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->Amenity_Model->countAll($stable_id,$_POST),
                "recordsFiltered" => $this->Amenity_Model->countFiltered($stable_id,$_POST),
                "data" => $result
            );
            echo json_encode($output);exit;
    }
    public function view($id)
    {
        if (!is_numeric($id)) {
            redirect($this->class_name);
        }
        $this->data['page_title'] = 'Amenity Details';
        $this->data['main_page_url'] =  $this->data['BASE_URL'].$this->class_name;
        $this->data['amenity'] = $this->Amenity_Model->getAmenityDataById($id);
        if(empty($this->data['amenity']))
        {
            $this->session->set_flashdata('message_error','Amenity Not Found.');
            redirect($this->class_name);
        }        
        $this->render($this->class_name.'view');
    }
    public function addEdit($id=false)
    {
        if ($id) {
            $postData = $this->Amenity_Model->getAmenityDataById($id);
            if(empty($postData))
            {
                $this->session->set_flashdata('message_error','Amenity Not Found.');
                redirect($this->class_name);
            }
            $this->data['page_title'] = $postData['amenities_name'] . " #" . $postData['amenities_id'];
        }else
        {
			$this->data['page_title'] = 'Create Amenity';
            $postData=[];
        }
        $this->load->helper('form');
        $this->data['main_page_url'] =  $this->data['BASE_URL'].$this->class_name;
        $this->load->model('Amenity_Model');        
        if($this->input->post()){
            $this->load->library('form_validation');
            $set_rules = $this->Amenity_Model->config_add;
            if(!empty($postData['amenities_id']))
            {
                $set_rules = $this->Amenity_Model->config_edit;
            }
            $this->form_validation->set_rules($set_rules);
            $this->form_validation->set_error_delimiters('<div class="form-error">','</div>');
            if($this->form_validation->run()===TRUE)
			{
                $_POST['amenities_id']=$id;
                unset($_POST['submit']);
                $errors = [];
                if($_POST['amenities_type'] == "Building" AND $_POST['amenities_acres'] <= 0){
                    $errors['amenities_acres'] = "All buildings take up some land. Please enter a new acreage value.";
                }
                if($_POST['amenities_type'] == "Paddock" AND $_POST['amenities_acres'] <= 0){
                    $errors['amenities_acres'] = "All paddocks fence in existing land. Please enter a new acreage value.";
                }
                if($_POST['amenities_type'] == "Course" AND $_POST['amenities_acres'] <= 0){
                    $errors['amenities_acres'] = "All courses take up some land. Please enter a new acreage value.";
                }
                if($_POST['amenities_type'] == "Land" AND $_POST['amenities_acres'] <= 0){
                    $errors['amenities_acres'] = "Please enter an acreage value.";
                }
                if(count($errors) > 0)
                {
                    $this->data['errors'] = $errors;
                    $this->data['postData'] = $_POST;    
                    return $this->render($this->class_name . 'addEdit');
                }
                $response = $this->Amenity_Model->saveAmenity($_POST);
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
			$page_title='Amenity Deleted';
			$this->load->model(['Amenity_Model']);
			$this->Amenity_Model->deleteAmenity($id) == 1 ? $this->session->set_flashdata('message_success',$page_title.' Successfully.') : $this->session->set_flashdata('message_error',$page_title.' Unsuccessfully.');
		}else{
			$this->session->set_flashdata('message_error','Missing information.');
	    }
		redirect($this->class_name);
    }
}