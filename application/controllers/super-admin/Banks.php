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
            $sub_page_url="addEdit";
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
                $name=$v['bank_nickname'];
                $ID='<a href="'.$this->data['BASE_URL'].$this->data['class_name'].$sub_page_view_url.'/'.$v['bank_id'].'">'.$v['bank_id'].'</a>';
                $bal = '$'.number_format($v['bank_credit_limit'] - $v['bank_balance']);
                if($v['bank_type'] != "Loan"): $bal = '$'.number_format($v['bank_available_balance']); endif;
                $action = '<div class="action-btns">';                
                $action .= '<a class="view-btn" href="'.BASE_URL.$this->data['class_name'].$sub_page_view_url."/".$v['bank_id'].'" title="View"><i class="las la-eye"></i></a> ';
                $action .= '<a class="view-btn" href="'.BASE_URL.$this->data['class_name'].$sub_page_url."/".$v['bank_id'].'" title="Edit"><i class="las la-edit"></i></a>';
                $action .= '</div>';
				$result[] = array($i,$ID,$name,$v['bank_type'],$v['bank_status'],'$'.number_format($v['bank_balance']),$bal,$action);
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
			$this->data['sub_page_title'] = 'Create Account';
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
		$this->data['account'] = $this->Bank->get($id,"NoChecks");
        //$this->data['account'] = $this->Bank->get($id);
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
			$this->session->set_flashdata('message_success', "Bank Account Updated Successfully.");
			redirect($this->class_name.'view/'.$id);
		}
        if($this->input->post('update_bank_balance_details')){
			$response = $this->Bank::edit_account_balance($member,$this->data['account'], $_POST);
			if(count($response['errors']) > 0){
				$this->session->set_flashdata('message_error', "There was a problem updating the bank account.");
				$this->session->set_flashdata('post', $_POST);
				$this->session->set_flashdata('errors', $response['errors']);
                redirect($this->class_name.'view/'.$id);
			}
			$this->session->set_flashdata('message_success', "Bank Account Updated Successfully.");
			redirect($this->class_name.'view/'.$id);
		}        
        $this->data['page_title'] = $this->data['account']['bank_type'] . " Statement: " . $this->data['account']['bank_nickname'] . " #" . $this->data['account']['bank_id'];
        $this->data['main_page_url'] = $this->data['BASE_URL'].$this->class_name.'view/'.$this->data['account']['join_players_id'];
        $this->load->model('Player');
        $this->data['member'] = $member;                
        if($this->data['account']['bank_type'] == "Checking"){                                    
            $this->data['dataTableElement'] = 'accountOverviewList';
            $this->data['dataTableURL'] = BASE_URL.$this->data['class_name'].'transactionsList/'.$id.'/checking/overview';
            $this->data['dataTableElement2'] = 'accountOutgoingList';
            $this->data['dataTableURL2'] = BASE_URL.$this->data['class_name'].'transactionsList/'.$id.'/checking/outgoing';
            $this->data['dataTableElement3'] = 'accountIncomingList';
            $this->data['dataTableURL3'] = BASE_URL.$this->data['class_name'].'transactionsList/'.$id.'/checking/incoming';
			$this->render($this->class_name.'bank-checking');
		}elseif($this->data['account']['bank_type'] == "Savings"){                        
            $this->data['dataTableElement'] = 'accountOverviewList';
            $this->data['dataTableURL'] = BASE_URL.$this->data['class_name'].'transactionsList/'.$id.'/savings/overview';
            $this->data['dataTableElement2'] = 'accountOutgoingList';
            $this->data['dataTableURL2'] = BASE_URL.$this->data['class_name'].'transactionsList/'.$id.'/savings/outgoing';
            $this->data['dataTableElement3'] = 'accountIncomingList';
            $this->data['dataTableURL3'] = BASE_URL.$this->data['class_name'].'transactionsList/'.$id.'/savings/incoming';
			$this->render($this->class_name.'bank-savings');
		}elseif($this->data['account']['bank_type'] == "Business"){            
            $this->data['dataTableElement'] = 'accountOverviewList';
            $this->data['dataTableURL'] = BASE_URL.$this->data['class_name'].'transactionsList/'.$id.'/business/overview';
            $this->data['dataTableElement2'] = 'accountOutgoingList';
            $this->data['dataTableURL2'] = BASE_URL.$this->data['class_name'].'transactionsList/'.$id.'/business/outgoing';
            $this->data['dataTableElement3'] = 'accountIncomingList';
            $this->data['dataTableURL3'] = BASE_URL.$this->data['class_name'].'transactionsList/'.$id.'/business/incoming';
			$this->render($this->class_name.'bank-business');
		}elseif($this->data['account']['bank_type'] == "Loan"){            
            $this->data['dataTableElement'] = 'accountOverviewList';
            $this->data['dataTableURL'] = BASE_URL.$this->data['class_name'].'transactionsList/'.$id.'/loan/overview';
            $this->data['dataTableElement2'] = 'accountOutgoingList';
            $this->data['dataTableURL2'] = BASE_URL.$this->data['class_name'].'transactionsList/'.$id.'/loan/outgoing';
			$this->render($this->class_name.'bank-loan');
		}
    }
    public function transactionsList($bank_id,$bankType,$txnType)
    {
        if(!is_numeric($bank_id) || empty($bankType) || empty($txnType)){
            redirect($this->class_name);
        }
        //checking
        if($bankType=="checking" && $txnType=="overview")
        {       
            $result=[];            
		    $checks = $this->Bank->getChecksList($bank_id,$bankType,$txnType,$_POST);
            $i=$_POST['start'];
            foreach($checks AS $i => $v){                
                $i++;
                $v['bank_checks_debit'] = 0;
                $v['bank_checks_credit'] = 0;
                if($v['join_bank_id'] == $bank_id){
                    $v['bank_checks_debit'] = $v['bank_checks_amount'];
                    $v['bank_checks_memo2'] = "To " . $v['b2_nickname'] . " #" . $v['bank_checks_to_id'];
                }else{                    
                    $v['bank_checks_credit'] = $v['bank_checks_amount'];
                    $v['bank_checks_memo2'] = "From " . $v['b1_nickname'] . " #" . $v['join_bank_id'];
                }            
                $result[] = [
                    $i,
                    $v['bank_checks_id'],
                    $v['bank_checks_date'],
                    $v['bank_checks_memo'].'<br/><small class="text-muted">'.$v['bank_checks_memo2'].'</small>',
                    number_format($v['bank_checks_credit']),
                    number_format($v['bank_checks_debit']),
                    $v['bank_checks_status']
                ];
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->Bank->countAllChecks($bank_id,$bankType,$txnType,$_POST),
                "recordsFiltered" => $this->Bank->countAllFilteredChecks($bank_id,$bankType,$txnType,$_POST),
                "data" => $result
            );
            echo json_encode($output);exit;
        }
        if($bankType=="checking" && $txnType=="outgoing")
        {       
            $result=[];
		    $checks = $this->Bank->getChecksList($bank_id,$bankType,$txnType,$_POST);
            $i=$_POST['start'];            
            foreach($checks AS $i => $v){                
                $i++;
                $v['bank_checks_debit'] = 0;
                $v['bank_checks_credit'] = 0;
                if($v['join_bank_id'] == $bank_id){
                    $v['bank_checks_debit'] = $v['bank_checks_amount'];
                    $v['bank_checks_memo2'] = "To " . $v['b2_nickname'] . " #" . $v['bank_checks_to_id'];
                }else{                    
                    $v['bank_checks_credit'] = $v['bank_checks_amount'];
                    $v['bank_checks_memo2'] = "From " . $v['b1_nickname'] . " #" . $v['join_bank_id'];
                }            
                $result[] = [
                    $i,
                    $v['bank_checks_id'],
                    $v['bank_checks_date'],
                    $v['bank_checks_memo'].'<br/><small class="text-muted">'.$v['bank_checks_memo2'].'</small>',                    
                    number_format($v['bank_checks_debit']),
                    $v['bank_checks_status']
                ];
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->Bank->countAllChecks($bank_id,$bankType,$txnType,$_POST),
                "recordsFiltered" => $this->Bank->countAllFilteredChecks($bank_id,$bankType,$txnType,$_POST),
                "data" => $result
            );
            echo json_encode($output);exit;
        }
        if($bankType=="checking" && $txnType=="incoming")
        {       
            $result=[];            
		    $checks = $this->Bank->getChecksList($bank_id,$bankType,$txnType,$_POST);
            $i=$_POST['start'];                        
            foreach($checks AS $i => $v){
                $i++;
                $v['bank_checks_debit'] = 0;
                $v['bank_checks_credit'] = 0;
                if($v['join_bank_id'] == $bank_id){
                    $v['bank_checks_debit'] = $v['bank_checks_amount'];
                    $v['bank_checks_memo2'] = "To " . $v['b2_nickname'] . " #" . $v['bank_checks_to_id'];
                }else{                    
                    $v['bank_checks_credit'] = $v['bank_checks_amount'];
                    $v['bank_checks_memo2'] = "From " . $v['b1_nickname'] . " #" . $v['join_bank_id'];
                }                        
                $url = $this->data['BASE_URL'].$this->class_name.'process_check/'.$bank_id.'/'.$v['bank_checks_id'];
                $form = '<form method="post" action="'.$url.'"><div class="row"><div class="col-lg-12">
                      '.hf_dropdown('action', '', '', array('deposit' => 'Deposit ', 'ignore' => 'Ignore', 'refuse' => 'Refuse'), array('class' => 'col-sm-12'), []).'</div><div class="col-lg-12">
                      '.hf_submit('process_check', 'Process', array('class' => 'btn btn-primary col-sm-12')).'</div></div></form>';    
                $result[] = [
                    $i,
                    $v['bank_checks_id'],
                    $v['bank_checks_date'],
                    $v['bank_checks_memo'].'<br/><small class="text-muted">'.$v['bank_checks_memo2'].'</small>',                    
                    number_format($v['bank_checks_credit']),
                    $v['bank_checks_status'],
                    $form
                ];
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->Bank->countAllChecks($bank_id,$bankType,$txnType,$_POST),
                "recordsFiltered" => $this->Bank->countAllFilteredChecks($bank_id,$bankType,$txnType,$_POST),
                "data" => $result
            );
            echo json_encode($output);exit;
        }
        //savings        
        if($bankType=="savings" && $txnType=="overview")
        {       
            $result=[];            
		    $checks = $this->Bank->getChecksList($bank_id,$bankType,$txnType,$_POST);
            $i=$_POST['start'];
            foreach($checks AS $i => $v){                
                $i++;
                $v['bank_checks_debit'] = 0;
                $v['bank_checks_credit'] = 0;
                if($v['join_bank_id'] == $bank_id){
                    $v['bank_checks_debit'] = $v['bank_checks_amount'];
                    $v['bank_checks_memo2'] = "To " . $v['b2_nickname'] . " #" . $v['bank_checks_to_id'];
                }else{                    
                    $v['bank_checks_credit'] = $v['bank_checks_amount'];
                    $v['bank_checks_memo2'] = "From " . $v['b1_nickname'] . " #" . $v['join_bank_id'];
                }            
                $result[] = [
                    $i,
                    $v['bank_checks_id'],
                    $v['bank_checks_date'],
                    $v['bank_checks_memo'].'<br/><small class="text-muted">'.$v['bank_checks_memo2'].'</small>',
                    number_format($v['bank_checks_credit']),
                    number_format($v['bank_checks_debit']),
                    $v['bank_checks_status']
                ];
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->Bank->countAllChecks($bank_id,$bankType,$txnType,$_POST),
                "recordsFiltered" => $this->Bank->countAllFilteredChecks($bank_id,$bankType,$txnType,$_POST),
                "data" => $result
            );
            echo json_encode($output);exit;
        }
        if($bankType=="savings" && $txnType=="outgoing")
        {       
            $result=[];            
		    $checks = $this->Bank->getChecksList($bank_id,$bankType,$txnType,$_POST);
            $i=$_POST['start'];            
            foreach($checks AS $i => $v){                
                $i++;
                $v['bank_checks_debit'] = 0;
                $v['bank_checks_credit'] = 0;
                if($v['join_bank_id'] == $bank_id){
                    $v['bank_checks_debit'] = $v['bank_checks_amount'];
                    $v['bank_checks_memo2'] = "To " . $v['b2_nickname'] . " #" . $v['bank_checks_to_id'];
                }else{                    
                    $v['bank_checks_credit'] = $v['bank_checks_amount'];
                    $v['bank_checks_memo2'] = "From " . $v['b1_nickname'] . " #" . $v['join_bank_id'];
                }            
                $result[] = [
                    $i,
                    $v['bank_checks_id'],
                    $v['bank_checks_date'],
                    $v['bank_checks_memo'].'<br/><small class="text-muted">'.$v['bank_checks_memo2'].'</small>',                    
                    number_format($v['bank_checks_debit']),
                    $v['bank_checks_status']
                ];
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->Bank->countAllChecks($bank_id,$bankType,$txnType,$_POST),
                "recordsFiltered" => $this->Bank->countAllFilteredChecks($bank_id,$bankType,$txnType,$_POST),
                "data" => $result
            );
            echo json_encode($output);exit;
        }
        if($bankType=="savings" && $txnType=="incoming")
        {       
            $result=[];            
		    $checks = $this->Bank->getChecksList($bank_id,$bankType,$txnType,$_POST);
            $i=$_POST['start'];                        
            foreach($checks AS $i => $v){
                $i++;
                $v['bank_checks_debit'] = 0;
                $v['bank_checks_credit'] = 0;
                if($v['join_bank_id'] == $bank_id){
                    $v['bank_checks_debit'] = $v['bank_checks_amount'];
                    $v['bank_checks_memo2'] = "To " . $v['b2_nickname'] . " #" . $v['bank_checks_to_id'];
                }else{                    
                    $v['bank_checks_credit'] = $v['bank_checks_amount'];
                    $v['bank_checks_memo2'] = "From " . $v['b1_nickname'] . " #" . $v['join_bank_id'];
                }                        
                $url = $this->data['BASE_URL'].$this->class_name.'process_check/'.$bank_id.'/'.$v['bank_checks_id'];                
                $result[] = [
                    $i,
                    $v['bank_checks_id'],
                    $v['bank_checks_date'],
                    $v['bank_checks_memo'].'<br/><small class="text-muted">'.$v['bank_checks_memo2'].'</small>',                    
                    number_format($v['bank_checks_credit']),
                    $v['bank_checks_status']                    
                ];
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->Bank->countAllChecks($bank_id,$bankType,$txnType,$_POST),
                "recordsFiltered" => $this->Bank->countAllFilteredChecks($bank_id,$bankType,$txnType,$_POST),
                "data" => $result
            );
            echo json_encode($output);exit;
        }
        //business        
        if($bankType=="business" && $txnType=="overview")
        {       
            $result=[];            
		    $checks = $this->Bank->getChecksList($bank_id,$bankType,$txnType,$_POST);
            $i=$_POST['start'];
            foreach($checks AS $i => $v){                
                $i++;
                $v['bank_checks_debit'] = 0;
                $v['bank_checks_credit'] = 0;
                if($v['join_bank_id'] == $bank_id){
                    $v['bank_checks_debit'] = $v['bank_checks_amount'];
                    $v['bank_checks_memo2'] = "To " . $v['b2_nickname'] . " #" . $v['bank_checks_to_id'];
                }else{                    
                    $v['bank_checks_credit'] = $v['bank_checks_amount'];
                    $v['bank_checks_memo2'] = "From " . $v['b1_nickname'] . " #" . $v['join_bank_id'];
                }            
                $result[] = [
                    $i,
                    $v['bank_checks_id'],
                    $v['bank_checks_date'],
                    $v['bank_checks_memo'].'<br/><small class="text-muted">'.$v['bank_checks_memo2'].'</small>',
                    number_format($v['bank_checks_credit']),
                    number_format($v['bank_checks_debit']),
                    $v['bank_checks_status']
                ];
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->Bank->countAllChecks($bank_id,$bankType,$txnType,$_POST),
                "recordsFiltered" => $this->Bank->countAllFilteredChecks($bank_id,$bankType,$txnType,$_POST),
                "data" => $result
            );
            echo json_encode($output);exit;
        }
        if($bankType=="business" && $txnType=="outgoing")
        {       
            $result=[];            
		    $checks = $this->Bank->getChecksList($bank_id,$bankType,$txnType,$_POST);
            $i=$_POST['start'];            
            foreach($checks AS $i => $v){                
                $i++;
                $v['bank_checks_debit'] = 0;
                $v['bank_checks_credit'] = 0;
                if($v['join_bank_id'] == $bank_id){
                    $v['bank_checks_debit'] = $v['bank_checks_amount'];
                    $v['bank_checks_memo2'] = "To " . $v['b2_nickname'] . " #" . $v['bank_checks_to_id'];
                }else{                    
                    $v['bank_checks_credit'] = $v['bank_checks_amount'];
                    $v['bank_checks_memo2'] = "From " . $v['b1_nickname'] . " #" . $v['join_bank_id'];
                }            
                $result[] = [
                    $i,
                    $v['bank_checks_id'],
                    $v['bank_checks_date'],
                    $v['bank_checks_memo'].'<br/><small class="text-muted">'.$v['bank_checks_memo2'].'</small>',                    
                    number_format($v['bank_checks_debit']),
                    $v['bank_checks_status']
                ];
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->Bank->countAllChecks($bank_id,$bankType,$txnType,$_POST),
                "recordsFiltered" => $this->Bank->countAllFilteredChecks($bank_id,$bankType,$txnType,$_POST),
                "data" => $result
            );
            echo json_encode($output);exit;
        }
        if($bankType=="business" && $txnType=="incoming")
        {       
            $result=[];            
		    $checks = $this->Bank->getChecksList($bank_id,$bankType,$txnType,$_POST);
            $i=$_POST['start'];                        
            foreach($checks AS $i => $v){
                $i++;
                $v['bank_checks_debit'] = 0;
                $v['bank_checks_credit'] = 0;
                if($v['join_bank_id'] == $bank_id){
                    $v['bank_checks_debit'] = $v['bank_checks_amount'];
                    $v['bank_checks_memo2'] = "To " . $v['b2_nickname'] . " #" . $v['bank_checks_to_id'];
                }else{                    
                    $v['bank_checks_credit'] = $v['bank_checks_amount'];
                    $v['bank_checks_memo2'] = "From " . $v['b1_nickname'] . " #" . $v['join_bank_id'];
                }                        
                $url = $this->data['BASE_URL'].$this->class_name.'process_check/'.$bank_id.'/'.$v['bank_checks_id'];                
                $result[] = [
                    $i,
                    $v['bank_checks_id'],
                    $v['bank_checks_date'],
                    $v['bank_checks_memo'].'<br/><small class="text-muted">'.$v['bank_checks_memo2'].'</small>',                    
                    number_format($v['bank_checks_credit']),
                    $v['bank_checks_status']                    
                ];
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->Bank->countAllChecks($bank_id,$bankType,$txnType,$_POST),
                "recordsFiltered" => $this->Bank->countAllFilteredChecks($bank_id,$bankType,$txnType,$_POST),
                "data" => $result
            );
            echo json_encode($output);exit;
        }
        //loan
        if($bankType=="loan" && $txnType=="overview")
        {       
            $result=[];            
		    $checks = $this->Bank->getChecksList($bank_id,$bankType,$txnType,$_POST);
            $i=$_POST['start'];
            foreach($checks AS $i => $v){                
                $i++;
                $v['bank_checks_debit'] = 0;
                $v['bank_checks_credit'] = 0;
                if($v['join_bank_id'] == $bank_id){
                    $v['bank_checks_debit'] = $v['bank_checks_amount'];
                    $v['bank_checks_memo2'] = "To " . $v['b2_nickname'] . " #" . $v['bank_checks_to_id'];
                }else{                    
                    $v['bank_checks_credit'] = $v['bank_checks_amount'];
                    $v['bank_checks_memo2'] = "From " . $v['b1_nickname'] . " #" . $v['join_bank_id'];
                }            
                $result[] = [
                    $i,
                    $v['bank_checks_id'],
                    $v['bank_checks_date'],
                    $v['bank_checks_memo'].'<br/><small class="text-muted">'.$v['bank_checks_memo2'].'</small>',
                    number_format($v['bank_checks_credit']),
                    number_format($v['bank_checks_debit']),
                    $v['bank_checks_status']
                ];
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->Bank->countAllChecks($bank_id,$bankType,$txnType,$_POST),
                "recordsFiltered" => $this->Bank->countAllFilteredChecks($bank_id,$bankType,$txnType,$_POST),
                "data" => $result
            );
            echo json_encode($output);exit;
        }
        if($bankType=="loan" && $txnType=="outgoing")
        {       
            $result=[];            
		    $checks = $this->Bank->getChecksList($bank_id,$bankType,$txnType,$_POST);
            $i=$_POST['start'];            
            foreach($checks AS $i => $v){                
                $i++;
                $v['bank_checks_debit'] = 0;
                $v['bank_checks_credit'] = 0;
                if($v['join_bank_id'] == $bank_id){
                    $v['bank_checks_debit'] = $v['bank_checks_amount'];
                    $v['bank_checks_memo2'] = "To " . $v['b2_nickname'] . " #" . $v['bank_checks_to_id'];
                }else{                    
                    $v['bank_checks_credit'] = $v['bank_checks_amount'];
                    $v['bank_checks_memo2'] = "From " . $v['b1_nickname'] . " #" . $v['join_bank_id'];
                }            
                $result[] = [
                    $i,
                    $v['bank_checks_id'],
                    $v['bank_checks_date'],
                    $v['bank_checks_memo'].'<br/><small class="text-muted">'.$v['bank_checks_memo2'].'</small>',                    
                    number_format($v['bank_checks_credit']),
                    $v['bank_checks_status']
                ];
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->Bank->countAllChecks($bank_id,$bankType,$txnType,$_POST),
                "recordsFiltered" => $this->Bank->countAllFilteredChecks($bank_id,$bankType,$txnType,$_POST),
                "data" => $result
            );
            echo json_encode($output);exit;
        }
    }
    public function process_check($bank_id,$check_id){                
        $this->data['account'] = $this->Bank->get($bank_id,"NoChecks");                
        $this->load->model('Member_Model');
        $member = $this->Member_Model->getUserDataById($this->data['account']['join_players_id']);        
        if(empty($member))
        {            
			$this->session->set_flashdata('message_error', "Bank Account Holder Not Found.");
            redirect($this->class_name);
        }
		$response = $this->Bank->process_check($member,$check_id,$_POST['action']);
		if(count($response['errors']) > 0){
			$this->session->set_flashdata('message_error', "There was a problem processing the check.");
			$this->session->set_flashdata('post', $_POST);
			$this->session->set_flashdata('errors', $response['errors']);
		}        
		$this->session->set_flashdata('message_success', $response['notice']);        	
        $sub_page_view_url = 'view';
        redirect($this->data['BASE_URL'].$this->data['class_name'].$sub_page_view_url.'/'.$bank_id,'refresh');
	}


    public function addEdit($id=false)
    {
        $this->load->model('Bank');	
        $this->load->model('Player');
        if($id){
            $postData = $this->Bank->get($id,"no");
            if(empty($postData))
            {
                $this->session->set_flashdata('message_error','Bank Not Found.');
                redirect($this->class_name.'inventory');
            }
            $this->data['page']['title'] = $postData['bank_nickname'] . " #" . $postData['bank_id'];
        }else
        {            
			$this->data['page']['title'] = 'Create Bank Item';
            $postData=['bank_interest_accrued'=>0,'bank_interest_incurred'=>0];
        }
        
        $this->load->helper('form');
        $this->data['players'] = $this->Player->get_all_players();
        $this->data['main_page_url'] =  $this->data['BASE_URL'].$this->class_name;
        if($this->input->post()){			
            $this->load->library('form_validation');
			$this->data['page']['title']="Bank Created";
            $set_rules = $this->Bank->admin_config_add;
            if(!empty($postData['itemid']))
            {
				$this->data['page']['title']="Bank Updated";
                $set_rules = $this->Bank->admin_config_edit;
            }
            $this->form_validation->set_rules($set_rules);
            
            if($this->form_validation->run()===TRUE)
            {                
                unset($_POST['submit']);
                $_POST['players_nickname'] = new Player($_POST['join_players_id']);
                $_POST['players_nickname'] = $_POST['players_nickname']->player['players_nickname'];                
                $response = $this->Bank->saveBank($_POST);
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