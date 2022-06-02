<?php

Class Stable_Model extends MY_Model {

	public $table='stables';
	public $amenitiesTable='stables_x_amenities';
	function __construct(){ 
        $this->stableTbl = 'stables';
        // Set default order        
        $this->column_search=['stables_id','join_players_id','players_nickname','players_email'];
        $this->column_order=['stables_id','join_players_id','players_nickname','players_email'];
        $this->order = ['stables_id' => 'desc'];
    } 		
	public $admin_config_add = array(
        array(
            'field' => 'stables_name',
            'label' => 'Stable Name',
            'rules' => 'required|max_length[50]',
            'errors' => array('required' => 'Enter Stable Name',),
        ),
        array(
            'field' => 'stables_boarding_public',
            'label' => 'Boarding Public',
            'rules' => 'required|max_length[1]',
        ),
        array(
            'field' => 'stables_description',
            'label' => 'Stable Description',
            'rules' => 'max_length[10000]',
        ),
        array(
            'field' => 'stables_boarding_fee',
            'label' => 'Stable Barding Fee',
            'rules' => 'is_natural',
        ),
        array(
            'field' => 'join_players_id',
            'label' => 'Player',
            'rules' => 'required',
            'errors' => array('required' => 'Please Select Player'),
        ),
    );
	public $admin_config_edit = array(
        array(
            'field' => 'stables_name',
            'label' => 'Stable Name',
            'rules' => 'required|max_length[50]',
            'errors' => array('required' => 'Enter Stable Name',),
        ),
        array(
            'field' => 'stables_boarding_public',
            'label' => 'Boarding Public',
            'rules' => 'required|max_length[1]',
        ),
        array(
            'field' => 'stables_description',
            'label' => 'Stable Description',
            'rules' => 'max_length[10000]',
        ),
        array(
            'field' => 'stables_boarding_fee',
            'label' => 'Stable Barding Fee',
            'rules' => 'is_natural',
        ),
        array(
            'field' => 'join_players_id',
            'label' => 'Player',
            'rules' => 'required',
            'errors' => array('required' => 'Please Select Player'),
        ),
    );
	public function getStableDataById($stables_id){		        
        $stable = $this->db->query("SELECT s.* FROM stables s WHERE stables_id=?", array($stables_id))->row_array();
        if(count($stable) > 0)
        {
            $stable['amenities'] = $this->db->query("SELECT sxa.*, a.* FROM stables_x_amenities sxa LEFT JOIN amenities a ON a.amenities_id=sxa.join_amenities_id WHERE sxa.join_stables_id=?", $stable['stables_id'])->result_array();
            $land = $paddocks = $stalls = $buildings = $courses = $misc = $used_acres = 0;
            foreach((array)$stable['amenities'] AS $k => $a){
                if($a['amenities_type'] == "Land"){
                    $land += $a['amenities_acres'];
                }elseif($a['amenities_type'] == "Paddock"){
                    $paddocks += $a['amenities_acres'];
                    $used_acres += $a['amenities_acres'];
                }elseif($a['amenities_type'] == "Stall"){
                    $stalls += $a['amenities_stalls'];
                }elseif($a['amenities_type'] == "Building"){
                    $buildings++;
                    $used_acres += $a['amenities_acres'];
                }elseif($a['amenities_type'] == "Course"){
                    $courses++;
                    $used_acres += $a['amenities_acres'];
                }elseif($a['amenities_type'] == "Miscellaneous"){
                    $misc++;
                    $used_acres += $a['amenities_acres'];
                }
                $stable['land'] = $land;
                $stable['paddocks'] = $paddocks;
                $stable['stalls'] = $stalls;
                $stable['buildings'] = $buildings;
                $stable['courses'] = $courses;
                $stable['misc'] = $misc;
                $stable['used_acres'] = $used_acres;
            }
        }        
        return $stable;
	}
    public function getAmenitiesDataByStableId($stable_id){		
		$condition=array('join_stables_id'=>$stable_id);
        $this->db->select('*');
        $this->db->from($this->amenitiesTable);
        $this->db->where($condition);
        $query = $this->db->get();
		$data=(array)$query->result_array();
        return $data;
	}
    public function getStablesList($player_id,$postData)
    {
        $this->get_stables_list_query($player_id,$postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'],$postData['start']);
        }
        $query = $this->db->get();
        return $query->result_array();        
    }    	
	public function deleteStable($id) {
		$this->db->where('stables_id',$id);
        $query = $this->db->delete($this->table);
		if ($query) {
            return 1;
		} else {
			return 0;
		}
    }
	public function saveStable($data) {         
		$id=isset($data['stables_id']) ? $data['stables_id']:'';        
		if(!empty($id)){
			$this->db->where('stables_id', $id);
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
    public function updateStable($data, $id){ 
        $update = $this->db->update($this->stableTbl, $data, array('id' => $id)); 
        return $update?true:false; 
    }     
    /* 
     * Fetch order data from the database 
     * @param id returns a single record 
    */ 	
	public function countAll($player_id,$postData)
    {
        $this->get_stables_list_query($player_id,$postData);
        return $this->db->count_all_results();
    }
    public function countFiltered($player_id,$postData)
    {
        $this->get_stables_list_query($player_id,$postData);
        return $this->db->count_all_results();
    }
    public function get_stables_list_query($player_id=null,$postData,$where=false)
    {
        $this->db->select('stables.*');        
		$condition=array();
		if($player_id){
			$condition['join_players_id']=$player_id;
            $this->db->where($condition);
		}        
        if($where)
        {
            $this->db->where($where);
        }
		$this->db->from($this->table);
        $i = 0;
        // loop searchable columns
        foreach($this->column_search as $item){
            // if datatable send POST for search
            if($postData['search']['value']){
                if($i==0){
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                }else{
                    $this->db->or_like($item, $postData['search']['value']);
                }                
                // last loop
                if(count($this->column_search) - 1 == $i){                    
                    $this->db->group_end();
                }
            }
            $i++;
        }         
        if(isset($postData['order'])){
            $this->db->order_by($this->column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        }else if(isset($this->order)){
            $order = $this->order;
            $this->db->order_by(key($order),$order[key($order)]);
        }
    }    
}
?>
