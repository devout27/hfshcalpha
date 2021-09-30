<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Activity extends Admin_Controller
{
    public $class_name='';
	function __construct()
	{
		parent::__construct();
		$this->class_name='super-admin/'.ucfirst(strtolower($this->router->fetch_class())).'/';
        $this->data['class_name'] = $this->class_name;        
        $this->load->model('Logs');
	}
	public function index($players_id=null)
	{   
        if($this->input->is_ajax_request()) {            
			$res = $this->Logs->getMyLogsList($players_id,$_POST);
            $sub_page_view_url="view";
            $result=[];
            $i=$_POST['start'];
			foreach($res as $v){             
                $i++;
                $id='<a href="'.$this->data['BASE_URL_ADMIN'].'Members/'.$sub_page_view_url.'/'.$v['join_players_id'].'">'.$v['players_nickname'].'</a>';
				$result[] = array($i,$id,$v['log_activity'],$v['log_ip'],$v['log_date']);
			}
			$output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->Logs->countAll($players_id,$_POST),
                "recordsFiltered" => $this->Logs->countFiltered($players_id,$_POST),
                "data" => $result
            );
            echo json_encode($output);exit;
		}else{
			$this->data['page_title'] = 'Activity Logs';
            $this->data['dataTableElement'] = 'myLogsList';
            $this->data['dataTableURL'] = BASE_URL.$this->data['class_name'];
		    $this->render($this->class_name.'index');
		}        
	}
}