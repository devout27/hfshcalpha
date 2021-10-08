<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Player extends CI_Model {
	var $player = null;

	function __construct($player_id = null){
		parent::__construct();
		if($player_id){
			$this->player = $this->db->query('
				SELECT
				*,
					DATE_FORMAT(players_last_active, "%M %D, %Y at %l:%i %p") AS players_last_active2,
					DATE_FORMAT(players_join_date, "%M %D, %Y") AS players_join_date2
				FROM players
				WHERE players_id = ? LIMIT 1
			', array($player_id))->row_array();

			if($this->player['players_admin']){
				$this->load->model('privileges');
				$this->player['privileges'] = $this->privileges->get($player_id);
			}
			$this->player['default_bank'] = $this->db->query("SELECT bank_id FROM bank WHERE join_players_id=? AND bank_default=1", array($player_id))->row()->bank_id;
		}
	}

	function get_online($qty = 1, $interval = "HOUR"){
		if(!in_array($interval, array("MINUTE", "HOUR", "DAY", "WEEK", "MONTH", "YEAR"))){
			$interval = "HOUR";
		}		
		return $this->db->query('SELECT players_nickname, DATE_FORMAT(players_last_active, "%M %D, %Y at %l:%i %p") AS players_last_active2, players_id FROM players WHERE players_last_active > NOW() - INTERVAL ' . $qty . " " . $interval . ' ORDER BY players_last_active DESC')->result_array();
	}

	function get_online_count(){
		return count(self::get_online());
	}

	function touch(){
		$this->db->query("UPDATE players SET players_last_active=NOW() WHERE players_id=? LIMIT 1", array($this->player['players_id']));
	}


	function get_questions($id){
		return $this->db->query('
					SELECT *
					FROM players_x_questions pxsq
						LEFT JOIN questions sq ON (sq.questions_id=pxsq.join_questions_id)
					WHERE pxsq.join_players_id = ?
					ORDER BY pxsq.players_x_questions_id ASC
				', array($id))->result_array();
	}

	function get_unread(){
		$unread = $this->db->query("SELECT messages_id FROM messages WHERE messages_to=? AND messages_read=0 AND join_messages_id=0", array($this->player_id))->num_rows();
		$unread += $this->db->query("SELECT messages_id FROM messages WHERE messages_to=? AND messages_read=0 AND join_messages_id!=0 GROUP BY join_messages_id", array($this->player_id))->num_rows();
		$unread += $this->db->query('SELECT notices_id FROM notices WHERE join_players_id = ? AND notices_read = 0', array($this->player['players_id']))->num_rows();
		return $unread;
	}

	function admin_get_pending(){
		$players = $this->db->query('SELECT *, DATE_FORMAT(players_join_date, "%M %D, %Y") AS players_join_date2 FROM players WHERE players_pending = 1 ORDER BY players_id ASC')->result_array();
		foreach((array)$players AS $k => $v){
			$players[$k]['questions'] = $this->get_questions($v['players_id']);

		}
		return $players;
	}

	function admin_get_pending_delete(){
		$players = $this->db->query('SELECT players_id, players_nickname, players_pending_delete_reason, DATE_FORMAT(players_pending_delete_date, "%M %D, %Y") AS players_pending_delete_date2,

				CASE
				WHEN  players_pending_delete_date >= NOW() - INTERVAL 7 DAY THEN "0"
				ELSE  "1"
				END as players_pending_delete_ready
		 FROM players WHERE players_pending_delete = 1 ORDER BY players_pending_delete_date ASC')->result_array();
		return $players;
	}



	function get_farriers(){
		$players = $this->db->query('
				SELECT p.*,
					DATE_FORMAT(p.players_last_active, "%M %D, %Y at %l:%i %p") AS players_last_active2
				FROM players p
				WHERE p.players_farrier>0
				ORDER BY p.players_id ASC
			')->result_array();

		return $players;
	}

	function add_farrier($data){
		$exists = $this->db->query("
				SELECT players_id, players_farrier
				FROM players
				WHERE players_id=? AND players_pending=0 AND players_deleted = 0 LIMIT 1
			", array($data['players_id']))->row_array();
		if(!count($exists)){
			$errors['players_id'] = "Invalid Player ID.";
		}
		if($exists['players_farrier']){
			$errors['players_id'] = "That player is already a Farrier.";
		}

		if(count($errors) > 0){
			return array('errors' => $errors);
		}

		$this->db->query("UPDATE players SET players_farrier=1 WHERE players_id=?", array($data['players_id']));
		$message = "You are now a Farrier.";

		//create notice to remind user
		$this->db->query("INSERT INTO notices(join_players_id, notices_body) VALUES(?, ?)", array($data['players_id'], $message));

		return array('errors' => $errors, 'notice' => $notice);
	}

	function delete_farrier($id){
		$this->db->query("UPDATE players SET players_farrier=0 WHERE players_id=?", array($id));

		$message = "You are no longer a Farrier.";

		//create notice to remind user
		$this->db->query("INSERT INTO notices(join_players_id, notices_body) VALUES(?, ?)", array($id, $message));

		return array('errors' => $errors, 'notice' => $notice);
	}


	function get_vets(){
		$players = $this->db->query('
				SELECT p.*,
					DATE_FORMAT(p.players_last_active, "%M %D, %Y at %l:%i %p") AS players_last_active2
				FROM players p
				WHERE p.players_vet>0
				ORDER BY p.players_id ASC
			')->result_array();

		return $players;
	}

	function add_vet($data){
		$exists = $this->db->query("
				SELECT players_id, players_vet
				FROM players
				WHERE players_id=? AND players_pending=0 AND players_deleted = 0 LIMIT 1
			", array($data['players_id']))->row_array();
		if(!count($exists)){
			$errors['players_id'] = "Invalid Player ID.";
		}
		if($exists['players_vet']){
			$errors['players_id'] = "That player is already a Vet.";
		}

		if(count($errors) > 0){
			return array('errors' => $errors);
		}

		$this->db->query("UPDATE players SET players_vet=1 WHERE players_id=?", array($data['players_id']));
		$message = "You are now a Veterinarian.";

		//create notice to remind user
		$this->db->query("INSERT INTO notices(join_players_id, notices_body) VALUES(?, ?)", array($data['players_id'], $message));

		return array('errors' => $errors, 'notice' => $notice);
	}

	function delete_vet($id){
		$this->db->query("UPDATE players SET players_vet=0 WHERE players_id=?", array($id));

		$message = "You are no longer a Vet.";

		//create notice to remind user
		$this->db->query("INSERT INTO notices(join_players_id, notices_body) VALUES(?, ?)", array($id, $message));

		return array('errors' => $errors, 'notice' => $notice);
	}


	function get_admins(){
		$players = $this->db->query('
				SELECT p.*, pr.*,
					DATE_FORMAT(p.players_last_active, "%M %D, %Y at %l:%i %p") AS players_last_active2
				FROM players p
					LEFT JOIN privileges pr ON pr.join_players_id=p.players_id
				WHERE p.players_admin>0
				ORDER BY p.players_id ASC
			')->result_array();

		return $players;
	}

	function add_admin($data){
		$exists = $this->db->query("
				SELECT players_id
				FROM players
				WHERE players_id=? AND players_pending=0 AND players_admin=0 AND players_deleted = 0 LIMIT 1
			", array($data['players_id']))->row_array();
		if(!count($exists)){
			$errors['players_id'] = "Invalid Player ID.";
		}


		$data_insert['join_players_id'] = $data['players_id'];
		$data_insert['privileges_admin'] = $data['privileges_admin'] ?: '0';
		$data_insert['privileges_news'] = $data['privileges_news'] ?: '0';
		$data_insert['privileges_members'] = $data['privileges_members'] ?: '0';
		$data_insert['privileges_horses'] = $data['privileges_horses'] ?: '0';
		$data_insert['privileges_adoption'] = $data['privileges_adoption'] ?: '0';
		$data_insert['privileges_bank'] = $data['privileges_bank'] ?: '0';
		$data_insert['privileges_cabs'] = $data['privileges_cabs'] ?: '0';
		$data_insert['privileges_articles'] = $data['privileges_articles'] ?: '0';

		if(count($errors) > 0){
			return array('errors' => $errors);
		}


		$this->db->insert('privileges', $data_insert);
		$this->db->query("UPDATE players SET players_admin=1 WHERE players_id=?", array($data_insert['join_players_id']));

		$message = "You are now an Administrator.";

		//create notice to remind user
		$this->db->query("INSERT INTO notices(join_players_id, notices_body) VALUES(?, ?)", array($data_insert['join_players_id'], $message));

		return array('errors' => $errors, 'notice' => $notice);
	}

	function edit_admin($id, $data){
		$exists = $this->db->query("
				SELECT players_id
				FROM players
				WHERE players_id=? AND players_admin=1 LIMIT 1
			", array($id))->row_array();
		if(!count($exists)){
			$errors['players_id'] = "Invalid Player ID.";
		}

		$data_insert['join_players_id'] = $id;
		$data_insert['privileges_admin'] = $data['privileges_admin'] ?: '0';
		$data_insert['privileges_news'] = $data['privileges_news'] ?: '0';
		$data_insert['privileges_members'] = $data['privileges_members'] ?: '0';
		$data_insert['privileges_horses'] = $data['privileges_horses'] ?: '0';
		$data_insert['privileges_adoption'] = $data['privileges_adoption'] ?: '0';
		$data_insert['privileges_bank'] = $data['privileges_bank'] ?: '0';
		$data_insert['privileges_cabs'] = $data['privileges_cabs'] ?: '0';
		$data_insert['privileges_articles'] = $data['privileges_articles'] ?: '0';

		if(count($errors) > 0){
			return array('errors' => $errors);
		}

		$this->db->query("DELETE FROM privileges WHERE join_players_id=?", array($id));
		$this->db->insert('privileges', $data_insert);

		$message = "Your administrator status has changed.";

		//create notice to remind user
		$this->db->query("INSERT INTO notices(join_players_id, notices_body) VALUES(?, ?)", array($data_insert['join_players_id'], $message));

		return array('errors' => $errors, 'notice' => $notice);
	}

	function delete_admin($id){
		$data_insert['join_players_id'] = $id;

		$this->db->query("DELETE FROM privileges WHERE join_players_id=?", array($id));
		$this->db->query("UPDATE players SET players_admin=0 WHERE players_id=?", array($id));

		$message = "You are no longer an administrator.";

		//create notice to remind user
		$this->db->query("INSERT INTO notices(join_players_id, notices_body) VALUES(?, ?)", array($data_insert['join_players_id'], $message));

		return array('errors' => $errors, 'notice' => $notice);
	}

	function accept_member($data){
		$player = new Player($data['players_id']);
		$player = $player->player;
		if(!$player['players_pending']){
			return array('errors' => array('players_pending' => "Invalid player application."));
		}

		$data2['join_players_id'] = $player['players_id'];
		$data2['bank_type'] = 'Checking';
		$data2['bank_balance'] = '100000';
		$data2['bank_pending'] = '0';
		$data2['bank_nickname'] = 'Default Checking';

		$this->db->query("UPDATE players SET players_pending=0 WHERE players_id=? LIMIT 1", array($player['players_id']));
		$this->db->query("INSERT INTO bank(join_players_id, bank_type, bank_balance, bank_pending, bank_nickname) VALUES (?, ?, ?, ?, ?)", $data2);

		if($data['send_email_checkbox']){
			// send an email
			$sn = SITE_NAME;
			$subject = "Application Accepted";
			$body = "Congratulations, " . $player['players_nickname'] . "! Your application to join $sn has been accepted. You may now login with the username and password you joined with.<br><br>" . $data['body'] . "<br><br>Sincerely,<br>$sn Team";
			$this->send_email($player['players_nickname'], $player['players_email'], $subject, $body);
		}


		return array('notice' => 'Application accepted.');
	}


	function reject_member($data){
		$player = new Player($data['players_id']);
		$player = $player->player;
		if(!$player['players_pending']){
			return array('errors' => array('players_pending' => "Invalid player application."));
		}

		$this->db->query("DELETE FROM players WHERE players_id=? LIMIT 1", array($player['players_id']));

		if($data['send_email_checkbox']){
			// send an email
			$sn = SITE_NAME;
			$subject = "Application Rejected";
			$body = $player['players_nickname'] . ", your application to join $sn has been rejected.<br><br>" . $data['body'] . "<br><br>Sincerely,<br>$sn Team";
			$this->send_email($player['players_nickname'], $player['players_email'], $subject, $body);
		}
		return array('notice' => 'Application rejected.');
	}





	public static function admin_remove($data){
		$CI =& get_instance();
		//this function removes a player from the game. Horses are sent to the HS. Bank accounts are closed. Player is marked as deleted.
		$horses = self::get_owned_horses($data['players_id']);
		foreach((array)$horses AS $k => $v){
			//insert owner log
			$CI->db->query('INSERT INTO horse_records(join_horses_id, join_players_id, horse_records_type) VALUES(?, ?, "Owner")', array($v['horses_id'], HUMANE_ID));
		}


		$CI->db->query("UPDATE horses SET horses_sale=0, join_stables_id=?, join_players_id=? WHERE join_players_id=?", array(HUMANE_ID, HUMANE_ID, $data['players_id']));
		$CI->db->query("UPDATE bank SET bank_closed=1 WHERE join_players_id=?", array($data['players_id']));
		$CI->db->query("UPDATE players SET players_deleted=1 WHERE players_id=? LIMIT 1", array($data['players_id']));

		return true;
	}


	public static function admin_update_credits($data){
		$CI =& get_instance();
		$CI->db->query("UPDATE players SET per_day_credits = ?, players_credits_adoptathon=?, players_credits_creation=? WHERE players_id=? LIMIT 1", array($data['per_day_credits'], $data['players_credits_adoptathon'], $data['players_credits_creation'], $data['players_id']));
		return  true;
	}

	public static function admin_adoptathon($data){
		$CI =& get_instance();
		if($data['credits'] < 1){
			//prevent accidental removal of credits
			$data['credits'] = 0;
		}elseif($data['credits'] > 100){
			$data['credits'] = 100;
		}
		$CI->db->query("UPDATE players SET players_credits_adoptathon=?", array($data['credits']));
		return  true;
	}

	function admin_update_profile($data){		
		if($this->input->post('update_profile')){
			//update the player's profile

			$this->form_validation->set_rules(array(
				array(
					'field' => 'players_nickname',
					'label' => 'Nickname',
					'rules' => 'required|strip_tags|min_length[3]|max_length[25]'
				),
				array(
					'field' => 'players_banner',
					'label' => 'Banner',
					'rules' => 'valid_url'
				),
				array(
					'field' => 'players_about',
					'label' => 'About',
					'rules' => 'xss_clean|max_length[6000]'
				),
				array(
					'field' => 'players_house',
					'label' => 'House',
					'rules' => 'xss_clean|callback_house_validate'
					)
			));


			if ($this->form_validation->run() !== false) {
				$data = $this->input->post();

				$allowed_fields = array(
					'players_nickname',
					'players_banner',
					'players_about',
					'players_house',
				);
				$update_data = filter_keys($data, $allowed_fields);
				$this->db->where('players_id', $data['players_id']);
				$this->db->update('players', $update_data);

			}

			foreach($_POST AS $v => $e){
				$e = form_error($v);
				if($e){
					$errors[$v] = $e;
				}
			}
			return array('errors' => $errors, 'notices' => $notices);

		}
	}
	function admin_update_role($data){		
		if($this->input->post('update_role')){
			//update the player's profile

			$this->form_validation->set_rules(array(
				array(
					'field' => 'players_super_admin',
					'label' => 'Player Role',
					'rules' => 'required|in_list[0,1]'
				)				
			));
			if ($this->form_validation->run() !== false) {
				$data = $this->input->post();
				$allowed_fields = array('players_super_admin');
				$update_data = filter_keys($data, $allowed_fields);
				$this->db->where('players_id', $data['players_id']);
				$this->db->update('players', $update_data);
			}
			foreach($_POST AS $v => $e){
				$e = form_error($v);
				if($e){
					$errors[$v] = $e;
				}
			}
			return array('errors' => $errors, 'notices' => $notices);
		}
	}


	public static function get_cabs($player_id){
		$CI =& get_instance();

		return $CI->db->query("SELECT * FROM cabs WHERE join_players_id=? AND cabs_disabled=0", array($player_id))->result_array();
	}

	public static function get_stables($player_id){
		$CI =& get_instance();
		$stables = $CI->db->query("SELECT * FROM stables WHERE join_players_id=?", array($player_id))->result_array();
		foreach((array)$stables AS $i => $s){
			$stables[$i]['amenities'] = $CI->db->query("SELECT sxa.*, a.* FROM stables_x_amenities sxa LEFT JOIN amenities a ON a.amenities_id=sxa.join_amenities_id WHERE sxa.join_stables_id=?", $s['stables_id'])->result_array();
			$land = $paddocks = $stalls = $buildings = $courses = $misc = $used_acres = 0;

			foreach((array)$stables[$i]['amenities'] AS $k => $a){
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
			}
			$stables[$i]['land'] = $land;
			$stables[$i]['paddocks'] = $paddocks;
			$stables[$i]['stalls'] = $stalls;
			$stables[$i]['buildings'] = $buildings;
			$stables[$i]['courses'] = $courses;
			$stables[$i]['misc'] = $misc;
		}
		return $stables;
	}

	public static function get_events($player_id, $data = NULL){
		$CI =& get_instance();

		if($data['only_recent']){
			$events = $CI->db->query("SELECT e.*, c.cabs_name FROM events e LEFT OUTER JOIN cabs c ON c.cabs_id=e.join_cabs_id WHERE e.join_players_id=? AND ((e.events_date1>=NOW() - INTERVAL 14 DAY AND e.events_pending<1) OR (e.events_pending>0)) ORDER BY e.events_date1 DESC, e.events_pending ASC", array($player_id))->result_array();
		}else{
			$events = $CI->db->query("SELECT e.*, c.cabs_name FROM events e LEFT OUTER JOIN cabs c ON c.cabs_id=e.join_cabs_id WHERE e.join_players_id=? ORDER BY e.events_date1 DESC, e.events_pending ASC", array($player_id))->result_array();
		}


		foreach((array)$events AS $k => $v){
			if($v['events_pending'] == 0){
				$events[$k]['events_status_english'] = "Confirmed";
			}elseif($v['events_pending'] == 1){
				$events[$k]['events_status_english'] = "Planning";
			}elseif($v['events_pending'] == 2){
				$events[$k]['events_status_english'] = "Pending";
			}elseif($v['events_pending'] == -1){
				$events[$k]['events_status_english'] = "Run";
			}
		}
		return $events;
	}

	public static function get_owned_horses($player_id){
		$CI =& get_instance();

		return $CI->db->query("SELECT * FROM horses WHERE join_players_id=? AND horses_pending=0", array($player_id))->result_array();
	}


	public static function get_vet_appts(){
		$CI =& get_instance();

		$appts = $CI->db->query('
				SELECT
					ha.*, h.horses_id, h.horses_name, h.horses_birthyear, h.horses_gender, h.horses_vet
				FROM horse_appointments ha
				LEFT JOIN horses h ON h.horses_id=ha.join_horses_id
				WHERE ha.horse_appointments_type = "Vet" AND ha.horse_appointments_completed = "0000-00-00 00:00:00"
				ORDER BY ha.horse_appointments_id ASC
			')->result_array();

		return $appts;
	}


	function cancel_quit($id){
		$this->db->query("UPDATE players SET players_pending_delete=0, players_pending_delete_date='0000-00-00 00:00:00' WHERE players_id=?", array($id));
		return true;
	}

	function quit($player, $data){
		//request deletion. ensure password is correct

		$player = $this->db->query('
			SELECT * FROM players
			WHERE players_username = ? AND players_password = PASSWORD(?)
		', array(
			$player['players_username'], $data['password']
		))->row_array();

		if(!$player['players_id']){
			$errors['password'] = 'Invalid request.';
		}

		if(!$data['reason']){
			$errors['reason'] = 'Please provide a response.';
		}


		if(count($errors) > 0){
			return array('errors' => $errors);
		}

		$this->db->query('
				UPDATE players SET players_pending_delete=1, players_pending_delete_date=NOW(), players_pending_delete_reason=? WHERE players_id=? LIMIT 1
			', array($data['reason'], $this->session->userdata('players_id')));

		return array('errors' => $errors, 'notices' => $notices);
	}

	public static function perform_vet($horse_appointments_id){
		$CI =& get_instance();

		$appt = $CI->db->query('
				SELECT
					ha.*, h.*
				FROM horse_appointments ha
				LEFT JOIN horses h ON h.horses_id=ha.join_horses_id
				WHERE ha.horse_appointments_id=? AND ha.horse_appointments_type = "Vet" AND ha.horse_appointments_completed = "0000-00-00 00:00:00"
				ORDER BY ha.horse_appointments_id ASC
			', array($horse_appointments_id))->row_array();

		if(!$appt['horse_appointments_id']){
			$errors['general'] = "Invalid appointment.";
		}

		if(count($errors) > 0){
			return array('errors' => $errors);
		}

		//complete appt
		$message = "<a href='/horses/view/" . $appt['horses_id'] . "'>". $appt['horses_competition_title'] . " " . $appt['horses_breeding_title'] . " " . $appt['horses_name'] . " #" . generateId($appt['horses_id']) . "</a> has been seen by the Vet.";
		$CI->db->query('UPDATE horse_appointments SET horse_appointments_completed=NOW() WHERE horse_appointments_id=?', array($horse_appointments_id));
		$CI->db->query('UPDATE horses SET horses_vet=? WHERE horses_id=?', array($appt['horse_appointments_date'], $appt['horses_id']));
		$CI->db->query("INSERT INTO horse_records(join_players_id, join_horses_id, horse_records_type, horse_records_date, horse_records_notes) VALUES(?, ?, ?, ?, ?)", array($appt['join_players_id'], $appt['horses_id'], "Vet", $appt['horse_appointments_date'], $appt['horse_appointments_description']));
		$CI->db->query("INSERT INTO notices(join_players_id, notices_body) VALUES(?, ?)", array($appt['join_players_id'], $message));

		$CI->session->set_flashdata('notice', "Appointment completed.");

		return array('errors' => $errors, 'notices' => $notices, 'horse_id' => $horse_id);
	}

	public static function reject_vet($horse_appointments_id){
		$CI =& get_instance();

		$appt = $CI->db->query('
				SELECT
					ha.*, h.*
				FROM horse_appointments ha
				LEFT JOIN horses h ON h.horses_id=ha.join_horses_id
				WHERE ha.horse_appointments_id=? AND ha.horse_appointments_type = "Vet" AND ha.horse_appointments_completed = "0000-00-00 00:00:00"
				ORDER BY ha.horse_appointments_id ASC
			', array($horse_appointments_id))->row_array();

		if(!$appt['horse_appointments_id']){
			$errors['general'] = "Invalid appointment.";
		}

		if(count($errors) > 0){
			return array('errors' => $errors);
		}

		//Delete appt
		$CI->db->query('DELETE FROM horse_appointments WHERE horse_appointments_id=?', array($horse_appointments_id));

		$CI->session->set_flashdata('notice', "Appointment rejected.");

		return array('errors' => $errors, 'notices' => $notices, 'horse_id' => $horse_id);
	}


	public static function get_farrier_appts(){
		$CI =& get_instance();

		$appts = $CI->db->query('
				SELECT
					ha.*, h.horses_id, h.horses_name, h.horses_birthyear, h.horses_gender, h.horses_vet
				FROM horse_appointments ha
				LEFT JOIN horses h ON h.horses_id=ha.join_horses_id
				WHERE ha.horse_appointments_type = "Farrier" AND ha.horse_appointments_completed = "0000-00-00 00:00:00"
				ORDER BY ha.horse_appointments_id ASC
			')->result_array();

		return $appts;
	}

	public static function perform_farrier($horse_appointments_id){
		$CI =& get_instance();

		$appt = $CI->db->query('
				SELECT
					ha.*, h.*
				FROM horse_appointments ha
				LEFT JOIN horses h ON h.horses_id=ha.join_horses_id
				WHERE ha.horse_appointments_id=? AND ha.horse_appointments_type = "Farrier" AND ha.horse_appointments_completed = "0000-00-00 00:00:00"
				ORDER BY ha.horse_appointments_id ASC
			', array($horse_appointments_id))->row_array();

		if(!$appt['horse_appointments_id']){
			$errors['general'] = "Invalid appointment.";
		}

		if(count($errors) > 0){
			return array('errors' => $errors);
		}

		//complete appt
		$message = "<a href='/horses/view/" . $appt['horses_id'] . "'>". $appt['horses_competition_title'] . " " . $appt['horses_breeding_title'] . " " . $appt['horses_name'] . " #" . generateId($appt['horses_id']) . "</a> has been seen by the Farrier.";
		$CI->db->query('UPDATE horse_appointments SET horse_appointments_completed=NOW() WHERE horse_appointments_id=?', array($horse_appointments_id));
		$CI->db->query('UPDATE horses SET horses_farrier=? WHERE horses_id=?', array($appt['horse_appointments_date'], $appt['horses_id']));
		$CI->db->query("INSERT INTO horse_records(join_players_id, join_horses_id, horse_records_type, horse_records_date, horse_records_notes) VALUES(?, ?, ?, ?, ?)", array($appt['join_players_id'], $appt['horses_id'], "Farrier", $appt['horse_appointments_date'], $appt['horse_appointments_description']));
		$CI->db->query("INSERT INTO notices(join_players_id, notices_body) VALUES(?, ?)", array($appt['join_players_id'], $message));

		$CI->session->set_flashdata('notice', "Appointment completed.");

		return array('errors' => $errors, 'notices' => $notices, 'horse_id' => $horse_id);
	}

	public static function reject_farrier($horse_appointments_id){
		$CI =& get_instance();

		$appt = $CI->db->query('
				SELECT
					ha.*, h.*
				FROM horse_appointments ha
				LEFT JOIN horses h ON h.horses_id=ha.join_horses_id
				WHERE ha.horse_appointments_id=? AND ha.horse_appointments_type = "Farrier" AND ha.horse_appointments_completed = "0000-00-00 00:00:00"
				ORDER BY ha.horse_appointments_id ASC
			', array($horse_appointments_id))->row_array();

		if(!$appt['horse_appointments_id']){
			$errors['general'] = "Invalid appointment.";
		}

		if(count($errors) > 0){
			return array('errors' => $errors);
		}

		//delete appt
		$CI->db->query('DELETE FROM horse_appointments WHERE horse_appointments_id=?', array($horse_appointments_id));

		$CI->session->set_flashdata('notice', "Appointment rejected.");

		return array('errors' => $errors, 'notices' => $notices, 'horse_id' => $horse_id);
	}


	function send_email($name, $email, $subject, $body){
		// load email library
		$this->load->library('email');
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$this->email->initialize($config);

		// from address
		$this->email
		    ->from(ADMIN_EMAIL, ADMIN_NAME)
		    ->to($email)
		 //   ->cc($cc_email)
		 //   ->bcc($bcc_email)
		 //   ->subject('Welcome to Hurricane Farm')
		    ->subject($subject)
		 //   ->message('Welcome! You have successfully applied to join the game. A member of the team will review your application and be in touch.');
		    ->message($body);

		$this->email->send(); // send Email
		//$this->email->print_debugger(array('headers', 'subject', 'body'));

		return array('notice' => 'Email sent.');
	}




	public static function get_hash($str){
		$CI =& get_instance();
		return $CI->db->query("SELECT PASSWORD(?) AS my_hash", array($str))->row_array();
	}





	public function search($data){
		$CI =& get_instance(); //allow us to use the db...
		//$CI->load->library('strings');

		$selects = $joins = $wheres = $params = array();

		/*
			SELECT p.* FROM players p
			WHERE
			LIMIT 500
		*/

        $selects = array(
            'p.players_id',
            'p.players_nickname',
            'DATE_FORMAT(players_last_active, "%M %D, %Y at %l:%i %p") AS players_last_active2',
            's.stables_name',
            's.stables_id',
            's.stables_boarding_fee',
            's.stables_boarding_public',
        );

        $joins[] = 'LEFT OUTER JOIN stables s ON s.join_players_id=p.players_id';

		$wheres[] = 'p.players_id != 0';
		$wheres[] = 'p.players_deleted = 0';
		$wheres[] = 'p.players_pending = 0';

		//---------- WHERES --------------
		if($data['players_id']){
			$wheres [] = "players_id=?";
			$params [] = $data['players_id'];
		}
		if($data['players_nickname']){
			$wheres [] = "players_nickname LIKE ?";
			$params [] = '%' . $data['players_nickname'] . '%';
		}

		if($data['stables_name']){
			$wheres [] = "stables_name LIKE ?";
			$params [] = '%' . $data['stables_name'] . '%';
		}
		if($data['stables_boarding_fee']){
			$wheres [] = "stables_boarding_fee<=? AND stables_boarding_public=1";
			$params [] = $data['stables_boarding_fee'];
		}


		if($data['active']){
			$wheres [] = "players_last_active>=NOW() - INTERVAL 30 DAY";
		}

		/*if($data['horses_status'] == 0){
			$wheres [] = "horses_deceased=0";
			$wheres [] = "horses_exported=0";
		}elseif($data['horses_status'] == 1){
			$wheres [] = "horses_deceased=1";
		}elseif($data['horses_status'] == 2){
			$wheres [] = "join_players_id=" + EXPORT_ID;
		}*/

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
		$players = $CI->db->query('
			SELECT '. implode(', ', $selects) .'
			FROM players p
			'. implode("\n", $joins) .'
			'. $wheres .'
		', $params)->result_array();
		//pre($CI->db->last_query());

        return $players;
	}

}
