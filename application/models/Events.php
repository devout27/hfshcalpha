<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events extends CI_Model {
	var $event = null;
	protected $table = 'events';
	function __construct($events_id = NULL){
		$this->data['player_id'] = $this->session->userdata('players_id');
		if($events_id){
			$this->event = $this->db->query('SELECT
				e.*, /*exc.*,*/ p.players_nickname, cabs.cabs_name
				FROM events e
				/*LEFT JOIN events_x_classes exc ON exc.join_events_id=e.events_id*/
				LEFT JOIN players p ON p.players_id=e.join_players_id
				LEFT OUTER JOIN cabs ON cabs.cabs_id=e.join_cabs_id
				WHERE e.events_id = ? LIMIT 1
			', array($events_id))->row_array();

			if($this->event['events_pending'] == 0){
				$this->event['events_status_english'] = "Confirmed";
			}elseif($this->event['events_pending'] == 1){
				$this->event['events_status_english'] = "Planning";
			}elseif($this->event['events_pending'] == 2){
				$this->event['events_status_english'] = "Pending";
			}elseif($this->event['events_pending'] == -1){
				$this->event['events_status_english'] = "Run";
			}

			$this->event['classes'] = $this->db->query("SELECT exc.*, cd.classlists_divisions_name FROM events_x_classes exc LEFT JOIN classlists_divisions cd ON cd.classlists_divisions_id=exc.join_divisions_id WHERE exc.join_events_id=? ORDER BY exc.events_x_classes_name ASC", array($this->event['events_id']))->result_array();

		}
	}


	function get($id){
		return $this->db->query("SELECT * FROM events WHERE events_id=?", array($id))->row_array();
	}

	function get_class($id){
		$class = $this->db->query("SELECT exc.*, cd.* FROM events_x_classes exc LEFT JOIN classlists_divisions cd ON cd.classlists_divisions_id=exc.join_divisions_id WHERE events_x_classes_id=?", array($id))->row_array();
		$class['entrants'] = $this->db->query("SELECT ee.*, h.horses_name, h.horses_breed, p.players_nickname FROM events_entrants ee LEFT JOIN horses h ON h.horses_id=ee.join_horses_id LEFT JOIN players p ON p.players_id=h.join_players_id WHERE join_events_x_classes_id=? ORDER BY ee.events_entrants_place ASC", array($id))->result_array();
		foreach((array)$class['entrants'] AS $e):
			$class['entrants_ids'] []= $e['join_horses_id'];
		endforeach;
		$class['division_results'] = $this->db->query("SELECT ed.*, h.horses_name, h.horses_breed, p.players_nickname FROM events_divisions ed LEFT JOIN horses h ON h.horses_id=ed.join_horses_id LEFT JOIN players p ON p.players_id=h.join_players_id WHERE ed.join_events_id=? AND join_divisions_id=? ORDER BY ed.events_divisions_place ASC", array($class['join_events_id'], $class['join_divisions_id']))->result_array();
		return $class;
	}

	function get_classlist($id){
		$classlist = $this->db->query("SELECT cc.*, c.*, cd.*, cabs.cabs_name
				FROM classlists c
					LEFT JOIN classlists_classes cc ON cc.join_classlists_id=c.classlists_id
					LEFT JOIN cabs ON cabs.cabs_id=c.join_cabs_id
					LEFT JOIN classlists_divisions cd ON cd.classlists_divisions_id=cc.join_divisions_id
				WHERE c.classlists_id=? ORDER BY cc.classlists_classes_name ASC", array($id))->result_array();

		return $classlist;
	}


	public static function cancel_event($id){
		$CI =& get_instance();
		$CI->db->query("DELETE FROM events_x_classes WHERE join_events_id=?", array($id));
		$CI->db->query("DELETE FROM events WHERE events_id=?", array($id));
		return $CI->db->affected_rows();
	}





	public static function admin_get_pending(){
		$CI =& get_instance();
		return $CI->db->query("SELECT e.*, p.players_nickname, c.cabs_name FROM events e
				LEFT OUTER JOIN cabs c ON c.cabs_id=e.join_cabs_id
				LEFT JOIN players p ON p.players_id=c.join_players_id
				WHERE e.events_pending=2 ORDER BY e.events_id ASC
			")->result_array();
	}


	public static function admin_edit_division($data){
		$CI =& get_instance();


		if(strlen(trim($data['classlists_divisions_name'])) < 3){
			$errors['classlists_divisions_name'] = "Please include a name.";
		}
		if(!$data['join_classlists_id'] AND !$data['classlists_divisions_id']){
			$errors['classlists_divisions_name'] = "Invalid classlist.";
		}

		if(count($errors) > 0){
			return array('errors' => $errors);
		}
		//save it
		$data['classlists_divisions_name'] = $CI->security->xss_clean($data['classlists_divisions_name']);


		if(!$data['classlists_divisions_id']){
			//create a new class
			$allowed_fields = array(
				'classlists_divisions_name',
				'join_classlists_id',
			);
			$create_data = filter_keys($data, $allowed_fields);
			$CI->db->query("INSERT INTO classlists_divisions(classlists_divisions_name, join_classlists_id) VALUES(?, ?)", $create_data);
			$create_data['classlists_divisions_id'] = $CI->db->insert_id();
		}else{
			// edit existing class
			$allowed_fields = array(
				'classlists_divisions_name',
				'classlists_divisions_id'
			);
			$create_data = filter_keys($data, $allowed_fields);
			$CI->db->query("UPDATE classlists_divisions SET classlists_divisions_name=? WHERE classlists_divisions_id=?", $create_data);
		}
		//pre($CI->db->last_query());exit;

		//return the good news
		return $create_data + array('errors' => $errors, 'notice' => 'Edited division.', 'classlists_divisions_id' => $data['classlists_divisions_id']);
	}

	public static function admin_delete_division($data){
		$CI =& get_instance();
		$CI->db->query("UPDATE classlists_classes SET join_divisions_id=0 WHERE join_divisions_id=?", $data);
		$CI->db->query("DELETE FROM classlists_divisions WHERE classlists_divisions_id=? LIMIT 1", $data);
		return $CI->db->affected_rows();
	}

	public static function get_divisions($id){
		$CI =& get_instance();
		$divisions = $CI->db->query("SELECT * FROM classlists_divisions WHERE join_classlists_id=? ORDER BY classlists_divisions_name ASC", array($id))->result_array();
		foreach((array)$divisions AS $d){
			$divisions2[$d['classlists_divisions_id']] = $d['classlists_divisions_name'];
		}
		return $divisions2;
	}



	public static function admin_save_classlist($player, $cabs, $id, $data){
		$CI =& get_instance();
		if(!$player['privileges']['privileges_events']){
			$errors[] = "You don't have permission to access this.";
		}

		if($data['join_cabs_id'] AND !in_array($data['join_cabs_id'], array_keys($cabs))){
			$errors['join_cabs_id'] = "Invalid CAB.";
		}
		if(strlen(trim($data['classlists_name'])) < 5){
			$errors['classlists_name'] = "Please include a name with at least 5 characters in length.";
		}
		$data['classlists_special'] = $data['classlists_special'] == 1 ?: '0';


		if(count($errors) > 0){
			return array('errors' => $errors);
		}

		$CI->db->query("UPDATE classlists SET classlists_name=?, classlists_special=?, join_cabs_id=? WHERE classlists_id=?", array($data['classlists_name'], $data['classlists_special'], $data['join_cabs_id'], $id));

		return array('errors' => $errors, 'notice' => 'Classlist edited.');
	}

	public static function admin_delete_class($data){
		$CI =& get_instance();
		$CI->db->query("DELETE FROM classlists_classes WHERE classlists_classes_id=? LIMIT 1", $data);
		return $CI->db->affected_rows();
	}


	public static function admin_delete_classlist($id){
		$CI =& get_instance();
		$CI->db->query("DELETE FROM classlists_classes WHERE join_classlists_id=?", $id);
		$CI->db->query("DELETE FROM classlists WHERE classlists_id=? LIMIT 1", $id);
		return $CI->db->affected_rows();
	}

	public static function admin_edit_class($data){
		$CI =& get_instance();
		$CI->load->model('horse');

		$breeds = $CI->horse->get_breeds();
		$disciplines = $CI->horse->get_disciplines();
		$breeds_types = $CI->horse->get_breeds_types();
		$divisions = self::get_divisions($data['join_classlists_id']);

		if(strlen(trim($data['classlists_classes_name'])) < 3){
			$errors['classlists_classes_name'] = "Please include a name.";
		}
		if(strlen(trim($data['classlists_classes_description'])) < 3){
			$errors['classlists_classes_description'] = "Please include a decription.";
		}
		$data['classlists_classes_strenuous'] = $data['classlists_classes_strenuous'] ? '1' : '0';
		if(!$data['classlists_classes_min_age'])
		{
			$errors['classlists_classes_min_age'] = "Please Enter Min age.";
		}
		if(!$data['classlists_classes_max_age'])
		{
			$errors['classlists_classes_max_age'] = "Please Enter Max age.";
		}
		if($data['classlists_classes_min_age'] < 0 || $data['classlists_classes_min_age'] > $data['classlists_classes_max_age']){
			$errors['classlists_classes_min_age'] = "Invalid Min Age.";
		}
		if($data['classlists_classes_max_age'] < 0 || $data['classlists_classes_max_age'] < $data['classlists_classes_min_age']){
			$errors['classlists_classes_max_age'] = "Invalid Max Age.";
		}
		if(!$data['classlists_classes_fee'])
		{
			$errors['classlists_classes_fee'] = "Please Enter Fee.";
		}
		if($data['classlists_classes_fee'] < 0){
			$errors['classlists_classes_fee'] = "Invalid fee.";
		}
		if($data['join_divisions_id'] && !array_key_exists($data['join_divisions_id'], $divisions)){
			$errors['join_divisions_id'] = "Invalid division.";
		}
		if(!$data['classlists_classes_disciplines'])
		{
			$errors['classlists_classes_disciplines'] = "Please Select Discipline.";
		}
		foreach((array)$data['classlists_classes_disciplines'] AS $d){
			if(!in_array($d, $disciplines)){
				$errors['classlists_classes_disciplines'] = "Invalid discipline.";
			}
		}
		if(!$data['classlists_classes_breeds_types'])
		{
			$errors['classlists_classes_breeds_types'] = "Please Select Type.";
		}
		foreach((array)$data['classlists_classes_breeds_types'] AS $d){
			if(!in_array($d, $breeds_types)){
				$errors['classlists_classes_breeds_types'] = "Invalid type.";
			}
		}
		if(!$data['classlists_classes_breeds'])
		{
			$errors['classlists_classes_breeds'] = "Please Select Breeds.";
		}
		foreach((array)$data['classlists_classes_breeds'] AS $d){
			if(!in_array($d, $breeds)){
				$errors['classlists_classes_breeds'] = "Invalid breed.";
			}
		}

		if(count($errors) > 0){
			return array('errors' => $errors);
		}
		//save it
		$data['classlists_classes_name'] = $CI->security->xss_clean($data['classlists_classes_name']);
		$data['classlists_classes_description'] = $CI->security->xss_clean($data['classlists_classes_description']);
		$data['classlists_classes_breeds_types'] = implode('|', $data['classlists_classes_breeds_types']);
		$data['classlists_classes_breeds'] = implode('|', $data['classlists_classes_breeds']);
		$data['classlists_classes_disciplines'] = implode('|', $data['classlists_classes_disciplines']);



		if(!$data['classlists_classes_id']){
			//create a new class
			$allowed_fields = array(
				'classlists_classes_name',
				'classlists_classes_description',
				'classlists_classes_strenuous',
				'classlists_classes_min_age',
				'classlists_classes_max_age',
				'classlists_classes_fee',
				'join_classlists_id',
				'join_divisions_id',
				'classlists_classes_disciplines',
				'classlists_classes_breeds',
				'classlists_classes_breeds_types',
			);
			$create_data = filter_keys($data, $allowed_fields);
			$CI->db->query("INSERT INTO classlists_classes(classlists_classes_name, classlists_classes_description, classlists_classes_strenuous, classlists_classes_min_age, classlists_classes_max_age, classlists_classes_fee, join_classlists_id, join_divisions_id, classlists_classes_disciplines, classlists_classes_breeds, classlists_classes_breeds_types) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", $create_data);
			$create_data['classlists_classes_id'] = $CI->db->insert_id();
		}else{
			// edit existing class
			$allowed_fields = array(
				'classlists_classes_name',
				'classlists_classes_description',
				'classlists_classes_strenuous',
				'classlists_classes_min_age',
				'classlists_classes_max_age',
				'classlists_classes_fee',
				'join_divisions_id',
				'classlists_classes_disciplines',
				'classlists_classes_breeds',
				'classlists_classes_breeds_types',
				'classlists_classes_id',
			);
			$create_data = filter_keys($data, $allowed_fields);
			$CI->db->query("UPDATE classlists_classes SET classlists_classes_name=?, classlists_classes_description=?, classlists_classes_strenuous=?, classlists_classes_min_age=?, classlists_classes_max_age=?, classlists_classes_fee=?, join_divisions_id=?, classlists_classes_disciplines=?, classlists_classes_breeds=?, classlists_classes_breeds_types=? WHERE classlists_classes_id=?", $create_data);
		}
//pre($divisions);
		//return the good news
		return $create_data + array('classlists_divisions_name' => $divisions[$create_data['join_divisions_id']], 'errors' => $errors, 'notice' => 'Edited class.', 'classlists_classes_id' => $data['classlists_classes_id']);
	}

	public static function admin_accept($data){
		$CI =& get_instance();
		$cab = $CI->db->query("SELECT * FROM cabs WHERE cabs_id=?", array($data['cabs_id']))->row_array();
		$notice = "Your CAB has been accepted.";
		$CI->db->query("INSERT INTO notices(notices_body, join_players_id) VALUES(?,?)", array($notice, $cab['join_players_id']));
		$CI->db->query("UPDATE cabs SET cabs_pending=0 WHERE cabs_id=?", array($data['cabs_id']));
		return true;
	}

	public static function admin_reject($data){
		$CI =& get_instance();
		$cab = $CI->db->query("SELECT * FROM cabs WHERE cabs_id=?", array($data['cabs_id']))->row_array();
		$notice = "Your CAB has been rejected.";
		$CI->db->query("INSERT INTO notices(notices_body, join_players_id) VALUES(?,?)", array($notice, $cab['join_players_id']));
		$CI->db->query("DELETE FROM cabs WHERE cabs_id=? AND cabs_pending=1 LIMIT 1", array($data['cabs_id']));
		return true;
	}



	public static function enter_class($player, $data){
		$CI =& get_instance(); //allow us to use the db...
		$CI->load->model('horse');
		$CI->load->model('bank');
		$player_id = $player['players_id'];

		//pre($player);exit;

		//get class
		$class = $CI->db->query("SELECT exc.*, e.* FROM events_x_classes exc LEFT JOIN events e ON e.events_id=exc.join_events_id WHERE exc.events_x_classes_id=? LIMIT 1", array($data['classes_id']))->row_array();

		//get entries for checking whether or not horse is too tired for this class
		$entries = $CI->db->query("
			SELECT ee.*, exc.*, e.*
			FROM events_entrants ee
				LEFT JOIN events_x_classes exc ON ee.join_events_x_classes_id=exc.events_x_classes_id
				LEFT JOIN events e ON e.events_id=exc.join_events_id
			WHERE ee.join_horses_id=?
			AND e.events_date1>=NOW() - INTERVAL 15 DAY", array($data['join_horses_id']))->result_array();
		//finish this guy later :)

		//pre($class);exit;
		//get horse
		$horse = $CI->db->query("SELECT * FROM horses WHERE horses_id=? LIMIT 1", array($data['join_horses_id']))->row_array();
		$horse['disciplines'] = $CI->db->query("SELECT * FROM horses_x_disciplines WHERE join_horses_id=?", array($data['join_horses_id']))->result_array();
		$breed = $CI->db->query("SELECT * FROM breeds WHERE breed_name=? LIMIT 1", array($horse['horses_breed']))->row_array();
		$horse['age'] = Horse::get_age_by_year($horse['horses_birthyear']);

		$strenuous_count = self::class_count($class['events_id'], $horse['horses_id']);

		$today = new DateTime(date('Y-m-d'));
		$event_date = new DateTime($class['events_date1']);

		$vet = new DateTime($horse['horses_vet']);
		$farrier = new DateTime($horse['horses_farrier']);
		$vet = $today->diff($vet);
		$farrier = $today->diff($farrier);


		if($breeds){
			$breeds = explode('|', $class['events_x_classes_breeds']);
		}
		if($breeds_types){
			$breeds_types = explode('|', $class['events_x_classes_breeds_types']);
		}
		$disciplines = explode('|', $class['events_x_classes_disciplines']);

		//check if player owns horse
		if($horse['join_players_id'] != $player_id){
			$errors []= "You do not own this horse.";
		}

		//check if horse is already entered
		$exists = $CI->db->query("SELECT * FROM events_entrants WHERE join_events_x_classes_id=? AND join_horses_id=?", array($data['classes_id'], $data['join_horses_id']))->row_array();
		if($exists['join_horses_id']){
			$errors []= "Horse is already entered.";
		}

		//check if horse is eligible for event
		if($class['events_pending'] != 0){
			$errors []= "Invalid event status.";
		}
		if($event_date <= $today){
			$errors []= "Entrants are no longer being accepted for this event.";
		}


		//check if horse is eligible for class
		if($horse['age'] < $class['events_x_classes_min_age'] || $horse['age'] > $class['events_x_classes_max_age']){
			$errors []= "Invalid age.";
		}

		if(count($breeds) > 0 AND !in_array($horse['horses_breed'], $breeds)){
			$errors []= "Invalid breed.";
		}

		if(count($disciplines) > 0 AND !empty(array_intersect($horse['disciplines'], $disciplines))){
			$errors []= "Invalid discipline.";
		}
		if(count($breeds_types) > 0 AND !in_array($breed['breeds_type'], $breeds_types)){
			$errors []= "Invalid breed type.";
		}
		if($vet->format('%y') > 0){
			$errors []= "Needs vet checkup.";
		}
		if($farrier->format('%y') > 0){
			$errors []= "Needs farrier checkup.";
		}

		//check when
		if(Horse::has_evented_recently(array('horse' => $horse, 'events_id' => $class['events_id']))){
			$errors []= "Not enough time has elapsed between events.";
		}

		//check if too many classes
		if(!$class['events_x_classes_strenuous'] AND $strenuous_count >= 8){
			$errors []= "Horse may not enter another class in this event.";
		}elseif($class['events_x_classes_strenuous'] AND $strenuous_count >= 7){
			$errors []= "Horse may not enter another strenuous class.";
		}


		if(count($errors) > 0){
			return array('errors' => $errors);
		}
		//pre($class);exit;

		//update the money. if error, don't update &  return errors again.
		$note = "Enter Horse #" . generateId($horse['horses_id']) ." into Class #" . $class['events_x_classes_id'];
		$transfer = Bank::instant_transfer($player_id, $player['default_bank'], $class['join_bank_id'], $class['events_x_classes_fee'], $note);
		if(count($transfer['errors']) > 0){
			return $transfer['errors'];
		}

		$CI->db->query("INSERT INTO events_entrants(join_events_x_classes_id, join_horses_id, join_divisions_id) VALUES(?, ?, ?)", array($data['classes_id'], $data['join_horses_id'], $class['join_divisions_id']));
		return 1;

	}


	public static function class_count($horse_id, $event_id){
		$CI =& get_instance();
		/**********
		check if a horse is in too many classes for a race/show
		*/
		$count = 0;

		$entries = $CI->db->query("SELECT ee.*, exc.events_x_classes_strenuous, e.events_type FROM events_entrants ee LEFT JOIN events_x_classes exc ON exc.events_x_classes_id=ee.join_events_x_classes_id LEFT JOIN events e ON e.events_id=exc.join_events_id WHERE ee.join_horses_id=? AND exc.join_events_id=?", array($event_id, $horse_id))->result_array();
		/* foreach((array)$entries AS $e){
			if($e['events_type'] == "Show" AND $e['events_x_classes_strenuous']){
				$count += 2;
			}elseif($e['events_type'] == "Show" AND $e['events_x_classes_strenuous']){
				$count += 1;
			}elseif($e['events_type'] == "Race"){
				$count = 8;
			}
		} 
		return $count;
		*/
		foreach((array)$entries AS $e){
			if($e['events_type'] == "Show" || $e['events_type'] == "Olympic" || $e['events_type'] == "WEGs")
			{
				if($e['events_x_classes_strenuous']){
					$count += 3;
				}
			}elseif($e['events_type'] == "Race"){
				$count = 8;
			}
		}
		return $count;		
	}

	public static function edit_class($player, $data){
		$CI =& get_instance(); //allow us to use the db...

		//check if player has access to editing this class
		$event = $CI->db->query("SELECT e.* FROM events_x_classes c LEFT JOIN events e on e.events_id=c.join_events_id WHERE c.events_x_classes_id=? LIMIT 1", array($data['events_x_classes_id']));
		if(!$player['privileges']['privileges_events'] AND $player['players_id'] != $event['join_players_id']){
			$errors['events_x_classes_name'] = "You do not have permission to edit this class.";
		}

		if(strlen(trim($data['events_x_classes_name'])) < 3){
			$errors['events_x_classes_name'] = "Please include a name.";
		}
		if(strlen(trim($data['events_x_classes_description'])) < 3){
			$errors['events_x_classes_description'] = "Please include a name.";
		}
		$data['events_x_classes_strenuous'] = $data['events_x_classes_strenuous'] ? '1' : '0';
		if($data['events_x_classes_min_age'] < 0 || $data['events_x_classes_min_age'] > $data['events_x_classes_max_age']){
			$errors['events_x_classes_min_age'] = "Invalid age.";
		}
		if($data['events_x_classes_max_age'] < 0 || $data['events_x_classes_max_age'] < $data['events_x_classes_min_age']){
			$errors['events_x_classes_max_age'] = "Invalid age.";
		}
		if($data['events_x_classes_fee'] < 0){
			$errors['events_x_classes_fee'] = "Invalid fee.";
		}

		if(count($errors) > 0){
			return array('errors' => $errors);
		}
		//save it
		$data['events_x_classes_name'] = $CI->security->xss_clean($data['events_x_classes_name']);
		$data['events_x_classes_description'] = $CI->security->xss_clean($data['events_x_classes_description']);
		/*$data['events_date1'] = $mysql_date1;
		$data['events_date2'] = $mysql_date2;
		$data['events_date3'] = $mysql_date3;*/

		$allowed_fields = array(
			'events_x_classes_name',
			'events_x_classes_description',
			'events_x_classes_strenuous',
			'events_x_classes_min_age',
			'events_x_classes_max_age',
			'events_x_classes_fee',
			'events_x_classes_prize01',
			'events_x_classes_prize02',
			'events_x_classes_prize03',
			'events_x_classes_prize04',
			'events_x_classes_prize05',
			'events_x_classes_prize06',
			'events_x_classes_prize07',
			'events_x_classes_prize08',
			'events_x_classes_prize09',
			'events_x_classes_prize10',
			'events_x_classes_prize11',
			'events_x_classes_prize12',
			'events_x_classes_id',
		);
		$create_data = filter_keys($data, $allowed_fields);

		$CI->db->query("UPDATE events_x_classes SET events_x_classes_name=?, events_x_classes_description=?, events_x_classes_strenuous=?, events_x_classes_min_age=?, events_x_classes_max_age=?, events_x_classes_fee=?, events_x_classes_prize01=?, events_x_classes_prize02=?, events_x_classes_prize03=?, events_x_classes_prize04=?, events_x_classes_prize05=?, events_x_classes_prize06=?, events_x_classes_prize07=?, events_x_classes_prize08=?, events_x_classes_prize09=?, events_x_classes_prize10=?, events_x_classes_prize11=?, events_x_classes_prize12=? WHERE events_x_classes_id=?", $create_data);
		//pre($CI->db->last_query());exit;

		//return the good news
		return array('errors' => $errors, 'notice' => 'Edited class.', 'events_x_classes_id' => $data['events_x_classes_id']);
	}


	public static function finalize_event($player, $event){
		$CI =& get_instance(); //allow us to use the db...


		$CI->db->query("UPDATE events SET events_pending=2 WHERE events_id=?", $event['events_id']);
		//pre($CI->db->last_query());exit;

		//return the good news
		return array('errors' => $errors, 'notice' => 'Finalized event.', 'event_id' => $event['events_id']);
	}



	public static function admin_approve_event($player, $event){
		$CI =& get_instance(); //allow us to use the db...


		$CI->db->query("UPDATE events SET events_pending=0 WHERE events_id=?", $event['events_id']);

		//return the good news
		return array('errors' => $errors, 'notice' => 'Approved event.', 'event_id' => $event['events_id']);
	}

	public static function edit_event($player, $event, $data){
		$CI =& get_instance(); //allow us to use the db...

		if($event['events_type'] == "Race"){
			$data['events_date1'] = $data['events_dater1'];
			$data['events_date2'] = $data['events_dater2'];
			$data['events_date3'] = $data['events_dater3'];
		}
		$date1 = explode('-', $data['events_date1']);
		$date2 = explode('-', $data['events_date2']);
		$date3 = explode('-', $data['events_date3']);


		if($event['events_type'] == "Show" || $event['events_type'] == "Olympic" || $event['events_type'] == "WEGs"){
			$acceptable_dates = array(6, 10, 13, 16, 20, 23, 26, 30);
			if(!checkdate($date1[1], $date1[2], $date1[0])){
				$errors['events_date1'] = "Invalid date. ";
			}elseif(!in_array($date1[2], $acceptable_dates)){
				$errors['events_date1'] = "Invalid day of the month.";
			}
			if(!checkdate($date2[1], $date2[2], $date2[0])){
				$errors['events_date2'] = "Invalid date.";
			}elseif(!in_array($date2[2], $acceptable_dates)){
				$errors['events_date2'] = "Invalid day of the month.";
			}
			if(!checkdate($date3[1], $date3[2], $date3[0])){
				$errors['events_date3'] = "Invalid date.";
			}elseif(!in_array($date3[2], $acceptable_dates)){
				$errors['events_date3'] = "Invalid day of the month.";
			}
		}else{
			$acceptable_days = array('Friday', 'Saturday');			
			if(!checkdate($date1[1], $date1[2], $date1[0])){
				$errors['events_dater1'] = "Invalid date.";
			}elseif(!in_array(date('l', strtotime($event['events_date1'])), $acceptable_days)){
				$errors['events_dater1'] = "Invalid day of the week.";
			}
			if(!checkdate($date2[1], $date2[2], $date2[0])){
				$errors['events_dater2'] = "Invalid date.";
			}elseif(!in_array(date('l', strtotime($event['events_date2'])), $acceptable_days)){
				$errors['events_dater2'] = "Invalid day of the week.";
			}
			if(!checkdate($date3[1], $date3[2], $date3[0])){
				$errors['events_dater3'] = "Invalid date.";
			}elseif(!in_array(date('l', strtotime($event['events_date3'])), $acceptable_days)){
				$errors['events_dater3'] = "Invalid day of the week.";
			}
		}

		if(strlen(trim($data['events_name'])) < 3){
			$errors['events_name'] = "Please include a name.";
		}

		if(count($errors) > 0){
			return array('errors' => $errors);
		}
		//save it
		$data['events_name'] = $CI->security->xss_clean($data['events_name']);
		$data['events_id'] = $event['events_id'];
		/*$data['events_date1'] = $mysql_date1;
		$data['events_date2'] = $mysql_date2;
		$data['events_date3'] = $mysql_date3;*/

		$allowed_fields = array(
			'events_name',
			'events_date1',
			'events_date2',
			'events_date3',
			'events_id',
		);
		$create_data = filter_keys($data, $allowed_fields);


		$CI->db->query("UPDATE events SET events_name=?, events_date1=?, events_date2=?, events_date3=? WHERE events_id=?", $create_data);
		//pre($CI->db->last_query());exit;

		//return the good news
		return array('errors' => $errors, 'notice' => 'Edited event.', 'event_id' => $event_id);
	}



	public static function create_event($player, $host_list, $class_list, $data){
		$CI =& get_instance(); //allow us to use the db...
		$CI->load->model('bank');

		foreach((array)$host_list AS $k => $v){
			$host_list2[$k] = $k;
		}
		foreach((array)$class_list AS $k => $v){
			$class_list2[$k] = $k;
		}

		if($data['events_type'] == 1){
			$data['events_date1'] = $data['events_dater1'];
			$data['events_date2'] = $data['events_dater2'];
			$data['events_date3'] = $data['events_dater3'];
		}
		$date1 = explode('-', $data['events_date1']);
		$date2 = explode('-', $data['events_date2']);
		$date3 = explode('-', $data['events_date3']);

		if($data['events_type'] == "0" || $data['events_type'] == "2" || $data['events_type'] == "3"){
			if($data['events_type'] == "2")
			{
				$data['events_type'] = "Olympic";
			}elseif($data['events_type'] == "3")
			{
				$data['events_type'] = "WEGs";
			}else
			{
				$data['events_type'] = "Show";
			}
			$acceptable_dates = array(6, 10, 13, 16, 20, 23, 26, 30);
			if(!checkdate($date1[1], $date1[2], $date1[0])){
				$errors['events_date1'] = "Invalid date. ";
			}elseif(!in_array($date1[2], $acceptable_dates)){
				$errors['events_date1'] = "Invalid day of the month.";
			}
			if(!checkdate($date2[1], $date2[2], $date2[0])){
				$errors['events_date2'] = "Invalid date.";
			}elseif(!in_array($date2[2], $acceptable_dates)){
				$errors['events_date2'] = "Invalid day of the month.";
			}
			if(!checkdate($date3[1], $date3[2], $date3[0])){
				$errors['events_date3'] = "Invalid date.";
			}elseif(!in_array($date3[2], $acceptable_dates)){
				$errors['events_date3'] = "Invalid day of the month.";
			}
		}else{
			$data['events_type'] = "Race";
			$acceptable_days = array('Friday', 'Saturday');
			if(!checkdate($date1[1], $date1[2], $date1[0])){
				$errors['events_dater1'] = "Invalid date.";
			}elseif(!in_array(date('l', strtotime($data['events_date1'])), $acceptable_days)){
				$errors['events_dater1'] = "Invalid day of the week.";
			}
			if(!checkdate($date2[1], $date2[2], $date2[0])){
				$errors['events_dater2'] = "Invalid date.";
			}elseif(!in_array(date('l', strtotime($data['events_date2'])), $acceptable_days)){
				$errors['events_dater2'] = "Invalid day of the week.";
			}
			if(!checkdate($date3[1], $date3[2], $date3[0])){
				$errors['events_dater3'] = "Invalid date.";
			}elseif(!in_array(date('l', strtotime($data['events_date3'])), $acceptable_days)){
				$errors['events_dater3'] = "Invalid day of the week.";
			}
		}

		if(!in_array($data['events_host'], $host_list2)){
			$errors['events_host'] = "Invalid host.";
		}
		if(!in_array($data['events_classlist'], $class_list2)){
			$errors['events_classlist'] = "Invalid classlist.";
		}
		if(strlen(trim($data['events_name'])) < 3){
			$errors['events_name'] = "Please include a name.";
		}

		//check if valid bank account
		$accounts = Bank::get_accounts($player['players_id'], array('bank_type' => 'Checking'), 1, 1);
		foreach((array)$accounts AS $k => $v){
			$accounts[$k] = $v['bank_id'];
		}
		if(!in_array($data['join_bank_id'], $accounts)){
			$errors['join_bank_id'] = "Invalid bank account. Only active checking accounts are accepted.";
		}


		if(count($errors) > 0){
			return array('errors' => $errors);
		}
		//save it
		$data['join_players_id'] = $player['players_id'];
		$data['events_name'] = $CI->security->xss_clean($data['events_name']);
		$data['events_pending'] = 1;
		$data['join_cabs_id'] = $data['events_host'];
		$data['join_classlists_id'] = $data['events_classlist'];
		//$data['events_type'] = $data['events_type'];
		$allowed_fields = array(
			'join_players_id',
			'events_name',
			'events_pending',
			'events_date1',
			'events_date2',
			'events_date3',
			'join_cabs_id',
			'join_classlists_id',
			'events_type',
			'join_bank_id'
		);
		$create_data = filter_keys($data, $allowed_fields);

		$CI->db->query("INSERT INTO events(join_players_id, events_name, events_pending, events_date1, events_date2, events_date3, join_cabs_id, join_classlists_id, events_type, join_bank_id) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", $create_data);
		$event_id = $CI->db->insert_id();

		//create the classlist based off the one chosen
		$CI->db->query("INSERT INTO events_x_classes(join_events_id, join_divisions_id, events_x_classes_name, events_x_classes_description, events_x_classes_min_age, events_x_classes_max_age, events_x_classes_strenuous, events_x_classes_fee)
				(SELECT ? AS join_events_id, join_divisions_id, classlists_classes_name, classlists_classes_description, classlists_classes_min_age, classlists_classes_max_age, classlists_classes_strenuous, classlists_classes_recommended_fee FROM classlists_classes WHERE join_classlists_id=?)", array($event_id, $data['join_classlists_id']));

		//pre($CI->db->last_query());exit;

		//return the good news
		return array('errors' => $errors, 'notice' => $data['events_type'].' is now pending. Please update the classlist.', 'event_id' => $event_id);
	}


	public static function admin_create_classlist($player, $cabs, $data){
		$CI =& get_instance(); //allow us to use the db...

		if($data['join_cabs_id'] AND !in_array($data['join_cabs_id'], array_keys($cabs))){
			$errors['join_cabs_id'] = "Invalid CAB.";
		}
		if(strlen(trim($data['classlists_name'])) < 5){
			$errors['classlists_name'] = "Please include a name with at least 5 characters in length.";
		}
		$data['classlists_special'] = $data['classlists_special'] == 1 ?: '0';


		if(count($errors) > 0){
			return array('errors' => $errors);
		}
		//save it
		$data['classlists_name'] = strip_tags(trim($CI->security->xss_clean($data['classlists_name'])));
		$allowed_fields = array(
			'join_cabs_id',
			'classlists_name',
			'classlists_special',
		);
		$create_data = filter_keys($data, $allowed_fields);

		$CI->db->query("INSERT INTO classlists(join_cabs_id, classlists_name, classlists_special) VALUES(?, ?, ?)", $create_data);
		$classlists_id = $CI->db->insert_id();
		//pre($CI->db->last_query());exit;

		//return the good news
		return array('errors' => $errors, 'notice' => 'Classlist created; please add classes.', 'classlists_id' => $classlists_id);
	}


	public static function get_classlists($data = NULL){
		$CI =& get_instance(); //allow us to use the db...
		$selects = $joins = $wheres = $params = array();

        $selects = array(
            'cl.*', 'c.cabs_name'
        );

        $joins[] = 'LEFT OUTER JOIN cabs c ON c.cabs_id=cl.join_cabs_id';

		//---------- WHERES --------------
		if($data['classlists_id']){
			$wheres [] = "cl.classlists_id=?";
			$params [] = $data['classlists_id'];
		}
		if($data['join_cabs_id']){
			$wheres [] = "e.join_cabs_id=?";
			$params [] = $data['join_cabs_id'];
		}
		if($data['classlists_name']){
			$wheres [] = "classlists_name LIKE ?";
			$params [] = '%' . $data['classlists_name'] . '%';
		}

		if($data['classlists_special'] == 1){
			$wheres [] = "classlists_special=1";
		}elseif($data['classlists_special'] === 0){
			$wheres [] = "classlists_special=0";
		}

		if(is_array($data['cabs_ids'])){
				//$cabs_where .= "join_cabs_id IN (";
			foreach((array)$data['cabs_ids'] AS $k => $v){
				$cabs_where []= "?";
				$params []= $k;
			}
			$wheres []= "join_cabs_id IN (" . implode(", ", $cabs_where) .")";
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
		$classlists = $CI->db->query('
			SELECT '. implode(', ', $selects) .'
			FROM classlists AS cl
			'. implode("\n", $joins) .'
			'. $wheres .'
		', $params)->result_array();
		//pre($data);
		//pre($CI->db->last_query());exit;

		//get classes if they're requested, too
		if($data['get_classes']){
			foreach((array)$classlists AS $i => $list){
				$classlists[$i]['classes'] = $CI->db->query("SELECT * FROM classlists_classes WHERE join_classlists_id=?", array($list['classlists_id']))->result_array();
			}
		}

        return $classlists;
	}

	public static function search($player, $data = NULL){
		$CI =& get_instance(); //allow us to use the db...
		$selects = $joins = $wheres = $params = array();

        $selects = array(
            'e.*',
            'p.players_nickname',
        );

        $joins[] = 'LEFT JOIN players p ON p.players_id=e.join_players_id';
        $joins[] = 'LEFT JOIN cabs c ON c.cabs_id=e.join_cabs_id';
        $joins[] = 'LEFT JOIN classlists cl ON cl.classlists_id=e.join_classlists_id';

		//---------- WHERES --------------
		if($data['events_id']){
			$wheres [] = "e.events_id=?";
			$params [] = $data['events_id'];
		}
		if($data['events_owner']){
			if((int)$data['events_owner'] > 0){
				$wheres [] = "e.join_players_id=?";
				$params [] = $data['events_owner'];
			}else{
				$wheres [] = "p.players_nickname LIKE ?";
				$params [] = '%' . $data['events_owner'] . '%';
			}
		}
		if($data['events_name']){
			$wheres [] = "events_name LIKE ?";
			$params [] = '%' . $data['events_name'] . '%';
		}
		if($data['join_cabs_id']){
			$wheres []= "join_cabs_id=?";
			$params []= $data['join_cabs_id'];
		}

		if($data['events_pending']){
			$wheres [] = "events_pending=1";
		}else{
			$wheres [] = "events_pending=0";
		}

		if($data['events_startdate']){
			$wheres [] = "events_startdate>=?";
			$params [] = $data['events_startdate'];
		}

		if($data['events_enddate']){
			$wheres [] = "events_enddate<=?";
			$params [] = $data['events_enddate'];
		}

		if($data['events_type']){
			$wheres [] = "events_enddate=?";
			$params [] = $data['events_type'];
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
		$cabs = $CI->db->query('
			SELECT '. implode(', ', $selects) .'
			FROM cabs AS c
			'. implode("\n", $joins) .'
			'. $wheres .'
		', $params)->result_array();
		//pre($data);
		//pre($CI->db->last_query());exit;

        return $cabs;
	}

	public function getCalendarEvents($weeks)
	{				
		$futureWeeks = strtotime("+ ".$weeks." weeks");				
		$endDate = date("Y-m-d", $futureWeeks);
		$startDate = Date("Y-m-d");
		$res1 = $this->db->select('events.*,players.players_nickname',)->join('players','players_id=join_players_id')->where('events_date1 BETWEEN "'.$startDate.'" AND "'.$endDate.'"')->get($this->table)->result_array();
		$res2 = $this->db->select('events.*,players.players_nickname',)->join('players','players_id=join_players_id')->where('events_date2 BETWEEN "'.$startDate.'" AND "'.$endDate.'"')->get($this->table)->result_array();
		$res3 = $this->db->select('events.*,players.players_nickname',)->join('players','players_id=join_players_id')->where('events_date3 BETWEEN "'.$startDate.'" AND "'.$endDate.'"')->get($this->table)->result_array();		
		return [$res1,$res2,$res3];
	}
}
