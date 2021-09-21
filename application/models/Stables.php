<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stables extends CI_Model {
	var $stable = null;

	function __construct($stables_id = NULL){
		$this->data['player_id'] = $this->session->userdata('players_id');
		if($stables_id){
			$stable = $this->db->query("SELECT s.*, p.players_nickname FROM stables s LEFT JOIN players p ON p.players_id=s.join_players_id WHERE stables_id=?", array($stables_id))->row_array();
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
			$this->stable = $stable;
		}
	}


	function get($id){
		return $this->db->query("SELECT * FROM events WHERE stables_id=?", array($id))->row_array();
	}


	function get_package($id){
		$package = $this->db->query("SELECT * FROM stables_packages WHERE stables_packages_id=?", array($id))->row_array();
		$amenities = $this->db->query("SELECT spxa.*, a.* FROM stables_packages_x_amenities spxa LEFT JOIN amenities a ON a.amenities_id=spxa.join_amenities_id WHERE spxa.join_stables_packages_id=?", array($id))->result_array();
		foreach((array)$amenities AS $a){
			$package['amenities'][$a['join_amenities_id']] = $a;
		}
		unset($amenities);
		return $package;
	}

	function get_packages(){
		$packages = $this->db->query("SELECT sp.*, spxa.stables_packages_x_amenities_id, a.* FROM stables_packages sp LEFT JOIN stables_packages_x_amenities spxa ON spxa.join_stables_packages_id=stables_packages_id LEFT JOIN amenities a ON a.amenities_id=spxa.join_amenities_id ORDER BY sp.stables_packages_name ASC")->result_array();
		foreach((array)$packages AS $k => $v){
			$packages2[$v['stables_packages_id']] []= $v;
		}
		return $packages2;
	}

	function admin_delete_package($id){
		$this->db->query("DELETE FROM stables_packages_x_amenities WHERE join_stables_packages_id=?", array($id));
		$this->db->query("DELETE FROM stables_packages WHERE stables_packages_id=?", array($id));
		return $count;
	}

	function admin_update_package($id, $data){
		//validation

		$name_exists = $this->db->query("SELECT * FROM stables_packages WHERE stables_packages_name=? AND stables_packages_id!=?", array($data['stables_packages_name'], $id))->num_rows();

		if($name_exists){
			$errors['stables_packages_name'] = "There is already a package with that name!";
		}
		if(strlen(trim($data['stables_packages_name'])) < 4){
			$errors['stables_packages_name'] = "Please include a name at least 4 characters in length.";
		}
		if($data['stables_packages_cost'] < 0){
			$errors['stables_packages_cost'] = "Price cannot be less than 0.";
		}
		if($data['stables_packages_cost_usd'] < 0){
			$data['stables_packages_cost_usd'] = 0;
		}
		if($data['stables_packages_available'] < 0){
			$data['stables_packages_available'] = 0;
		}


		if(count($errors) > 0){
			return array('errors' => $errors);
		}

		$this->db->query("UPDATE stables_packages SET stables_packages_name=?, stables_packages_cost=?, stables_packages_description=?, stables_packages_cost_usd=?, stables_packages_available=? WHERE stables_packages_id=?", array($data['stables_packages_name'], $data['stables_packages_cost'], $data['stables_packages_description'], $data['stables_packages_cost_usd'], $data['stables_packages_available'], $id));

		return array('errors' => $errors, 'notice' => 'Package edited.');

	}


	function admin_add_package($data){
		//validation

		$name_exists = $this->db->query("SELECT * FROM stables_packages WHERE stables_packages_name=?", array($data['stables_packages_name']))->num_rows();

		if($name_exists){
			$errors['stables_packages_name'] = "There is already a package with that name!";
		}
		if(strlen(trim($data['stables_packages_name'])) < 4){
			$errors['stables_packages_name'] = "Please include a name at least 4 characters in length.";
		}
		if($data['stables_packages_cost'] < 0){
			$errors['stables_packages_cost'] = "Price cannot be less than 0.";
		}
		if($data['stables_packages_cost_usd'] < 0){
			$data['stables_packages_cost_usd'] = 0;
		}
		if($data['stables_packages_available'] < 0){
			$data['stables_packages_available'] = 0;
		}


		if(count($errors) > 0){
			return array('errors' => $errors);
		}

		$this->db->query("INSERT INTO stables_packages SET stables_packages_name=?, stables_packages_cost=?, stables_packages_description=?, stables_packages_cost_usd=?, stables_packages_available=?", array($data['stables_packages_name'], $data['stables_packages_cost'], $data['stables_packages_description'], $data['stables_packages_cost_usd'], $data['stables_packages_available']));
		$insert_id = $this->db->insert_id();

		return array('errors' => $errors, 'notice' => 'Package created.', 'stables_packages_id' => $insert_id);

	}

	function admin_update_package_amenities($id, $data){
		//validation

		//pre($data);exit;
		$a = count($data['amenities_id']);
		for($i=0; $i<$a; $i++){
			if($data['stables_packages_x_amenities_quantity'][$i] >= 1){
				$insert_batch []= array(
						'join_stables_packages_id' => $id,
						'join_amenities_id' => $data['amenities_id'][$i],
						'stables_packages_x_amenities_quantity' => $data['stables_packages_x_amenities_quantity'][$i],
					);
			}
		}
		//pre($insert_batch);exit;

		if(count($errors) > 0){
			return array('errors' => $errors);
		}


		$this->db->query("DELETE FROM stables_packages_x_amenities WHERE join_stables_packages_id=?", $id);

		//normalize data and insert it
		if(count($insert_batch) > 0){
			$this->db->insert_batch('stables_packages_x_amenities', $insert_batch);
		}
		return array('errors' => $errors, 'notice' => 'Package amenities edited.');

	}





	function get_amenities(){
		return $this->db->query("SELECT * FROM amenities")->result_array();
	}

	function get_amenity($id){
		return $this->db->query("SELECT * FROM amenities WHERE amenities_id=?", array($id))->row_array();
	}

	function count_amenities($id){
		return $this->db->query("SELECT * FROM stables_x_amenities WHERE join_amenities_id=?", array($id))->num_rows();
	}

	function admin_delete_amenity($id){
		$this->db->query("DELETE FROM stables_x_amenities WHERE join_amenities_id=?", array($id));
		$count = $this->db->affected_rows();
		$this->db->query("DELETE FROM stables_packages_x_amenities WHERE join_amenities_id=?", array($id));
		$this->db->query("DELETE FROM amenities WHERE amenities_id=?", array($id));
		//$count += $this->db->affected_rows();
		return $count;
	}


	function admin_update_amenity($id, $data){
		//validation

		if(strlen(trim($data['amenities_name'])) < 4){
			$errors['amenities_name'] = "Please include a name at least 4 characters in length.";
		}
		if($data['amenities_cost'] < 1){
			$errors['amenities_cost'] = "Please include a cost for this amenity.";
		}
		if(!in_array($data['amenities_type'], array('Building','Course','Land','Stall','Paddock','Miscellaneous'))){
			$errors['amenities_type'] = "Invalid type.";
		}
		if($data['amenities_type'] == "Building" AND $data['amenities_acres'] <= 0){
			$errors['amenities_acres'] = "All buildings take up some land. Please enter a new acreage value.";
		}
		if($data['amenities_type'] == "Paddock" AND $data['amenities_acres'] <= 0){
			$errors['amenities_acres'] = "All paddocks fence in existing land. Please enter a new acreage value.";
		}
		if($data['amenities_type'] == "Course" AND $data['amenities_acres'] <= 0){
			$errors['amenities_acres'] = "All courses take up some land. Please enter a new acreage value.";
		}
		if($data['amenities_type'] == "Land" AND $data['amenities_acres'] <= 0){
			$errors['amenities_acres'] = "Please enter an acreage value.";
		}


		if(count($errors) > 0){
			return array('errors' => $errors);
		}

		$this->db->query("UPDATE amenities SET amenities_name=?, amenities_cost=?, amenities_description=?, amenities_picture=?, amenities_type=?, amenities_acres=?, amenities_stalls=?, amenities_limit=? WHERE amenities_id=?", array($data['amenities_name'], $data['amenities_cost'], $data['amenities_description'], $data['amenities_picture'], $data['amenities_type'], $data['amenities_acres'], $data['amenities_stalls'], $data['amenities_limit'], $id));

		return array('errors' => $errors, 'notice' => 'Amenity edited.');

	}

	function admin_add_amenity($data){
		//validation

		if(strlen(trim($data['amenities_name'])) < 4){
			$errors['amenities_name'] = "Please include a name at least 4 characters in length.";
		}
		if($data['amenities_cost'] < 1){
			$errors['amenities_cost'] = "Please include a cost for this amenity.";
		}
		if(!in_array($data['amenities_type'], array('Building','Course','Land','Stall','Paddock','Miscellaneous'))){
			$errors['amenities_type'] = "Invalid type.";
		}
		if($data['amenities_type'] == "Building" AND $data['amenities_acres'] <= 0){
			$errors['amenities_acres'] = "All buildings take up some land. Please enter a new acreage value.";
		}
		if($data['amenities_type'] == "Paddock" AND $data['amenities_acres'] <= 0){
			$errors['amenities_acres'] = "All paddocks fence in existing land. Please enter a new acreage value.";
		}
		if($data['amenities_type'] == "Course" AND $data['amenities_acres'] <= 0){
			$errors['amenities_acres'] = "All courses take up some land. Please enter a new acreage value.";
		}
		if($data['amenities_type'] == "Land" AND $data['amenities_acres'] <= 0){
			$errors['amenities_acres'] = "Please enter an acreage value.";
		}

		$data['amenities_picture'] = strip_tags($data['amenities_picture']);


		if(count($errors) > 0){
			return array('errors' => $errors);
		}

		$this->db->query("INSERT INTO amenities(amenities_name, amenities_cost, amenities_description, amenities_picture, amenities_type, amenities_acres, amenities_stalls, amenities_limit) VALUES(?, ?, ?, ?, ?, ?, ?, ?)", array($data['amenities_name'], $data['amenities_cost'], $data['amenities_description'], $data['amenities_picture'], $data['amenities_type'], $data['amenities_acres'], $data['amenities_stalls'], $data['amenities_limit']));
		$insert_id = $this->db->insert_id();

		return array('errors' => $errors, 'notice' => 'Amenity added.', 'amenities_id' => $insert_id);

	}





	public static function admin_get_pending(){
		$CI =& get_instance();
		return $CI->db->query("SELECT stables_orders_id FROM stables_orders WHERE stables_orders_pending=1")->result_array();
	}

	public static function admin_delete_class($data){
		$CI =& get_instance();
		$CI->db->query("DELETE FROM classlists_classes WHERE classlists_classes_id=? LIMIT 1", $data);
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
			$errors['classlists_classes_description'] = "Please include a name.";
		}
		$data['classlists_classes_strenuous'] = $data['classlists_classes_strenuous'] ? '1' : '0';
		if($data['classlists_classes_min_age'] < 0 || $data['classlists_classes_min_age'] > $data['classlists_classes_max_age']){
			$errors['classlists_classes_min_age'] = "Invalid age.";
		}
		if($data['classlists_classes_max_age'] < 0 || $data['classlists_classes_max_age'] < $data['classlists_classes_min_age']){
			$errors['classlists_classes_max_age'] = "Invalid age.";
		}
		if($data['classlists_classes_fee'] < 0){
			$errors['classlists_classes_fee'] = "Invalid fee.";
		}
		if($data['join_divisions_id'] AND !array_key_exists($data['join_divisions_id'], $divisions)){
			$errors['join_divisions_id'] = "Invalid division.";
		}

		foreach((array)$data['classlists_classes_disciplines'] AS $d){
			if(!in_array($d, $disciplines)){
				$errors['classlists_classes_disciplines'] = "Invalid discipline.";
			}
		}
		foreach((array)$data['classlists_classes_breeds_types'] AS $d){
			if(!in_array($d, $breeds_types)){
				$errors['classlists_classes_breeds_types'] = "Invalid type.";
			}
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
		if($data['stables_id']){
			$wheres [] = "e.stables_id=?";
			$params [] = $data['stables_id'];
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

}
