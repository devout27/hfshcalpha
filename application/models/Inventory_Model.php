<?php
Class Inventory_Model extends MY_Model {
	public $table='inventory';
	public $playersTable='players';
	function __construct(){ 
        $this->inventoryTbl = 'inventories';
        // Set default order
        $this->column_search=['itemid','join_players_id','itemtype','itemrarity','itemname','itemdesc'];
        $this->column_order=['itemid','join_players_id','itemtype','itemrarity','itemname','itemdesc'];
        $this->order = ['itemid' => 'desc'];
    } 
	public $config_add = array(
        array(
            'field' => 'itemname',
            'label' => 'Name',
            'rules' => 'required|max_length[255]',
            'errors' => array('required' => 'Please Enter Item Name.'),
        ),
        array(
            'field' => 'itemtype',
            'label' => 'Item Type',
            'rules' => 'required|max_length[255]',
            'errors' => array('required' => 'Please Select Item Type'),
        ),
        array(
            'field' => 'itemrarity',
            'label' => 'Item Rarity',
            'rules' => 'required|max_length[255]',            
            'errors' => array('required' => 'Please Select Item Rarity'),
        ),
        array(
            'field' => 'itemimg',
            'label' => 'Item Image',
            'rules' => 'valid_url|max_length[2048]',            
        ),
        array(
            'field' => 'itemdesc',
            'label' => 'Item Description',
            'rules' => 'max_length[500]',            
        ),
        		
    );
	
	public $config_edit = array(
        array(
            'field' => 'itemname',
            'label' => 'Name',
            'rules' => 'required|max_length[255]',
            'errors' => array('required' => 'Please Enter Item Name.'),
        ),
        array(
            'field' => 'itemtype',
            'label' => 'Item Type',
            'rules' => 'required|max_length[255]',
            'errors' => array('required' => 'Please Select Item Type'),
        ),
        array(
            'field' => 'itemrarity',
            'label' => 'Item Rarity',
            'rules' => 'required|max_length[255]',            
            'errors' => array('required' => 'Please Select Item Rarity'),
        ),
        array(
            'field' => 'itemimg',
            'label' => 'Item Image',
            'rules' => 'valid_url|max_length[2048]',            
        ),
        array(
            'field' => 'itemdesc',
            'label' => 'Item Description',
            'rules' => 'max_length[500]',            
        ),
    );
	public function getInventoryDataById($itemid){		        
        $inventory = $this->db->query("SELECT s.* FROM inventory s WHERE itemid=?", array($itemid))->row_array();
        return $inventory;
	}    
    public function getInventorysList($player_id,$postData)
    {
        $this->get_inventories_list_query($player_id,$postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'],$postData['start']);
        }
        $query = $this->db->get();
        return $query->result_array();        
    }    	
	public function deleteInventory($id) {
		$this->db->where('itemid',$id);
        $query = $this->db->delete($this->table);
		if ($query) {
            return 1;
		} else {
			return 0;
		}
    }
	public function saveInventory($data) {         
		$id=!empty($data['itemid']) ? $data['itemid']:'';        
		if(!empty($id)){			
			$this->db->where('itemid', $id);
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
    public function updateInventory($data, $id){ 
        $update = $this->db->update($this->inventoryTbl, $data, array('id' => $id)); 
        return $update?true:false; 
    }     
    /* 
     * Fetch order data from the database 
     * @param id returns a single record 
    */ 	
	public function countAll($player_id,$postData)
    {
        $this->get_inventories_list_query($player_id,$postData);
        return $this->db->count_all_results();
    }
    public function countFiltered($player_id,$postData)
    {
        $this->get_inventories_list_query($player_id,$postData);
        return $this->db->count_all_results();
    }
    public function get_inventories_list_query($player_id=null,$postData,$where=false)
    {
        $this->db->select('inventory.*,players.players_email');
        $this->db->join('players','players.players_id=inventory.join_players_id','left');
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
