<?php

Class StablePackage_Model extends MY_Model {

	public $table='stables_packages';
	function __construct(){ 
        $this->packageTbl = 'stables_packages';        
        $this->column_search=['stables_packages_id','stables_packages_name','stables_packages_cost','stables_packages_cost_usd','stables_packages_available','stables_packages_created'];
        $this->column_order=['stables_packages_id','stables_packages_name','stables_packages_cost','stables_packages_cost_usd','stables_packages_available','stables_packages_created'];        
        $this->order = ['stables_packages_id' => 'desc'];
    }    
	public $config_add = array(
        array(
                'field' => 'stables_packages_name',
                'label' => 'Package Name',
                'rules' => 'required|max_length[50]|min_length[4]',                
        ),
        array(
                'field' => 'stables_packages_description',
                'label' => 'Package Description',
                'rules' => 'max_length[1000]',                
        ),
        array(
                'field' => 'stables_packages_cost',
                'label' => 'Package Cost',
                'rules' => 'required|numeric|xss_clean|greater_than_equal_to[0]',                
        ),
        array(
                'field' => 'stables_packages_cost_usd',
                'label' => 'PayPal Cost',
                'rules' => 'required|numeric|xss_clean|greater_than_equal_to[0]',                
        ),
        array(
            'field' => 'stables_packages_available',
            'label' => 'Packages Available for Purchase',
            'rules' => 'required|numeric|xss_clean|greater_than_equal_to[0]',
        ),		
    );
	
	public $config_edit = array(
        array(
                'field' => 'stables_packages_name',
                'label' => 'Package Name',
                'rules' => 'required|max_length[50]|min_length[4]',
        ),
        array(
                'field' => 'stables_packages_description',
                'label' => 'Package Description',
                'rules' => 'max_length[1000]',                
        ),
        array(
                'field' => 'stables_packages_cost',
                'label' => 'Package Cost',
                'rules' => 'required|numeric|xss_clean|greater_than_equal_to[0]',                
        ),
        array(
                'field' => 'stables_packages_cost',
                'label' => 'PayPal Cost',
                'rules' => 'required|numeric|xss_clean|greater_than_equal_to[0]',                
        ),
        array(
            'field' => 'stables_packages_available',
            'label' => 'Packages Available for Purchase',
            'rules' => 'required|numeric|xss_clean|greater_than_equal_to[0]',
        ),
    );
	public function getPackageDataById($stables_packages_id){		        
        $package = $this->db->query("SELECT * from $this->table WHERE stables_packages_id=?", array($stables_packages_id))->row_array();        
        return $package;
	}    
    public function getPackagesList($player_id,$postData)
    {
        $this->get_stables_packages_list_query($player_id,$postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'],$postData['start']);
        }
        $query = $this->db->get();
        return $query->result_array();        
    }    	
	public function deletePackage($id) {
        $query = $this->db->query("DELETE FROM stables_packages_x_amenities WHERE join_stables_packages_id=?",array($id));
		$this->db->query("DELETE FROM stables_packages WHERE stables_packages_id = ?",array($id));
		if($query) {
            return 1;
		} else {
			return 0;
		}
    }
	public function savePackage($data,$amenitiesData) {
		$id=isset($data['stables_packages_id']) ? $data['stables_packages_id']:'';
        $amenities = [];
		if(!empty($id)){
			$this->db->where('stables_packages_id', $id);            
			$query = $this->db->update($this->table, $data);
			if ($query) {
                foreach($amenitiesData as $k=>$v):
                    $this->load->model('Amenity_Model');
                    if($this->Amenity_Model->getPackageAmenityByID($data['stables_packages_id'],$k))
                    {
                        $this->db->where('join_stables_packages_id',$data['stables_packages_id'])->where('join_amenities_id',$k)->update('stables_packages_x_amenities',['stables_packages_x_amenities_quantity'=>(int)$v]);
                    }else
                    {
                        array_push($amenities,['join_stables_packages_id'=>$data['stables_packages_id'],'join_amenities_id'=>$k,'stables_packages_x_amenities_quantity'=>(int)$v]);
                    }                    
                endforeach;
                if(count($amenities) > 0)
                {
                    $this->db->insert_batch('stables_packages_x_amenities',$amenities);
                }
               return $id;
			} else {
				return false;
			}
		}else{			
			$query = $this->db->insert($this->table, $data);
			if ($query) {
                $insert_id = $this->db->insert_id();
                foreach($amenitiesData as $k=>$v):                    
                    array_push($amenities,['join_stables_packages_id'=>$insert_id,'join_amenities_id'=>$k,'stables_packages_x_amenities_quantity'=>(int)$v]);
                endforeach;                
                if(count($amenities) > 0)
                {
                    $this->db->insert_batch('stables_packages_x_amenities',$amenities);
                }
                return $insert_id;
			} else {
				return 0;
			}
		}
    }
    public function updatePackage($data, $id){ 
        $update = $this->db->update($this->packageTbl, $data, array('id' => $id)); 
        return $update?true:false; 
    }     
    /* 
     * Fetch order data from the database 
     * @param id returns a single record 
    */ 	
	public function countAll($stable_id,$postData)
    {
        $this->get_stables_packages_list_query($stable_id,$postData);
        return $this->db->count_all_results();
    }
    public function countFiltered($stable_id,$postData)
    {
        $this->get_stables_packages_list_query($stable_id,$postData);
        return $this->db->count_all_results();
    }
    public function get_stables_packages_list_query($stable_id=null,$postData,$where=false)
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
