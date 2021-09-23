<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Members extends Admin_Controller
{
    public $class_name = '';
    public function __construct()
    {
        parent::__construct();
        $this->class_name = 'super-admin/' . ucfirst(strtolower($this->router->fetch_class())) . '/';
        $this->data['class_name'] = $this->class_name;        
    }

    public function index($status = null)
    {
        
        if($this->input->is_ajax_request())
        {
            $this->load->model('Member_Model');
            $i = $_POST['start'];
            $sub_page_view_url = 'view';
            $sub_page_delete_url = 'delete';
            $sub_page_url_active_inactive = 'activeInactive';
            $sub_page_url = 'manage';
            $res = $this->Member_Model->getUsersList($status,$_POST);
            $data = array();
            foreach($res as $v){
                $i++;
                if($v['players_pending']==1)
                {
                    $my_status = '<a class="mr-2" href="'.BASE_URL.$this->data['class_name'].$sub_page_url_active_inactive."/".$v['players_id']."/1/".$status.'"><button type="submit" class="custom-active px-3"><i class="lar la-check-circle"></i></button></a>';
                    $my_status .= '<a href="'.BASE_URL.$this->data['class_name'].$sub_page_url_active_inactive."/".$v['players_id']."/0/".$status.'"><button type="submit" class="custom-inactive px-3"><i class="lar la-times-circle"></i></button></a>';
                }else
                {
                    $my_status = ($v['players_pending']==0) ? '<button type="submit" class="custom-active">Accepted</button>' : '<button type="submit" class="custom-inactive">Rejected</button>';
                }
                $action = '<div class="action-btns">';                
                $action .='<a class="view-btn" href="'.BASE_URL.$this->data['class_name'].$sub_page_url."/".$v['players_id']."/".$page_status.'" title="Edit"><i class="las la-edit"></i></a>';
                $action .='<a class="view-btn" href="'.BASE_URL.$this->data['class_name']."changePassword/".$v['players_id']."/".$page_status.'" title="Change Password"><i class="las la-lock"></i></a>';
                $url = BASE_URL.$this->data['class_name'].$sub_page_delete_url."/".$v['players_id']."/".$page_status;
                $msg = "Are you sure you want to delete this user and You may permanently remove a player from the game. This will move their horses to the Humane Society, disable their account, and disable their bank accounts.?";
                $action .='<a href="javascript:void(0)" msg="'.$msg.'" url="'.$url.'" title="delete" class="delete-btn my-del-btn"><i class="las la-trash"></i></a>';
                $action .='</div>';
                $id ='<a href="'.BASE_URL.$this->data['class_name'].$sub_page_view_url."/".$v['players_id']."/".$page_status.'" title="View">'.generateId($v['players_id']).'</a>';                
                $v['players_last_active']=$v['players_last_active']=='0000-00-00 00:00:00' ? 'N/A' : dateFormate($v['players_last_active']);
                $data[] = array($i,$id,ucfirst($v['players_nickname']),$v['players_email'],$my_status,$v['players_last_active'],dateFormate($v['players_join_date']),$action);
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->Member_Model->countAll($status,$_POST),
                "recordsFiltered" => $this->Member_Model->countFiltered($status,$_POST),
                "data" => $data
            );
            echo json_encode($output);exit;
        }else
        {
            $this->load->model('Member_Model');
            $title = empty($status) ? 'All Members' : ucfirst($status) . ' Members';
            $page_status = !empty($status) ? $status : '';
            $this->data['page_title'] = $title;
            $this->data['page_status'] = $page_status;
            $this->data['sub_page_title'] = 'Add New User';
            $this->data['sub_page_url'] = 'addEdit';
            $this->data['sub_page_view_url'] = 'view';
            $this->data['sub_page_delete_url'] = 'delete';
            $this->data['sub_page_url_active_inactive'] = 'activeInactive';
            $this->data['status'] = $status;
            $this->data['dataTableElement'] = 'usersList';
            $this->data['dataTableURL'] = BASE_URL.$this->data['class_name']."index/".$status;
            $this->render($this->class_name . 'index');
        }
    }
    
    public function sendVerification($id)
    {
        $id = base64_decode($id);        
        $this->load->model('Member_Model');
        $user = $this->Member_Model->getUserDataById($id);
        if(count($user) > 0)
        {
            $toEmail = $user['email'];            
            $from_name =	setting('site_name');								
            $url = BASE_URL.'Logins/emailVerification/'.base64_encode($user['id']);
            $subject = 'Email Verification';
            $body='<div class="top-info" style="margin-top: 25px;text-align: left;">
                        <span style="font-size: 17px; letter-spacing: 0.5px; line-height: 28px; word-spacing: 0.5px;">
                            Hi '.$user['name'].',<br>You have Successfully created your '.$from_name .' account. Please click on the link bellow to verify your email address and complete your registration.
                        </span>
                    </div>
                    <div style="margin: 25px 0px;">
                        <a style="font-size: 14px;text-transform: uppercase;color: #000;font-weight: 600;padding: 10px 30px;border-radius: 3px;border: none;background: #00a9d0;cursor: pointer;text-decoration: none;" href="'.$url.'">
                            Visit Website
                        </a>
                    </div>
                    <div class="top-info" style="margin-top: 25px;text-align: left;">
                        <span style="font-size: 17px; letter-spacing: 0.5px; line-height: 28px; word-spacing: 0.5px;">
                            if you havent created a  '.$from_name .' account, Please ignore this<br> message and make sure that your email account is secure. 
                        </span>
                    </div>';
            $body = emailTemplate($subject,$body);
            sendEmail($toEmail,$subject,$body);
            $this->session->set_flashdata('message_success','Verification Email Sent Successfully.');
        }else
        {
            $this->session->set_flashdata('message_error','User not Found.');
        }   
        redirect("admin/users");
    }
    
    
    
    public function view($id = null,$page_status=null)
    {
        if (!is_numeric($id)) {            
            redirect($this->class_name);
        }
        $this->load->model('Member_Model');
        $this->data['page_title'] = 'User Details';
        $this->data['sub_page_url_active_inactive'] = 'activeInactive';
        $this->data['main_page_url'] =  $this->data['main_page_url'] = 'index/' . $page_status;
        $this->load->model('Member_Model');
        $member = $this->Member_Model->getUserDataById($id);
        if(empty($member))
        {            
            redirect($this->class_name);
        }
        $this->load->model('Player');
        $member['questions']=$this->Player->get_questions($id);
        $this->data['member'] = $member;
        $this->data['dataTableElement'] = 'myHorsesList';
        $this->data['dataTableURL'] = $this->data['BASE_URL_ADMIN'].'Horses/index/'.$id;
        $this->data['dataTableElement2'] = 'myLogsList';
        $this->data['dataTableURL2'] = $this->data['BASE_URL_ADMIN'].'Activity/index/'.$id;
        $this->data['dataTableElement3'] = 'myBankAccountsList';
        $this->data['dataTableURL3'] = $this->data['BASE_URL_ADMIN'].'Banks/index/'.$id;
        $this->render($this->class_name . 'view');
    }
    public function activeInactive($id = null, $status = null, $page_status = null)
    {        
        if (!empty($id) && ($status == 1 || $status == 0)) {
            $postData['players_id'] = $id;
            $page_title = 'Member Approved';
            if ($status == 0) {
                $page_title = 'Member Pending';
            }
            $this->load->model('Player');
            if($status == 1)
            {
                $postData['players_pending'] = 0;
                $res = $this->player->accept_member($postData);
            }else
            {
                $postData['players_pending'] = 1;
                $res = $this->player->reject_member($postData);
            }                   
            if(isset($res['notice']))
            {
                $this->session->set_flashdata('message_success',$res['notice']);
            }
            else
            {                
                $this->session->set_flashdata('message_error',$res['errors']['players_pending']);
            }
        } else {
            $this->session->set_flashdata('message_error', 'Missing information.');
        }
        $this->load->library('user_agent');
        if($this->agent->is_referral())
        {
            redirect($this->agent->referrer());
        }else
        {
            redirect($this->class_name . 'index/' . $page_status);
        }        
    }
    public function delete($id=null,$page_status=null)
    {	 
        if(is_numeric($id)){
			$page_title='Member Deleted';
			$this->load->model(['Player']);
			if($this->Player->admin_remove(['players_id'=>$id]))
			{
			    $this->session->set_flashdata('message_success',$page_title.' Successfully.');
			}
			else
			{
			    $this->session->set_flashdata('message_error',$page_title.' Unsuccessfully.');
			}
		}else{
			$this->session->set_flashdata('message_error','Missing information.');
	    }
		redirect($this->class_name.'index/'.$page_status);
    }    
    public function changePassword($id, $page_status = '', $page_name = null)
    {
        $this->load->helper('form');
        $this->load->model('Member_Model');
        $this->data['page_title'] = $page_title = 'Change Password';
        if (empty($id)) {
            redirect($this->class_name);
        }
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $set_rules = $this->Member_Model->configChangePasswordAdmin;
            $this->form_validation->set_rules($set_rules);
            $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
            $password = $this->input->post('password');
            $postData['players_id'] = $this->input->post('players_id');
            if($this->form_validation->run() === true) {
                $postData['players_password'] = $this->Member_Model->getPassword($password);                
                if($this->Member_Model->saveUser($postData)) {
                    $this->session->set_flashdata('message_success', 'Password Changed Successfully.');
                    if(!empty($postData['players_id']) && !empty($password)){
                        $postData = $this->Member_Model->getUserDataById($postData['players_id']);
						$url = BASE_URL;
                        $toEmail = $postData['players_email'];
                        $subject = "Reset Password By Admin";
                        $body = '<div class="top-info" style="margin-top: 25px;text-align: left;"><span style="font-size: 17px; letter-spacing: 0.5px; line-height: 28px; word-spacing: 0.5px;">
                        Hi ' . $postData['players_nickname'] . ',<br> Your password has been updated by admin.Please login your account<br>Login Url :  ' . $url . '<br>Email :    ' . $postData['players_email'] . '<br> New Password:    ' . $password . '<br></span></div>';
                        send_email($data['players_nickname'],$toEmail, $subject, $body);                        
                    }
                    redirect($this->class_name.'index/' . $page_status);
                } else {
                    $this->session->set_flashdata('message_error','Password Changed Unsuccessfully.');
                }
            }
        }
        $this->data['id'] = $id;
        $this->render($this->class_name . 'change_password');

    }       
    public function manage($id = null, $page_status = null)
    {
        $this->load->helper('form');
        $this->data['page_title'] = $page_title = 'Add New Member';
        if (is_numeric($id)) {
            $this->data['page_title'] = $page_title = 'Member Management';
        }
        $this->data['main_page_url'] = 'index/' . $page_status;
        $this->load->model('Member_Model');
        $postData = array();
        $postData = $this->Member_Model->getUserDataById($id);
        $this->load->model('Player');
        if($this->input->post('update_credits')){                
            $response = $this->Player->admin_update_credits($_POST);
            if(count($response['errors']) > 0){
                $this->session->set_flashdata('message_error', "There was a problem updating the member's credits.");                
                foreach($_POST as $k=>$v)
                {
                    $postData[$k]=$_POST[$k];
                }
                $this->session->set_flashdata('errors', $response['errors']);
            }else{
                $this->session->set_flashdata('message_success', "Member Credits updated.");
                redirect($this->class_name.'index/' . $page_status);
            }            
            redirect($this->class_name.'index/' . $page_status);
        }elseif($this->input->post('update_profile')){
            $response = $this->Player->admin_update_profile($_POST);
            if(count($response['errors']) > 0){
                $this->session->set_flashdata('message_error', "There was a problem updating the member's profile.");                
                foreach($_POST as $k=>$v)
                {
                    $postData[$k]=$_POST[$k];
                }        
                $this->session->set_flashdata('errors', $response['errors']);
            }else{
                $this->session->set_flashdata('message_success', "Member Profile updated.");
                redirect($this->class_name.'index/' . $page_status);
            }
        }
        elseif($this->input->post('update_role')){
            $response = $this->Player->admin_update_role($_POST);
            if(count($response['errors']) > 0){
                $this->session->set_flashdata('message_error', "There was a problem updating the member's Role.");
                $postData=$_POST;
                $this->session->set_flashdata('errors', $response['errors']);
            }else{
                $this->session->set_flashdata('message_success', "Member Role updated.");
                redirect($this->class_name.'index/' . $page_status);
            }
        }
        $this->data['errors'] = $this->session->flashdata('errors');
        $this->data['postData'] = $postData;
        $this->render($this->class_name . 'manage');
    }    
    public function sendLoginCredientials($id)
    {
        $id = base64_decode($id);        
        $this->load->model('Member_Model');
        $user = $this->Member_Model->getUserDataById($id);
        if(count($user) > 0)
        {
            $toEmail = $user['email'];               
            $password=uniqid();
			$postData['password']=md5($password);
			$postData['id']=$user['id'];
            $this->Member_Model->saveUser($postData);
            $from_name =	WEBSITE_NAME;		
            $subject='Your account login credentials';
            $body='<div class="top-info" style="margin-top: 25px;text-align: left;"><span style="font-size: 17px; letter-spacing: 0.5px; line-height: 28px; word-spacing: 0.5px;">
                        Hi '.$user['name'].',<br><br>
                        We hope you enjoy your time with us.<br><br>
                        Your account login credentials:<br>
                        Email:'.$toEmail.'<br>
                        Password:'.$password.'
                    </span>
                </div>';
            $body = emailTemplate($subject,$body);
            sendEmail($toEmail,$subject,$body);
            $this->session->set_flashdata('message_success','Login Credientials Email Sent Successfully.');
        }else
        {
            $this->session->set_flashdata('message_error','User not Found.');
        }   
        redirect("admin/users");
    }    
}
