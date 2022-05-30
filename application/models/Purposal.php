<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Purposal extends CI_Model {	
	function __construct(){
		parent::__construct();
		$CI =& get_instance();		
		$this->column_search=['id','join_players_id','join_players_username','join_horses_name','join_horse_id','title','email','description','created','price'];
		$this->column_order=['id','join_players_id','join_players_username','join_horses_name','join_horse_id','title','email','description','created','price'];
		$this->order = ['id' => 'desc'];
	}
	/* datatable related functions */
		public function getMyPurposalsList($player_id,$postData)
		{
			$this->get_list_query($player_id,$postData);
			if($postData['length'] != -1){
			  $this->db->limit($postData['length'],$postData['start']);
			}
			$query = $this->db->get();
			return $query->result_array();	
		}
		public function countAll($player_id,$postData)
		{
			$this->get_list_query($player_id,$postData);
			return $this->db->count_all_results();
		}
		public function countFiltered($player_id,$postData)
		{			
			$this->get_list_query($player_id,$postData);
			return $this->db->count_all_results();      
		}
		public function get_list_query($player_id,$postData,$where=false)
		{																
			$this->db->from('horses_sale_purposals');			
			if($where)
			{
				$this->db->where($where);
			}
			$this->db->where('join_horse_owner_id',$player_id);
			$i = $_POST['start'];
			foreach($this->column_search as $item){
				if($postData['search']['value']){                
					if($i==0){                    
						$this->db->group_start();
						$this->db->like($item, $postData['search']['value']);
					}else{
						$this->db->or_like($item, $postData['search']['value']);
					}
					if(count($this->column_search) - 1 == $i){
						$this->db->group_end();
					}
				}
				$i++;
			}         
			if(isset($postData['order'])){
				$this->db->order_by($this->column_order[$postData['order']['0']['column']],$postData['order']['0']['dir']);
			}else if(isset($this->order)){
				$order = $this->order;
				$this->db->order_by(key($order),$order[key($order)]);
			}
		}
	/* datatable  related functions end*/
	public function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	function validate_mobile($mobile)
	{
		return preg_match('/^[0-9]{10}+$/', $mobile);
	}
	public function SavePurposal($player, $horse,$data)
	{		
		$CI =& get_instance();
		$allowed_fields = array('join_players_id','join_horse_id','join_horse_owner_id','join_horses_name','join_players_username','title','email','price','description',);
		$update_data = filter_keys($data, $allowed_fields);		
		$CI->db->insert('horses_sale_purposals', $update_data);
		$horse_id = $CI->db->insert_id();
		$CI->db->query("INSERT INTO notices(join_players_id, notices_body) VALUES(?, ?);", array($data['join_horse_owner_id'],"You have received request "));
		return array('errors' => $errors, 'notices' => [], 'horse_id' => $horse_id);		
	}
	public function checkPurposalAlreadySent($horse_id,$owner_id,$player_id)
	{		
		$this->db->from('horses_sale_purposals');
		$this->db->where('join_players_id',$player_id);
		$this->db->where('join_horse_owner_id',$owner_id);
		$query = $this->db->where('join_horse_id',$horse_id)->get();
		return $query->row();
	}
	public function getPurposal($purposal_id)
	{
		$this->db->from('horses_sale_purposals');
		$this->db->where('id',$purposal_id);
		$query = $this->db->get();
		return $query->row();
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete('horses_sale_purposals');
	}
}
