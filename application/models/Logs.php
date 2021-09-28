<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logs extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->column_search=['log_ip','log_activity','join_players_id'];
		$this->column_order=['log_ip','log_activity','join_players_id'];
		$this->order = ['log_id' => 'desc'];
	}

	function search($data = NULL){
		$selects = $joins = $wheres = $params = array();

        $selects = array(
            'l.*',
            'p.players_nickname',
            'DATE_FORMAT(log_date, "%M %D, %Y at %l:%i %p") AS log_date2',
        );

        $joins[] = 'LEFT JOIN players p ON p.players_id=l.join_players_id';

		//---------- WHERES --------------
		if($data['join_players_id']){
			$wheres [] = "l.join_players_id=?";
			$params [] = $data['join_players_id'];
		}
		if($data['log_ip']){
			$wheres [] = "l.log_ip LIKE ?";
			$params [] = '%' . $data['log_ip'] . '%';
		}
		if($data['log_activity']){
			$wheres [] = "l.log_activity LIKE ?";
			$params [] = '%' . $data['log_activity'] . '%';
		}

		if($data['start_date']){
			$wheres [] = "l.log_date>=?";
			$params [] = $data['start_date'];
		}
		if($data['end_date']){
			$wheres [] = "l.log_date<=?";
			$params [] = $data['end_date'];
		}


		//prevent sql injection or other tampering
		if(strtolower($data['by']) == "desc"){
			$data['by'] = "DESC";
		}else{
			$data['by'] = "ASC";
		}
		$orderby = $order . ' ' . $data['by'];

		if(count($wheres) > 0){
			$wheres = 'WHERE ' . implode(' AND ', $wheres);
		}else{
			$wheres = "";
		}


		//---------- ACTUAL QUERY --------------
		$players = $this->db->query('
			SELECT '. implode(', ', $selects) .'
			FROM log l
			'. implode("\n", $joins) .'
			'. $wheres .'
		', $params)->result_array();
		//pre($this->db->last_query());

        return $players;

	}

	public function form_fail($location, $value){
		/*
		$ip = self::get_ip();
		if($value){
			@mysql_query("INSERT INTO log_bots(log_bots_address, log_bots_datetime, log_bots_location, log_bots_value, join_players_id)
				VALUES ('$ip', NOW(), '$location', '$value', '". $_SESSION['player_id'] ."')");
			return true;
		}
		return false;*/
	}

	public function log_ip($player_id, $activity = "Login"){
		$ipaddress = self::get_ip();

		if($activity == "Login"){
			$query = $this->db->query("SELECT join_players_id FROM log WHERE join_players_id=? AND log_ip=? AND log_date>=NOW() - INTERVAL 1 HOUR", array($player_id, $ipaddress));
			$exists_recent = $query->num_rows();
		}

		if(!$exists_recent){ // create new ip record
			if(!$ipaddress){
				$ipaddress = "-";
			}
			$this->db->query('INSERT INTO log(join_players_id, log_date, log_ip, log_activity)
				VALUES (?, NOW(), ?, ?)', array($player_id, $ipaddress, $activity));
		}
	}

	public function get_ip(){
        if ($_SERVER['HTTP_CLIENT_IP'])
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if($_SERVER['HTTP_X_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if($_SERVER['HTTP_X_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if($_SERVER['HTTP_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if($_SERVER['HTTP_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if($_SERVER['REMOTE_ADDR'])
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        return $ipaddress;
	}

	/* datatable related functions */
		public function getMyLogsList($player_id,$postData)
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
			$this->db->select( 'log.*,p.players_nickname,DATE_FORMAT(log_date, "%M %D, %Y at %l:%i %p") AS log_date2');			
			$this->db->join('players p','p.players_id=log.join_players_id','LEFT');
			$this->db->from('log');
			if(is_numeric($player_id))
			{							
				$this->db->where('log.join_players_id',$player_id);
			}			
			if($where)
			{
				$this->db->where($where);
			}
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
}
