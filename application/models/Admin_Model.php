<?php

Class Admin_Model extends MY_Model {

	public $table='players';
	
    public $config_login = array(
		array(
			'field' => 'username',
			'label' => 'Username',
			'rules' => 'required',
			'errors' => array(
					'required' => 'Enter Username',
			),
		),
		array(
			'field' => 'password',
			'label' => 'Password',
			'rules' => 'required',
			'errors' => array(

					'required' => 'Enter Password',
			),
		)
    );
	public $config_forgot_password = array(
		array(
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'required|valid_email',			
		),		
    );
	public $config_change_password = array(

		    array(
                'field' => 'current_password',
                'label' => 'Current Password',
                'rules' => 'required|min_length[8]',
                'errors' => array(

                        'required' => 'Current password is required.',
                ),
            ),
			array(
                'field' => 'new_password',
                'label' => 'New Password',
                'rules' => 'required|min_length[8]',
                'errors' => array(

                        'required' => 'New password is required.',
                ),
            ),
			array(
                'field' => 'confirm_password',
                'label' => 'Confirm Password',
                'rules' => 'matches[new_password]',
                'errors' => array(

                        'matches' => 'Confirm password not matched with new password.',
                ),
            ),
    );

	public $config_reset_password = array(

		array(
                'field' => 'password',
                'label' => 'password',
                'rules' => 'required|min_length[8]|max_length[20]',
                'errors' => array(

                        'required' => 'Enter new password',
                ),
			),
			array(
				'field' => 'passconf',
                'label' => 're-password',
                'rules' => 'required|matches[password]',
                'errors' => array(

                        'required' => 'Enter re-password',
                ),
        )
    );

    public function checkAdminLogin($data){
 
 		$LoginUser=array();        
		$player = $this->db->query('SELECT * FROM players WHERE players_username = ? AND players_password = PASSWORD(?) AND players_super_admin = ?', array($data['username'], $data['password'],1))->row_array();		
        if ($player) {
           $LoginUser=$player;
        }
				
		return $LoginUser;
	}

	public function getAdminDataById($id) {

        $this->db->select('*');
        $this->db->from($this->table);
		$this->db->where(array('players_id'=>$id));
        $query = $this->db->get();
		$data=(array)$query->row();
		return $data;
    }
	public function getDataByEmailId($email) {

        $this->db->select('*');
        $this->db->from($this->table);
		$this->db->where(array('players_email'=>$email,'players_super_admin'=>1));
        $query = $this->db->get();
		
		$data=(array)$query->row();

		return $data;

    }

	public function saveAdmin($data) {				
		if($data['players_id'] != ""){			
			$id=$data['players_id'];
			$this->db->where('players_id', $id);
			$query = $this->db->update($this->table, $data);
			if ($query) {
               return true;
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
	public function getAdminDataByRole($role) {
        $this->db->select('*');
        $this->db->from($this->table);
		$this->db->where(array('role'=>$role));
        $query = $this->db->get();
		$data=(array)$query->row();
		return $data;
    }
}

?>
