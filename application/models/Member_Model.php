<?php

Class Member_Model extends MY_Model {

	public $table='players';
	function __construct(){ 
        $this->userTbl = 'players';
        // Set default order
        $this->order = array('players_id' => 'desc');
        $this->user_column_search=['players_id','players_nickname','players_email'];
        $this->user_column_order=['players_id','players_nickname','players_email'];
        $this->order = ['players_id' => 'desc'];
    } 
	public $config = array(
        array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|max_length[50]',
                'errors' => array(
                        'required' => 'Enter name',
                ),
        ),
		array(
                'field' => 'email',
                'label' => 'email id',
                'rules' => 'required|valid_email|max_length[150]|is_unique[users.email]',
                'errors' => array(
                        'required' => 'Enter email id',
						'is_unique'=>'Email id already registered'
                ),
        ),
		array(
			'field' => 'mobile',
			'label' => 'Phone',
			'rules' => 'min_length[5]|max_length[20]',
			
     	),
		array(
                'field' => 'password',
                'label' => 'password',
                'rules' => 'required|max_length[20]|min_length[8]',
                'errors' => array(
                        'required' => 'Enter Password',
                ),
        ),
		array(
				'field'  => 'confirm_password',
				'label'  => 'Confirm Password',
				'rules'  => 'required|matches[password]',
	    ),
    );
	
	public $config_edit = array(
        array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|max_length[50]',
                'errors' => array(
                        'required' => 'Enter first name',
                ),
        ),
		

		array(
                'field' => 'mobile',
                'label' => 'phone number',
                'rules' => 'max_length[14]|min_length[6]',
                'errors' => array(
                        'required' => 'Enter  phone number',
                ),
        ),
		
	
    );
	public $config_admin = array(
        array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|max_length[50]',
                'errors' => array(
                        'required' => 'Enter name',
                ),
        ),
		array(
                'field' => 'mobile',
                'label' => 'Phone',
                'rules' => 'required|min_length[8]|max_length[12]|is_unique[users.mobile]',
                'errors' => array(
					'required' => 'Enter Phone',
					'is_unique'=>'Phone number already registered'
                ),
        ),
		array(
                'field' => 'email',
                'label' => 'email id',
                'rules' => 'required|valid_email|max_length[150]|is_unique[users.email]',
                'errors' => array(
                        'required' => 'Enter email id',
						'is_unique'=>'Email id already registered'
                ),
        ),
		array(
                'field' => 'password',
                'label' => 'password',
                'rules' => 'required|max_length[20]|min_length[8]',
                'errors' => array(
                        'required' => 'Enter Password',
                ),
        ),
		array(
				'field'  => 'confirm_password',
				'label'  => 'Confirm Password',
				'rules'  => 'required|matches[password]',
				'errors' => array(
					'required' => 'Enter Confirm Password',
					'matches'=>"Password and confirm password don't match"
			    ),
	    ),
    );
	
	public $config_edit_admin = array(
        array(
                'field' => 'name',
                'label' => 'name',
                'rules' => 'required|max_length[50]',
                'errors' => array(
                        'required' => 'Enter name',
                ),
        ),
    );
	public $loginRules = [
				[
						'field'  => 'email',
						'label'  => 'Email',
						'rules'  => 'trim|required|valid_email',
				],
				[
						'field'  => 'password',
						'label'  => 'password',
						'rules'  => 'required',
				],
		];
		
	public $configChangePassword = array(
       
		array(
                'field' => 'password',
                'label' => 'password',
                'rules' => 'required|max_length[20]|min_length[8]',
                'errors' => array(
                        'required' => 'Enter Password',
                ),
        )
    );
	public $configChangePasswordAdmin = array(
       
		array(
				'field' => 'password',
				'label' => 'password',
				'rules' => 'required|max_length[20]|min_length[8]',
				'errors' => array(
						'required' => 'Enter Password',
				),
			),
			array(
					'field'  => 'confirm_password',
					'label'  => 'Confirm Password',
					'rules'  => 'required|matches[password]',
					'errors' => array(
						'required' => 'Enter Confirm Password',
						'matches'=>"Password and confirm password don't match"
					),
			),
    );

    public $config_forgot_password = array(

		    array(
                'field' => 'email',
                'label' => 'email id',
                'rules' => 'required|valid_email',
                'errors' => array(

                        'required' => 'Enter email id',
                ),
            ),
    ); 

     public $config_reset_password = array(

		    array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|max_length[20]|min_length[8]',
                
            ),
			array(
				'field'  => 'confirm_password',
				'label'  => 'Confirm Password',
				'rules'  => 'matches[password]',
				'errors' => array(
					'matches'=>"Password and confirm password don't match"
				),
		    ),
    );     
	public function checkMobileNumber($mobile_number){
		$LoginUser=array();
		$condition=array('mobile'=>$mobile_number);
        $this->db->select(array('mobile'));
        $this->db->from('users');
        $this->db->where($condition);
        $query = $this->db->get();
        if($query->count_all_results() > 0) {
           return true;
        }else{
			return false;
		}
	}
	public function checkMobileNumberOnEdit($mobile_number,$userLoginId){
        $LoginUser=array();
		$condition=array('mobile'=>$mobile_number);
	    $this->db->select(array('mobile'));
        $this->db->from('users');
        $this->db->where($condition);
        $this->db->where('id!=',$userLoginId);
        $query = $this->db->get();
       if($query->count_all_results() > 0) {
           return true;
        }else{
			false;
		}
	}
	public function checkEmailId($email){

		$LoginUser=array();
		$condition=array('email'=>$email);
        $this->db->select(array('email'));
        $this->db->from('users');
        $this->db->where($condition);
        $query = $this->db->get();
		$data=(array)$query->row();
		//pr($data);
        if($query->count_all_results() > 0) {

           return true;
		   
        }else{

			false;
		}
	}
	public function getUserDataByEmailId($email){
		$LoginUser=array();
		$condition=array('players_email'=>$email);
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where($condition);
        $query = $this->db->get();
		$data=(array)$query->row();
        return $data;
	}
    public function getUsersList($status,$postData)
    {        
        $this->get_users_list_query($status,$postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'],$postData['start']);
        }
        $query = $this->db->get();
        return $query->result_array();        
    }    
	public function getListNewUser() {
        $this->db->select('*');
		/*$condition=array();
		$this->db->where($condition);*/
		$this->db->from($this->table);
		$this->db->order_by("created", "desc");
		$this->db->limit(10,0);
        $query = $this->db->get();
		$data=$query->result_array();
		return $data;
    }
	public function getCountUser($status=null) {



        $this->db->select('id');
		$condition=array();
		if($status=='active'){
			$condition['status']=1;
		}else if($status=='inactive'){

			$condition['status']=0;
		}

		$this->db->where($condition);
		$this->db->from($this->table);
        $query = $this->db->get();
		return $query->count_all_results();
    }
	public function getUserDataById($id) {		
        $this->db->select('*');
        $this->db->from($this->table);
		$this->db->where(array('players_id'=>$id));
        $query = $this->db->get();
		$data=(array)$query->row();
		return $data;
    }
    public function getCountryName($id) {
        $this->db->select('name');
        $this->db->from('countries');
        $this->db->where(array('id'=>$id));
		$query = $this->db->get();
		$data=$query->row_array();
		return $data['name'];
    }
    public function getStateName($id) {
        $this->db->select('name');
        $this->db->from('states');
        $this->db->where(array('id'=>$id));
		$query = $this->db->get();
		$data=$query->row_array();
		return $data['name'];
    }
	public function deleteUser($id) {

		$this->db->where('players_id',$id);
        $query = $this->db->delete($this->table);
		if ($query) {
            return 1;
		} else {
			return 0;
		}

    }
	public function saveUser($data) { 
		$id=isset($data['players_id']) ? $data['players_id']:'';        
		if(!empty($id)){			
			$this->db->where('players_id', $id);
			$query = $this->db->update($this->table, $data);
			if ($query) {
               return $id;
			} else {
				return 0;
			}
		}else{			
			$query = $this->db->insert($this->table, $data);
			if ($query) {
               return $insert_id = $this->db->insert_id();
			} else {
				return 0;
			}
		}
    }
    public function getPassword($pass)
    {        
        $p = $this->db->query("SELECT PASSWORD(?) AS pass", array($pass))->row_array();
        return $p['pass'];
    }
	public function saveUserPassword($data) {
		$email=isset($data['players_email']) ? $data['players_email']:'';
		if(!empty($email)){			
			$this->db->where('players_email', $email);
			$query = $this->db->update($this->table, $data);
			if ($query) {
				return true;
			} else {
				return false;
			}
		}else{

			return false;
		}
    }	    
	public function updateUserpassword($data) {

		$password=isset($data['players_password']) ? $data['players_password']:'';

		if(!empty($password)){			
			$this->db->where('players_id', $data['players_id']);
			$query = $this->db->update($this->table, $data);
			if ($query) {
				return true;
			} else {
				return false;
			}
		}else{

			return false;
		}
    }	
    public function updateUser($data, $id){ 
        $update = $this->db->update($this->userTbl, $data, array('id' => $id)); 
        return $update?true:false; 
    } 
    public function updateUserWithWhere($data, $where){ 
        $update = $this->db->update($this->userTbl, $data, $where);
        return $update?true:false; 
    } 
    public function updateSubscription($data, $id){ 
        $update = $this->db->update($this->subscripTbl, $data, array('id' => $id)); 
        return $update?true:false; 
    } 
     
    /* 
     * Fetch order data from the database 
     * @param id returns a single record 
    */ 	
	public function countAll($status,$postData)
    {
        $this->get_users_list_query($status,$postData);
        return $this->db->count_all_results();
    }
    public function countFiltered($status,$postData)
    {
        $this->get_users_list_query($status,$postData);
        return $this->db->count_all_results();
    }
    public function get_users_list_query($status=null,$postData,$where=false)
    {
        $this->db->select('*');
		$condition=array();
		if($status=='active'){
			$condition['players_pending']=0;
            $this->db->where($condition);
		}else if($status=='inactive'){
			$condition['players_pending']=1;
            $this->db->where($condition);
		}else if($status == "superAdmins")
        {
            $condition['players_super_admin']=1;
            $this->db->where($condition);
        }

        $this->db->where('players_deleted',0);        
        if($where)
        {
            $this->db->where($where);
        }		
		$this->db->from($this->table);        
        $i = 0;
        // loop searchable columns 
        foreach($this->user_column_search as $item){
            // if datatable send POST for search
            if($postData['search']['value']){                
                if($i==0){                    
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                }else{
                    $this->db->or_like($item, $postData['search']['value']);
                }                
                // last loop
                if(count($this->user_column_search) - 1 == $i){                    
                    $this->db->group_end();
                }
            }
            $i++;
        }         
        if(isset($postData['order'])){
            $this->db->order_by($this->user_column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        }else if(isset($this->order)){
            $order = $this->order;
            $this->db->order_by(key($order),$order[key($order)]);
        }
    }    
}
?>
