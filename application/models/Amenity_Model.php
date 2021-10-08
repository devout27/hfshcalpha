<?php

Class Amenity_Model extends MY_Model {

	public $table='amenities';
	function __construct(){ 
        $this->amenityTbl = 'amenities';
        // Set default order        
        $this->column_search=['amenities_id','amenities_name','amenities_cost','amenities_type','amenities_stalls','amenities_acres','ameneties_created'];
        $this->column_order=['amenities_id','amenities_name','amenities_cost','amenities_type','amenities_stalls','amenities_acres','ameneties_created'];        
        $this->order = ['amenities_id' => 'desc'];
    }    
        
    


	public $config_add = array(
        array(
                'field' => 'amenities_name',
                'label' => 'Amenity Name',
                'rules' => 'required|max_length[50]|min_length[4]',                
        ),
        array(
                'field' => 'amenities_description',
                'label' => 'Amenity Description',
                'rules' => 'max_length[1000]',                
        ),
        array(
                'field' => 'amenities_cost',
                'label' => 'Amenity Cost',
                'rules' => 'required|numeric|xss_clean|greater_than[0]',                
        ),
        array(
            'field' => 'amenities_limit',
            'label' => 'Amenity Limit',
            'rules' => 'numeric|xss_clean',
        ),
		array(
            'field' => 'amenities_type',
            'label' => 'Amenity Type',
            'rules' => "required",            
        ),
    );
	
	public $config_edit = array(
        array(
            'field' => 'amenities_name',
            'label' => 'Amenity Name',
            'rules' => 'required|max_length[50]|min_length[4]',                
        ),
        array(
                'field' => 'amenities_description',
                'label' => 'Amenity Description',
                'rules' => 'max_length[500]',                
        ),
        array(
                'field' => 'amenities_cost',
                'label' => 'Amenity Cost',
                'rules' => 'required|numeric|xss_clean|greater_than[0]',                
        ),
        array(
                'field' => 'amenities_limit',
                'label' => 'Amenity Limit',
                'rules' => 'numeric|xss_clean',
        ),
        array(
            'field' => 'amenities_type',
            'label' => 'Amenity Type',
            'rules' => "required",            
        ),
    );
	public function getAmenityDataById($amenities_id){		        
        $amenity = $this->db->query("SELECT * from $this->table WHERE amenities_id=?", array($amenities_id))->row_array();        
        return $amenity;
	}
    public function getPackageAmenityQty($id,$join_amenities_id)
    {
        $d = $this->db->where('join_stables_packages_id',$id)->where('join_amenities_id',$join_amenities_id)->get('stables_packages_x_amenities')->row_array();        
        return isset($d['stables_packages_x_amenities_quantity']) ? $d['stables_packages_x_amenities_quantity'] : 0;
    }    
    public function getPackageAmenityByID($join_stables_packages_id,$join_amenities_id)
    {
        $d = $this->db->where('join_stables_packages_id',$join_stables_packages_id)->where('join_amenities_id',$join_amenities_id)->get('stables_packages_x_amenities')->row_array();        
        return isset($d['join_stables_packages_id']) ? $d : false;
    }    
    public function getAmenitiesList($player_id,$postData)
    {
        $this->get_amenities_list_query($player_id,$postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'],$postData['start']);
        }
        $query = $this->db->get();
        return $query->result_array();
    }    	
	public function deleteAmenity($id) {
        $query = $this->db->query("DELETE FROM stables_x_amenities WHERE join_amenities_id=?", array($id));		
		$this->db->query("DELETE FROM stables_packages_x_amenities WHERE join_amenities_id=?", array($id));
		$this->db->query("DELETE FROM amenities WHERE amenities_id=?", array($id));
		if($query) {
            return 1;
		} else {
			return 0;
		}
    }
	public function saveAmenity($data) {         
		$id=isset($data['amenities_id']) ? $data['amenities_id']:'';
		if(!empty($id)){
			$this->db->where('amenities_id', $id);
			$query = $this->db->update($this->table, $data);
			if ($query) {
               return $id;
			} else {
				return false;
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
    public function updateAmenity($data, $id){ 
        $update = $this->db->update($this->amenityTbl, $data, array('id' => $id)); 
        return $update?true:false; 
    }     
    /* 
     * Fetch order data from the database 
     * @param id returns a single record 
    */ 	
	public function countAll($stable_id,$postData)
    {
        $this->get_amenities_list_query($stable_id,$postData);
        return $this->db->count_all_results();
    }
    public function countFiltered($stable_id,$postData)
    {
        $this->get_amenities_list_query($stable_id,$postData);
        return $this->db->count_all_results();
    }    
    public function get_amenities_list_query($stable_id=null,$postData,$where=false)
    {
        $this->db->select('*');        
		$condition=array();
		if($stable_id){
			$condition['join_players_id']=$stable_id;
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
