<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Horses extends Admin_Controller
{
    public $class_name='';
	function __construct()
	{
		parent::__construct();
		$this->class_name='super-admin/'.ucfirst(strtolower($this->router->fetch_class())).'/';
        $this->data['class_name'] = $this->class_name;        
        $this->load->model('Horse');
	}
	public function index($players_id=null)
	{   
        if ($this->input->is_ajax_request()) {            
			$res = $this->Horse->getMyHorsesList($players_id,$_POST);
            $sub_page_view_url="view";
            $result=[];
            $i=$_POST['start'];
			foreach($res as $v){             
                $i++;
				$name = $v['horses_competition_title'].' '.$v['horses_breeding_title'].' '.$v['horses_name'];
				$action = '';                                
                $v['horses_vet']=$v['horses_vet'] == "0000-00-00" ? "N\A" : $v['horses_vet'];
                $v['horses_farrier']=$v['horses_farrier'] == "0000-00-00" ? "N\A" : $v['horses_farrier'];
                $vetFerr = $v['horses_vet'].' '.$v['horses_farrier'];
				$status = $v['horses_pending']==1 ? '<span class="badge badge-danger pb-1">Pending</span>' : '<span class="badge badge-success pb-1">Approved</span>';
				$stable = $v['stables_name'];                
                $id ='<a href="'.BASE_URL.$this->data['class_name'].$sub_page_view_url."/".$v['horses_id'].'" title="View">'.generateId($v['horses_id']).'</a>';
                $v['horses_hs'] = $v['horses_hs']  ? $v['horses_hs'] : 'N/A';
                $v['horses_fs'] = $v['horses_fs']  ? $v['horses_fs'] : 'N/A';
                $v['players_username'] = $v['players_username']  ? $v['players_username'] : 'N/A';
                $v['horses_color'] = $v['horses_color']  ? $v['horses_color'] : 'N/A';                
				$result[] = array($i,$id,$name,$v['players_username'],$stable,$v['horses_birthyear'],$v['horses_color'],$v['horses_breed'],$v['horses_gender'],$v['horses_hs'],$v['horses_fs'],$vetFerr,$status);
			}
			$output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->Horse->countAll($players_id,$_POST),
                "recordsFiltered" => $this->Horse->countFiltered($players_id,$_POST),
                "data" => $result
            );
            echo json_encode($output);exit;
		}else{
			$this->data['page_title'] = 'Horses';
            $this->data['dataTableElement'] = 'myHorsesList';
            $this->data['dataTableURL'] = BASE_URL.$this->data['class_name'];
		    $this->render($this->class_name.'index');
		}        
	}
}