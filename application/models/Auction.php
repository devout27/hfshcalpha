<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auction extends CI_Model {
	var $auction = null;

	function __construct($auction_id = null){
		parent::__construct();
		$CI =& get_instance();
		$CI->data['player_id'] = $this->session->userdata('players_id');
	}



	public static function get_auctions($data = null){
		$CI =& get_instance();
		$selects = $joins = $wheres = $params = array();
		if($data == null || !$data['auctions_winning_bidder']){
			$data['auctions_winning_bidder'] = 0;
		}

		/*
			SELECT a.*,  FROM auctions a
			LEFT JOIN horses h ON h.horses_id=a.join_horses_id
			LEFT JOIN players p ON p.players_id=h.join_players_id
			WHERE
			LIMIT 500
		*/

        $selects = array(
            'a.*',
            'h.*',
            'p.players_nickname',
            'h.join_players_id AS horse_owner'
        );

        $joins[] = 'LEFT JOIN horses h ON h.horses_id=a.join_horses_id';
        $joins[] = 'LEFT JOIN players p ON p.players_id=h.join_players_id';

		$wheres[] = 'h.horses_pending = 0';
		if(!$data['include_expired']){
			$wheres[] = 'a.auctions_end>=NOW()';
		}
		$wheres []= "a.auctions_winning_bidder=?";
		$params [] = $data['auctions_winning_bidder'];

		//---------- WHERES --------------
		if($data['auctions_start']){
			$wheres [] = "a.auctions_start>=?";
			$params [] = $data['auctions_start'];
		}
		if($data['auctions_end']){
			$wheres [] = "a.auctions_end<=?";
			$params [] = $data['auctions_end'];
		}
		if($data['type'] == "stallions"){
			$wheres []= "h.horses_gender=?";
			$params [] = "Stallion";
		}elseif($data['type'] == "geldings"){
			$wheres []= "h.horses_gender=?";
			$params [] = "Gelding";
		}elseif($data['type'] == "mares"){
			$wheres []= "h.horses_gender=?";
			$params [] = "Mare";
		}elseif($data['type'] == "foals"){
			$wheres []= "h.horses_birthyear<=NOW()-INTERVAL 2 YEAR";
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
		$auctions = $CI->db->query('
			SELECT '. implode(', ', $selects) .'
			FROM auctions AS a
			'. implode("\n", $joins) .'
			'. $wheres .'
			ORDER BY a.auctions_end ASC
		', $params)->result_array();
		//pre($CI->db->last_query());

		$auctions['stallions'] = 0;
		$auctions['mares'] = 0;
		$auctions['geldings'] = 0;
		$auctions['foals'] = 0;


		if(!$auctions[0]['auctions_id']){
			return $auctions;
		}

		//normalize data & grab bids
		foreach((array)$auctions AS $k => $v){
			$auctions[$k]['bids'] = $CI->db->query('
					SELECT * FROM auctions_bids WHERE join_auctions_id=? ORDER BY auctions_bids_amount DESC'
				, array($v['auctions_id']))->result_array();
			if($v['horses_birthyear'] > date(Y) - 3){
				$auctions['foals'] += 1;
			}
			if($v['horses_gender'] == 'Stallion'){
				$auctions['stallions'] += 1;
			}elseif($v['horses_gender'] == 'Mare'){
				$auctions['mares'] += 1;
			}elseif($v['horses_gender'] == 'Gelding'){
				$auctions['geldings'] += 1;
			}
		}

		//pre($auctions);exit;



		return $auctions;
	}



	public static function auction($player, $horse, $data){
		$CI =& get_instance();
		$CI->load->model('bank');
		$account = Bank::get_balance($data['join_bank_id']);

		if($data['min_bid'] < 100){
			$errors['min_bid'] = "Minimum bid must be at least $100.";
		}
		if($data['bid_increment'] < 10){
			$errors['bid_increment'] = "Bid increment must be at least $10.";
		}
		if($data['auction_ends'] < 2 || $data['auction_ends'] > 21){
			$errors['auction_ends'] = "Auction must end in 2 to 21 days.";
		}
		if($player['players_id'] != $horse['join_players_id']){
			$errors['min_bid'] = "You do not own this horse.";
		}
		if($account['join_players_id'] != $player['players_id']){
			$errors['join_bank_id'] = "Invalid bank account.";
		}

		if(count($errors) > 0){
			return array('errors' => $errors);
		}

		//create auction
		$CI->db->query("INSERT INTO auctions(join_horses_id, join_bank_id, auctions_start, auctions_end, auctions_increment, auctions_starting_bid) VALUES(?, ?, NOW(), NOW() + INTERVAL ? DAY, ?, ?)", array($horse['horses_id'], $data['join_bank_id'], $data['auction_ends'], $data['bid_increment'], $data['min_bid']));

		return array('errors' => $errors, 'notices' => $notices, 'horse_id' => $horse_id);

	}

	public static function bid($player, $data){
		$CI =& get_instance();
		$CI->load->model('bank');
		$account = Bank::get_balance($data['bank_id']);
		$auction = self::get($data['join_auctions_id'], 1);
		//pre($data);exit;

		//check if player has enough $ to bid
		if(!$auction['auctions_id']){
			$errors['auctions_bids_amount'] = "Invalid auction.";
		}
		if($account['bank_balance'] < $data['auctions_bids_amount']){
			$errors['auctions_bids_amount'] = "You cannot afford this bid.";
		}
		if($account['join_players_id'] != $player['players_id']){
			$errors['auctions_bids_amount'] = "Invalid bank account.";
		}
		if($auction['bids'][0]['auctions_bids_amount'] + $auction['auctions_increment'] > $data['auctions_bids_amount']){
			$errors['auctions_bids_amount'] = "Bid is too low.";
		}
		if($auction['auctions_starting_bid'] > $data['auctions_bids_amount']){
			$errors['auctions_bids_amount'] = "Bid is too low.";
		}
		//check if bidder owns horse.
		if($player['players_id'] == $auction['horse_owner']){
			$errors['auctions_bids_amount'] = "You cannot bid on your own horse.";
		}

		if(count($errors) > 0){
			return array('errors' => $errors);
		}


		//pre($data);exit;
		//place the bid
		$CI->db->query("INSERT INTO auctions_bids(join_auctions_id, join_players_id, join_bank_id, auctions_bids_amount, auctions_bids_date,join_players_name) VALUES(?, ?, ?, ?, NOW(), ?)", array($data['join_auctions_id'], $player['players_id'], $data['bank_id'], $data['auctions_bids_amount'],$player['players_nickname']));

		return array('errors' => $errors, 'notices' => $notices, 'auction_id' => $data['join_auctions_id']);
	}

	public static function get($auction_id, $active = NULL){
		$CI =& get_instance();
		if($active == 1){
			$auction = $CI->db->query("SELECT a.*, h.join_players_id AS horse_owner FROM auctions a LEFT JOIN horses h ON h.horses_id=a.join_horses_id WHERE a.auctions_id=? AND a.auctions_end>=NOW() LIMIT 1", array($auction_id))->row_array();
		}else{
			$auction = $CI->db->query("SELECT a.*, h.join_players_id AS horse_owner FROM auctions a LEFT JOIN horses h ON h.horses_id=a.join_horses_id FROM a.auctions WHERE a.auctions_id=? LIMIT 1", array($auction_id))->row_array();
		}
		$auction['bids'] = $CI->db->query('
					SELECT * FROM auctions_bids WHERE join_auctions_id=? ORDER BY auctions_bids_amount DESC'
				, array($auction_id))->result_array();
		return $auction;
	}



/*
	public static function has_appt($horse_id, $type = "Vet"){
		$CI =& get_instance();

		$appt = $CI->db->query("SELECT * FROM horse_appointments WHERE join_horses_id=? AND horse_appointments_type=? AND horse_appointments_completed='0000-00-00 00:00:00'", array($horse_id, $type))->num_rows();
		if($appt > 0){
			return true;
		}
		return false;
	}


	public static function admin_get_import(){
		$CI =& get_instance();
		$EXPORT_ID = EXPORT_ID;
		return $CI->db->query("
				SELECT ir.*, p.players_nickname, ir.join_players_id AS import_requests_players_id, h.*
				FROM import_requests ir
					LEFT JOIN horses h ON ir.join_horses_id=h.horses_id
					LEFT JOIN players p ON ir.join_players_id=p.players_id
				WHERE h.join_players_id=? ORDER BY h.horses_pending_export_date ASC", array($EXPORT_ID))->result_array();
	}


	public static function get_breeds(){
		$CI =& get_instance();
		$breeds = $CI->db->query("SELECT * FROM breeds ORDER BY breed_name ASC")->result_array();
		foreach($breeds AS $k => $v){
			$normalized[$v['breed_id']] = $v['breed_name'];
		}
		return $normalized;
	}
	*/

}