<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Banks extends Admin_Controller
{
    public $class_name='';
	function __construct()
	{
		parent::__construct();
		$this->class_name='super-admin/'.ucfirst(strtolower($this->router->fetch_class())).'/';
        $this->data['class_name'] = $this->class_name;        
        $this->load->model('Bank');
	}
	public function index($players_id=null)
	{   
        if ($this->input->is_ajax_request()) {            
			$res = $this->Bank->getMyBankAccountsList($players_id,$_POST);
            $sub_page_view_url="view";
            $result=[];
            $i=$_POST['start'];
			foreach($res as $v){             
                $i++;
                if($v['bank_pending']){
                    $v['bank_status'] = "Pending";
                }elseif($v['bank_closed']){
                    $v['bank_status'] = "Closed";
                }else{
                    $v['bank_status'] = "Open";
                }
                $v['bank_available_balance'] = $v['bank_balance'];
                $name='<a href="'.$this->data['BASE_URL'].$this->data['class_name'].$sub_page_view_url.'/'.$v['bank_id'].'">'.$v['bank_nickname'].' #'.$v['bank_id'].'</a>';
                $bal = '$'.number_format($v['bank_credit_limit'] - $v['bank_balance']);
                if($v['bank_type'] != "Loan"):
                    $bal = '$'.number_format($v['bank_available_balance']);                 
                endif;
				$result[] = array($i,$name,$v['bank_type'],$v['bank_status'],'$'.number_format($v['bank_balance']),$bal);
			}
			$output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->Bank->countAll($players_id,$_POST),
                "recordsFiltered" => $this->Bank->countFiltered($players_id,$_POST),
                "data" => $result
            );
            echo json_encode($output);exit;
		}else{
			$this->data['page_title'] = 'Bank Accounts';
            $this->data['dataTableElement'] = 'myBankAccountsList';
            $this->data['dataTableURL'] = BASE_URL.$this->data['class_name'];
		    $this->render($this->class_name.'index');
		}        
	}
    public function view($id)
    {           
        if (!is_numeric($id)) {            
            redirect($this->class_name);
        }
        $account = new $this->Bank($id);        
		$this->data['account'] = $this->Bank->get($id);        
        if($this->data['account']['bank_status'] == "Pending"){
			$this->session->set_flashdata('message_error', "Account is currently pending.");
			redirect($this->class_name);;
		}elseif($this->data['account']['bank_status'] == "Closed"){
			$this->session->set_flashdata('message_error', "Account is closed.");
			redirect($this->class_name);
		}
        $this->load->model('Member_Model');
        $member = $this->Member_Model->getUserDataById($this->data['account']['join_players_id']);
        if(empty($member))
        {            
			$this->session->set_flashdata('message_error', "Bank Account Holder Not Found.");
            redirect($this->class_name);
        }
        if($this->input->post('update_bank_details')){
			$response = $this->Bank::edit_account($member,$this->data['account'], $_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('message_error', "There was a problem updating the bank account.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);				
                redirect($this->class_name.'view/'.$id);
			}
			$this->session->set_flashdata('notice', "Account updated.");
			redirect($this->class_name.'view/'.$id);
		}                
        $this->data['page_title'] = $this->data['account']['bank_type'] . " Statement: " . $this->data['account']['bank_nickname'] . " #" . $this->data['account']['bank_id'];        
        $this->data['main_page_url'] = $this->data['BASE_URL'].$this->class_name.'view/'.$this->data['account']['join_players_id'];        
        $this->load->model('Player');        
        $this->data['member'] = $member;        
        if($this->data['account']['bank_type'] == "Checking"){            
			$this->render($this->class_name.'bank-checking');
		}elseif($this->data['account']['bank_type'] == "Savings"){            
			$this->render($this->class_name.'bank-savings');
		}elseif($this->data['account']['bank_type'] == "Business"){
			$this->render($this->class_name.'bank-business');
		}elseif($this->data['account']['bank_type'] == "Loan"){
			$this->render($this->class_name.'bank-loan');
		}
    }
}