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
                $msg = "Are you sure you want to delete this user and Remove All Data Related to this User like Cards ,Cards Likes,Cards Reviews, Cards Comments and Subscription?";
                $action .='<a href="javascript:void(0)" msg="'.$msg.'" url="'.$url.'" title="delete" class="delete-btn my-del-btn"><i class="las la-trash"></i></a>';
                $action .='</div>';
                $id ='<a href="'.BASE_URL.$this->data['class_name'].$sub_page_view_url."/".$v['players_id']."/".$page_status.'" title="View">'.generateId($v['players_id']).'</a>';                
                $data[] = array($i,$id,ucfirst($v['players_nickname']),$v['players_email'],$my_status,dateFormate($v['players_last_active']),dateFormate($v['players_join_date']),$action);
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
        if (empty($id)) {
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
        if(!empty($id)){ 
			$page_title='Member Deleted';
			$this->load->model('Member_Model');            
			$userInfo = $this->Member_Model->getUserDataById($id);
			if ($this->Member_Model->deleteUser($id))
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
    public $stripe,$currency,$symbol=false;
    
    public function cancelUserMembership($userInfo)
    {   
        $this->load->model(['Member_Model','Membership_Model']);
        $plan=$this->Membership_Model->getMembershipPlan($userInfo['subscription_plan_id']);
        if(count($plan)>0 && count($userInfo) > 0)
        {
            require_once APPPATH."/third_party/stripe-php/init.php";
            $this->stripe = new \Stripe\StripeClient(STRIPE_SECRET);
            $response = $this->stripe->subscriptions->update($userInfo['stripe_subscription_id'],['cancel_at_period_end'=>true]);
            if($response)
            {
                $subscription = $this->Member_Model->getSubscription($userInfo['subscription_id']);
                $info = [
                    'status'=>'canceled on '.date('d M',strtotime($userInfo['next_billing_time'])),
                    'canceled_reason'=>"This Membership Owner's Account was Deleted.",
                    'canceled_on'=>date('Y-m-d H:i:s',strtotime($userInfo['next_billing_time']))
                ];
                $this->Member_Model->updateSubscription($info,$userInfo['subscription_id']);
                $body = '<div class="top-info" style="margin-top: 25px;text-align: left;"><span style="font-size: 17px; letter-spacing: 0.5px; line-height: 28px; word-spacing: 0.5px;">';
                $body .= "Your Membership Subscription for ".$plan['name']." is Canceled on ".dateFormate($userInfo['next_billing_time'])." and Your Account was Deleted by Admin. If you have any questions, you may ask ".setting('site_name')." Support about this cancellation and Account Deletion.
                <br><br>
                Here's the information:<br><br>
                By: ".setting('site_name')."<br>
                For:	".$subscription['plan_name']."<br>
                <br><br>
                About the automatic payment canceled:<br><br>
                Amount to be paid each time: ".addTax($plan['price'],$subscription['tax'])." ".ucfirst($subscription['plan_amount_currency'])."<br>
                Payments start:	".dateformate($userInfo['membership_purchased_on']);
                $body .='</span></div>';
                $subject='Hi '.$userInfo['name'].',';
                $body = emailTemplate($subject,$body);
                sendEmail($userInfo['email'],$subject,$body,setting('email'),setting('site_name'));
            }
        }        
        return true;
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
    public function addEdit($id = null, $page_status = null)
    {
        $this->load->helper('form');

        $this->data['page_title'] = $page_title = 'Add New User';
        if (!empty($id)) {

            $this->data['page_title'] = $page_title = 'Edit User';
        }
        $this->data['main_page_url'] = 'index/' . $page_status;
        $this->load->model('Member_Model');

        $postData = array();
        $postData = $this->Member_Model->getUserDataById($id);

        if ($this->input->post()) {

            $this->load->library('form_validation');
            $set_rules = $this->Member_Model->config_admin;

            if (!empty($id)) {
                $set_rules = $this->Member_Model->config_edit_admin;
            }

            $this->form_validation->set_rules($set_rules);
            $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

            if (!empty($id)) {

                $postData['id'] = $this->input->post('id');
            }

            $postData['name'] = $this->input->post('name');
            $postData['email'] = $this->input->post('email');
            $password=$postData['password'] = $this->input->post('password');
            $postData['mobile'] = $this->input->post('mobile');
            if ($this->form_validation->run() === true) {

                if (!empty($postData['password'])) {
                    user_security(['id'=>$postData['id'],'password'=>$postData['password']]);
                    $postData['password'] = md5($postData['password']);
                } else {
                    unset($postData['password']);
                }

                if(empty($postData['id'])){

                    $postData['email_verification']=1;
                    $postData['created_from']='backends';
                }
                $insert_id = $this->Member_Model->saveUser($postData);
                if ($insert_id > 0) {

                    $this->session->set_flashdata('message_success', $page_title . ' Successfully.');
                    if(empty($postData['id'])){

                        //$url = base_url() . 'login';
						$url='';
                        $toEmail = $postData['email'];
                        $subject = "Account Created By Admin";
                        $toEmail = $postData['email'];
                        $body = '<div class="top-info" style="margin-top: 25px;text-align: left;"><span style="font-size: 17px; letter-spacing: 0.5px; line-height: 28px; word-spacing: 0.5px;">
                        Hi ' . $postData['name'] . ',<br> Your account has been created by admin.Please login your account<br>Login Url :  ' . $url . '<br>Email :    ' . $postData['email'] . '<br> Password:    ' . $password . '<br></span></div>';
                        $body = emailTemplate($subject, $body);
                        sendEmail($toEmail, $subject, $body);
                    }
                    redirect($this->class_name.'index/' . $page_status);
                } else {
                    $this->session->set_flashdata('message_error', $page_title . ' Unsuccessfully.');
                }
            } else {

                #$this->session->set_flashdata('message_error', 'Missing information.');
            }
        }

        $this->data['postData'] = $postData;
        $this->render($this->class_name . 'add_edit');

    }
    public function exportCSV($status = null)
    {

        $this->load->model('Member_Model');
// file name
        $filename = 'user-list-' . date('d') . '-' . date('m') . '-' . date('Y') . '.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");

        $lists = $this->Member_Model->getUserList($status);
// file creation
        $file = fopen('php://output', 'w');
        $header = array("Customer Code", "Name", "Mobile", "Email", "Last Login", "Last Login IP", "Created On", "Status");
        fputcsv($file, $header);

        foreach ($lists as $key => $list) {
            $data = array();
            $data['customer_code'] = CUSTOMER_ID_PREFIX . $list['id'];
            $data['name'] = ucwords($list['name']);
            $data['mobile'] = $list['mobile'];
            $data['email'] = $list['email'];
            $data['last_login'] = dateFormate($list['last_login']);
            $data['last_login_ip'] = $list['last_login_ip'];
            $data['created'] = dateFormate($list['created']);
            $data['status'] = $list['status'] == 1 ? "Active" : "Inactive";
            fputcsv($file, $data);
        }
        fclose($file);
        exit;
    }

    public function ImportCSV()
    {

        $this->load->model('Member_Model');
        $page_status = $_POST['page_status'];
        if (!empty($_FILES['csv']['name'])) {

            $tmp_name = $_FILES['csv']['tmp_name'];
            $filename = $_FILES['csv']['name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if ($ext == "csv") {
                if (($handle = fopen($tmp_name, "r")) !== false) {
                    $i = 0;
                    while (($data = fgetcsv($handle, 1000, ",")) !== false) {

                        $userSaveData = array();
                        $row = 0;
                        if ($i > 0) {

                            $name = trim($data['0']);
                            $mobile = trim($data['1']);
                            $email = trim($data['2']);
                            $password = trim($data['3']);

                            if (!empty($email) && !$this->Member_Model->checkEmailId($email) && !empty($name)) {

                                $userSaveData['name'] = $name;
                                $userSaveData['email'] = $email;
                                $userSaveData['mobile'] = $mobile;
                                $userSaveData['password'] = !empty($password) ? md5($password) : md5('12345678');
                                $userSaveData['email_verification'] = 1;
                                $id = $this->Member_Model->saveUser($userSaveData);
#pr($userSaveData);
                                if ($id > 0) {
                                    $row++;

                                }
                            }
                        }
                        $i++;
                    }

                    fclose($handle);
                    $this->session->set_flashdata('message_success', $row . ' User import  successfully.');

                } else {

                    $this->session->set_flashdata('message_error', 'Selected only csv file');
                }
            } else {

                $this->session->set_flashdata('message_error', 'Selected only csv file');

            }

        } else {

            $this->session->set_flashdata('message_success', 'Please selected csv file');
        }
        redirect('admin/Users/index/' . $page_status);
    }  
    
	public function subscribers()
    {
        $this->load->helper('form');
        $this->load->model('Member_Model');
        $title ='Subscribers';
        $this->data['page_title'] = $title;
        $this->data['sub_page_delete_url'] = 'subscriberDelete';
        $lists = $this->Member_Model->getSubscribersList();
        $this->data['lists'] = $lists;
        $this->data['status'] = $status;
        $this->render($this->class_name . 'subscribers');
    }
	
    public function contacts()
    {
        $this->load->helper('form');
        $this->load->model('Member_Model');
        $title ='Contacts';
        $this->data['page_title'] = $title;
        $this->data['sub_page_delete_url'] = 'contactDelete';
        $lists = $this->Member_Model->getContactsList();
        $this->data['lists'] = $lists;
        $this->data['status'] = $status;
        $this->render($this->class_name . 'contacts');
    }
	public function subscriberDelete($id = null)
    {
        if (!empty($id)) {

            $page_title = 'Subscribe Email Delete';
            $this->load->model('Member_Model');
            if ($this->Member_Model->deleteSubscribeEmail($id)) {
                $this->session->set_flashdata('message_success', $page_title . ' Successfully.');

            } else {
                $this->session->set_flashdata('message_error', $page_title . ' Unsuccessfully.');
            }
        } else {

            $this->session->set_flashdata('message_error', 'Missing information.');
        }
        redirect('admin/Users/subscribers');
    }
    public function contactDelete($id = null)
    {
        if (!empty($id)) {

            $page_title = 'Contact Delete';
            $this->load->model('Member_Model');
            if ($this->Member_Model->deleteContact($id)) {
                $this->session->set_flashdata('message_success', $page_title . ' Successfully.');

            } else {
                $this->session->set_flashdata('message_error', $page_title . ' Unsuccessfully.');
            }
        } else {

            $this->session->set_flashdata('message_error', 'Missing information.');
        }
        redirect('admin/Users/contacts');
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
