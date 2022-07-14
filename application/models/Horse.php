<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Horse extends CI_Model {
	var $horse = null;

	function __construct($horse_id = null){
		parent::__construct();
		$CI =& get_instance();
		$CI->data['player_id'] = $this->session->userdata('players_id');
		if($horse_id){
			$this->horse = $this->db->query('SELECT
				h.*, s.stables_name, sire.horses_name AS horses_sire_name, dam.horses_name AS horses_dam_name
				FROM horses h				
				LEFT JOIN stables s ON s.stables_id=h.join_stables_id
				LEFT JOIN horses sire ON sire.horses_id=h.horses_sire
				LEFT JOIN horses dam ON dam.horses_id=h.horses_dam
				WHERE h.horses_id = ? LIMIT 1
			', array($horse_id))->row_array();

			//pre($horse_id);

			$this->horse['ownership_log'] = $this->db->query('SELECT * FROM horse_records  WHERE join_horses_id=? AND horse_records_type="Owner" ORDER BY horse_records_id DESC', array($horse_id))->result_array();

			$this->horse['care_records'] = $this->db->query('
					SELECT hr.*, DATE_FORMAT(hr.horse_records_date, "%Y-%m-%d") AS horse_records_date
					FROM horse_records hr					
					WHERE hr.join_horses_id=? AND (hr.horse_records_type="Vet" OR hr.horse_records_type="Farrier")
					ORDER BY hr.horse_records_id DESC
				', array($horse_id))->result_array();

			$this->horse['event_records'] = $this->db->query('
					SELECT hr.*, DATE_FORMAT(hr.horse_records_date, "%Y-%m-%d") AS horse_records_date
					FROM horse_records hr					
					WHERE hr.join_horses_id=? AND (hr.horse_records_type="Show"  OR hr.horse_records_type="WEGs" OR hr.horse_records_type="Olympic" OR hr.horse_records_type="Race" OR hr.horse_records_type="Event")
					ORDER BY hr.horse_records_id DESC
				', array($horse_id))->result_array();

			unset($normalized);
			$disciplines = $this->db->query('
					SELECT disciplines_name FROM horses_x_disciplines WHERE join_horses_id=? ORDER BY disciplines_name ASC
				', array($horse_id))->result_array();
				foreach($breeds AS $k => $v){
					$normalized[$k] = $v['disciplines_name'];
				}
			$this->horse['disciplines'] = $disciplines;
			unset($normalized, $disciplines);


			$this->horse['progeny'] = $this->db->query('SELECT * FROM horses WHERE (horses_sire=? OR horses_dam=?) ORDER BY horses_name ASC', array($horse_id, $horse_id))->result_array();
			//pre($this->db->last_query());
			if($this->horse['horses_sire'] != 0){
				$this->horse['siblings_sire'] = $this->db->query('SELECT * FROM horses WHERE horses_id!=0 AND horses_sire=? ORDER BY horses_name ASC', array($this->horse['horses_sire']))->result_array();
			}
			if($this->horse['horses_dam'] != 0){
				$this->horse['siblings_dam'] = $this->db->query('SELECT * FROM horses WHERE horses_id!=0 AND horses_dam=? ORDER BY horses_name ASC', array($this->horse['horses_dam']))->result_array();
			}

			//$genes = $this->db->query('SELECT hxg.*, g.genes_name FROM horses_x_genes hxg RIGHT JOIN genes g ON g.genes_id=hxg.join_genes_id AND hxg.join_horses_id=? ORDER BY g.genes_name ASC', array($horse_id))->result_array();

			$genes = $this->db->query('SELECT hxg.*, g.genes_name, g.genes_id AS join_genes_id, g.genes_code3 FROM genes g LEFT JOIN horses_x_genes hxg ON hxg.join_genes_id=g.genes_id AND hxg.join_horses_id=? ORDER BY g.genes_name ASC', array($horse_id))->result_array();
			foreach($genes AS $k => $v){
				$normalized[$v['join_genes_id']] = $v;
			}
			$this->horse['genes'] = $normalized;
			unset($normalized, $genes);
			//pre($this->db->last_query());
		}
		$this->column_search=['horses_id','horses_name','horses_birthyear','horses_gender','horses_color','horses_pattern','horses_breed','horses_points','horses_competition_title','horses_breeding_title','horses_level'];
		$this->column_order=['horses_id','horses_name','horses_birthyear','horses_gender','horses_color','horses_pattern','horses_breed','horses_points','horses_competition_title','horses_breeding_title','horses_level'];
		$this->order = ['horses_id' => 'desc'];
	}


	public static function getBirthYear($horses_id)
	{		
		$CI =& get_instance();
		$r = $CI->db->query('SELECT horses_birthyear FROM horses where horses_id = ? LIMIT 1', array($horses_id))->row_array();
		return $r ? $r['horses_birthyear'] : false;
	}

	public static function get_blueprint_possibilities($horse, $cat = null, $genes = null, $blueprints = null){
		$CI =& get_instance();
		//get all blueprints based on the genetic code passed in. return array of categories + possibilities
		//first, normalize genes by categories
		if(!$genes){
			$genes = self::get_genes();
		}
		if(!$blueprints){
			$blueprints = self::get_blueprints();
		}
		//pre($horse);

		foreach((array)$horse AS $i => $h){
			if(!is_array($h)){
			//	echo "<b>we made it<br></b>";
				$horse2[$i]['horses_x_genes_value'] = $h;
				$horse2[$i]['join_genes_categories_name'] = $cat;
				$horse2[$i]['join_genes_id'] = $i;
			}else{
			}
		}
		//pre($horse2);//exit;
		if($horse2){
			$horse = $horse2;
		}
		//pre($horse);

		foreach((array)$genes AS $g){
			$cats[$g['join_genes_categories_name']]['genes'] []= $g;
		}
		foreach((array)$blueprints AS $b){
			$blueprints_by_cats[$b['join_genes_categories_name']] []= $b;
		}

		/*foreach((array)$horse AS $gene_id => $code){
			foreach($)
		}*/
		unset($possibilities);

		//now the blueprints
		foreach((array)$cats AS $i => $c){
			//pre($blueprints_by_cats[$i]);
			foreach((array)$blueprints_by_cats[$i] AS $b){
				//pre($b);
				foreach((array)$b['genes'] AS $id => $check_genes){
					if(!$horse[$id]['horses_x_genes_value']){
						$horse[$id]['horses_x_genes_value'] = $horse[$id]['genes_code3'];
					}
					//pre($check_genes);
					//pre($horse[$id]);
					//pre($b);exit;
					//pre($horse[$id]['horses_x_genes_value']);
					//pre($check_genes['values']);
					//echo "<hr>";

					if(in_array($horse[$id]['horses_x_genes_value'], $check_genes['values'])){
						$possibilities[$i][$b['genes_blueprints_id']] = $b;
					}else{
						unset($possibilities[$i][$b['genes_blueprints_id']]);
						break 1;
					}
				}
			}
		}
		//pre($possibilities);//exit;
		//echo "<hr>";
		return $possibilities;
	}

	public static function get_foal_genetic_possibilities($horse1, $horse2){
		$genes = self::get_genes();
		$blueprints = self::get_blueprints();
		//pre($blueprints);exit;
		//pre($genes);

		foreach((array)$genes AS $i => $g){
			$cats[$g['join_genes_categories_name']] = $g['join_genes_categories_name'];
		}

		foreach((array)$genes AS $i => $g){
			if(!$horse1[$i]['horses_x_genes_value']){
				$horse1[$i]['horses_x_genes_value'] = $g['genes_code3'];
			}
			if(!$horse2[$i]['horses_x_genes_value']){
				$horse2[$i]['horses_x_genes_value'] = $g['genes_code3'];
			}

			if($horse1[$i]['horses_x_genes_value'] == $horse2[$i]['horses_x_genes_value']){
				if($horse1[$i]['horses_x_genes_value'] == $g['genes_code1']){
					//$foal['genes'][$i]['possibility1_percent'] = 100;
					$paws[$g['join_genes_categories_name']][$i] = array($horse2[$i]['horses_x_genes_value']);
				}elseif($horse1[$i]['horses_x_genes_value'] == $g['genes_code2']){
					//$foal['genes'][$i]['possibility2_percent'] = 100;
					$paws[$g['join_genes_categories_name']][$i] = array($g['genes_code1'], $g['genes_code2'], $g['genes_code3']);
				}else{
					//$foal['genes'][$i]['possibility3_percent'] = 100;
					$paws[$g['join_genes_categories_name']][$i] = array($horse2[$i]['horses_x_genes_value']);
				}
			}else{
				//if($horse1[$i])
				if($horse1[$i]['horses_x_genes_value'] == $g['genes_code1'] AND $horse2[$i]['horses_x_genes_value'] == $g['genes_code2']){
					/*$foal['genes'][$i]['possibility1_percent'] = 50;
					$foal['genes'][$i]['possibility2_percent'] = 50;*/
					$paws[$g['join_genes_categories_name']][$i] = array($g['genes_code1'], $g['genes_code2']);
				}elseif($horse1[$i]['horses_x_genes_value'] == $g['genes_code1'] AND $horse2[$i]['horses_x_genes_value'] == $g['genes_code3']){
					/*$foal['genes'][$i]['possibility2_percent'] = 100;*/
					$paws[$g['join_genes_categories_name']][$i] = array($g['genes_code2']);

				}elseif($horse1[$i]['horses_x_genes_value'] == $g['genes_code2'] AND $horse2[$i]['horses_x_genes_value'] == $g['genes_code1']){
					/*$foal['genes'][$i]['possibility1_percent'] = 50;
					$foal['genes'][$i]['possibility2_percent'] = 50;*/
					$paws[$g['join_genes_categories_name']][$i] = array($g['genes_code1'], $g['genes_code2']);

				}elseif($horse1[$i]['horses_x_genes_value'] == $g['genes_code2'] AND ($horse2[$i]['horses_x_genes_value'] == $g['genes_code3'] || !$horse2[$i]['horses_x_genes_value'])){
					/*$foal['genes'][$i]['possibility2_percent'] = 50;
					$foal['genes'][$i]['possibility3_percent'] = 50;*/
					$paws[$g['join_genes_categories_name']][$i] = array($g['genes_code2'], $g['genes_code3']);

				}elseif($horse1[$i]['horses_x_genes_value'] == $g['genes_code3'] AND $horse2[$i]['horses_x_genes_value'] == $g['genes_code1']){
					/*$foal['genes'][$i]['possibility2_percent'] = 100;*/
					$paws[$g['join_genes_categories_name']][$i] = array($g['genes_code3']);

				}elseif($horse1[$i]['horses_x_genes_value'] == $g['genes_code3'] AND $horse2[$i]['horses_x_genes_value'] == $g['genes_code2']){
					/*$foal['genes'][$i]['possibility2_percent'] = 50;
					$foal['genes'][$i]['possibility3_percent'] = 50;*/
					$paws[$g['join_genes_categories_name']][$i] = array($g['genes_code2'], $g['genes_code3']);

				}else{
					/*$foal['genes'][$i]['possibility3_percent'] = 100;*/
					$paws[$g['join_genes_categories_name']][$i] = array($g['genes_code3']);
				}
			}
		}

		//pre($blueprints);exit;

		//pre($paws);

/*
//this works. but need more.
		foreach((array)$paws AS $cat => $v){
			$combos[$cat] = self::multi_dimensional_combinations($v);

			foreach((array)$combos[$cat] AS $key => $value){
				//pre($value);
				//pre($key);exit;
				//pre($blueprints);
				foreach((array)$blueprints AS $bk => $print){
				//	pre($bk);
//pre($combos);exit;
					if($cat != $print['join_genes_categories_name']){
						//pre($cat); pre($bk);
						continue;
					}

					$gene_flag = 0;
					//if(!in_array($value[]))


					foreach((array)$print['genes'] AS $g => $gene){
						$gene_flag = 0;
						if($print['genes_blueprints_name'] == "Buckskin"){
						}
						if(!in_array($value[$g], $gene['values'])){
							unset($blueprints_available[$cat][$bk]);
							continue;
						}
						$gene_flag = 1;
					}
					if($gene_flag == 1){
						$blueprints_available[$cat][$bk] = $print['genes_blueprints_name'];
					}
				}
			}
		}*/
		//pre($combos);//exit;


		foreach((array)$paws AS $cat => $v){
		//	pre($v);
			$combos2[$cat] = self::multi_dimensional_combinations($v);
		}
		//pre($combos2);exit;
		foreach((array)$combos2 AS $cat => $prints){
			foreach((array)$prints AS $i => $print){
				//pre($print);
				$final_combos []= self::get_blueprint_possibilities($print, $cat, $genes, $blueprints);
				//pre($final_combos);exit;
			}
		}
		//exit;
		//pre($final_combos);exit;
		//clean up the final combos so we can make dropdowns!
		foreach((array)$final_combos AS $fc){
			foreach((array)$fc AS $cat => $id){
				foreach((array)$id AS $b){
					//pre($b);
					$bp[$cat][$b['genes_blueprints_id']] = $b['genes_blueprints_name'];
				}
			}
		}

		//pre($bp);exit;


		//exit;
		$foal = $paws;
		$foal['blueprints_available'] = $bp;

		return $foal;
	}

	public static function multi_dimensional_combinations($data) {
	    $blueprints = array();
	    $count = 0;
	    $gene_count = count($data);
	    $index = array_fill(0, $gene_count, 0);
	    $lens = array();
	    $keys = array();
	    foreach((array)$data AS $gene => $pairs){
	        $lens[] = count($pairs);
	        $keys[] = $gene;
	    }

	    while ($index[0] < count($data[$keys[0]])) {
	        unset($temp_var);
	        for($i = 0; $i < $gene_count; $i++) {
	            $temp_var[$keys[$i]] = $data[$keys[$i]][$index[$i]];
	        }
	        $blueprints []= $temp_var;
	        for($j = $gene_count-1; $j >= 0; $j--) {
	            if (++$index[$j] >= $lens[$j]) {
	                if ($j == 0) {
	                    break;
	                }
	                $index[$j] = 0;
	            } else {
	                break;
	            }
	        }
	    }
	    return $blueprints;
	}

	public static function get_blueprint_possibilities_offspring($sire, $dam){
		//pre($sire);
		//pre($dam);exit;
		//$sire = self::get_blueprint_possibilities($sire);
		//$dam = self::get_blueprint_possibilities($dam);
		$foal = self::get_foal_genetic_possibilities($sire, $dam);
		//$possibilities = array_merge($sire, $dam);
		//pre($possibilities);exit;
		return $foal;
	}

	public static function update($player, $horse, $data, $allowed){
		
		//allowed is the list of each breed, color, etc. that is allowed as an option
		$CI =& get_instance();
		// if player is regular player, only allow update of breeding fee & sale.

		$data['players_nickname'] = new Player($horse['join_players_id']);		
		$data['players_nickname'] = $data['players_nickname']->player['players_nickname'];		
		$data['horses_sale_price'] = preg_replace("/[^0-9.]/", "", $data['horses_sale_price']);						
		$data['horses_breeding_fee'] = preg_replace("/[^0-9.]/", "", $data['horses_breeding_fee']);
		$data['horses_sale'] = 0;
		if((int)$data['horses_sale_price'] > 0)
		{
			$data['horses_sale'] = 1;
		}
		if($player['privileges']['privileges_horses']){ //admin can update everything else
			$allowed_fields = array(
				'horses_name',
				'horses_breed',
				'horses_birthyear',
				'horses_gender',
				'horses_color',
				//'horses_pattern',
				//'horses_breed',
				'horses_breed2',
				'horses_line',
				'horses_sire',
				'horses_dam',
				'horses_sale',
				'horses_created',
				'horses_adoptable',
				'horses_deceased',
				'horses_notes',
				'horses_breeding_fee',
				'horses_sale_price',				
				'horses_registration_type',
				'players_nickname',
				'join_stables_id'
			);

			
			//check if horse name is unique
			$name_exists = $CI->db->query("SELECT horses_id FROM horses WHERE horses_name=? AND horses_id!=? LIMIT 1", array($data['horses_name'], $data['horses_id']))->row_array();
			if($name_exists){
				$errors['horses_name'] = "That horse name is already in use.";
			}

			//check if horse name is restricted
			$restricted = $CI->db->query("SELECT restricted_name FROM restricted WHERE restricted_name LIKE ? LIMIT 1", array($data['horses_name']))->row_array();
			if($restricted){
				$errors['horses_name'] = "That horse name is restricted.";
			}
			$check = in_array($data['horses_breed'], $allowed['breeds']);
			if(!$check){
				$errors['horses_breed'] = "Invalid breed.";
			}
			/*$check = in_array($data['horses_color'], $allowed['base_colors']);
			if(!$check){
				$errors['horses_color'] = "Invalid base color.";
			}
			$check = in_array($data['horses_pattern'], $allowed['base_patterns']);
			if(!$check){
				$errors['horses_pattern'] = "Invalid base pattern.";
			}*/
			$check = in_array($data['horses_line'], $allowed['lines']);
			if(!$check AND $horse['horses_line']){
				$errors['horses_line'] = "Invalid line.";
			}
			$check = in_array($data['horses_gender'], array('Stallion', 'Mare', 'Gelding'));
			if(!$check){
				$errors['horses_gender'] = "Invalid gender.";
			}
			if(!$data['horses_birthyear']){
				$errors['horses_birthyear'] = "Birth year is required.";
			}
			if($data['horses_breeding_fee'] < 0){
				$data['horses_breeding_fee'] = 0;
			}
			if($data['horses_sale']==1 && empty($data['horses_sale_price']))
			{
				$errors['horses_sale_price'] = "Please Enter a Sale Price.";
			}
			if($data['horses_birthyear'] > date('Y') || $data['horses_birthyear'] < "1950"){
				$errors['horses_birthyear'] = "Invalid birth year.";
			}
			
			if(!$data['horses_name']){
				$errors['horses_name'] = "Name is required.";
			}			
			/*  */
			$sire = self::getHorseById($data['horses_sire'],true);
			$dam = self::getHorseById($data['horses_dam'],true);
			if($data['horses_registration_type']=="breed" && empty($data['horses_sire']) || $data['horses_registration_type']=="breed" && !ctype_digit($data['horses_sire']))
			{
				$errors['horses_sire'] = "Sire is required.";
			}elseif($data['horses_registration_type']=="breed" && !$sire || $data['horses_registration_type']=="breed" && $sire['horses_gender'] != 'Stallion')
			{								
				$errors['horses_sire'] = "This Sire Doesn't exist.";
			}elseif($data['horses_registration_type'] == "creation" && $sire['horses_gender'] == "Gelding")
			{
				$errors['horses_sire'] = "Gelding Horse does not make Sire Please Provide Valid Sire Horse Entity.";
			}elseif($data['horses_registration_type']=="breed" && self::getBirthYear($data['horses_sire']) == $data['horses_birthyear'])
			{
				$errors['horses_sire']="Foal Birth Year Matched with Sire birth year.";
			}elseif($data['horses_registration_type']=="breed" && $data['horses_birthyear'] < self::getBirthYear($data['horses_sire']))
			{
				$errors['horses_sire']="Foal birth year is not greather than his Sire.";
			}

			if($data['horses_registration_type']=="breed" && empty($data['horses_dam']) ||  $data['horses_registration_type']=="breed" && !ctype_digit($data['horses_dam']))
			{
				$errors['horses_dam'] = "Dam is required.";
			}elseif($data['horses_registration_type']=="breed" && !$dam || $data['horses_registration_type']=="breed" && $dam['horses_gender'] != 'Mare')
			{
				$errors['horses_dam'] = "This Dam Doesn't exist.";
			}elseif($data['horses_registration_type']=="breed" && self::getBirthYear($data['horses_dam']) == $data['horses_birthyear'])
			{
				$errors['horses_dam']="Foal Birth Year Matched with Dam birth year.";
			}elseif($data['horses_registration_type']=="breed" && $data['horses_birthyear'] < self::getBirthYear($data['horses_dam']))
			{
				$errors['horses_dam']="Foal Birth Year is not greather than his Dam.";
			}elseif($data['horses_registration_type']=="breed" && !empty($data['horses_dam']))
			{
				$horse_id = $horse['horses_id'];
				$year_exists = $CI->db->query("SELECT horses_id FROM horses WHERE  horses_birthyear = ? AND horses_dam = ? AND horses_id != ? LIMIT 1", array($data['horses_birthyear'],$data['horses_dam'],$horse_id))->row_array();
				if($year_exists){
					$errors['horses_dam'] = "The Mare has a foal born that year.";
				}
			}
			if($data['horses_gender']=="Stallion" && !empty($data['horses_sire']))
			{
				$birthDate = "01/01/".self::getBirthYear($data['horses_sire']);
				$birthDate = explode("/", $birthDate);
				$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md") ? ((date("Y") - $birthDate[2]) - 1) : (date("Y") - $birthDate[2]));
				if($age < 3 || $age > 29)
				{
					$errors['horses_sire']="There is a Gender issue or that the horse is too young/old";
				}
			}			
			if($data['horses_gender']=="Mare" && !empty($data['horses_dam']))
			{
				$birthDate = "01/01/".self::getBirthYear($data['horses_dam']);
				$birthDate = explode("/", $birthDate);
				$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md") ? ((date("Y") - $birthDate[2]) - 1) : (date("Y") - $birthDate[2]));
				if($age < 3 || $age > 25)
				{
					$errors['horses_dam']="There is a gender issue or that the horse is too young/old.";
				}
			}
		/*  */
    	if( !empty($horse['horses_breed'])  && !empty($horse['horses_sire']) && !empty($horse['horses_dam']) )
			{		
			
				$horses_breed = $CI->db->query("SELECT breed_id FROM breeds WHERE breed_name= ?  LIMIT 1", array($horse['horses_breed']))->row_array();	
			
				$hold=[];	
				$sire_breed = $CI->db->query("SELECT horses_breed FROM horses WHERE horses_id= ?  LIMIT 1", array($horse['horses_sire']))->row_array();	
			
				if($sire_breed){
				array_push($hold,$sire_breed['horses_breed']);
				}
				$dam_breed = $CI->db->query("SELECT horses_breed FROM horses WHERE horses_id= ?  LIMIT 1", array($horse['horses_dam']))->row_array();	
			
				if($dam_breed){
				array_push($hold,$dam_breed['horses_breed']);
				}
				
				if( !in_array($horse['horses_breed'],$hold) ){ 
				$errors['horses_breed'] = "Breed must match with sire or dam.";
				}
			}
		/* if($data['horses_sale'] != 1 AND $data['horses_sale2'] > 0){
				$data['horses_sale'] = $data['horses_sale2'];
			}else{
				$data['horses_sale'] = 0;
			} */
			
		}elseif($player['players_id'] == $horse['join_players_id']){						
			if($data['horses_sale']==1 && empty($data['horses_sale_price']) || $data['horses_sale']==1 && !$data['horses_sale_price'] > 0)
			{
				$errors['horses_sale_price'] = "Please Enter a Sale Price.";
			}
			$allowed_fields = array(
				'horses_sale',
				'horses_breeding_fee',
				'horses_sale_price',
				'horses_adoptable',
				'horses_deceased',
				'players_nickname',
				'join_stables_id'
			);
		}else{
			$errors['horses_name'] = "You do not own this horse.";
		}

		if($horse['horses_deceased']){			
			$data['horses_sale'] = 0;
			$data['horses_deceased'] = 1;
		}		
		// if horse is for auction, error
		$auctioned = $CI->db->query("SELECT join_horses_id FROM auctions WHERE join_horses_id=? AND auctions_end>=NOW()", array($horse['horses_id']))->num_rows();
		if($auctioned >= 1 AND $data['horses_sale'] > 0){
			$errors['horses_sale'] = "Horse is listed for auction and may not be put up for sale.";
		}

		$update_data = filter_keys($data, $allowed_fields);
		if(count($errors) > 0){
			return array('errors' => $errors);
		}

		//update horse
		$CI->db->update('horses', $update_data, "horses_id = " . $horse['horses_id']);

		//insert disciplines
		/*if(count($horse['disciplines'])){
			$disc = self::change_disciplines($horse_id, $horse['disciplines']);
			if($disc !== true){
				$CI->db->query("DELETE FROM horses WHERE horses_id=?", array($horse_id));
				return array('errors' => $disc['errors']);
			}
		}*/


		$CI->session->set_flashdata('notice', "Record updated.");

		return array('errors' => $errors, 'notices' => $notices, 'horse_id' => $horse_id);
	}



	public static function update_genes($player, $horse, $data, $genes){
		$CI =& get_instance();

		if(!$player['privileges']['privileges_horses']){
			$CI->session->set_flashdata('notice', "You do not have permission to edit that.");
			redirect('horses/update/' . $horse['horses_id']);
		}
		if(!$data['genes']){}

		$CI->db->query("DELETE FROM horses_x_genes WHERE join_horses_id=?", array($horse['horses_id']));

//pre($data);exit;

		//add new genes
		foreach((array)$data['genes'] AS $k => $v){
			if(!$genes[$k]){
				continue;
			}
			$insert []= "(?, ?, ?)";
			$values []= $horse['horses_id'];
			$values []= $k;
			$values []= $v;
		}

		if(empty($insert)){
			return array('errors' => 'Invalid genetic sequence.');
		}

		$CI->db->query("INSERT INTO horses_x_genes(join_horses_id, join_genes_id, horses_x_genes_value) VALUES ".implode(',', $insert), $values);

		// call function to set horse's color & pattern
		self::update_gene_names($player, $data, $horse['horses_id']);

		return array('errors' => $errors, 'notices' => $notices, 'horse_id' => $horse['horses_id']);
	}

	public static function update_gene_names($player, $horse, $horse_id){
		$CI =& get_instance();
		//force a blueprint based upon the values of the genes (in the case of manual editing of genes on a horse's profile)

		if(!$player['privileges']['privileges_horses']){
			$CI->session->set_flashdata('notice', "You do not have permission to edit that.");
			redirect('horses/update/' . $horse_id);
		}

		$blueprints = self::get_blueprint_possibilities($horse['genes']);
		//pre($blueprints);exit;
		foreach((array)$blueprints AS $cat => $prints){
				$possibilities[$cat] = "Undocumented";
			foreach((array)$prints AS $print){
				if($print['genes_blueprints_name'] != "Undocumented"){
					$possibilities[$cat] = $print['genes_blueprints_name'];
				}
			}
		}

		$CI->db->query("UPDATE horses SET horses_color=?, horses_pattern=? WHERE horses_id=?", array($possibilities['Color'], $possibilities['Pattern'], $horse_id));
	}



	public static function adopt($player, $horse, $payment){
		$CI =& get_instance();
		$EXPORT_ID = EXPORT_ID;
		$HUMANE_ID = HUMANE_ID;
		$RETIRE_ID = RETIRE_ID;
		$CEMETERY_ID = CEMETERY_ID;

		if(HUMANE_ID != $horse['join_players_id']){
			$errors []= "This horse isn't owned by the Humane Society.";
		}
		if(!$horse['horses_adoptable']){
			$errors []= "Horse isn't available for adoption.";
		}

		//check if player has enough adoption/creation credits
		if($payment == "ac"){
			// 1 adoption credit
			$cost = 1;
			$sql = "players_credits_adoptathon=players_credits_adoptathon-".$cost;
			if($player['players_credits_adoptathon'] < $cost){
				$errors []= "You do not have enough adoption credits.";
			}
		}else{
			// 1/3 creation credit
			$cost = 0.3;
			$sql = 'players_credits_creation=players_credits_creation-'.$cost;
			if($player['players_credits_creation'] < $cost){
				$errors []= "You do not have enough creation credits.";
			}
		}


		$data['join_players_id'] = $player['players_id'];
		$data['players_nickname'] = $player['players_nickname'];
		$data['horses_adoptable'] = 0;
		$update_data = filter_keys($data, array(
				'join_players_id',
				'horses_adoptable',
		));

		if(count($errors) > 0){
			return array('errors' => $errors);
		}

		//update horse
		$CI->db->update('horses', $update_data, "horses_id = " . $horse['horses_id']);
		$CI->db->query("UPDATE players SET " .$sql . " WHERE players_id=? LIMIT 1", array($player['players_id']));
		$CI->db->query('INSERT INTO horse_records(join_horses_id, join_players_id, horse_records_type, owner_name) VALUES(?, ?, "Owner", ?)', array($horse['horses_id'], $player['players_id'], @$player['players_nickname']));
		$message = "<a href='/horses/view/" . $horse['horses_id'] . "'>". $horse['horses_competition_title'] . " " . $horse['horses_breeding_title'] . " " . $horse['horses_name'] . " #" . $horse['horses_id'] . "</a> has been adopted.";
		$CI->db->query("INSERT INTO notices(join_players_id, notices_body) VALUES(?, ?)", array($player['players_id'], $message));

		$CI->session->set_flashdata('notice', "Horse adopted.");

		return array('errors' => $errors, 'notices' => $notices, 'horse_id' => $horse_id);

	}

	public static function transfer($player, $horse, $data){
		$CI =& get_instance();
		$EXPORT_ID = EXPORT_ID;
		$HUMANE_ID = HUMANE_ID;
		$RETIRE_ID = RETIRE_ID;
		$CEMETERY_ID = CEMETERY_ID;
		$data['horses_sale'] = 0;
		$data['horses_sale_price'] = 0;
		if($player['players_id'] != $horse['join_players_id']){
			$errors['recipient'] = "You do not own this horse.";
		}

		if($data['players_id'] == $horse['join_players_id']){
			$errors['recipient'] = "You cannot send a horse to yourself.";
		}		
		if($data['recipient'] == "Member"){
			$data['join_players_id'] = $data['players_id'];
			$data['players_nickname'] = new Player($data['join_players_id']);
			$data['players_nickname'] = $data['players_nickname']->player['players_nickname'];
			$data['horses_adoptable'] = 0;
			$update_data = filter_keys($data, array(
					'join_players_id',
					'horses_adoptable',
					'horses_sale',
					'horses_sale_price',
			));
			if(!$data['join_players_id']){
				$errors['players_id'] = "Invalid member.";
			}
		}elseif($data['recipient'] == "Humane Society"){
			$data['join_players_id'] = $HUMANE_ID;
			$data['players_nickname'] = new Player($data['join_players_id']);
			$data['players_nickname'] = $data['players_nickname']->player['players_nickname'];
			$data['horses_adoptable'] = 1;
			$update_data = filter_keys($data, array(
					'join_players_id',
					'horses_adoptable',
					'horses_sale',
					'horses_sale_price',
					'players_nickname'
			));
		}elseif($data['recipient'] == "Retirement Home"){
			$data['join_players_id'] = $REITRE_ID;
			$data['players_nickname'] = new Player($data['join_players_id']);
			$data['players_nickname'] = $data['players_nickname']->player['players_nickname'];
			$data['horses_adoptable'] = 0;
			$update_data = filter_keys($data, array(
					'join_players_id',
					'horses_adoptable',
					'horses_sale',
					'horses_sale_price',
					'players_nickname'
			));
		}elseif($data['recipient'] == "Cemetery"){
			$data['join_players_id'] = $CEMETERY_ID;
			$data['players_nickname'] = new Player($data['join_players_id']);
			$data['players_nickname'] = $data['players_nickname']->player['players_nickname'];
			$data['horses_adoptable'] = 0;
			$data['horses_deceased'] = 1;
			$update_data = filter_keys($data, array(
					'join_players_id',
					'horses_adoptable',
					'horses_deceased',
					'horses_sale',
					'horses_sale_price',
					'players_nickname'
			));
		}elseif($data['recipient'] == "Export"){
			$data['horses_pending_export'] = 1;
			$data['horses_pending_export_date'] = date("Y-m-d H:i:s");
			$data['horses_adoptable'] = 0;
			$update_data = filter_keys($data, array(
					'horses_pending_export',
					'horses_pending_export_date',
					'horses_adoptable',
					'horses_sale',
					'horses_sale_price',
					'players_nickname'
			));
			$skip_record_insert = true;
		}else{
			$errors['recipient'] = "Invalid recipient.";
		}


		if(count($errors) > 0){
			return array('errors' => $errors);
		}

		//update horse
		$CI->db->update('horses', $update_data, "horses_id = " . $horse['horses_id']);

		$notice = "Congratulations! You have purchased <a href=/horses/view/" . $horse['horses_id'] . ">" . $horse['horses_name'] . " #" . generateId($horse['horses_id']) . ".</a>";
		$CI->db->query("INSERT INTO notices(notices_body, join_players_id) VALUES(?,?)", array($notice, $data['join_players_id']));

		$notice = "Congratulations! You have sold <a href=/horses/view/" . $horse['horses_id'] . ">" . $horse['horses_name'] . " #" . generateId($horse['horses_id']) . ".</a>";
		$CI->db->query("INSERT INTO notices(notices_body, join_players_id) VALUES(?,?)", array($notice, $player['players_id']));

		if(!$skip_record_insert){
			$player = $CI->db->query("SELECT * FROM players WHERE players_id=?", array($data['join_players_id']))->row_array();
			$CI->db->query('INSERT INTO horse_records(join_horses_id, join_players_id, horse_records_type, owner_name) VALUES(?, ?, "Owner", ?)', array($horse['horses_id'], $player['players_id'], @$player['players_nickname']));
		}

		$CI->session->set_flashdata('notice', "Horse transferred.");

		return array('errors' => $errors, 'notices' => $notices, 'horse_id' => $horse_id);
	}


	public static function vet($player, $horse, $data){
		$CI =& get_instance();

		if($player['players_id'] != $horse['join_players_id']){
			$errors['appointment'] = "You do not own this horse.";
		}
		if(!in_array($data['appointment'], array('Required Annual Care', 'Disaster Care Package'))){
			$errors['appointment'] = "Invalid appointment type.";
		}
		if(self::has_appt($horse['horses_id'], "Vet")){
			$errors['appointment'] = "Horse already has an appointment scheduled with the vet.";
		}

		if(count($errors) > 0){
			return array('errors' => $errors);
		}

		//create appt
		$CI->db->query('INSERT INTO horse_appointments(join_horses_id, horse_appointments_type, horse_appointments_description) VALUES(?, "Vet", ?)', array($horse['horses_id'], $data['appointment']));

		$CI->session->set_flashdata('notice', "Appointment created.");

		return array('errors' => $errors, 'notices' => $notices, 'horse_id' => $horse_id);
	}


	public static function farrier($player, $horse, $data){
		$CI =& get_instance();

		if($player['players_id'] != $horse['join_players_id']){
			$errors['appointment'] = "You do not own this horse.";
		}
		if(!in_array($data['appointment'], array('Basic Care', 'Performance/Race Package'))){
			$errors['appointment'] = "Invalid appointment type.";
		}
		if(self::has_appt($horse['horses_id'], "Farrier")){
			$errors['appointment'] = "Horse already has an appointment scheduled with the farrier.";
		}

		if(count($errors) > 0){
			return array('errors' => $errors);
		}

		//create appt
		$CI->db->query('INSERT INTO horse_appointments(join_horses_id, horse_appointments_type, horse_appointments_description) VALUES(?, "Farrier", ?)', array($horse['horses_id'], $data['appointment']));

		$CI->session->set_flashdata('notice', "Appointment created.");

		return array('errors' => $errors, 'notices' => $notices, 'horse_id' => $horse_id);
	}

	public static function has_appt($horse_id, $type = "Vet"){
		$CI =& get_instance();

		$appt = $CI->db->query("SELECT * FROM horse_appointments WHERE join_horses_id=? AND horse_appointments_type=? AND horse_appointments_completed='0000-00-00 00:00:00'", array($horse_id, $type))->num_rows();
		if($appt > 0){
			return true;
		}
		return false;
	}

	public static function get_age_by_year($year){
		return date('Y') - $year;
	}

	public static function get($horse_id){ // get one horse
		$CI =& get_instance();
		$result = $CI->db->query("
			SELECT
				h.*, s.stables_name, sire.horses_name AS horses_sire_name, dam.horses_name AS horses_dam_name
				FROM horses h				
				LEFT JOIN stables s ON s.stables_id=h.join_stables_id
				LEFT JOIN horses sire ON sire.horses_id=h.horses_sire
				LEFT JOIN horses dam ON dam.horses_id=h.horses_dam

				WHERE h.horses_id = ? LIMIT 1
		", array($horse_id))->row_array();
		//pre($CI->db->last_query());
		if(!$result['horses_id']){
			return false;
		}
		return $result;
	}

	public static function get_ownership_log($horse_id){

	}
	public static function register_horse($horse, $allowed, $mod_id){				
		$CI =& get_instance();
		$CI->load->model('messages');
		/*$horse = new Horse($data['horses_id']);
		$horse = $horse->horse;*/
		$d = $horse['disciplines'];
		/*foreach((array)$horse['disciplines'] AS $v){
			$d []= $v['disciplines_name'];
		}
		$horse['disciplines'] = $d;*/
		if(!empty($horse['horses_breed'])  && !empty($horse['horses_sire']) && !empty($horse['horses_dam']) )
		{		
			$horses_breed = $CI->db->query("SELECT breed_id FROM breeds WHERE breed_name= ?  LIMIT 1", array($horse['horses_breed']))->row_array();			
			$hold=[];	
			$sire_breed = $CI->db->query("SELECT horses_breed FROM horses WHERE horses_id= ?  LIMIT 1", array($horse['horses_sire']))->row_array();			
			if($sire_breed){
        array_push($hold,$sire_breed['horses_breed']);
			}
			$dam_breed = $CI->db->query("SELECT horses_breed FROM horses WHERE horses_id= ?  LIMIT 1", array($horse['horses_dam']))->row_array();	
		
			if($dam_breed){
        array_push($hold,$dam_breed['horses_breed']);
			}			
      if( !in_array($horse['horses_breed'],$hold) ){ 
			 $errors['horses_breed'] = "Breed must match with sire or dam.";
			}
		}        
		$check = in_array($horse['horses_breed'], $allowed['breeds']);
		if(!$check){
			$errors['horses_breed'] = "Invalid breed.";
		}
		$check = in_array($horse['horses_color'], $allowed['base_colors']);
		if(!$check){
			$errors['horses_color'] = "Invalid base color.";
		}
		$check = in_array($horse['horses_pattern'], $allowed['base_patterns']);
		if(!$check){
			$errors['horses_pattern'] = "Invalid pattern color.";
		}
		$check = in_array($horse['horses_line'], $allowed['lines']);
		if(!$check AND $horse['horses_line']){
			$errors['horses_line'] = "Invalid line.";
		}
		$check = in_array($horse['horses_gender'], array('Stallion', 'Mare', 'Gelding'));
		if(!$check){
			$errors['horses_gender'] = "Select gender.";
		}
		if(!$horse['horses_name']){
			$errors['horses_name'] = "Name is required.";
		}
		if(!$horse['horses_birthyear']){
			$errors['horses_birthyear'] = "Birth year is required.";
		}
		if($horse['horses_birthyear'] > date('Y') || $horse['horses_birthyear'] < "1950"){
			$errors['horses_birthyear'] = "Invalid birth year.";
		}

		//check if horse name is unique
		$name_exists = $CI->db->query("SELECT horses_id FROM horses WHERE horses_name=? AND horses_id!=? LIMIT 1", array($horse['horses_name'], $horse['horses_id']))->row_array();
		if($name_exists){
			$errors['horses_name'] = "That horse name is already in use.";
		}							
		/*  */
			$sire = self::getHorseById($horse['horses_sire'],true);
			$dam = self::getHorseById($horse['horses_dam'],true);
			if($horse['horses_registration_type']=="breed" && empty($horse['horses_sire']) || $horse['horses_registration_type']=="breed" && !ctype_digit($horse['horses_sire']))
			{
				$errors['horses_sire'] = "Sire is required.";
			}elseif($horse['horses_registration_type']=="breed" &&  !$sire || $horse['horses_registration_type']=="breed" &&  $sire['horses_gender'] != 'Stallion')
			{								
				$errors['horses_sire'] = "This Sire Doesn't exist.";
			}elseif($horse['horses_registration_type'] == "creation" && $sire['horses_gender'] == "Gelding")
			{
				$errors['horses_sire'] = "Gelding Horse does not make Sire Please Provide Valid Sire Horse Entity.";
			}elseif($horse['horses_registration_type']=="breed" &&  self::getBirthYear($horse['horses_sire']) == $horse['horses_birthyear'])
			{
				$errors['horses_sire']="Foal Birth Year Matched with Sire birth year.";
			}elseif($horse['horses_registration_type']=="breed" &&  $horse['horses_birthyear'] < self::getBirthYear($horse['horses_sire']))
			{
				$errors['horses_sire']="Foal birth year is not greather than his Sire.";
			}

			if($horse['horses_registration_type']=="breed" && empty($horse['horses_dam']) ||  $horse['horses_registration_type']=="breed" && !ctype_digit($horse['horses_dam']))
			{
				$errors['horses_dam'] = "Dam is required.";
			}elseif($horse['horses_registration_type']=="breed" &&  !$dam || $horse['horses_registration_type']=="breed" && $dam['horses_gender'] != 'Mare')
			{
				$errors['horses_dam'] = "This Dam Doesn't exist.";
			}elseif($horse['horses_registration_type']=="breed" &&  self::getBirthYear($horse['horses_dam']) == $horse['horses_birthyear'])
			{
				$errors['horses_dam']="Foal Birth Year Matched with Dam birth year.";
			}elseif($horse['horses_registration_type']=="breed" &&  $horse['horses_birthyear'] < self::getBirthYear($horse['horses_dam']))
			{
				$errors['horses_dam']="Foal Birth Year is not greather than his Dam.";
			}elseif($horse['horses_registration_type']=="breed" &&  !empty($horse['horses_dam']))
			{
				$horse_id = $horse['horses_id'];
				$year_exists = $CI->db->query("SELECT horses_id FROM horses WHERE  horses_birthyear = ? AND horses_dam = ? AND horses_id != $horse_id LIMIT 1", array($horse['horses_birthyear'],$horse['horses_dam']))->row_array();
				if($year_exists){
					$errors['horses_dam'] = "The Mare has a foal born that year.";
				}
			}
			if($horse['horses_gender']=="Stallion" && !empty($horse['horses_sire']))
			{
				$birthDate = "01/01/".self::getBirthYear($horse['horses_sire']);
				$birthDate = explode("/", $birthDate);
				$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md") ? ((date("Y") - $birthDate[2]) - 1) : (date("Y") - $birthDate[2]));
				if($age < 3 || $age > 29)
				{
					$errors['horses_sire']="There is a Gender issue or that the horse is too young/old";
				}
			}			
			if($horse['horses_gender']=="Mare" && !empty($horse['horses_dam']))
			{
				$birthDate = "01/01/".self::getBirthYear($horse['horses_dam']);
				$birthDate = explode("/", $birthDate);
				$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md") ? ((date("Y") - $birthDate[2]) - 1) : (date("Y") - $birthDate[2]));
				if($age < 3 || $age > 25)
				{
					$errors['horses_dam']="There is a gender issue or that the horse is too young/old.";
				}
			}	

		/*  */		
		if(count($errors) > 0){
			return array('errors' => $errors);
		}

		//create horse
		$horse['horses_pending'] = 0;
		$allowed_fields = array(
			'horses_name',
			'horses_breed',
			'horses_birthyear',
			'horses_gender',
			'horses_color',
			'horses_pattern',
			'horses_breed',
			'horses_breed2',
			'horses_line',
			'horses_sire',
			'horses_dam',
			'horses_pending',
			'horses_registration_type',
			'horses_created',
			'join_stables_id',
		);
		$horse['horses_created']=$horse['horses_registration_type'] == "creation" ? 1 : 0;
		$update_data = filter_keys($horse, $allowed_fields);

		//insert disciplines
		if(count($horse['disciplines'])){
			$disc = self::change_disciplines($horse['horses_id'], $horse['disciplines']);
			if($disc !== true){
				return array('errors' => $disc['errors']);
			}
		}

		$CI->db->update('horses', $update_data, 'horses_id=' . $horse['horses_id']);
		$horse_id = $horse['horses_id'];

		$message = "<b>Horse registered! <a href='/horses/view/" . $horse['horses_id'] ."'>" . $horse['horses_name'] ." #" . generateId($horse['horses_id']) . "</a>";

		if($horse['body']){
			$sn = SITE_NAME;
			$msg['messages_to'] = $horse['join_players_id'];
			$msg['messages_sender'] = $mod_id;
			$msg['messages_subject'] = "Horse Registration Accepted";
			$msg['messages_body'] = "<a href='/horses/view/" . $horse['horses_id'] ."'>" . $horse['horses_name'] ." #" . generateId($horse['horses_id']) . "</a> has been registered with the game and is now available in your account.<br><br>". $horse['body'] . "<br><br>Sincerely,<br>$sn Team";
			$result = $CI->messages->send($msg);
		}
		return array('errors' => $errors, 'notices' => $notices, 'horse_id' => $horse['horses_id']);
	}


	public static function reject_horse($data){
		$CI =& get_instance();
		$horse = new Horse($data['horses_id']);
		$horse = $horse->horse;

		$message = "Horse registration rejected (".$horse['horses_name']."). <i>" . $data['body'] . "</i>";
		$CI->db->query("INSERT INTO notices(join_players_id, notices_body) VALUES(?, ?)", array($horse['join_players_id'], $message));
		$CI->db->query("UPDATE players SET players_credits_creation=players_credits_creation+1 WHERE players_id=? LIMIT 1", array($horse['join_players_id']));

		$CI->db->query("DELETE FROM horses WHERE horses_id=? AND horses_pending=1 LIMIT 1", array($data['horses_id']));

		return array('errors' => $errors, 'notices' => $notices, 'horse_id' => $horse['horses_id']);
	}










	public static function admin_accept_breeding($post, $player, $allowed){
		$CI =& get_instance();

		$data = $CI->db->query("SELECT * FROM horses_breedings WHERE horses_breedings_id=? LIMIT 1", array($post['horses_breedings_id']))->row_array();
		$mare = new Horse($data['join_mares_id']);
		$stallion = new Horse($data['join_horses_id']);

		

		$mare = $mare->horse;
		$stallion = $stallion->horse;
		$genes = self::get_blueprint_possibilities_offspring($stallion['genes'], $mare['genes']);

		if(!self::breeding_request_exists(0, 0, $data['horses_breedings_id'])){
			$errors []= "Invalid breeding request.";
		}

		$check = in_array($post['horses_breedings_breed'], $allowed['breeds']);
		if(!$check){
			$errors['horses_breedings_breed'] = "Invalid breed.";
		}
		/*
		$check = in_array($post['horses_breedings_color'], $allowed['base_colors']);
		if(!$check){
			$errors['horses_breedings_color'] = "Invalid base color.";
		}
		$check = in_array($post['horses_breedings_pattern'], $allowed['base_patterns']);
		if(!$check){
			$errors['horses_breedings_pattern'] = "Invalid base pattern.";
		}*/

		$check = in_array($post['horses_breedings_line'], $allowed['lines']);
		if(!$check AND $post['horses_breedings_line']){
			$errors['horses_line'] = "Invalid line.";
		}

		//let's check the genes to ensure this is a valid combination

		/* $foal_genes = self::get_blueprint_possibilities_offspring($stallion['genes'], $mare['genes']);		
		if(!in_array($post['horses_breedings_color'], $foal_genes['blueprints_available']['Color'])){
			$errors['horses_breedings_color'] = "Invalid genetic color for this foal.";
		}
		if(!in_array($post['horses_breedings_pattern'], $foal_genes['blueprints_available']['Pattern'])){
			$errors['horses_breedings_pattern'] = "Invalid genetic pattern for this foal.";
		} */

		$colors = self::get_base_colors();		
		$patterns = self::get_base_patterns();		

		if(!in_array($post['horses_breedings_color'], $colors)){
			$errors['horses_breedings_color'] = "Invalid genetic color for this foal.";
		}
		if(!in_array($post['horses_breedings_pattern'], $patterns)){
			$errors['horses_breedings_pattern'] = "Invalid genetic pattern for this foal.";
		}

		if(count($errors) > 0){
			return array('errors' => $errors);
		}


		$message = "A moderator has approved and completed this breeding: <a href='/horses/view/" . $data['join_mares_id'] ."'>" . $mare['horses_competition_title'] ." " . $mare['horses_breeding_title'] . " " . $mare['horses_name'] . " #". generateId($mare['horses_id']) . "</a> x <a href='/horses/view/" . $data['join_horses_id'] ."'>" . $stallion['horses_competition_title'] ." " . $stallion['horses_breeding_title'] . " " . $stallion['horses_name'] . " #". generateId($stallion['horses_id']) . "</a> for <font color=green>$" . $data['horses_breedings_fee'] . "</font>.";


		if($stallion['join_players_id'] != $mare['join_players_id']){
			$CI->db->query("INSERT INTO notices(join_players_id, notices_body) VALUES(?, ?), (?, ?)", array($stallion['join_players_id'], $message, $mare['join_players_id'], $message));
		}else{
			$CI->db->query("INSERT INTO notices(join_players_id, notices_body) VALUES(?, ?)", array($stallion['join_players_id'], $message));
		}

		$horse['join_players_id'] = $data['horses_breedings_owner'];
		$owner = new Player($data['horses_breedings_owner']);
		$horse['players_nickname'] = $owner->player['players_nickname'];
		/* $horse['horses_name'] = $post['horses_birthyear'] . ' Foal (#' . generateId($stallion['horses_id']) .' x #' . generateId($mare['horses_id']) . ')'; */
        // $horse['horses_name'] = $data['horses_breedings_name'].' Foal (#' . generateId($stallion['horses_id']) .' x #' . generateId($mare['horses_id']) . ')';
		$horse['horses_name'] = $data['horses_breedings_name'];
		$horse['horses_breed'] = $post['horses_breedings_breed'];
		$horse['horses_birthyear'] = $data['horses_birthyear'];
		$horse['horses_gender'] = $data['horses_breedings_gender'];
		$horse['horses_color'] = $post['horses_breedings_color'];
		$horse['horses_pattern'] = $post['horses_breedings_pattern'];
		$horse['horses_breed'] = $post['horses_breedings_breed'];
		$horse['horses_breed2'] = $post['horses_breedings_breed2'];
		$horse['horses_line'] = $post['horses_breedings_line'];
		$horse['horses_sire'] = $data['join_horses_id'];
		$horse['horses_dam'] = $data['join_mares_id'];
		$horse['horses_pending_date'] = date('Y-m-d H:i:s');
		$horse['horses_pending'] = 0;		

		

		$allowed_fields = array(
			'join_players_id',
			'players_nickname',
			'horses_name',
			'horses_breed',
			'horses_birthyear',
			'horses_gender',
			'horses_color',
			'horses_pattern',
			'horses_breed',
			'horses_breed2',
			'horses_line',
			'horses_sire',
			'horses_dam',
			'horses_pending_date',
			'horses_pending',
		);

		$foal = filter_keys($horse, $allowed_fields);
		$CI->db->insert('horses', $foal);
		$horse_id = $CI->db->insert_id();		




		// ********* GENETICS *************
		$genes['Color'] = $CI->db->query("
				SELECT join_genes_id AS horses_x_genes_id, genes_blueprints_x_genes_value AS horses_x_genes_value, join_genes_blueprints_id
				FROM genes_blueprints_x_genes
				WHERE join_genes_blueprints_id IN
					(SELECT genes_blueprints_id FROM genes_blueprints WHERE genes_blueprints_name=? AND join_genes_categories_name='Color')
				", array(/* $post['horses_breedings_color'] */array_values($genes['blueprints_available']['Color'])[0]))->result_array();
		$genes['Pattern'] = $CI->db->query("
				SELECT join_genes_id AS horses_x_genes_id, genes_blueprints_x_genes_value AS horses_x_genes_value, join_genes_blueprints_id
				FROM genes_blueprints_x_genes
				WHERE join_genes_blueprints_id IN
					(SELECT genes_blueprints_id FROM genes_blueprints WHERE genes_blueprints_name=? AND join_genes_categories_name='Pattern')
				", array(/* $post['horses_breedings_pattern'] */ array_values($genes['blueprints_available']['Pattern'])[0]))->result_array();
		//normalize the genes, and do logic check to ensure horse is getting the right gene if there's multiple possibilities in this blueprint.
		//pre($genes);
		foreach((array)$genes AS $key => $cat){
			foreach((array)$cat AS $v){
				$final_genes[$key][$v['horses_x_genes_id']] []= $v['horses_x_genes_value'];
			}
		}
		//okay, let's check for multiple copies of a gene and do the logic now. bear with me on the loops.
		foreach((array)$final_genes AS $key => $cat){
		//	pre($cat);
			foreach((array)$cat AS $i => $v){
				$final_genes2 []= $horse_id;
				$final_genes2 []= $i;
				if(count($v) > 1){
					//multiple possibilities. Let's check foal genetics and compare
					if(count($foal_genes[$key][$i]) > 1){
						// this could be improved further by checking the possibility percentage instead of randomizing.
						$rand = rand(0,count($foal_genes[$key][$i]) -1);
						$final_genes2 []= $foal_genes[$key][$i][$rand];
					}else{
						$final_genes2 []= $foal_genes[$key][$i][0];
					}
				}else{
					$final_genes2 []= $v[0];
				}
				$insert []= "(?, ?, ?)";
			}
		}

		//pre($final_genes2);
		//pre($insert);
		//create the genes
		$CI->db->query("INSERT INTO horses_x_genes(join_horses_id, join_genes_id, horses_x_genes_value) VALUES " . implode(', ', $insert), $final_genes2);
		//pre($CI->db->last_query());



		//insert disciplines
		if(count($post['horses_breedings_disciplines'])){
			$disc = self::change_disciplines($horse_id, $post['horses_breedings_disciplines']);
			if($disc !== true){
				$CI->db->query("DELETE FROM horses WHERE horses_id=?", array($horse_id));
				return array('errors' => $disc['errors']);
			}
		}

		//update credits		
			$player = $CI->db->query("SELECT * FROM players WHERE players_id=?", array($data['horses_breedings_owner']))->row_array();
			$CI->db->query('INSERT INTO horse_records(join_horses_id, join_players_id, horse_records_type, owner_name) VALUES(?, ?, "Owner", ?)', array($horse_id, $player['players_id'], @$player['players_nickname']));

		//set breeding as complete
		$CI->db->query("DELETE FROM horses_breedings WHERE horses_breedings_id=? LIMIT 1", array($post['horses_breedings_id']));

		return array('errors' => $errors, 'notices' => $notices, 'horse_id' => $horse['horses_id']);
	}


	public static function admin_reject_breeding($post, $player, $is_temprarily = false){
		$CI =& get_instance();
		$data = $CI->db->query("SELECT * FROM horses_breedings WHERE horses_breedings_id=? LIMIT 1", array($post['horses_breedings_id']))->row_array();
		$mare = new Horse($data['join_mares_id']);
		$stallion = new Horse($data['join_horses_id']);
		$mare = $mare->horse;
		$stallion = $stallion->horse;
		if($is_temprarily && !@$_REQUEST['body'])
		{
			$errors['body'] = "Please enter a message for give them the option to fix it.";
		}elseif($is_temprarily && strlen(@$_REQUEST['body']) < 10)
		{
			$errors['body'] = "Please enter a message atleast 10 charactors.";
		}elseif($is_temprarily && strlen(@$_REQUEST['body']) > 10000)
		{
			$errors['body'] = "Please enter a message no more than 10000 charactors.";
		}
		
		if(!self::breeding_request_exists(0, 0, $data['horses_breedings_id'])){
			$errors['horses_name']= "Invalid breeding request.";
		}

		if(count($errors) > 0){
			return array('errors' => $errors);
		}
		$msg = "A moderator has rejected this breeding: ";
		if(!empty(@$_REQUEST['body']))
		{
			$msg = $_REQUEST['body'];
		}		
		$message = $msg." <a href='/horses/view/" . $data['join_mares_id'] ."'>" . $mare['horses_competition_title'] ." " . $mare['horses_breeding_title'] . " " . $mare['horses_name'] . " #". generateId($mare['horses_id']) . "</a> x <a href='/horses/view/" . $data['join_horses_id'] ."'>" . $stallion['horses_competition_title'] ." " . $stallion['horses_breeding_title'] . " " . $stallion['horses_name'] . " #". generateId($stallion['horses_id']) . "</a> for <font color=green>$".$data['horses_breedings_fee']."</font>.";

		if($stallion['join_players_id'] != $mare['join_players_id']){
			$CI->db->query("INSERT INTO notices(join_players_id, notices_body) VALUES(?, ?), (?, ?)", array($stallion['join_players_id'], $message, $mare['join_players_id'], $message));
		}else{
			$CI->db->query("INSERT INTO notices(join_players_id, notices_body) VALUES(?, ?)", array($stallion['join_players_id'], $message));
		}		

		if($is_temprarily)
		{
			$horses_breeding_user_id_fixes = $stallion['join_players_id'] != $mare['join_players_id'] ? $data['receiver_player_id'] : $stallion['join_players_id'];
			$CI->db->query("UPDATE horses_breedings SET horses_breeding_is_rejected_temporarily=1, horses_breeding_reject_reason=?, horses_breeding_user_id_fixes=? WHERE horses_breedings_id=? LIMIT 1", array($msg,$horses_breeding_user_id_fixes,$data['horses_breedings_id']));
		}else
		{
			$CI->db->query("DELETE FROM horses_breedings WHERE horses_breedings_id=? LIMIT 1", array($post['horses_breedings_id']));
		}
		return array('errors' => $errors, 'notices' => $notices, 'horse_id' => $horse['horses_id']);
	}


	public static function admin_add_gene($data){
		$CI =& get_instance();

		//all data present?
		if(!$data['genes_code'][0]){
			$errors['genes_code'][0] = "Required.";
		}
		if(!$data['genes_code']){
			$errors['genes_code'][1] = "Required.";
		}
		if(!$data['genes_code']){
			$errors['genes_code'][2] = "Required.";
		}
		if(!$data['genes_name']){
			$errors['genes_name'] = "Required.";
		}
		//no duplicates
		$exists = $CI->db->query("SELECT * FROM genes WHERE genes_name=?", array($data['genes_name']))->num_rows();
		if($exists){
			$errors['genes_name'] = 'Gene already exists.';
		}
		//ensure the category exists
		$exists = $CI->db->query("SELECT * FROM genes_categories WHERE genes_categories_name=?", array($data['genes_categories_name']))->num_rows();
		if(!$exists){
			$errors['genes_categories_name'] = 'Invalid category.';
		}
		if(count($errors) > 0){
			return array('errors' => $errors);
		}

		if(!$data['genes_required']){
			$data['genes_required'] = 0;
		}else{
			$data['genes_required'] = 1;
		}

		$CI->db->query("INSERT INTO genes(genes_name, genes_code1, genes_code2, genes_code3, join_genes_categories_name, genes_required, genes_notes) VALUES(?, ?, ?, ?, ?, ?, ?)", array($data['genes_name'], $data['genes_code'][0], $data['genes_code'][1], $data['genes_code'][2], $data['genes_categories_name'], $data['genes_required'], $data['genes_notes']));
		return array('errors' => $errors, 'notices' => $notices);
	}


	public static function admin_edit_gene($id, $data){
		$CI =& get_instance();

		//all data present?
		if(!$data['genes_code'][0]){
			$errors['genes_code'][0] = "Required.";
		}
		if(!$data['genes_code']){
			$errors['genes_code'][1] = "Required.";
		}
		if(!$data['genes_code']){
			$errors['genes_code'][2] = "Required.";
		}
		if(!$data['genes_name']){
			$errors['genes_name'] = "Required.";
		}
		//no duplicates
		$exists = $CI->db->query("SELECT * FROM genes WHERE genes_name=? AND genes_id!=?", array($data['genes_name'], $id))->num_rows();
		if($exists){
			$errors['genes_name'] = 'Gene name already exists.';
		}
		//ensure the category exists
		$exists = $CI->db->query("SELECT * FROM genes_categories WHERE genes_categories_name=?", array($data['genes_categories_name']))->num_rows();
		if(!$exists){
			$errors['genes_categories_name'] = 'Invalid category.';
		}
		if(count($errors) > 0){
			return array('errors' => $errors);
		}

		if(!$data['genes_required']){
			$data['genes_required'] = 0;
		}else{
			$data['genes_required'] = 1;
		}

		$CI->db->query("UPDATE genes SET genes_name=?, genes_code1=?, genes_code2=?, genes_code3=?, join_genes_categories_name=?, genes_required=?, genes_notes=? WHERE genes_id=?", array($data['genes_name'], $data['genes_code'][0], $data['genes_code'][1], $data['genes_code'][2], $data['genes_categories_name'], $data['genes_required'], $data['genes_notes'], $id));
		return array('errors' => $errors, 'notices' => $notices);
	}

	public static function admin_remove_gene($data){
		$CI =& get_instance();
		//make sure deleted isn't the same as change-to
		//change all horses to the new one
		//check blueprints
		$blueprints = $CI->db->query("SELECT * FROM genes_blueprints_x_genes WHERE join_genes_id=?", $data['remove_gene'])->num_rows();
		if($blueprints){
			return array('errors' => array('remove_gene' => "This gene is present in some genetic blueprints. Please edit those blueprints first."));
		}
		if(strtolower($data['remove_gene']) == strtolower($data['remove_gene2']) || !$data['remove_gene2']){
			return array('errors' => array('remove_gene2' => 'Please choose a different gene.'));
		}
		if($data['remove_gene2'] == "none"){
			//delete this gene from horses
			$CI->db->query("DELETE FROM horses_x_genes WHERE join_genes_id=?", array($data['remove_gene']));
			$affected = $CI->db->affected_rows();
			$CI->db->query("DELETE FROM genes_blueprints_x_genes WHERE join_genes_id=?", array($data['remove_gene']));
		}else{
			//get new gene
			$old_gene = self::get_gene($data['remove_gene']);
			$new_gene = self::get_gene($data['remove_gene2']);
			$CI->db->query("UPDATE horses_x_genes SET join_genes_id=?, horses_x_genes_value=? WHERE join_genes_id=? AND horses_x_genes_value=?", array($new_gene['genes_id'], $new_gene['genes_code1'], $old_gene['genes_id'], $old_gene['genes_code1']));
			$affected = $CI->db->affected_rows();
			$CI->db->query("UPDATE horses_x_genes SET join_genes_id=?, horses_x_genes_value=? WHERE join_genes_id=? AND horses_x_genes_value=?", array($new_gene['genes_id'], $new_gene['genes_code2'], $old_gene['genes_id'], $old_gene['genes_code2']));
			$affected += $CI->db->affected_rows();
			$CI->db->query("UPDATE horses_x_genes SET join_genes_id=?, horses_x_genes_value=? WHERE join_genes_id=? AND horses_x_genes_value=?", array($new_gene['genes_id'], $new_gene['genes_code3'], $old_gene['genes_id'], $old_gene['genes_code3']));
			$affected += $CI->db->affected_rows();
		}
		$CI->db->query("DELETE FROM genes WHERE genes_id=?", array($data['remove_gene']));
		return array('affected' => $affected);
	}

	public static function admin_add_gene_category($data){
		$CI =& get_instance();
		//no duplicates
		$exists = $CI->db->query("SELECT * FROM genes_categories WHERE genes_categories_name=?", array($data['genes_categories_name']))->num_rows();
		if($exists){
			return array('errors' => array('genes_categories_name' => 'Category already exists.'));
		}
		$CI->db->query("INSERT INTO genes_categories SET genes_categories_name=?", array($data['genes_categories_name']));
		return 1;
	}

	public static function admin_remove_gene_category($data){
		$CI =& get_instance();
		//return false;
		//make sure deleted isn't the same as change-to
		//change all horses to the new one
		if(strtolower($data['genes_categories_name']) == strtolower($data['genes_categories_name2'])){
			return array('errors' => array('genes_categories_name2' => 'Please choose a different category.'));
		}
		$CI->db->query("UPDATE genes SET join_genes_categories_name=? WHERE join_genes_categories_name=?", array($data['genes_categories_name2'], $data['genes_categories_name']));
		$affected = $CI->db->affected_rows();
		$CI->db->query("DELETE FROM genes_categories WHERE genes_categories_name=?", array($data['genes_categories_name']));
		return array('affected' => $affected);
	}

	public static function admin_add_blueprint($data){
		$CI =& get_instance();
		//no duplicates
		$exists = $CI->db->query("SELECT * FROM genes_blueprints WHERE genes_blueprints_name=? AND join_genes_categories_name=?", array($data['genes_blueprints_name'], $data['join_genes_categories_name']))->num_rows();
		if($exists || !$data['genes_blueprints_name']){
			$errors['genes_blueprints_name'] = 'Blueprint name already exists.';
		}

		//ensure the category exists
		$exists = $CI->db->query("SELECT * FROM genes_categories WHERE genes_categories_name=?", array($data['join_genes_categories_name']))->num_rows();
		if(!$exists){
			$errors['join_genes_categories_name'] = 'Invalid category.';
		}

		if(count($errors) > 0){
			return array('errors' => $errors);
		}

		if(!$data['genes_blueprints_special']){
			$data['genes_blueprints_special'] = 0;
		}else{
			$data['genes_blueprints_special'] = 1;
		}
		$CI->db->query("INSERT INTO genes_blueprints(join_genes_categories_name, genes_blueprints_name, genes_blueprints_special, genes_blueprints_description) VALUES(?, ?, ?, ?)", array($data['join_genes_categories_name'], $data['genes_blueprints_name'], $data['genes_blueprints_special'], $data['genes_blueprints_description']));
		return 1;
	}

	public static function admin_edit_blueprint($id, $data, $blueprint){
		$CI =& get_instance();

		//all data present?
		if(!$data['genes_blueprints_name']){
			$errors['genes_blueprints_name'] = "Required.";
		}
		//no duplicates
		$exists = $CI->db->query("SELECT * FROM genes_blueprints WHERE genes_blueprints_name=? AND join_genes_categories_name=? AND genes_blueprints_id!=?", array($data['genes_blueprints_name'], $data['join_genes_categories_name'], $id))->num_rows();
		if($exists){
			$errors['genes_blueprints_name'] = 'Blueprint name already exists.';
		}

		//ensure the category exists
		$exists = $CI->db->query("SELECT * FROM genes_categories WHERE genes_categories_name=?", array($data['join_genes_categories_name']))->num_rows();
		if(!$exists){
			$errors['join_genes_categories_name'] = 'Invalid category.';
		}

		if(count($errors) > 0){
			return array('errors' => $errors);
		}

		if(!$data['genes_blueprints_special']){
			$data['genes_blueprints_special'] = 0;
		}else{
			$data['genes_blueprints_special'] = 1;
		}

		if($data['join_genes_categories_name'] != $blueprint['join_genes_categories_name']){
			//delete the genes assigned to this color
			$CI->db->query("DELETE FROM genes_blueprints_x_genes WHERE join_genes_blueprints_id=?", $id);
		}

		$CI->db->query("UPDATE genes_blueprints SET join_genes_categories_name=?, genes_blueprints_name=?, genes_blueprints_special=?, genes_blueprints_description=? WHERE genes_blueprints_id=?", array($data['join_genes_categories_name'], $data['genes_blueprints_name'], $data['genes_blueprints_special'], $data['genes_blueprints_description'], $id));
		return array('errors' => $errors, 'notices' => $notices);
	}

	public static function admin_edit_blueprint_genes($id, $genes, $data){
		$CI =& get_instance();
		$insert = $values = array();
		//delete all old genes
		$CI->db->query("DELETE FROM genes_blueprints_x_genes WHERE join_genes_blueprints_id=?", $id);

		//add new genes
		foreach((array)$data['genes_code1'] AS $k => $v){
			if(!$genes[$k]){
				continue;
			}
			$insert []= "(?, ?, ?)";
			$values []= $id;
			$values []= $k;
			$values []= $genes[$k]['genes_code1'];
		}
		foreach((array)$data['genes_code2'] AS $k => $v){
			if(!$genes[$k]){
				continue;
			}
			$insert []= "(?, ?, ?)";
			$values []= $id;
			$values []= $k;
			$values []= $genes[$k]['genes_code2'];
		}
		foreach((array)$data['genes_code3'] AS $k => $v){
			if(!$genes[$k]){
				continue;
			}
			$insert []= "(?, ?, ?)";
			$values []= $id;
			$values []= $k;
			$values []= $genes[$k]['genes_code3'];
		}

		$CI->db->query("INSERT INTO genes_blueprints_x_genes(join_genes_blueprints_id, join_genes_id, genes_blueprints_x_genes_value) VALUES ".implode(',', $insert), $values);
		//pre($CI->db->last_query());
		//exit;
		return array('errors' => $errors, 'notices' => $notices);
	}

	public static function admin_remove_blueprint($data){
		$CI =& get_instance();

		$CI->db->query("DELETE FROM genes_blueprints_x_genes WHERE join_genes_blueprints_id=?", array($data['remove_blueprint']));
		$CI->db->query("DELETE FROM genes_blueprints WHERE genes_blueprints_id=?", array($data['remove_blueprint']));
		return array('affected' => $affected);
	}









	public static function admin_add_breed($data){
		$CI =& get_instance();
		//no duplicates
		$exists = $CI->db->query("SELECT * FROM breeds WHERE breed_name=?", array($data['breed']))->num_rows();
		if($exists){
			return array('errors' => array('breed' => 'Breed already exists.'));
		}
		$CI->db->query("INSERT INTO breeds SET breed_name=?", array($data['breed']));
		return 1;
	}

	public static function admin_remove_breed($data){
		$CI =& get_instance();
		//make sure deleted isn't the same as change-to
		//change all horses to the new one
		if(strtolower($data['remove_breed']) == strtolower($data['horses_breed2'])){
			return array('errors' => array('horses_breed2' => 'Please choose a different breed.'));
		}
		$CI->db->query("UPDATE horses SET horses_breed=? WHERE horses_breed=?", array($data['horses_breed2'], $data['remove_breed']));
		$affected = $CI->db->affected_rows();
		$CI->db->query("DELETE FROM breeds WHERE breed_name=?", array($data['remove_breed']));
		return array('affected' => $affected);
	}


	public static function admin_add_discipline($data){
		$CI =& get_instance();
		//no duplicates
		$exists = $CI->db->query("SELECT * FROM disciplines WHERE disciplines_name=?", array($data['horses_discipline']))->num_rows();
		if($exists){
			return array('errors' => array('horses_discipline' => 'Discipline already exists.'));
		}
		$CI->db->query("INSERT INTO disciplines SET disciplines_name=?", array($data['horses_discipline']));
		return 1;
	}

	public static function admin_remove_discipline($data){
		$CI =& get_instance();
		//make sure deleted isn't the same as change-to
		//change all horses to the new one
		if(strtolower($data['remove_discipline']) == strtolower($data['horses_discipline2'])){
			return array('errors' => array('horses_discipline2' => 'Please choose a different discipline.'));
		}
		$CI->db->query("UPDATE horses_x_disciplines SET disciplines_name=? WHERE disciplines_name=?", array($data['horses_discipline2'], $data['remove_discipline']));
		$affected = $CI->db->affected_rows();
		$CI->db->query("DELETE FROM disciplines WHERE disciplines_name=?", array($data['remove_discipline']));
		return array('affected' => $affected);
	}

	public static function admin_add_base_color($data){
		$CI =& get_instance();
		//no duplicates
		$exists = $CI->db->query("SELECT * FROM colors WHERE colors_name=? AND colors_base=1", array($data['horses_color']))->num_rows();
		if($exists){
			return array('errors' => array('horses_color' => 'Color already exists.'));
		}
		$CI->db->query("INSERT INTO colors SET colors_name=?, colors_base=1", array($data['horses_color']));
		return 1;
	}

	public static function admin_remove_base_color($data){
		$CI =& get_instance();
		//make sure deleted isn't the same as change-to
		//change all horses to the new one
		if(strtolower($data['remove_color']) == strtolower($data['horses_color2'])){
			return array('errors' => array('horses_color2' => 'Please choose a different base.'));
		}
		$CI->db->query("UPDATE horses SET horses_color=? WHERE horses_color=?", array($data['horses_color2'], $data['remove_color']));
		$affected = $CI->db->affected_rows();
		$CI->db->query("DELETE FROM colors WHERE colors_name=? AND colors_base=1", array($data['remove_color']));
		return array('affected' => $affected);
	}


	public static function admin_add_pattern($data){
		$CI =& get_instance();
		//no duplicates
		$exists = $CI->db->query("SELECT * FROM colors WHERE colors_name=? AND colors_pattern=1", array($data['horses_pattern']))->num_rows();
		if($exists){
			return array('errors' => array('horses_pattern' => 'Color already exists.'));
		}
		$CI->db->query("INSERT INTO colors SET colors_name=?, colors_pattern=1", array($data['horses_pattern']));
		return 1;
	}

	public static function admin_remove_pattern($data){
		$CI =& get_instance();
		//make sure deleted isn't the same as change-to
		//change all horses to the new one
		if(strtolower($data['remove_pattern']) == strtolower($data['horses_pattern2'])){
			return array('errors' => array('horses_pattern2' => 'Please choose a different pattern.'));
		}
		$CI->db->query("UPDATE horses SET horses_pattern=? WHERE horses_pattern=?", array($data['horses_pattern2'], $data['remove_pattern']));
		$affected = $CI->db->affected_rows();
		$CI->db->query("DELETE FROM colors WHERE colors_name=? AND colors_pattern=1", array($data['remove_pattern']));
		return array('affected' => $affected);
	}



	public static function admin_add_line($data){
		$CI =& get_instance();
		//no duplicates
		$exists = $CI->db->query("SELECT * FROM horse_lines WHERE horse_lines_name=?", array($data['horses_line']))->num_rows();
		if($exists){
			return array('errors' => array('horses_line' => 'Line already exists.'));
		}
		$CI->db->query("INSERT INTO horse_lines SET horse_lines_name=?", array($data['horses_line']));
		return 1;
	}

	public static function admin_remove_line($data){
		$CI =& get_instance();
		//make sure deleted isn't the same as change-to
		//change all horses to the new one
		if(strtolower($data['remove_line']) == strtolower($data['horses_line2'])){
			return array('errors' => array('horses_line2' => 'Please choose a different line.'));
		}
		$CI->db->query("UPDATE horses SET horses_line=? WHERE horses_line=?", array($data['horses_line2'], $data['remove_line']));
		$affected = $CI->db->affected_rows();
		$CI->db->query("DELETE FROM horse_lines WHERE horse_lines_name=?", array($data['remove_line']));
		return array('affected' => $affected);
	}

	public static function admin_add_restricted($data){
		$CI =& get_instance();
		//no duplicates
		$exists = $CI->db->query("SELECT * FROM restricted WHERE restricted_name=?", array($data['restricted_name']))->num_rows();
		if($exists){
			return array('errors' => array('restricted_name' => 'Restricted name already exists.'));
		}
		$CI->db->query("INSERT INTO restricted SET restricted_name=?", array($data['restricted_name']));
		return 1;
	}

	public static function admin_remove_restricted($data){
		$CI =& get_instance();
		$CI->db->query("DELETE FROM restricted WHERE restricted_name=?", array($data['remove_name']));
		return true;
	}

	public static function admin_get_registration(){
		$CI =& get_instance();
		$horses = $CI->db->query("SELECT h.* FROM horses h WHERE h.horses_pending=1 ORDER BY h.horses_id ASC")->result_array();
		foreach((array)$horses AS $k => $h){
			$d = $CI->db->query("SELECT disciplines_name FROM horses_x_disciplines WHERE join_horses_id=? ORDER BY disciplines_name ASC", array($h['horses_id']))->result_array();
			//normalize
			foreach((array)$d AS $k2){
				$di[] = $k2['disciplines_name'];
			}
			$horses[$k]['disciplines'] = $di;
			unset($di);
		}
		return $horses;
	}


	public static function admin_get_breedings(){
		$CI =& get_instance();
		$breedings = $CI->db->query("
				SELECT hb.*, h1.*, h1.players_nickname AS p1_nickname,hb.horses_birthyear AS horses_breedings_birthyear,
					h2.horses_id AS h2_id, h2.horses_name AS h2_name, h2.horses_birthyear AS h2_birthyear, h2.horses_gender AS h2_gender, h2.horses_breed AS h2_breed, h2.horses_breed2 AS h2_breed2,
					h2.players_nickname AS p2_nickname,
					h2.join_players_id AS p2_id,
					DATE_FORMAT(hb.horses_breedings_date, '%Y/%m/%d') AS horses_breedings_date
				FROM horses_breedings hb
					LEFT JOIN horses h1 ON h1.horses_id=hb.join_horses_id
					LEFT JOIN horses h2 ON h2.horses_id=hb.join_mares_id					
				WHERE hb.horses_breedings_accepted=1 AND horses_breeding_is_rejected_temporarily = 0
				ORDER BY hb.horses_breedings_date ASC")->result_array();
		foreach((array)$breedings AS $k => $v){
			$dam = new Horse($v['join_mares_id']);
			$dam = $dam->horse;
			$stallion = new Horse($v['join_horses_id']);
			$stallion = $stallion->horse;
			$breedings[$k]['genes'] = self::get_blueprint_possibilities_offspring($stallion['genes'], $dam['genes']);
		}
		return $breedings;
	}

	public static function admin_get_export(){
		$CI =& get_instance();
		//$EXPORT_ID = EXPORT_ID;
		return $CI->db->query("SELECT h.* FROM horses h WHERE h.horses_pending_export=1 ORDER BY h.horses_pending_export_date ASC")->result_array();
	}

	public static function accept_export($data, $mod_id){
		$CI =& get_instance();
		$CI->load->model('messages');
		$EXPORT_ID = EXPORT_ID;
		$horse = new Horse($data['horses_id']);
		$horse = $horse->horse;


		//update horse
		$result = $CI->db->query("UPDATE horses SET join_players_id=?, horses_pending_export=0, horses_pending_export_date='0000-00-00 00:00:00' WHERE horses_id=? LIMIT 1", array($EXPORT_ID, $horse['horses_id']));

		//create record
		$player = $CI->db->query("SELECT * FROM players WHERE players_id=?", array($horse['join_players_id']))->row_array();
		$CI->db->query('INSERT INTO horse_records(join_horses_id, join_players_id, horse_records_type, owner_name) VALUES(?, ?, "Owner", ?)', array($horse['horses_id'], $player['players_id'], @$player['players_nickname']));		

		//send message
		$message = "<b>Horse exported. <a href='/horses/view/" . $horse['horses_id'] ."'>" . $horse['horses_name'] ." #" . generateId($horse['horses_id']) . "</a>";

		if($data['body']){
			$sn = SITE_NAME;
			$msg['messages_to'] = $horse['join_players_id'];
			$msg['messages_sender'] = $mod_id;
			$msg['messages_subject'] = "Horse Exported";
			$msg['messages_body'] = "<a href='/horses/view/" . $horse['horses_id'] ."'>" . $horse['horses_name'] ." #" . generateId($horse['horses_id']) . "</a> has been exported successfully.<br><br>". $data['body'] . "<br><br>Sincerely,<br>$sn Team";
			$result = $CI->messages->send($msg);
			//pre($result);
		}
		//pre($data);exit;
	}

	public static function reject_export($data, $mod_id){
		$CI =& get_instance();
		$CI->load->model('messages');
		$EXPORT_ID = EXPORT_ID;
		$horse = new Horse($data['horses_id']);
		$horse = $horse->horse;


		$message = "<a href='/horses/view/" . $horse['horses_id'] ."'>" . $horse['horses_competition_title'] ." " . $horse['horses_breeding_title'] . " " . $horse['horses_name'] . " #". generateId($horse['horses_id']) . "</a> has been rejected for export.";

		$CI->db->query("UPDATE horses SET horses_pending_export=0, horses_pending_export_date='0000-00-00 00:00:00' WHERE horses_id=? LIMIT 1", array($horse['horses_id']));

		$CI->db->query("INSERT INTO notices(join_players_id, notices_body) VALUES(?, ?)", array($horse['join_players_id'], $message));

		if($data['body']){
			$sn = SITE_NAME;
			$msg['messages_to'] = $horse['join_players_id'];
			$msg['messages_sender'] = $mod_id;
			$msg['messages_subject'] = "Horse Export Rejected";
			$msg['messages_body'] = "<a href='/horses/view/" . $horse['horses_id'] ."'>" . $horse['horses_name'] ." #" . generateId($horse['horses_id']) . "</a> has been rejected for export.<br><br>". $data['body'] . "<br><br>Sincerely,<br>$sn Team";
			$result = $CI->messages->send($msg);
		}
	}

	public static function accept_import($data, $mod_id){
		$CI =& get_instance();
		$CI->load->model('messages');
		$EXPORT_ID = EXPORT_ID;
		$horse = new Horse($data['horses_id']);
		$horse = $horse->horse;

		//get import info
		$import = $CI->db->query("SELECT * FROM import_requests WHERE import_requests_id=? AND join_horses_id=? AND import_requests_accepted=0", array($data['import_requests_id'], $data['horses_id']))->row_array();


		if(!$import['import_requests_id']){
			$errors ['body']= "Invalid import request.";
		}

		if(count($errors) > 0){
			return array('errors' => $errors);
		}


		//update horse
		$result = $CI->db->query("UPDATE horses SET join_players_id=?, horses_sale=0, horses_auction=0 WHERE join_players_id=? AND horses_id=? LIMIT 1", array($import['join_players_id'], $EXPORT_ID, $data['horses_id']));
		$result = $CI->db->query("UPDATE import_requests SET import_requests_accepted=1 WHERE import_requests_id=? LIMIT 1", array($import['import_requests_id']));

		$message = "<a href='/horses/view/" . $horse['horses_id'] ."'>" . $horse['horses_competition_title'] ." " . $horse['horses_breeding_title'] . " " . $horse['horses_name'] . " #". generateId($horse['horses_id']) . "</a> has been imported.";

		$CI->db->query("INSERT INTO notices(join_players_id, notices_body) VALUES(?, ?)", array($import['join_players_id'], $message));


		//create record		
		$player = $CI->db->query("SELECT * FROM players WHERE players_id=?", array($import['join_players_id']))->row_array();
		$CI->db->query('INSERT INTO horse_records(join_horses_id, join_players_id, horse_records_type, owner_name) VALUES(?, ?, "Owner", ?)', array($data['horses_id'], $player['players_id'], @$player['players_nickname']));


		if($data['body']){
			$sn = SITE_NAME;
			$msg['messages_to'] = $import['join_players_id'];
			$msg['messages_sender'] = $mod_id;
			$msg['messages_subject'] = "Horse Imported";
			$msg['messages_body'] = "<a href='/horses/view/" . $horse['horses_id'] ."'>" . $horse['horses_name'] ." #" . generateId($horse['horses_id']) . "</a> has been imported successfully.<br><br>". $data['body'] . "<br><br>Sincerely,<br>$sn Team";
			$result = $CI->messages->send($msg);
		}
	}


	public static function reject_import($data, $mod_id){
		$CI =& get_instance();
		$CI->load->model('messages');
		$EXPORT_ID = EXPORT_ID;
		$horse = new Horse($data['horses_id']);
		$horse = $horse->horse;

		//get import info
		$import = $CI->db->query("SELECT * FROM import_requests WHERE import_requests_id=? AND join_horses_id=? AND import_requests_accepted=0", array($data['import_requests_id'], $data['horses_id']))->row_array();

		$message = "Your import request was denied for horse <a href='/horses/view/" . $horse['horses_id'] ."'>" . $horse['horses_competition_title'] ." " . $horse['horses_breeding_title'] . " " . $horse['horses_name'] . " #". generateId($horse['horses_id']) . "</a>";

		$CI->db->query("DELETE FROM import_requests WHERE import_requests_id=? LIMIT 1", array($import['import_requests_id']));

		$CI->db->query("INSERT INTO notices(join_players_id, notices_body) VALUES(?, ?)", array($horse['join_players_id'], $message));

		if($data['body']){
			$sn = SITE_NAME;
			$msg['messages_to'] = $horse['join_players_id'];
			$msg['messages_sender'] = $mod_id;
			$msg['messages_subject'] = "Horse Import Rejected";
			$msg['messages_body'] = "<a href='/horses/view/" . $horse['horses_id'] ."'>" . $horse['horses_name'] ." #" . generateId($horse['horses_id']) . "</a> has been rejected for import.<br><br>". $data['body'] . "<br><br>Sincerely,<br>$sn Team";
			$result = $CI->messages->send($msg);
		}
	}



	public static function reject_breeding($data, $mod_id){
		$CI =& get_instance();
		$CI->load->model('messages');
		$EXPORT_ID = EXPORT_ID;
		$horse = new Horse($data['horses_id']);
		$horse = $horse->horse;

		//get import info
		$import = $CI->db->query("SELECT * FROM import_requests WHERE import_requests_id=? AND join_horses_id=? AND import_requests_accepted=0", array($data['import_requests_id'], $data['horses_id']))->row_array();

		$message = "Your breeding request was denied for <a href='/horses/view/" . $horse['horses_id'] ."'>" . $horse['horses_competition_title'] ." " . $horse['horses_breeding_title'] . " " . $horse['horses_name'] . " #". $horse['horses_id'] . "</a>";

		$CI->db->query("DELETE FROM import_requests WHERE import_requests_id=? LIMIT 1", array($import['import_requests_id']));

		$CI->db->query("INSERT INTO notices(join_players_id, notices_body) VALUES(?, ?)", array($horse['join_players_id'], $message));

		if($data['body']){
			$sn = SITE_NAME;
			$msg['messages_to'] = $horse['join_players_id'];
			$msg['messages_sender'] = $mod_id;
			$msg['messages_subject'] = "Horse Import Rejected";
			$msg['messages_body'] = "<a href='/horses/view/" . $horse['horses_id'] ."'>" . $horse['horses_name'] ." #" . generateId($horse['horses_id']) . "</a> has been rejected for import.<br><br>". $data['body'] . "<br><br>Sincerely,<br>$sn Team";
			$result = $CI->messages->send($msg);
		}
	}

	public static function admin_get_import(){ // get import requests
		$CI =& get_instance();
		$EXPORT_ID = EXPORT_ID;
		return $CI->db->query("
				SELECT ir.*, p.players_nickname, ir.join_players_id AS import_requests_players_id, h.*
				FROM import_requests ir
					LEFT JOIN horses h ON ir.join_horses_id=h.horses_id
					LEFT JOIN players p ON ir.join_players_id=p.players_id
				WHERE ir.import_requests_accepted=0 AND h.join_players_id=? ORDER BY h.horses_pending_export_date ASC", array($EXPORT_ID))->result_array();
	}


	public static function get_restricted_names(){
		$CI =& get_instance();
		$breeds = $CI->db->query("SELECT * FROM restricted ORDER BY restricted_name ASC")->result_array();
		foreach($breeds AS $k => $v){
			$normalized[$v['restricted_id']] = $v['restricted_name'];
		}
		return $normalized;
	}

	public static function get_breeds(){
		$CI =& get_instance();
		$breeds = $CI->db->query("SELECT * FROM breeds ORDER BY breed_name ASC")->result_array();
		foreach($breeds AS $k => $v){
			$normalized[$v['breed_id']] = $v['breed_name'];
		}
		return $normalized;
	}


	public static function get_genes($data = null){
		$CI =& get_instance();
		if($data['join_genes_categories_name']){
			$genes = $CI->db->query("SELECT * FROM genes WHERE join_genes_categories_name=? ORDER BY genes_name ASC", array($data['join_genes_categories_name']))->result_array();
		}else{
			$genes = $CI->db->query("SELECT * FROM genes ORDER BY genes_name ASC")->result_array();
		}

		foreach($genes AS $k => $v){
			$normalized[$v['genes_id']] = $v;
		}
		return $normalized;
	}
	public static function get_gene($id){
		$CI =& get_instance();
		return $CI->db->query("SELECT * FROM genes WHERE genes_id=?", array($id))->row_array();
	}
	public static function get_genes_normalized($data = null){
		$genes = self::get_genes($data);

		foreach($genes AS $k => $v){
			$normalized[$v['genes_id']] = $v['genes_name'];
		}
		return $normalized;
	}

	public static function get_blueprints_by_gene_id($id){
		$CI =& get_instance();
		//get blueprints that include this gene
		return $CI->db->query("SELECT * FROM genes_blueprints WHERE genes_blueprints_id IN (SELECT join_genes_blueprints_id FROM genes_blueprints_x_genes WHERE join_genes_id=?)", array($id))->result_array();
	}

	public static function get_blueprints(){
		$CI =& get_instance();
		//all blueprints
		$blueprints = $CI->db->query("SELECT * FROM genes_blueprints ORDER BY genes_blueprints_name ASC")->result_array();
		foreach((array)$blueprints AS $i => $b){
			$genes = $CI->db->query("SELECT * FROM genes_blueprints_x_genes WHERE join_genes_blueprints_id=? ORDER BY genes_blueprints_x_genes_value", array($b['genes_blueprints_id']))->result_array();
			foreach((array)$genes AS $g){
				$blueprints[$i]['genes'][$g['join_genes_id']] []= $g;
				$blueprints[$i]['genes'][$g['join_genes_id']]['values'] []= $g['genes_blueprints_x_genes_value'];
			}
		}
		return $blueprints;
	}

	public static function get_blueprints_normalized(){
		$CI =& get_instance();
		$blueprints = self::get_blueprints();

		foreach($blueprints AS $k => $v){
			$normalized[$v['genes_blueprints_id']] = $v['genes_blueprints_name'];
		}
		return $normalized;
	}

	public static function get_blueprint($id){
		$CI =& get_instance();
		//all blueprints
		$blueprints = $CI->db->query("SELECT * FROM genes_blueprints WHERE genes_blueprints_id=?", array($id))->row_array();
		$genes = $CI->db->query("SELECT * FROM genes_blueprints_x_genes WHERE join_genes_blueprints_id=? ORDER BY genes_blueprints_x_genes_value", array($blueprints['genes_blueprints_id']))->result_array();
		foreach((array)$genes AS $v){
			$blueprints['genes'][$v['join_genes_id']] []= $v;
		}

	//	pre($CI->db->last_query());
	//	pre($blueprints);exit;
		return $blueprints;
	}


	public static function get_genes_categories(){
		$CI =& get_instance();
		$breeds = $CI->db->query("SELECT * FROM genes_categories ORDER BY genes_categories_name ASC")->result_array();
		foreach($breeds AS $k => $v){
			$normalized[$v['genes_categories_id']] = $v['genes_categories_name'];
		}
		return $normalized;
	}

	public static function get_base_colors(){
		$CI =& get_instance();
		$breeds = $CI->db->query("SELECT * FROM colors WHERE colors_base=1 ORDER BY colors_name ASC")->result_array();
		foreach($breeds AS $k => $v){
			$normalized[$v['colors_id']] = $v['colors_name'];
		}
		return $normalized;
	}

	public static function get_base_patterns(){
		$CI =& get_instance();
		$breeds = $CI->db->query("SELECT * FROM colors WHERE colors_pattern=1 ORDER BY colors_name ASC")->result_array();
		foreach($breeds AS $k => $v){
			$normalized[$v['colors_id']] = $v['colors_name'];
		}
		return $normalized;
	}

	public static function get_lines(){
		$CI =& get_instance();
		$breeds = $CI->db->query("SELECT * FROM horse_lines ORDER BY horse_lines_name ASC")->result_array();
		foreach($breeds AS $k => $v){
			$normalized[$v['horse_lines_id']] = $v['horse_lines_name'];
		}
		return $normalized;
	}

	public static function get_disciplines(){
		$CI =& get_instance();
		$breeds = $CI->db->query("SELECT * FROM disciplines ORDER BY disciplines_name ASC")->result_array();
		foreach($breeds AS $k => $v){
			$normalized[$v['disciplines_id']] = $v['disciplines_name'];
		}
		return $normalized;
	}

	public static function get_horses($player_id){
		//get all horses owned by this player
		$CI =& get_instance();
		$horses = $CI->db->query("SELECT * FROM horses WHERE join_players_id=? AND horses_pending=0 AND horses_exported=0 ORDER BY horses_name ASC", array($player_id))->result_array();
		return $horses;
	}

	public static function get_horses_dropdown($player_id){
		$CI =& get_instance();
		$horses = self::get_horses($player_id);
		foreach($horses AS $k => $v){
			$normalized[$v['horses_id']] = $v['horses_name'] . " (#". $v['horses_id'] ."), " . $v['horses_breed'] . ", " . $v['horses_gender'];
		}
		return $normalized;
	}

	public static function get_breedable_mares($player_id){ 
		//get all mares that are eligible to breed for this player
		$year_start = date('Y') - 32;
		$CI =& get_instance();
		$breeds = $CI->db->query("SELECT * FROM horses WHERE join_players_id=? AND horses_gender='Mare' AND horses_pending=0 AND horses_exported=0 AND horses_birthyear>=? AND horses_bred=0 ORDER BY horses_name ASC", array($player_id, $year_start))->result_array();
		foreach($breeds AS $k => $v){
			$normalized[$v['horses_id']] = $v['horses_name'] . ", " . $v['horses_breed'];
		}
		return $normalized;
	}
	public static function get_breedable_stallions($player_id){
		//get all mares that are eligible to breed for this player
		$year_start = date('Y') - 26;
		$CI =& get_instance();
		$breeds = $CI->db->query("SELECT * FROM horses WHERE join_players_id=? AND horses_gender='Stallion' AND horses_pending=0 AND horses_exported=0 AND horses_birthyear >= ? AND horses_bred = 0 ORDER BY horses_name ASC", array($player_id, $year_start))->result_array();
		foreach($breeds AS $k => $v){
			$normalized[$v['horses_id']] = $v['horses_name'] . ", " . $v['horses_breed'];
		}
		return $normalized;
	}

	public static function is_breedable($horse_id,$check_mare_fee = false){
		//check that horse is breedable.
		$year_start = date('Y') - 32;
		$CI =& get_instance();		
		$horse = $CI->db->query("SELECT horses_id, horses_breeding_fee, horses_gender FROM horses WHERE horses_id=? AND ((horses_gender='Mare'  AND horses_bred=0) OR horses_gender='Stallion') AND horses_pending=0 AND horses_exported=0 AND horses_birthyear>=? LIMIT 1", array($horse_id, $year_start))->row_array();
		if($horse['horses_id']){						
			if($check_mare_fee)
			{			
				if($horse['horses_gender'] == "Stallion"){
					return true;
				}elseif($horse['horses_gender'] == "Mare" && $horse['horses_breeding_fee'] > 0){
					return true;
				}
			}else
			{			
				if($horse['horses_gender'] == "Stallion" && $horse['horses_breeding_fee'] > 0){
					return true;
				}elseif($horse['horses_gender'] == "Mare"){
					return true;
				}
			}			
		}
		return false;
	}
	public static function change_disciplines($horse_id, $disciplines){
		//delete the old
		$CI =& get_instance();
		$CI->db->query("DELETE FROM horses_x_disciplines WHERE join_horses_id=?", array($horse_id));

		if(count($disciplines)){
			foreach((array)$disciplines AS $d){
				$wheres []= '?';
			}

			$wheres = implode(',', $wheres);
			$selected = $CI->db->query("SELECT disciplines_name FROM disciplines WHERE disciplines_name IN (".$wheres.")", $disciplines)->result_array();

			foreach((array)$selected AS $d){
				$disciplines2 []= $d['disciplines_name'];
			}
			sort($disciplines);
			sort($disciplines2);

			if($disciplines != $disciplines2){
				return (array('errors' => array('disciplines[]' => "Invalid discipline.")));
			}

			$disciplines = $disciplines2;
			unset($disciplines2);

			foreach((array)$disciplines AS $d){
				$update_data = array('disciplines_name' => $d, 'join_horses_id' => $horse_id);
				$CI->db->insert('horses_x_disciplines', $update_data);
			}
		}
		return true;
	}

	public static function breeding_request_exists($stallion_id, $mare_id, $horses_breedings_id = 0){
		$CI =& get_instance();

		if($horses_breedings_id != 0){
			$request = $CI->db->query("SELECT horses_breedings_id FROM horses_breedings WHERE horses_breedings_id=? LIMIT 1", array($horses_breedings_id))->row_array();
		}else{
			$request = $CI->db->query("SELECT horses_breedings_id FROM horses_breedings WHERE join_horses_id=? AND join_mares_id=? LIMIT 1", array($stallion_id, $mare_id))->row_array();
		}
		if($request['horses_breedings_id']){
			return true;
		}
		return false;
	}

	public static function get_breeding_requests($stallion,$player_id = false){
		$CI =& get_instance();
		if($stallion && $player_id)
		{			
			$requests = $CI->db->query("SELECT * FROM horses_breedings WHERE join_horses_id = ? AND receiver_player_id = ? and join_horses_id = ? AND sender_player_id = ? ",array($stallion['horses_id'],$player_id,$stallion['horses_id'],$player_id))->result_array();
		}else
		{
			$requests = $CI->db->query("SELECT * FROM horses_breedings  WHERE receiver_player_id=? or sender_player_id=?",array($player_id,$player_id))->result_array();
		}		
		foreach((array)$requests AS $k => $v){			
			$dam = new Horse($v['join_mares_id']);
			$dam = $dam->horse;
			$stallion = new Horse($v['join_horses_id']);
			$stallion = $stallion->horse;
			$requests[$k]['stallion'] = $stallion;
			$requests[$k]['mare'] = $dam;
			$requests[$k]['genes'] = self::get_blueprint_possibilities_offspring($stallion['genes'], $dam['genes']);
		}
		return $requests;
	}
	public static function get_breeding_request($id){
		$CI =& get_instance();
		return $CI->db->query("SELECT * FROM horses_breedings WHERE horses_breedings_id=? LIMIT 1", array($id))->row_array();
	}

	public static function accept_breed_request($player, $horse, $data, $is_resend = false){
		$CI =& get_instance();
		$post = $data; //the post info
		$data = $CI->db->query("SELECT * FROM horses_breedings WHERE horses_breedings_id=? LIMIT 1", array($data['horses_breedings_id']))->row_array();
		$mare = new Horse($data['join_mares_id']);
		$stallion = new Horse($data['join_horses_id']);
		$mare = $mare->horse;
		$stallion = $stallion->horse;
		$mare_birthyear = self::getBirthYear($data['join_mares_id']);
		$stallion_birthyear = self::getBirthYear($data['join_horses_id']);
		$name_exists = $CI->db->query("SELECT horses_id FROM horses WHERE horses_name=? LIMIT 1", array($post['horses_name']))->row_array();
		if(!$post['horses_name']){
			$errors['horses_name'] = "Name is required.";
		}elseif(strlen($post['horses_name']) > 50){
			$errors['horses_name'] = "Name is no more than 50 charactors.";
		}elseif($name_exists){
			$errors['horses_name'] = "That horse name is already in use.";
		}
		if(strpos($post['horses_owner'],"Mare's Owner")  !== false){
			$post['horses_owner'] = $mare['join_players_id'];
		}else{
			$post['horses_owner'] = $stallion['join_players_id'];
		}
		if(!self::breeding_request_exists(0, 0, $data['horses_breedings_id'])){
			$errors[] = "Invalid breeding request.";
		}		
		if($horse['join_players_id'] != $player->player['players_id'] && $mare['join_players_id'] != $player->player['players_id'] ){
			$errors[] = "You don't own this horse.";
		}
		if(!in_array($post['horses_gender'], array('Mare', 'Stallion', 'Gelding'))){
			$errors['horses_gender'] = "Invalid gender.";
		}
		if(is_array($post['disciplines'])){
			$post['disciplines'] = implode(',', $post['disciplines']);
		}
		if(!empty($mare['horses_id'])){
				$year_exists = $CI->db->query("SELECT horses_id FROM horses WHERE  horses_birthyear = ? AND horses_dam = ? LIMIT 1", array($post['horses_birthyear'],$mare['horses_id']))->row_array();
		}
		/* check horse is foal year born  */
		if(!$post['horses_birthyear']){
			$errors['horses_birthyear'] = "Birth year is required.";
		}elseif($post['horses_birthyear'] > date('Y') || $post['horses_birthyear'] < "1950"){
			$errors['horses_birthyear'] = "Invalid birth year.";
		}elseif($year_exists){
			$errors['horses_birthyear'] = "The Mare has a foal born that year.";
		}elseif(($post['horses_birthyear'] < ($mare_birthyear+2)) || ($post['horses_birthyear'] < ($stallion_birthyear+2))){
			$errors['horses_birthyear'] = "The Foal must be younger.";
		}
		/* check horse is foal year born  end*/
		if(count($errors) > 0){
			return array('errors' => $errors);
		}
		if($is_resend)
		{
			$player = new Player($post['horses_owner']);
			$players_nickname = $player->player['players_nickname'];
			$CI->db->query("UPDATE horses_breedings SET  horses_breedings_name=?,horses_birthyear=?, horses_breedings_gender=?, horses_breedings_owner=?,horses_breedings_owner_nickname = ?, horses_breedings_breed=?, horses_breedings_breed2=?, horses_breedings_color=?, horses_breedings_pattern=?, horses_breedings_line=?, horses_breedings_disciplines=?, horses_breeding_is_rejected_temporarily=0, horses_breeding_user_id_fixes=0 WHERE horses_breedings_id=? AND horses_breedings_accepted=0 LIMIT 1", array($post['horses_name'],$post['horses_birthyear'], $post['horses_gender'], $post['horses_owner'],$players_nickname, $post['horses_breed'], $post['horses_breed2'], $post['horses_color'], $post['horses_pattern'], $post['horses_line'], $post['disciplines'], $data['horses_breedings_id']));
			return array('errors' => $errors, 'notices' => $notices, 'horse_id' => $horse['horses_id']);
		}else
		{
			$message = "Breeding request accepted! <a href='/horses/view/" . $data['join_mares_id'] ."'>" . $mare['horses_competition_title'] ." " . $mare['horses_breeding_title'] . " " . $mare['horses_name'] . " #". generateId($mare['horses_id']) . "</a> x <a href='/horses/view/" . $data['join_horses_id'] ."'>" . $stallion['horses_competition_title'] ." " . $stallion['horses_breeding_title'] . " " . $stallion['horses_name'] . " #". generateId($stallion['horses_id']) . "</a> for <font color=green>$" . $data['horses_breedings_fee'] . "</font>.";
			$message1 = $message . " <i>A moderator must now approve the breeding.</i>";
			if($stallion['join_players_id'] != $mare['join_players_id']){
				$CI->db->query("INSERT INTO notices(join_players_id, notices_body) VALUES(?, ?), (?, ?)", array($stallion['join_players_id'], $message1, $mare['join_players_id'], $message1));
			}else{
				$CI->db->query("INSERT INTO notices(join_players_id, notices_body) VALUES(?, ?)", array($stallion['join_players_id'], $message1));
			}
			$player = new Player($post['horses_owner']);
			$players_nickname = $player->player['players_nickname'];
			$CI->db->query("UPDATE horses_breedings SET  horses_breedings_name=?,horses_birthyear=?, horses_breedings_accepted=1, horses_breedings_gender=?, horses_breedings_owner=?,horses_breedings_owner_nickname = ?, horses_breedings_breed=?, horses_breedings_breed2=?, horses_breedings_color=?, horses_breedings_pattern=?, horses_breedings_line=?, horses_breedings_disciplines=? WHERE horses_breedings_id=? AND horses_breedings_accepted=0 LIMIT 1", array($post['horses_name'],$post['horses_birthyear'], $post['horses_gender'], $post['horses_owner'],$players_nickname, $post['horses_breed'], $post['horses_breed2'], $post['horses_color'], $post['horses_pattern'], $post['horses_line'], $post['disciplines'], $data['horses_breedings_id']));
			return array('errors' => $errors, 'notices' => $notices, 'horse_id' => $horse['horses_id']);
		}
	}

	public static function reject_breed_request($player, $horse, $data, $is_temprarily = false){
		$CI =& get_instance();
		$data = $CI->db->query("SELECT * FROM horses_breedings WHERE horses_breedings_id=? LIMIT 1", array($data['horses_breedings_id']))->row_array();
		$mare = new Horse($data['join_mares_id']);
		$stallion = new Horse($data['join_horses_id']);
		$mare = $mare->horse;
		$stallion = $stallion->horse;
		$errors = [];
		if($is_temprarily && !@$_REQUEST['message'])
		{
			$errors['message'] = "Please enter a message for give them the option to fix it.";
		}elseif($is_temprarily && strlen(@$_REQUEST['message']) < 10)
		{
			$errors['message'] = "Please enter a message atleast 10 charactors.";
		}elseif($is_temprarily && strlen(@$_REQUEST['message']) > 10000)
		{
			$errors['message'] = "Please enter a message no more than 10000 charactors.";
		}
		if(!self::breeding_request_exists(0, 0, $data['horses_breedings_id'])){
			$errors['horses_name'] = "Invalid breeding request.";
		}
		if($horse['join_players_id'] != $player->player['players_id']){
			$errors['horses_name'] = "You don't own this stallion.";
		}
		if(count($errors) > 0){
			return array('errors' => $errors);
		}
		$msg = "Breeding request rejected.";
		if(!empty($_REQUEST['message']))
		{
			$msg = $_REQUEST['message'];
		}
		$message = $msg." <a href='/horses/view/" . $data['join_mares_id'] ."'>" . $mare['horses_competition_title'] ." " . $mare['horses_breeding_title'] . " " . $mare['horses_name'] . " #". generateId($mare['horses_id']) . "</a> x <a href='/horses/view/" . $data['join_horses_id'] ."'>" . $stallion['horses_competition_title'] ." " . $stallion['horses_breeding_title'] . " " . $stallion['horses_name'] . " #". generateId($stallion['horses_id']) . "</a>";
		if($stallion['join_players_id'] != $mare['join_players_id']){
			$CI->db->query("INSERT INTO notices(join_players_id, notices_body) VALUES(?, ?), (?, ?)", array($stallion['join_players_id'], $message, $mare['join_players_id'], $message));
		}else{			
			$CI->db->query("INSERT INTO notices(join_players_id, notices_body) VALUES(?, ?)", array($data['sender_player_id'], $message));
		}
		if($is_temprarily)
		{
			$horses_breeding_user_id_fixes = $stallion['join_players_id'] != $mare['join_players_id'] ? $mare['join_players_id'] : $data['sender_player_id'];
			$CI->db->query("UPDATE horses_breedings SET horses_breeding_is_rejected_temporarily=1, horses_breeding_reject_reason=?, horses_breeding_user_id_fixes=? WHERE horses_breedings_id=? LIMIT 1", array($msg,$horses_breeding_user_id_fixes,$data['horses_breedings_id']));
		}else
		{
			$CI->db->query("DELETE FROM horses_breedings WHERE horses_breedings_id=? LIMIT 1", array($data['horses_breedings_id']));
		}
		return array('errors' => $errors, 'notices' => $notices, 'horse_id' => $horse['horses_id']);
	}
	public static function import($player, $horse, $data){
		//allowed is the list of each breed, color, etc. that is allowed as an option
		$CI =& get_instance();
		$CI->load->model('bank');
		$horse = new Horse($horse['horses_id']);
		$player = $player->player;
		$horse = $horse->horse;
		$bank_money = $CI->db->query("SELECT bank_balance FROM bank WHERE bank_id=? AND join_players_id=? AND bank_type='Checking' AND bank_pending=0 AND bank_closed=0", array($data['bank_id'], $player['players_id']))->row_array();
		$bank_money = $bank_money['bank_balance'];
		if($bank_money < $horse['horses_sale']){
			$errors []= "You cannot afford this horse.";
		}
		if($horse['join_players_id'] != EXPORT_ID){
			$errors[] = "Horse isn't available for import.";
		}elseif(!$horse['horses_sale']){
			$errors[] = "Horse import price hasn't been set yet.";
		}
		if(count($errors) > 0){
			return array('errors' => $errors);
		}


		//---------automatically move money
		//initiate transfer
		$transfer_data['transfer_id'] = EXPORT_BANK_ID;
		$transfer_data['transfer_to'] = EXPORT_BANK_ID;
		$transfer_data['transfer_from'] = $data['bank_id'];
		$transfer_data['transfer_amount'] = $horse['horses_sale'];
		$transfer_data['transfer_memo'] = 'Horse Import';
		$transfer_data['transfer_recurring'] = 'No';
		$transfer = Bank::transfer($player, $transfer_data);

		//pre($transfer);exit;

		//update horse
		$CI->db->query("UPDATE horses SET join_players_id=?, horses_sale=0 WHERE horses_id=?", array($player['players_id'], $horse['horses_id']));


		//insert owner log
		$player = $CI->db->query("SELECT * FROM players WHERE players_id=?", array($player['players_id']))->row_array();
		$CI->db->query('INSERT INTO horse_records(join_horses_id, join_players_id, horse_records_type, owner_name) VALUES(?, ?, "Owner", ?)', array($horse['horses_id'], $player['players_id'], @$player['players_nickname']));

		$message = "<a href='/horses/view/" . $horse['horses_id'] . "'>". $horse['horses_competition_title'] . " " . $horse['horses_breeding_title'] . " " . $horse['horses_name'] . " #" . generateId($horse['horses_id']) . "</a> has been imported.";

		$CI->db->query("INSERT INTO notices(join_players_id, notices_body) VALUES(?, ?)", array($player['players_id'], $message));

		return array('errors' => $errors, 'notices' => $notices, 'horse_id' => $horse['horses_id']);



	}
	public static function submit_mare_breed_request($player, $mare, $data, $allowed = array()){					
		
		//allowed is the list of each breed, color, etc. that is allowed as an option
		$post = $data;
		$CI =& get_instance();
		$stallion = new Horse($data['stallion_id']);
		$player = $player->player;
		$stallion = $stallion->horse;				
		//do stallion & mare validation
		if(@$stallion['horses_id'] && !self::is_breedable($stallion['horses_id'],true)){
			$errors['common'] = "Stallion is not breedable.";
		}elseif(@$stallion['horses_id']){
			if($stallion['horses_vet'] === "0000-00-00")
			{
				$errors['stallion_id'] = "Stallion Vet not up to date";
			} 
			if($stallion['horses_farrier'] === "0000-00-00")
			{
				$errors['stallion_id'] = "Stallion Farrier not up to date";	
			}
		}
		if(@$mare['horses_id'] && !self::is_breedable($mare['horses_id'],true)){
			$errors['common'] = "Mare is not breedable.";
		}elseif(@$mare['horses_id'])
		{
			if($mare['horses_vet'] === "0000-00-00")
			{
				$errors['common'] = "Mare Vet not up to date";
			} 
			if($mare['horses_farrier'] === "0000-00-00")
			{
				$errors['common'] = "Mare Farrier not up to date";	
			}
		}
		if(!@$data['stallion_id'])
		{
			$errors['stallion_id'] = "Please select mare horse.";
		}elseif($stallion['join_players_id'] != $player['players_id']){
			$errors['stallion_id'] = "You do not own this stallion.";
		}
		if(self::breeding_request_exists($stallion['horses_id'], $mare['horses_id'])){
			$errors['stallion_id'] = "Breeding request already exists.";
		}		
		$check = in_array($post['horses_breed'], $allowed['breeds']);
		if(!$check){
			$errors['horses_breed'] = "Invalid breed.";
		}
		$check = in_array($post['horses_color'], $allowed['base_colors']);
		if(!$check){
			$errors['horses_color'] = "Invalid base color.";
		}
		$check = in_array($post['horses_pattern'], $allowed['base_patterns']);
		if(!$check){
			$errors['horses_pattern'] = "Invalid pattern color.";
		}
		$check = in_array($post['horses_line'], $allowed['lines']);
		if(!$check AND $post['horses_line']){
			$errors['horses_line'] = "Invalid line.";
		}
	/*  */
		if(!$post['horses_name']){
			$errors['horses_name'] = "Name is required.";
		}elseif(strlen($post['horses_name']) > 50){
			$errors['horses_name'] = "Name is no more than 50 charactors.";
		}elseif(count($CI->db->query("SELECT horses_id FROM horses WHERE horses_name=? LIMIT 1", array($post['horses_name']))->row_array()) > 0){
			$errors['horses_name'] = "That horse name is already in use.";
		}
		if(!@$post['horses_owner'])
		{
			$errors['horses_owner'] = "Please select owner.";
		}elseif(strpos($post['horses_owner'],"Mare's Owner")  !== false){
			$post['horses_owner'] = $mare['join_players_id'];
			$post['horses_breedings_owner_nickname'] = $mare['players_nickname'];
		}else{
			$post['horses_owner'] = $stallion['join_players_id'];
			$post['horses_breedings_owner_nickname'] = $stallion['players_nickname'];
		}
		if(!@$errors['stallion_id'] && $stallion['join_players_id'] != $player['players_id'] && $mare['join_players_id'] != $player['players_id']){
			$errors['stallion_id'] = "You don't own this horse.";
		}
		if(!in_array($post['horses_gender'], array('Mare', 'Stallion', 'Gelding'))){
			$errors['horses_gender'] = "Invalid gender.";
		}
		if(is_array($post['disciplines'])){
			$post['disciplines'] = implode(',', $post['disciplines']);
		}
		$mare_birthyear = self::getBirthYear($mare['horses_id']); $stallion_birthyear = self::getBirthYear($stallion['horses_id']);
		/* check horse is foal year born  */
		if(!$post['horses_birthyear']){
			$errors['horses_birthyear'] = "Birth year is required.";
		}elseif($post['horses_birthyear'] > date('Y') || $post['horses_birthyear'] < "1950"){
			$errors['horses_birthyear'] = "Invalid birth year.";
		}elseif(count($CI->db->query("SELECT horses_id FROM horses WHERE  horses_birthyear = ? AND horses_dam = ? LIMIT 1", array($post['horses_birthyear'],$mare['horses_id']))->row_array()) > 0){
			$errors['horses_birthyear'] = "The Mare has a foal born that year.";
		}elseif(($post['horses_birthyear'] < ($mare_birthyear+2)) || ($post['horses_birthyear'] < ($stallion_birthyear+2))){
			$errors['horses_birthyear'] = "The Foal must be younger.";
		}		
		/* check horse is foal year born  end */
		if(count($errors) > 0){
			return array('errors' => $errors);
		}
	/*  */		
		//create request
		$horse['join_horses_id'] = $stallion['horses_id'];
		$horse['join_mares_id'] = $mare['horses_id'];
		$horse['horses_breedings_fee'] = $mare['horses_breeding_fee'];
		$horse['sender_player_id'] = $stallion['join_players_id'];
		$horse['receiver_player_id'] = $mare['join_players_id'];
		$horse['horses_breedings_name'] = $post['horses_name'];
		$horse['horses_birthyear'] = $post['horses_birthyear'];
		$horse['horses_breedings_gender'] = $post['horses_gender'];
		$horse['horses_breedings_owner'] = $post['horses_owner'];
		$horse['horses_breedings_owner_nickname'] = $post['horses_breedings_owner_nickname'];
		$horse['horses_breedings_breed'] = $post['horses_breed'];
		$horse['horses_breedings_breed2'] = $post['horses_breed2'];
		$horse['horses_breedings_color'] = $post['horses_color'];
		$horse['horses_breedings_pattern'] = $post['horses_pattern'];
		$horse['horses_breedings_line'] = $post['horses_line'];
		$horse['horses_breedings_disciplines'] = $post['disciplines'];		
		$horse['horses_breedings_accepted'] = 0;
		$CI->db->insert('horses_breedings', $horse);
	
		$message = "<a href='/horses/view/" . $stallion['horses_id'] . "'>". $stallion['horses_competition_title'] . " " . $stallion['horses_breeding_title'] . " " . $stallion['horses_name'] . " #" . generateId($stallion['horses_id']) . "</a> has requested a breeding to <a href='/horses/view/" . $mare['horses_id'] . "'>". $mare['horses_competition_title'] . " " . $mare['horses_breeding_title'] . " " . $mare['horses_name'] . " #" . generateId($mare['horses_id']) . "</a>.";
		//create notice to stallion owner
		if($mare['join_players_id'] == $player['players_id']){
			$CI->session->set_flashdata('notice', "Your request has been submitted. Please accept it to complete the breeding.");
		}else{
			$CI->db->query("INSERT INTO notices(join_players_id, notices_body) VALUES(?, ?)", array($mare['join_players_id'], $message));
			$CI->session->set_flashdata('notice', "Your request has been submitted.<br/>Remember to send a check for the stud fee!");
		}
		return array('errors' => $errors, 'notices' => $notices, 'horse_id' => $mare['horses_id']);
	}
	public static function submit_breed_request($player, $stallion, $data, $allowed = array()){					
		
		//allowed is the list of each breed, color, etc. that is allowed as an option		
		$CI =& get_instance();
		$post = $data;
		$mare = new Horse($data['mare_id']);
		$player = $player->player;	
		$mare = $mare->horse;		
		//do stallion & mare validation
		if(@$stallion['horses_id'] && !self::is_breedable($stallion['horses_id'])){
			$errors['common'] = "Stallion is not breedable.";
		}elseif(@$stallion['horses_id']){
			if($stallion['horses_vet'] === "0000-00-00")
			{
				$errors['common'] = "Stallion Farrier not up to date";	
			} 
			elseif($stallion['horses_farrier'] === "0000-00-00")
			{
				$errors['common'] = "Stallion Vet not up to date";	
			}
		}
		if(@$mare['horses_id'] && !self::is_breedable($mare['horses_id'])){
			$errors['common'] = "Mare is not breedable.";
		}elseif(@$mare['horses_id'])
		{			
			if($mare['horses_vet'] === "0000-00-00")
			{
				$errors['mare_id'] = "Mare Farrier not up to date";	
			} 
			elseif($mare['horses_farrier'] === "0000-00-00")
			{
				$errors['mare_id'] = "Mare Vet not up to date";
			}
		}		
		if(!@$data['mare_id'])
		{
			$errors['mare_id'] = "Please select mare horse.";
		}elseif($mare['join_players_id'] != $player['players_id']){
			$errors['mare_id'] = "You do not own this mare.";
		}
		if(self::breeding_request_exists($stallion['horses_id'], $mare['horses_id'])){
			$errors['mare_id'] = "Breeding request already exists.";
		}		
		$check = in_array($post['horses_breed'], $allowed['breeds']);
		if(!$check){
			$errors['horses_breed'] = "Invalid breed.";
		}
		$check = in_array($post['horses_color'], $allowed['base_colors']);
		if(!$check){
			$errors['horses_color'] = "Invalid base color.";
		}
		$check = in_array($post['horses_pattern'], $allowed['base_patterns']);
		if(!$check){
			$errors['horses_pattern'] = "Invalid pattern color.";
		}
		$check = in_array($post['horses_line'], $allowed['lines']);
		if(!$check AND $post['horses_line']){
			$errors['horses_line'] = "Invalid line.";
		}
/*  */
		if(!$post['horses_name']){
			$errors['horses_name'] = "Name is required.";
		}elseif(strlen($post['horses_name']) > 50){
			$errors['horses_name'] = "Name is no more than 50 charactors.";
		}elseif(count($CI->db->query("SELECT horses_id FROM horses WHERE horses_name=? LIMIT 1", array($post['horses_name']))->row_array()) > 0){
			$errors['horses_name'] = "That horse name is already in use.";
		}
		if(!@$post['horses_owner'])
		{
			$errors['horses_owner'] = "Please select owner.";
		}elseif(strpos($post['horses_owner'],"Mare's Owner")  !== false){
			$post['horses_owner'] = $mare['join_players_id'];
			$post['horses_breedings_owner_nickname'] = $mare['players_nickname'];
		}else{
			$post['horses_owner'] = $stallion['join_players_id'];
			$post['horses_breedings_owner_nickname'] = $stallion['players_nickname'];
		}
		if(!@$errors['mare_id'] && $stallion['join_players_id'] != $player['players_id'] && $mare['join_players_id'] != $player['players_id']){
			$errors['mare_id'] = "You don't own this horse.";
		}
		if(!in_array($post['horses_gender'], array('Mare', 'Stallion', 'Gelding'))){
			$errors['horses_gender'] = "Invalid gender.";
		}
		if(is_array($post['disciplines'])){
			$post['disciplines'] = implode(',', $post['disciplines']);
		}
		$mare_birthyear = self::getBirthYear($mare['horses_id']); $stallion_birthyear = self::getBirthYear($stallion['horses_id']);
		/* check horse is foal year born  */
		if(!$post['horses_birthyear']){
			$errors['horses_birthyear'] = "Birth year is required.";
		}elseif($post['horses_birthyear'] > date('Y') || $post['horses_birthyear'] < "1950"){
			$errors['horses_birthyear'] = "Invalid birth year.";
		}elseif(count($CI->db->query("SELECT horses_id FROM horses WHERE  horses_birthyear = ? AND horses_dam = ? LIMIT 1", array($post['horses_birthyear'],$mare['horses_id']))->row_array()) > 0){
			$errors['horses_birthyear'] = "The Mare has a foal born that year.";
		}elseif(($post['horses_birthyear'] < ($mare_birthyear+2)) || ($post['horses_birthyear'] < ($stallion_birthyear+2))){
			$errors['horses_birthyear'] = "The Foal must be younger.";
		}		
		/* check horse is foal year born  end */
		if(count($errors) > 0){
			return array('errors' => $errors);
		}
/*  */		
		//create request
		$horse['join_horses_id'] = $stallion['horses_id'];
		$horse['join_mares_id'] = $mare['horses_id'];
		$horse['horses_breedings_fee'] = $stallion['horses_breeding_fee'];
		$horse['sender_player_id'] = $mare['join_players_id'];
		$horse['receiver_player_id'] = $stallion['join_players_id'];
		$horse['horses_breedings_name'] = $post['horses_name'];
		$horse['horses_birthyear'] = $post['horses_birthyear'];
		$horse['horses_breedings_gender'] = $post['horses_gender'];
		$horse['horses_breedings_owner'] = $post['horses_owner'];
		$horse['horses_breedings_owner_nickname'] = $post['horses_breedings_owner_nickname'];
		$horse['horses_breedings_breed'] = $post['horses_breed'];
		$horse['horses_breedings_breed2'] = $post['horses_breed2'];
		$horse['horses_breedings_color'] = $post['horses_color'];
		$horse['horses_breedings_pattern'] = $post['horses_pattern'];
		$horse['horses_breedings_line'] = $post['horses_line'];
		$horse['horses_breedings_disciplines'] = $post['disciplines'];		
		$horse['horses_breedings_accepted'] = 0;
		$CI->db->insert('horses_breedings', $horse);

		$last_id = $CI->db->insert_id();

		$message = "<a href='/horses/view/" . $mare['horses_id'] . "'>". $mare['horses_competition_title'] . " " . $mare['horses_breeding_title'] . " " . $mare['horses_name'] . " #" . generateId($mare['horses_id']) . "</a> has requested a breeding to <a href='/horses/view/" . $stallion['horses_id'] . "'>". $stallion['horses_competition_title'] . " " . $stallion['horses_breeding_title'] . " " . $stallion['horses_name'] . " #" . generateId($stallion['horses_id']) . "</a>. Click <a href='/horses/breeding/accept/" . $last_id. "'>here</a> for accept this breeding and Click <a href='/horses/breeding/reject/" . $last_id . "'>here</a> for reject this breeding.";
		//create notice to stallion owner
		if($stallion['join_players_id'] == $player['players_id']){
			$CI->session->set_flashdata('notice', "Your request has been submitted. Please accept it to complete the breeding.");
		}else{
			$CI->db->query("INSERT INTO notices(join_players_id, notices_body) VALUES(?, ?)", array($stallion['join_players_id'], $message));
			$CI->session->set_flashdata('notice', "Your request has been submitted.<br/>Remember to send a check for the stud fee!");
		}
		return array('errors' => $errors, 'notices' => $notices, 'horse_id' => $stallion['horses_id']);
	}




	public static function sample_genes($h1, $h1_genes, $h2, $h2_genes){
		$genes = self::get_genes();

		//pre($genes);exit;

		//pre($h1_genes);exit;
		//normalize the genes
		$horse1 = array('horses_id' => $h1);
		$horse2 = array('horses_id' => $h2);
		foreach((array)$h1_genes AS $g){
			$horse1['genes'][$g['join_genes_id']] = $g;
		}
		unset($h1_genes);

		foreach((array)$h2_genes AS $g){
			$horse2['genes'][$g['join_genes_id']] = $g;
		}
		unset($h2_genes);

		foreach((array)$genes AS $i => $g){
			$foal['genes'][$i]['possibility1'] = $g['genes_code1'];
			$foal['genes'][$i]['possibility2'] = $g['genes_code2'];
			$foal['genes'][$i]['possibility3'] = $g['genes_code3'];
			$foal['genes'][$i]['possibility1_percent'] = 0;
			$foal['genes'][$i]['possibility2_percent'] = 0;
			$foal['genes'][$i]['possibility3_percent'] = 0;

			if(!$horse1['genes'][$i]['horses_x_genes_value']){
				$horse1['genes'][$i]['horses_x_genes_value'] = $g['genes_code3'];
			}
			if(!$horse2['genes'][$i]['horses_x_genes_value']){
				$horse2['genes'][$i]['horses_x_genes_value'] = $g['genes_code3'];
			}

			if($horse1['genes'][$i]['horses_x_genes_value'] == $horse2['genes'][$i]['horses_x_genes_value']){
				if($horse1['genes'][$i]['horses_x_genes_value'] == $g['genes_code1']){
					$foal['genes'][$i]['possibility1_percent'] = 100;
				}elseif($horse1['genes'][$i]['horses_x_genes_value'] == $g['genes_code2']){
					$foal['genes'][$i]['possibility1_percent'] = 25;
					$foal['genes'][$i]['possibility2_percent'] = 50;
					$foal['genes'][$i]['possibility3_percent'] = 25;
				}else{
					$foal['genes'][$i]['possibility3_percent'] = 100;
				}
			}else{
				if($horse1['genes'][$i]['horses_x_genes_value'] == $g['genes_code1'] AND $horse2['genes'][$i]['horses_x_genes_value'] == $g['genes_code2']){
					$foal['genes'][$i]['possibility1_percent'] = 50;
					$foal['genes'][$i]['possibility2_percent'] = 50;
				}elseif($horse1['genes'][$i]['horses_x_genes_value'] == $g['genes_code1'] AND $horse2['genes'][$i]['horses_x_genes_value'] == $g['genes_code3']){
					$foal['genes'][$i]['possibility2_percent'] = 100;

				}elseif($horse1['genes'][$i]['horses_x_genes_value'] == $g['genes_code2'] AND $horse2['genes'][$i]['horses_x_genes_value'] == $g['genes_code1']){
					$foal['genes'][$i]['possibility1_percent'] = 50;
					$foal['genes'][$i]['possibility2_percent'] = 50;
				}elseif($horse1['genes'][$i]['horses_x_genes_value'] == $g['genes_code2'] AND ($horse2['genes'][$i]['horses_x_genes_value'] == $g['genes_code3'] || !$horse2['genes'][$i]['horses_x_genes_value'])){
					$foal['genes'][$i]['possibility2_percent'] = 50;
					$foal['genes'][$i]['possibility3_percent'] = 50;

				}elseif($horse1['genes'][$i]['horses_x_genes_value'] == $g['genes_code3'] AND $horse2['genes'][$i]['horses_x_genes_value'] == $g['genes_code1']){
					$foal['genes'][$i]['possibility2_percent'] = 100;
				}elseif($horse1['genes'][$i]['horses_x_genes_value'] == $g['genes_code3'] AND $horse2['genes'][$i]['horses_x_genes_value'] == $g['genes_code2']){
					$foal['genes'][$i]['possibility2_percent'] = 50;
					$foal['genes'][$i]['possibility3_percent'] = 50;
				}else{
					$foal['genes'][$i]['possibility3_percent'] = 100;
				}
			}

		}
		$genes['horse1'] = $horse1;
		$genes['horse2'] = $horse2;
		$genes['foal'] = $foal;
		return $genes;
	}


	public static function get_breeds_types(){
		$CI =& get_instance();
		$breeds = $CI->db->query("SELECT breeds_type FROM breeds GROUP BY breeds_type ORDER BY breeds_type ASC")->result_array();
		foreach((array)$breeds AS $k => $v){
			$normalized[] = $v['breeds_type'];
		}
		return $normalized;
	}

	public static function has_evented_recently($data){
		$CI =& get_instance();
		/**********
		check if a horse has:
		-been in a show within the past 2 days
		-been in an event within the past 5 days
		-been in a race within the past 13 days
		*/
		//check forward 14 days and back 14 days
		$entries = $CI->db->query("SELECT ee.*, e.events_type, DATEDIFF(e.events_date1, NOW()) AS forward_date, DATEDIFF(NOW(), e.events_date1) AS backward_date FROM events_entrants ee LEFT JOIN events_x_classes exc ON exc.events_x_classes_id=ee.join_events_x_classes_id LEFT JOIN events e ON e.events_id=exc.join_events_id WHERE ee.join_horses_id=? AND exc.join_events_id!=? AND e.events_date1>=NOW() - INTERVAL 14 DAY AND e.events_date1 <=NOW() + INTERVAL 14 DAY", array($data['events_id'], $data['horse']['horses_id']))->result_array();
		foreach((array)$entries AS $e){
			if($e['events_type'] == "Show" AND ($e['forward_date'] >= -2 || $e['forward_date'] <= 2)){
				return true;
			}elseif($e['events_type'] == "Olympic" AND ($e['forward_date'] >= -2 || $e['forward_date'] <= 2)){
				return true;
			}elseif($e['events_type'] == "WEGs" AND ($e['forward_date'] >= -2 || $e['forward_date'] <= 2)){
				return true;
			}elseif($e['events_type'] == "Event" AND ($e['forward_date'] >= -5 || $e['forward_date'] <= 5)){
				return true;
			}elseif($e['events_type'] == "Race" AND ($e['forward_date'] >= -13 || $e['forward_date'] <= 13)){
				return true;
			}
		}
		return false;
	}


	public static function getHorseById($id,$res=false)
	{
		$CI =& get_instance();
		$horse_exists = $CI->db->query("SELECT * FROM horses WHERE  horses_id = ? LIMIT 1", array($id))->row_array();
		if($res && $horse_exists)
		{
			return $horse_exists;
		}
		if($horse_exists){
			return true;
		}
		return false;
	}
	/**** create horse  ****/
	public static function register($player, $horse, $allowed){		
		//allowed is the list of each breed, color, etc. that is allowed as an option
		$CI =& get_instance();		
		//does player have adoption credit?
		if($player->player['players_credits_creation'] < 1){
			$errors['horses_name'] = "You do not have any creation credits.";
		}
		if(self::getTodayAdoption($player->player['players_id']) >= $player->player['per_day_credits'])
		{
			$errors['horses_name'] = "You do not have any creation credits for Today.";
		}
		$check = in_array($horse['horses_breed'], $allowed['breeds']);				
		if(!$horse['horses_birthyear']){
			$errors['horses_birthyear'] = "Birth year is required.";
		}
		if($horse['horses_birthyear'] > date('Y') || $horse['horses_birthyear'] < "1950"){
			$errors['horses_birthyear'] = "Invalid birth year.";
		}		
		/*  */
			$sire = self::getHorseById($horse['horses_sire'],true);
			$dam = self::getHorseById($horse['horses_dam'],true);
			if($horse['horses_registration_type']=="breed" && empty($horse['horses_sire']) || $horse['horses_registration_type']=="breed" && !ctype_digit($horse['horses_sire']))
			{
				$errors['horses_sire'] = "Sire is required.";
			}elseif($horse['horses_registration_type']=="breed" &&  !$sire || $horse['horses_registration_type']=="breed" &&  $sire['horses_gender'] != 'Stallion')
			{								
				$errors['horses_sire'] = "This Sire Doesn't exist.";
			}elseif($horse['horses_registration_type'] == "creation" && $sire['horses_gender'] == "Gelding")
			{
				$errors['horses_sire'] = "Gelding Horse does not make Sire Please Provide Valid Sire Horse Entity.";
			}elseif($horse['horses_registration_type']=="breed" &&  self::getBirthYear($horse['horses_sire']) == $horse['horses_birthyear'])
			{
				$errors['horses_sire']="Foal Birth Year Matched with Sire birth year.";
			}elseif($horse['horses_registration_type']=="breed" && $horse['horses_birthyear'] < self::getBirthYear($horse['horses_sire']))
			{
				$errors['horses_sire']="Foal birth year is not greather than his Sire.";
			}

			if($horse['horses_registration_type']=="breed" && empty($horse['horses_dam']) ||  $horse['horses_registration_type']=="breed" && !ctype_digit($horse['horses_dam']))
			{
				$errors['horses_dam'] = "Dam is required.";
			}elseif($horse['horses_registration_type']=="breed" &&  !$dam || $horse['horses_registration_type']=="breed" &&  $dam['horses_gender'] != 'Mare')
			{
				$errors['horses_dam'] = "This Dam Doesn't exist.";
			}elseif($horse['horses_registration_type']=="breed" &&  self::getBirthYear($horse['horses_dam']) == $horse['horses_birthyear'])
			{
				$errors['horses_dam']="Foal Birth Year Matched with Dam birth year.";
			}elseif($horse['horses_registration_type']=="breed" &&  $horse['horses_birthyear'] < self::getBirthYear($horse['horses_dam']))
			{
				$errors['horses_dam']="Foal Birth Year is not greather than his Dam.";
			}elseif($horse['horses_registration_type']=="breed" && !empty($horse['horses_dam']))
			{
				$horse_id = $horse['horses_id'];
				$year_exists = $CI->db->query("SELECT horses_id FROM horses WHERE  horses_birthyear = ? AND horses_dam = ? LIMIT 1", array($horse['horses_birthyear'],$horse['horses_dam']))->row_array();
				if($year_exists){
					$errors['horses_dam'] = "The Mare has a foal born that year.";
				}
			}
			if($horse['horses_registration_type']=="breed" && $horse['horses_gender']=="Stallion" && !empty($horse['horses_sire']))
			{
				$birthDate = "01/01/".self::getBirthYear($horse['horses_sire']);
				$birthDate = explode("/", $birthDate);
				$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md") ? ((date("Y") - $birthDate[2]) - 1) : (date("Y") - $birthDate[2]));
				if($age < 3 || $age > 29)
				{
					$errors['horses_sire']="There is a Gender issue or that the horse is too young/old";
				}
			}			
			if($horse['horses_registration_type']=="breed" &&  $horse['horses_gender']=="Mare" && !empty($horse['horses_dam']))
			{
				$birthDate = "01/01/".self::getBirthYear($horse['horses_dam']);
				$birthDate = explode("/", $birthDate);
				$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md") ? ((date("Y") - $birthDate[2]) - 1) : (date("Y") - $birthDate[2]));
				if($age < 3 || $age > 25)
				{
					$errors['horses_dam']="There is a gender issue or that the horse is too young/old.";
				}
			}
		/*  */		
		if( !empty($horse['horses_breed'])  && !empty($horse['horses_sire']) && !empty($horse['horses_dam']) )
		{		
		
			$horses_breed = $CI->db->query("SELECT breed_id FROM breeds WHERE breed_name= ?  LIMIT 1", array($horse['horses_breed']))->row_array();	
		
			$hold=[];	
			$sire_breed = $CI->db->query("SELECT horses_breed FROM horses WHERE horses_id= ?  LIMIT 1", array($horse['horses_sire']))->row_array();	
		
			if($sire_breed){
             array_push($hold,$sire_breed['horses_breed']);
			}
			$dam_breed = $CI->db->query("SELECT horses_breed FROM horses WHERE horses_id= ?  LIMIT 1", array($horse['horses_dam']))->row_array();	
		
			if($dam_breed){
             array_push($hold,$dam_breed['horses_breed']);
			}
			
      if( !in_array($horse['horses_breed'],$hold) ){ 
			 $errors['horses_breed'] = "Breed must match with sire or dam.";
			}
		}
		if(!$check){
			$errors['horses_breed'] = "Invalid breed.";
		}
		$check = in_array($horse['horses_color'], $allowed['base_colors']);
		if(!$check){
			$errors['horses_color'] = "Invalid base color.";
		}
		$check = in_array($horse['horses_pattern'], $allowed['base_patterns']);
		if(!$check){
			$errors['horses_pattern'] = "Invalid pattern color.";
		}
		$check = in_array($horse['horses_line'], $allowed['lines']);
		if(!$check AND $horse['horses_line']){
			$errors['horses_line'] = "Invalid line.";
		}
		$check = in_array($horse['horses_gender'], array('Stallion', 'Mare', 'Gelding'));
		if(!$check){
			$errors['horses_gender'] = "Select gender.";
		}
		if(!$horse['horses_name']){
			$errors['horses_name'] = "Name is required.";
		}		

		//check if horse name is unique
		$name_exists = $CI->db->query("SELECT horses_id FROM horses WHERE horses_name=? LIMIT 1", array($horse['horses_name']))->row_array();
		if($name_exists){
			$errors['horses_name'] = "That horse name is already in use.";
		}
        
		//check if horse name is restricted
		$restricted = $CI->db->query("SELECT restricted_name FROM restricted WHERE restricted_name LIKE ? LIMIT 1", array($horse['horses_name']))->row_array();
		if($restricted){
			$errors['horses_name'] = "That horse name is restricted.";
		}

		if(count($errors) > 0){  
			return array('errors' => $errors);
		}
		//create horse
		$horse['join_players_id'] = $player->player['players_id'];
		$horse['players_nickname'] = $player->player['players_nickname'];
		$horse['horses_pending_date'] = date('Y-m-d H:i:s');
		$allowed_fields = array(
			'join_players_id',
			'players_nickname',
			'horses_name',
			'horses_breed',
			'horses_created',
			'horses_birthyear',
			'horses_gender',
			'horses_color',
			'horses_pattern',			
			'horses_breed2',
			'horses_line',
			'horses_sire',
			'horses_dam',
			'horses_pending_date',
			'horses_registration_type',
			'join_stables_id',
		);
		$horse['horses_created'] = $horse['horses_registration_type'] == "creation" ? 1 : 0;
		$update_data = filter_keys($horse, $allowed_fields);				
		$CI->db->insert('horses', $update_data);
		$horse_id = $CI->db->insert_id();
		//insert disciplines
		if(count($horse['disciplines'])){
			$disc = self::change_disciplines($horse_id, $horse['disciplines']);
			if($disc !== true){
				$CI->db->query("DELETE FROM horses WHERE horses_id=?", array($horse_id));
				return array('errors' => $disc['errors']);
			}
		}

		//update credits
	  if( $horse['horses_registration_type']!='breed' ){	
		$CI->db->query("UPDATE players SET players_credits_creation=players_credits_creation-1 WHERE players_id=? LIMIT 1", array($player->player['players_id']));
	  }	
		
		$player = $CI->db->query("SELECT * FROM players WHERE players_id=?", array($player->player['players_id']))->row_array();
		$CI->db->query('INSERT INTO horse_records(join_horses_id, join_players_id, horse_records_type, owner_name) VALUES(?, ?, "Owner", ?)', array($horse_id, $player['players_id'], @$player['players_nickname']));

		$CI->session->set_flashdata('notice', "Your horse is now pending registration.");

		return array('errors' => $errors, 'notices' => $notices, 'horse_id' => $horse_id);
	}

	public static function getTodayAdoption($player_id)
	{
		$CI =& get_instance();
		$res = $CI->db->query("SELECT count(horses_id) as total_records FROM horses WHERE horses_registration_type = ? AND join_players_id = ? AND DATE(`horses_pending_date`) = CURDATE()", array('creation',$player_id))->row_array();
		return $res['total_records'];
	}

	public function search_owners($data){
		$CI =& get_instance(); //allow us to use the db...
		$selects = $joins = $wheres = $params = array();

		/*
			SELECT hr.* FROM horse_records hr, p.players_nickname
			LEFT JOIN players p ON p.players_id=hr.join_players_id
			LEFT JOIN horses h ON h.horses_id=hr.join_horses_id
			WHERE
			LIMIT 500
		*/


        $selects = array(
            'hr.*',
            'hr.horse_records_id, hr.join_players_id AS horse_owner, DATE_FORMAT(hr.horse_records_date, "%Y/%m/%d") AS horse_records_date',
            'h.*'            
        );
        
        $joins[] = 'LEFT JOIN horses h ON h.horses_id=hr.join_horses_id';

        $wheres[] = 'hr.horse_records_type="Owner"';

		//---------- WHERES --------------
		if($data['owner_id']){
			$wheres [] = "hr.join_players_id=?";
			$params [] = $data['owner_id'];
		}
		if($data['start_date']){
			$wheres [] = "hr.horse_records_date>=?";
			$params [] = $data['start_date'];
		}
		if($data['end_date']){
			$wheres [] = "hr.horse_records_date<=?";
			$params [] = $data['end_date'];
		}
		if($data['horses_id']){
			$wheres [] = "h.horses_id=?";
			$params [] = $data['horses_id'];
		}
		if($data['horses_name']){
			$wheres [] = "h.horses_name LIKE ?";
			$params [] = '%' . $data['horses_name'] . '%';
		}
		if($data['horses_pattern']){
			$wheres [] = "h.horses_pattern LIKE ?";
			$params [] = '%' . $data['horses_pattern'] . '%';
		}
		if($data['horses_breed2']){
			$wheres [] = "h.horses_breed2 LIKE ?";
			$params [] = '%' . $data['horses_breed2'] . '%';
		}

		if($data['horses_birthyear']){
			$wheres [] = "h.horses_birthyear=?";
			$params [] = $data['horses_birthyear'];
		}
		if($data['horses_gender']){
			$wheres [] = "h.horses_gender=?";
			$params [] = $data['horses_gender'];
		}
		if($data['horses_breed']){
			$wheres [] = "h.horses_breed=?";
			$params [] = $data['horses_breed'];
		}
		if($data['horses_color']){
			$wheres [] = "h.horses_color=?";
			$params [] = $data['horses_color'];
		}
		if($data['horses_pattern']){
			$wheres [] = "h.horses_pattern=?";
			$params [] = $data['horses_pattern'];
		}
		if($data['horses_line']){
			$wheres [] = "h.horses_line=?";
			$params [] = $data['horses_line'];
		}

		if($data['horses_status'] == 0){
			$wheres [] = "h.horses_deceased=0";
			$wheres [] = "h.join_players_id!=" . EXPORT_ID;
		}elseif($data['horses_status'] == 1){
			$wheres [] = "h.horses_deceased=1";
		}elseif($data['horses_status'] == 2){
			$wheres [] = "h.join_players_id=" . EXPORT_ID;
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
		$owners = $CI->db->query('
			SELECT '. implode(', ', $selects) .'
			FROM horse_records AS hr
			'. implode("\n", $joins) .'
			'. $wheres .'
			ORDER BY hr.join_players_id ASC
		', $params)->result_array();
		//pre($CI->db->last_query());

		//normalize data for display purposes
		foreach((array)$owners AS $k => $v){
			$owners2[$v['horse_owner']]['join_players_id'] = $v['horse_owner'];
			$owners2[$v['horse_owner']]['players_nickname'] = $v['players_nickname'];
			$owners2[$v['horse_owner']]['horses'] []= $v;
			unset($owners[$k]);
		}

        return $owners2;
	}


	public function search($data){
		$CI =& get_instance(); //allow us to use the db...
		//$CI->load->library('strings');

		$selects = $joins = $wheres = $params = array();

		/*
			SELECT h.*, p.players_nickname FROM horses h
			LEFT JOIN players p ON p.players_id=h.join_players_id
			WHERE
			LIMIT 500
		*/

        $selects = array(
            'h.*'            
        );
        

		$wheres[] = 'horses_pending = 0';

		//---------- WHERES --------------		
		if($data['for_sale'] == 1){
			$wheres [] = "horses_sale = ?";
			$params [] = 1;			
			$wheres [] = "horses_sale_price > ?";
			$params [] = 0;
		}
		if($data['min_price']){
			$wheres [] = "horses_sale_price>=?";
			$params [] = $data['min_price'];
		}
		if($data['max_price']){
			$wheres [] = "horses_sale_price <= ? AND horses_sale_price > 0";
			$params [] = $data['max_price'];
		}
		if($data['horses_id']){
			$wheres [] = "horses_id=?";
			$params [] = $data['horses_id'];
		}
		if($data['join_players_id']){
			$wheres [] = "join_players_id=?";
			$params [] = $data['join_players_id'];
		}
		if($data['horses_name']){
			$wheres [] = "horses_name LIKE ?";
			$params [] = '%' . $data['horses_name'] . '%';
		}
		if($data['horses_pattern']){
			$wheres [] = "horses_pattern LIKE ?";
			$params [] = '%' . $data['horses_pattern'] . '%';
		}
		if($data['horses_breed2']){
			$wheres [] = "horses_breed2 LIKE ?";
			$params [] = '%' . $data['horses_breed2'] . '%';
		}

		if($data['horses_birthyear']){
			$wheres [] = "horses_birthyear=?";
			$params [] = $data['horses_birthyear'];
		}
		if($data['horses_gender']){
			$wheres [] = "horses_gender=?";
			$params [] = $data['horses_gender'];
		}
		if($data['horses_breed']){
			$wheres [] = "horses_breed=?";
			$params [] = $data['horses_breed'];
		}
		if($data['horses_color']){
			$wheres [] = "horses_color=?";
			$params [] = $data['horses_color'];
		}
		if($data['horses_pattern']){
			$wheres [] = "horses_pattern=?";
			$params [] = $data['horses_pattern'];
		}
		if($data['horses_line']){
			$wheres [] = "horses_line=?";
			$params [] = $data['horses_line'];
		}
		if($data['horses_adoptable']){
			$wheres [] = "horses_adoptable=1";
		}

		if($data['horses_status'] == 0){
			$wheres [] = "horses_deceased=0";
			$wheres [] = "horses_exported=0";
		}elseif($data['horses_status'] == 1){
			$wheres [] = "horses_deceased=1";
		}elseif($data['horses_status'] == 2){
			$wheres [] = "join_players_id=" + EXPORT_ID;
		}


		if($data['min_breed']){
			$wheres [] = "horses_breeding_fee>=?";
			$params [] = $data['min_breed'];
		}
		if($data['max_breed']){
			$wheres [] = "horses_breeding_fee<=? AND horses_breeding_fee>0";
			$params [] = $data['max_breed'];
		}

		$year_start = date('Y') - $data['min_age'];
		$year_end = date('Y') - $data['max_age'];
		if($data['min_age']){
			$wheres [] = "horses_birthyear<=?";
			$params [] = $year_start;
		}
		if($data['max_age']){
			$wheres [] = "horses_birthyear>=?";
			$params [] = $year_end;
		}

		if($data['owner_name']){
			$wheres [] = "players_nickname LIKE ?";
			$params [] = '%'.$data['owner_name'].'%';
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
		$horses = $CI->db->query('
			SELECT '. implode(', ', $selects) .'
			FROM horses AS h
			'. implode("\n", $joins) .'
			'. $wheres .'
		', $params)->result_array();
		//pre($CI->db->last_query());

        return $horses;
	}



	/* datatable related functions */
		public function getMyHorsesList($player_id,$postData)
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
			$this->db->select('horses.*,s.stables_name,p.players_username,p.players_id');
			$this->db->join('stables s','s.stables_id=horses.join_stables_id','LEFT');
			$this->db->join('players p','p.players_id=horses.join_players_id','LEFT');
			$this->db->from('horses');						
			if(is_numeric($player_id))
			{							
				$this->db->where('horses.join_players_id',$player_id);
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
		/* adoptable start */
		public function getAdoptableHorsesList($player_id,$postData)
		{
			$this->get_adoptable_list_query($player_id,$postData);
			if($postData['length'] != -1){
			  $this->db->limit($postData['length'],$postData['start']);
			}
			$query = $this->db->get();
			return $query->result_array();	
		}
		public function countAllAdoptable($player_id,$postData)
		{
			$this->get_adoptable_list_query($player_id,$postData);
			return $this->db->count_all_results();
		}
		public function countFilteredAdoptable($player_id,$postData)
		{			
			$this->get_adoptable_list_query($player_id,$postData);
			return $this->db->count_all_results();      
		}
		public function get_adoptable_list_query($player_id,$postData,$where=false)
		{													
			$this->db->select('horses.*,s.stables_name,p.players_username,p.players_id');
			$this->db->join('stables s','s.stables_id=horses.join_stables_id','LEFT');
			$this->db->join('players p','p.players_id=horses.join_players_id','LEFT');
			$this->db->from('horses');						
			if(is_numeric($player_id))
			{							
				$this->db->where('horses.join_players_id != ',$player_id);
				$this->db->where('horses.horses_adoptable',1);
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
		/* adoptable end */
	/* datatable  related functions end*/
	public function getMyStables($player_id)
	{
		$this->db->from('stables');
		$this->db->where('join_players_id = ',$player_id);
		$this->db->or_where('join_players_id = ',-1);
		$query = $this->db->get();
		$data = $query->result_array();
		$res = [];
		foreach ($data as $key => $value) {
			$res[$value['stables_id']] = $value['stables_name'];
		}		
		return $res;
	}
	public static function get_horses_vet_status($id)
	{
		$CI =& get_instance();
		$appt = $CI->db->query('SELECT * FROM horse_appointments ha WHERE ha.join_horses_id=? AND ha.horse_appointments_type = "Vet" AND ha.horse_appointments_completed = "0000-00-00 00:00:00" ORDER BY ha.horse_appointments_id ASC', array($id))->row_array();
		return count($appt) > 0 ? "Pending Approval" : false;
	}
	public static function get_horses_farrier_status($id)
	{
		$CI =& get_instance();
		$appt = $CI->db->query('SELECT * FROM horse_appointments ha WHERE ha.join_horses_id=? AND ha.horse_appointments_type = "Farrier" AND ha.horse_appointments_completed = "0000-00-00 00:00:00" ORDER BY ha.horse_appointments_id ASC', array($id))->row_array();
		return count($appt) > 0 ? "Pending Approval" : false;
	}

	public function getMyVetHorsesList($player_id,$type)
	{
		$this->db->select('horses_name,horses_id');
		$this->db->from('horses');
		$this->db->where('join_players_id',$player_id);		
		$this->db->order_by('horses_id','desc');		
		$query = $this->db->get();
		$data = $query->result_array();
		$res = [];		
		foreach ($data as $key => $horse) {
			if(($type == "vet" && self::get_horses_vet_status($horse['horses_id']) === false) || ($type == "farrier" && self::get_horses_farrier_status($horse['horses_id']) === false))
			{
				array_push($res,$horse);
			}
		}
		return $res;		
	}
}