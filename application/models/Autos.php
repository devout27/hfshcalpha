<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Autos extends CI_Model {

	function __construct(){
		$this->data['player_id'] = $this->session->userdata('players_id');
	}

	function bank_transfers(){
		//do the automatic transfers!
		//get all transfers from active accounts to active accounts
		//and make sure they are in the proper day to do the transfer
		//then do the actual transfer
		//if it's internal, do it immediately
		//otherwise, create a check.
		$day = date('d');
		$today = date('Y-m-d');
		$last_day = date('t');
		if($last_day == $day){
			//if it's the last day of the month, ensure transactions that would be run on the remaining days in a longer month would also be run (ie, the 31st)
			for($i = $day; $i <= 31; $i++){
				$day_query[] = "EXTRACT(DAY FROM br.bank_recurring_start_date)=" .$i;
			}
			$day_query = implode(' OR ', $day_query);
			$day_query = " OR " . $day_query;
		}

		//grab every record that can be processed today
		$days = $this->db->query("
				SELECT br.*,
					bf.join_players_id AS pid, bf.bank_balance, bf.bank_type,
					bt.join_players_id AS pid2, bt.bank_balance AS bank_balance2, bt.bank_type AS bank_type2
				FROM bank_recurring br
					JOIN bank bf ON br.join_bank_id=bf.bank_id
					JOIN bank bt ON br.bank_recurring_to=bt.bank_id
				WHERE
					bf.bank_pending=0 AND bf.bank_closed=0 AND bt.bank_pending=0 AND bt.bank_closed=0
					AND (
						(br.bank_recurring_days!=0 AND DATEDIFF(br.bank_recurring_start_date, NOW()) % br.bank_recurring_days = 0)
						OR (
							br.bank_recurring_months!=0
							AND TIMESTAMPDIFF(MONTH, br.bank_recurring_start_date, NOW()) % br.bank_recurring_months = 0
							AND (
								EXTRACT(DAY FROM br.bank_recurring_start_date) = ?
								$day_query
							)
						)
					)
			", array($day))->result_array();

		foreach((array)$days AS $d){
			//if loan OR internal, apply money instantly
			if($d['pid'] == $d['pid2'] || $d['bank_type2'] == "Loan"){
				//apply instantly
				$this->db->query("UPDATE bank SET bank_balance=bank_balance-? WHERE bank_id=?", array($d['bank_recurring_amount'], $d['bank_recurring_to'])); //decrease loan balance (add credit)
				$this->db->query("UPDATE bank SET bank_balance=bank_balance-? WHERE bank_id=?", array($d['bank_recurring_amount'], $d['join_bank_id'])); //decrease bank balance
				$insert_array = array();
				$insert_array ['bank_checks_from']= $d['join_bank_id'];
				$insert_array ['bank_checks_to_id']= $d['bank_recurring_to'];
				$insert_array ['bank_checks_amount']= $d['bank_recurring_amount'];
				$insert_array ['bank_checks_memo']= $d['bank_recurring_memo'] ?: "Automatic Transfer";
				$insert_array ['bank_checks_status']= "Deposited";
				$this->db->query("INSERT INTO bank_checks(join_bank_id, bank_checks_to_id, bank_checks_amount, bank_checks_memo, bank_checks_status) VALUES(?,?,?,?,?)", $insert_array); //create log

			}else{
				//create the check to be manually deposited
				$insert_array = array();
				$insert_array ['bank_checks_from']= $d['join_bank_id'];
				$insert_array ['bank_checks_to_id']= $d['bank_recurring_to'];
				$insert_array ['bank_checks_amount']= $d['bank_recurring_amount'];
				$insert_array ['bank_checks_memo']= $d['bank_recurring_memo'] ?: "Automatic Transfer";
				$insert_array ['bank_checks_status']= "Pending";
				$this->db->query("INSERT INTO bank_checks(join_bank_id, bank_checks_to_id, bank_checks_amount, bank_checks_memo, bank_checks_status) VALUES(?,?,?,?,?)", $insert_array); //create log
			}
		}
		echo "Updated transfers.";
	}

	function statement(){
		//update loan & checking accounts interest for the month. auto deposit/debit it.

		$accounts = $this->db->query("SELECT * FROM bank WHERE bank_pending=0 AND bank_closed=0")->result_array();

		foreach((array)$accounts AS $a){
			if($a['bank_type'] == "Loan"){
				$interest = $a['bank_balance'] * .02;
				$this->db->query("UPDATE bank SET bank_interest_incurred=?, bank_balance=bank_balance+? WHERE bank_id=?", array($interest, $interest, $a['bank_id']));
				$this->db->query("INSERT INTO bank_checks(join_bank_id, bank_checks_to_id, bank_checks_amount, bank_checks_memo, bank_checks_status) VALUES(?,?,?,?,?)", array($a['bank_id'], $a['bank_id'], $interest, 'Interest Incurred', 'Deposited')); //create log
			}elseif($a['bank_type'] == "Savings"){
				$interest = $a['bank_balance'] * .01;

				$this->db->query("UPDATE bank SET bank_interest_accrued=?, bank_balance=bank_balance+? WHERE bank_id=?", array($interest, $interest, $a['bank_id']));
				$this->db->query("INSERT INTO bank_checks(join_bank_id, bank_checks_to_id, bank_checks_amount, bank_checks_memo, bank_checks_status) VALUES(?,?,?,?,?)", array('0', $a['bank_id'], $interest, 'Interest Accrued', 'Deposited')); //create log

			}elseif($a['bank_type'] == "Checking" || $a['bank_type'] == "Business"){
				if($a['bank_tier'] == "A"){$stipend = 30000;
				}elseif($a['bank_tier'] == "B"){$stipend = 25000;
				}elseif($a['bank_tier'] == "C"){$stipend = 20000;
				}elseif($a['bank_tier'] == "E"){$stipend = 15000;
				}elseif($a['bank_tier'] == "F"){$stipend = 10000;
				}else{continue;}

				$this->db->query("UPDATE bank SET bank_balance=bank_balance+? WHERE bank_id=?", array($stipend, $a['bank_id']));
				$this->db->query("INSERT INTO bank_checks(join_bank_id, bank_checks_to_id, bank_checks_amount, bank_checks_memo, bank_checks_status) VALUES(?,?,?,?,?)", array($a['bank_id'], $a['bank_id'], $stipend, 'Monthly Paycheck', 'Deposited')); //create log
			}


		}

		//update loan due dates
		$this->db->query("UPDATE bank SET bank_credit_payment_due=LAST_DAY(DATE_ADD(NOW(), INTERVAL 1 MONTH)) WHERE bank_type='Loan' AND bank_balance>0 AND bank_credit_payment_due='0000-00-00'");

		echo "Stipends and interest applied.";
	}


	function auctions(){
		// complete auctions
		// if there's a bid, notify the winner. Place the winner's check into seller's account as pending.
		$this->load->model('auction');
		$this->load->model('bank');
		$auctions = $this->auction->get_auctions(array('auctions_end' => date('Y-m-d'), 'auctions_winning_bidder' => 0, 'include_expired' => 1));

		foreach((array)$auctions AS $k => $v){
			if(!$v['horses_id']){
  				continue;
  			}
			//get winning bid
			$winner = $auctions[$k]['bids'][0];
			if($winner['join_players_id']){
				//winner is found, let's create the check & messages, then update the winning bidder on the auction
				$transfer = array(
						'transfer_from' => $winner['join_bank_id'],
						'transfer_to' => $v['join_bank_id'],
						'transfer_amount' => $winner['auctions_bids_amount'],
						'transfer_memo' => 'Winning auction bid for Horse #' . generateId($v['join_horses_id']),
					);

				$player = array('players_id' => $v['horse_owner']);
				$this->db->query("INSERT INTO bank_checks(join_bank_id, bank_checks_to_id, bank_checks_amount, bank_checks_memo, bank_checks_status) VALUES(?,?,?,?,'Pending')", $transfer);

				$winner_notice = "You placed a winning bid on <a href=/horses/view/" . $v['join_horses_id'] . ">" . $v['horses_name'] . " #" . generateId($v['join_horses_id']) . "</a> for $" . number_format($winner['auctions_bids_amount']);
				$seller_notice = "Player #" . $winner['join_players_id'] . " placed a winning bid on <a href=/horses/view/" . $v['join_horses_id'] . ">" . $v['horses_name'] . " #" . generateId($v['join_horses_id']) . "</a> for $" . number_format($winner['auctions_bids_amount']) . ". Please accept the check and transfer the horse.";
				$this->db->query("INSERT INTO notices(notices_body, join_players_id) VALUES(?,?), (?,?)", array($winner_notice, $winner['join_players_id'], $seller_notice, $v['horse_owner']));
				$this->db->query("UPDATE auctions SET auctions_winning_bidder=?, auctions_winning_bid=?", array($winner['join_players_id'], $winner['auctions_bids_amount']));
			}

		}
		echo "Auctions completed.";
	}

	function retire(){
		$this->db->query("UPDATE horses SET horses_deceased=1 WHERE horses_birthyear>=NOW() - INTERVAL 30 YEAR");
		echo "Horses retired.";
	}


	function run_events(){
		$this->load->model('bank');


		//get all events & their classes that are scheduled to run today
		$events = $this->db->query("SELECT e.*, ec.* FROM events e LEFT JOIN events_x_classes ec ON ec.join_events_id=e.events_id WHERE events_pending=0 AND events_date1<=NOW() ORDER BY e.events_id ASC")->result_array();

		//get all entrants in the classes, decide if a split is necessary
		foreach((array)$events AS $event){
			$entrants = $this->db->query("SELECT * FROM events_entrants WHERE join_events_x_classes_id=? ORDER BY RAND()", array($event['events_x_classes_id']))->result_array();
			unset($classes);

			//ghost horses in races only
			if(count($entrants) <= 3 AND $event['events_type'] == "Race"){
				$max = 4 - count($entrants);
				for($i = 0; $i <= $max; $i++){
					if(!empty($event['events_x_classes_id']))
					{
						$horse_id = 0 - ($i+1);
						$this->db->query("INSERT INTO events_entrants(join_events_x_classes_id, join_horses_id) VALUES(?, ?)", array($event['events_x_classes_id'], $horse_id));	
					}					
				}
			}

			//splits
			if($event['events_type'] == "Show" || $event['events_type'] == "Olympic" || $event['events_type'] == "WEGs"){
				$split = 80;
			}else{
				$split = 18;
			}
			$groups = ceil(count($entrants)/$split);
			if($groups > 1){
				$split = $entrants / $groups; //number of entries in each new class once the split is completed
				//insert a new class & move the entries over there
				$entrants2 = array_chunk($entrants, $split);
				for($i = 0; $i < $groups; $i++){
					$this->db->query("INSERT INTO events_x_classes(join_events_id, events_x_classes_name, events_x_classes_breeds, events_x_classes_description, events_x_classes_min_age, events_x_classes_max_age, events_x_classes_strenuous, events_x_classes_fee, events_x_classes_points, events_x_classes_disciplines, events_x_classes_breeds_types, events_x_classes_division, events_x_classes_prize01, events_x_classes_prize02, events_x_classes_prize03, events_x_classes_prize04, events_x_classes_prize05, events_x_classes_prize06, events_x_classes_prize07, events_x_classes_prize08, events_x_classes_prize09, events_x_classes_prize10, events_x_classes_prize11, events_x_classes_prize12) SELECT join_events_id, events_x_classes_name, events_x_classes_breeds, events_x_classes_description, events_x_classes_min_age, events_x_classes_max_age, events_x_classes_strenuous, events_x_classes_fee, events_x_classes_points, events_x_classes_disciplines, events_x_classes_breeds_types, events_x_classes_division, events_x_classes_prize01, events_x_classes_prize02, events_x_classes_prize03, events_x_classes_prize04, events_x_classes_prize05, events_x_classes_prize06, events_x_classes_prize07, events_x_classes_prize08, events_x_classes_prize09, events_x_classes_prize10, events_x_classes_prize11, events_x_classes_prize12 FROM events_x_classes WHERE events_x_classes_id=?", array($event['events_x_classes_id']));
					$class_id = $this->db->insert_id();
					$classes []= $class_id;
					foreach((array)$entrants2[$i] AS $k => $v){
						$entrants2[$i][$k]['join_events_x_classes_id'] = $class_id;
					}
					$this->db->insert_batch('events_entrants', $entrants2[$i]);
				}
				$this->db->query("DELETE FROM events_x_classes WHERE events_x_classes_id=?", array($event['events_x_classes_id']));
				$this->db->query("DELETE FROM events_entrants WHERE join_events_x_classes_id=?", array($event['events_x_classes_id']));
			}
		}

		//okay, splitting is done, now let's get the good data one more time and do the actual running of the event
		$events = $this->db->query("SELECT * FROM events e WHERE events_pending=0 AND events_date1<=NOW() ORDER BY events_id ASC")->result_array();
		foreach((array)$events AS $event){


			$classes = $this->db->query("SELECT * FROM events_x_classes WHERE join_events_id=?", array($event['events_id']))->result_array();

			//get all entrants in the classes
			foreach((array)$classes AS $class){ //
				//set prizes each time
				$show_points[1] = 10;
				$show_points[2] = 9;
				$show_points[3] = 8;
				$show_points[4] = 7;
				$show_points[5] = 6;
				$show_points[6] = 5;
				$show_points[7] = 4;
				$show_points[8] = 3;
				$show_points[9] = 2;
				$show_points[10] = 1;
				$show_points[11] = 0.5;
				$show_points[12] = 0.5;

				$race_points[1] = $show_points[1] * 4;
				$race_points[2] = $show_points[2] * 4;
				$race_points[3] = $show_points[3] * 4;
				$race_points[4] = $show_points[4] * 4;
				$race_points[5] = $show_points[5] * 4;
				$race_points[6] = $show_points[6] * 4;
				$race_points[7] = $show_points[7] * 4;
				$race_points[8] = $show_points[8] * 4;
				$race_points[9] = $show_points[9] * 4;
				$race_points[10] = $show_points[10] * 4;
				$race_points[11] = $show_points[11] * 4;
				$race_points[12] = $show_points[12] * 4;




				$entrants = $this->db->query("SELECT ee.*, b.bank_id, h.join_players_id AS horse_owner FROM events_entrants ee LEFT JOIN horses h ON h.horses_id=ee.join_horses_id LEFT JOIN bank b ON b.join_players_id=h.join_players_id AND b.bank_default=1 WHERE ee.join_events_x_classes_id=? ORDER BY RAND() LIMIT 12", array($class['events_x_classes_id']))->result_array();
				$count = 0;

				//bonuses for races if they're full
				if(count($entrants) >= 15){
					for($i = 1; $i <= 12; $i++){
						$race_points[$i] += 5;
					}
				}


				foreach((array)$entrants AS $e){
					$count++;
					//echo "<hr>";
					//pre($e);

					//create horse record...because I deleted it x.x

					$record = "Placed #" . $count . " in <a href=\"/city/events/classes/". $class['events_x_classes_id'] ."\">". $class['events_type'] ." Class #". $class['events_x_classes_id']."</a>";
					$this->db->query('INSERT INTO horse_records(join_horses_id, horse_records_type, horse_records_notes) VALUES(?, ?, ?)', array($e['join_horses_id'], $event['events_type'], $record));

					if($count == 1){
						$this->db->query("UPDATE events_entrants SET events_entrants_place=?, events_entrants_points=?, events_entrants_prize=? WHERE events_entrants_id=?", array($count, $show_points[$count], $class['events_x_classes_prize01'], $e['events_entrants_id']));
						$this->db->query("UPDATE horses SET horses_points=horses_points+? WHERE horses_id=? LIMIT 1", array($show_points[$count], $e['join_horses_id']));


						if($class['join_divisions_id']){continue;}

						//do a bank transaction if there's a prize
						if($class['events_x_classes_prize01']){
							$note = "Event prize: Horse #" . generateId($e['join_horses_id']) ." placed #". $count ." in Class #" . $class['events_x_classes_id'];
							$transfer = Bank::instant_transfer($class['join_players_id'], $class['join_bank_id'], $e['bank_id'], $class['events_x_classes_prize01'], $note, 1);
						}
					}elseif($count == 2){
						$this->db->query("UPDATE events_entrants SET events_entrants_place=?, events_entrants_points=?, events_entrants_prize=? WHERE events_entrants_id=?", array($count, $show_points[$count], $class['events_x_classes_prize02'], $e['events_entrants_id']));
						$this->db->query("UPDATE horses SET horses_points=horses_points+? WHERE horses_id=? LIMIT 1", array($show_points[$count], $e['join_horses_id']));

						if($class['join_divisions_id']){continue;}

						//do a bank transaction if there's a prize
						if($class['events_x_classes_prize02']){
							$note = "Event prize: Horse #" . generateId($e['join_horses_id']) ." placed #". $count ." in Class #" . $class['events_x_classes_id'];
							$transfer = Bank::instant_transfer($class['join_players_id'], $class['join_bank_id'], $e['bank_id'], $class['events_x_classes_prize02'], $note, 1);
						}
					}elseif($count == 3){
						$this->db->query("UPDATE events_entrants SET events_entrants_place=?, events_entrants_points=?, events_entrants_prize=? WHERE events_entrants_id=?", array($count, $show_points[$count], $class['events_x_classes_prize03'], $e['events_entrants_id']));
						$this->db->query("UPDATE horses SET horses_points=horses_points+? WHERE horses_id=? LIMIT 1", array($show_points[$count], $e['join_horses_id']));

						if($class['join_divisions_id']){continue;}

						//do a bank transaction if there's a prize
						if($class['events_x_classes_prize03']){
							$note = "Event prize: Horse #" . generateId($e['join_horses_id']) ." placed #". $count ." in Class #" . $class['events_x_classes_id'];
							$transfer = Bank::instant_transfer($class['join_players_id'], $class['join_bank_id'], $e['bank_id'], $class['events_x_classes_prize03'], $note, 1);
						}
					}elseif($count == 4){
						$this->db->query("UPDATE events_entrants SET events_entrants_place=?, events_entrants_points=?, events_entrants_prize=? WHERE events_entrants_id=?", array($count, $show_points[$count], $class['events_x_classes_prize04'], $e['events_entrants_id']));
						$this->db->query("UPDATE horses SET horses_points=horses_points+? WHERE horses_id=? LIMIT 1", array($show_points[$count], $e['join_horses_id']));

						if($class['join_divisions_id']){continue;}

						//do a bank transaction if there's a prize
						if($class['events_x_classes_prize04']){
							$note = "Event prize: Horse #" . generateId($e['join_horses_id']) ." placed #". $count ." in Class #" . $class['events_x_classes_id'];
							$transfer = Bank::instant_transfer($class['join_players_id'], $class['join_bank_id'], $e['bank_id'], $class['events_x_classes_prize04'], $note, 1);
						}
					}elseif($count == 5){
						$this->db->query("UPDATE events_entrants SET events_entrants_place=?, events_entrants_points=?, events_entrants_prize=? WHERE events_entrants_id=?", array($count, $show_points[$count], $class['events_x_classes_prize05'], $e['events_entrants_id']));
						$this->db->query("UPDATE horses SET horses_points=horses_points+? WHERE horses_id=? LIMIT 1", array($show_points[$count], $e['join_horses_id']));

						if($class['join_divisions_id']){continue;}

						//do a bank transaction if there's a prize
						if($class['events_x_classes_prize05']){
							$note = "Event prize: Horse #" . generateId($e['join_horses_id']) ." placed #". $count ." in Class #" . $class['events_x_classes_id'];
							$transfer = Bank::instant_transfer($class['join_players_id'], $class['join_bank_id'], $e['bank_id'], $class['events_x_classes_prize05'], $note, 1);
						}
					}elseif($count == 6){
						$this->db->query("UPDATE events_entrants SET events_entrants_place=?, events_entrants_points=?, events_entrants_prize=? WHERE events_entrants_id=?", array($count, $show_points[$count], $class['events_x_classes_prize06'], $e['events_entrants_id']));
						$this->db->query("UPDATE horses SET horses_points=horses_points+? WHERE horses_id=? LIMIT 1", array($show_points[$count], $e['join_horses_id']));

						if($class['join_divisions_id']){continue;}

						//do a bank transaction if there's a prize
						if($class['events_x_classes_prize06']){
							$note = "Event prize: Horse #" . generateId($e['join_horses_id']) ." placed #". $count ." in Class #" . $class['events_x_classes_id'];
							$transfer = Bank::instant_transfer($class['join_players_id'], $class['join_bank_id'], $e['bank_id'], $class['events_x_classes_prize06'], $note, 1);
						}
					}elseif($count == 7){
						$this->db->query("UPDATE events_entrants SET events_entrants_place=?, events_entrants_points=?, events_entrants_prize=? WHERE events_entrants_id=?", array($count, $show_points[$count], $class['events_x_classes_prize07'], $e['events_entrants_id']));
						$this->db->query("UPDATE horses SET horses_points=horses_points+? WHERE horses_id=? LIMIT 1", array($show_points[$count], $e['join_horses_id']));

						if($class['join_divisions_id']){continue;}

						//do a bank transaction if there's a prize
						if($class['events_x_classes_prize07']){
							$note = "Event prize: Horse #" . generateId($e['join_horses_id']) ." placed #". $count ." in Class #" . $class['events_x_classes_id'];
							$transfer = Bank::instant_transfer($class['join_players_id'], $class['join_bank_id'], $e['bank_id'], $class['events_x_classes_prize07'], $note, 1);
						}
					}elseif($count == 8){
						$this->db->query("UPDATE events_entrants SET events_entrants_place=?, events_entrants_points=?, events_entrants_prize=? WHERE events_entrants_id=?", array($count, $show_points[$count], $class['events_x_classes_prize08'], $e['events_entrants_id']));
						$this->db->query("UPDATE horses SET horses_points=horses_points+? WHERE horses_id=? LIMIT 1", array($show_points[$count], $e['join_horses_id']));

						if($class['join_divisions_id']){continue;}

						//do a bank transaction if there's a prize
						if($class['events_x_classes_prize08']){
							$note = "Event prize: Horse #" . generateId($e['join_horses_id']) ." placed #". $count ." in Class #" . $class['events_x_classes_id'];
							$transfer = Bank::instant_transfer($class['join_players_id'], $class['join_bank_id'], $e['bank_id'], $class['events_x_classes_prize08'], $note, 1);
						}
					}elseif($count == 9){
						$this->db->query("UPDATE events_entrants SET events_entrants_place=?, events_entrants_points=?, events_entrants_prize=? WHERE events_entrants_id=?", array($count, $show_points[$count], $class['events_x_classes_prize09'], $e['events_entrants_id']));
						$this->db->query("UPDATE horses SET horses_points=horses_points+? WHERE horses_id=? LIMIT 1", array($show_points[$count], $e['join_horses_id']));

						if($class['join_divisions_id']){continue;}

						//do a bank transaction if there's a prize
						if($class['events_x_classes_prize09']){
							$note = "Event prize: Horse #" . generateId($e['join_horses_id']) ." placed #". $count ." in Class #" . $class['events_x_classes_id'];
							$transfer = Bank::instant_transfer($class['join_players_id'], $class['join_bank_id'], $e['bank_id'], $class['events_x_classes_prize09'], $note, 1);
						}
					}elseif($count == 10){
						$this->db->query("UPDATE events_entrants SET events_entrants_place=?, events_entrants_points=?, events_entrants_prize=? WHERE events_entrants_id=?", array($count, $show_points[$count], $class['events_x_classes_prize10'], $e['events_entrants_id']));
						$this->db->query("UPDATE horses SET horses_points=horses_points+? WHERE horses_id=? LIMIT 1", array($show_points[$count], $e['join_horses_id']));

						if($class['join_divisions_id']){continue;}

						//do a bank transaction if there's a prize
						if($class['events_x_classes_prize10']){
							$note = "Event prize: Horse #" . generateId($e['join_horses_id']) ." placed #". $count ." in Class #" . $class['events_x_classes_id'];
							$transfer = Bank::instant_transfer($class['join_players_id'], $class['join_bank_id'], $e['bank_id'], $class['events_x_classes_prize10'], $note, 1);
						}
					}elseif($count == 11){
						$this->db->query("UPDATE events_entrants SET events_entrants_place=?, events_entrants_points=?, events_entrants_prize=? WHERE events_entrants_id=?", array($count, $show_points[$count], $class['events_x_classes_prize11'], $e['events_entrants_id']));
						$this->db->query("UPDATE horses SET horses_points=horses_points+? WHERE horses_id=? LIMIT 1", array($show_points[$count], $e['join_horses_id']));

						if($class['join_divisions_id']){continue;}

						//do a bank transaction if there's a prize
						if($class['events_x_classes_prize11']){
							$note = "Event prize: Horse #" . generateId($e['join_horses_id']) ." placed #". $count ." in Class #" . $class['events_x_classes_id'];
							$transfer = Bank::instant_transfer($class['join_players_id'], $class['join_bank_id'], $e['bank_id'], $class['events_x_classes_prize11'], $note, 1);
						}
					}elseif($count == 12){
						$this->db->query("UPDATE events_entrants SET events_entrants_place=?, events_entrants_points=?, events_entrants_prize=? WHERE events_entrants_id=?", array($count, $show_points[$count], $class['events_x_classes_prize12'], $e['events_entrants_id']));
						$this->db->query("UPDATE horses SET horses_points=horses_points+? WHERE horses_id=? LIMIT 1", array($show_points[$count], $e['join_horses_id']));

						if($class['join_divisions_id']){continue;}

						//do a bank transaction if there's a prize
						if($class['events_x_classes_prize12']){
							$note = "Event prize: Horse #" . generateId($e['join_horses_id']) ." placed #". $count ." in Class #" . $class['events_x_classes_id'];
							$transfer = Bank::instant_transfer($class['join_players_id'], $class['join_bank_id'], $e['bank_id'], $class['events_x_classes_prize12'], $note, 1);
						}
					}
				}
			}

			//now we award division prizes! get all the classes with divisions, add up the points, and award division champions based on the prizes from the first class in the division
			$entrants = $this->db->query("
				SELECT ee.*, sum(ee.events_entrants_points) AS total_points, cd.*, b.bank_id, h.join_players_id AS horse_owner
				FROM events_entrants ee
	            	LEFT JOIN events_x_classes exc ON exc.events_x_classes_id=ee.join_events_x_classes_id
	            	LEFT JOIN classlists_divisions cd ON cd.classlists_divisions_id=exc.join_divisions_id
	            	LEFT JOIN horses h ON h.horses_id=ee.join_horses_id
	            	LEFT JOIN bank b ON b.join_players_id=h.join_players_id AND b.bank_default=1
				WHERE exc.join_events_id=? AND exc.join_divisions_id!=0 AND ee.events_entrants_points>0
				GROUP BY exc.join_divisions_id, ee.join_horses_id
				ORDER BY exc.join_divisions_id ASC, SUM(ee.events_entrants_points) DESC
			", array($event['events_id']))->result_array();
			$previous_division = 0;

			foreach((array)$entrants AS $e){
				$count++;
				$note = "";
				if($e['join_divisions_id'] != $previous_division){
					$count = 1;
				}
				$previous_division = $e['join_divisions_id'];

				if($count == 1 AND $e['classlists_divisions_prize01']){
					$prize = $e['classlists_divisions_prize01'];
					$note = "Division prize: Horse #" . generateId($e['join_horses_id']) ." placed #". $count ." in Division " . $e['classlists_divisions_name'] . " and won $". $e['classlists_divisions_prize01'];
					$this->db->query('INSERT INTO horse_records(join_horses_id, horse_records_type, horse_records_notes) VALUES(?, ?, ?)', array($e['join_horses_id'], $event['events_type'], $note));
					if($prize){
						$transfer = Bank::instant_transfer($class['join_players_id'], $class['join_bank_id'], $e['bank_id'], $e['classlists_divisions_prize01'], $note, 1);
					}

				}elseif($count == 2 AND $e['classlists_divisions_prize02']){
					$prize = $e['classlists_divisions_prize02'];
					$note = "Division prize: Horse #" . generateId($e['join_horses_id']) ." placed #". $count ." in Division " . $e['classlists_divisions_name'] . " and won $". $e['classlists_divisions_prize02'];
					$this->db->query('INSERT INTO horse_records(join_horses_id, horse_records_type, horse_records_notes) VALUES(?, ?, ?)', array($e['join_horses_id'], $event['events_type'], $note));
					if($prize){
						$transfer = Bank::instant_transfer($class['join_players_id'], $class['join_bank_id'], $e['bank_id'], $e['classlists_divisions_prize02'], $note, 1);
					}

				}elseif($count == 3 AND $e['classlists_divisions_prize03']){
					$prize = $e['classlists_divisions_prize03'];
					$note = "Division prize: Horse #" . generateId($e['join_horses_id']) ." placed #". $count ." in Division " . $e['classlists_divisions_name'] . " and won $". $e['classlists_divisions_prize03'];
					$this->db->query('INSERT INTO horse_records(join_horses_id, horse_records_type, horse_records_notes) VALUES(?, ?, ?)', array($e['join_horses_id'], $event['events_type'], $note));
					if($prize){
						$transfer = Bank::instant_transfer($class['join_players_id'], $class['join_bank_id'], $e['bank_id'], $e['classlists_divisions_prize03'], $note, 1);
					}

				}elseif($count == 4 AND $e['classlists_divisions_prize04']){
					$prize = $e['classlists_divisions_prize04'];
					$note = "Division prize: Horse #" . generateId($e['join_horses_id']) ." placed #". $count ." in Division " . $e['classlists_divisions_name'] . " and won $". $e['classlists_divisions_prize04'];
					$this->db->query('INSERT INTO horse_records(join_horses_id, horse_records_type, horse_records_notes) VALUES(?, ?, ?)', array($e['join_horses_id'], $event['events_type'], $note));
					if($prize){
						$transfer = Bank::instant_transfer($class['join_players_id'], $class['join_bank_id'], $e['bank_id'], $e['classlists_divisions_prize04'], $note, 1);
					}

				}elseif($count == 5 AND $e['classlists_divisions_prize05']){
					$prize = $e['classlists_divisions_prize05'];
					$note = "Division prize: Horse #" . generateId($e['join_horses_id']) ." placed #". $count ." in Division " . $e['classlists_divisions_name'] . " and won $". $e['classlists_divisions_prize05'];
					$this->db->query('INSERT INTO horse_records(join_horses_id, horse_records_type, horse_records_notes) VALUES(?, ?, ?)', array($e['join_horses_id'], $event['events_type'], $note));
					if($prize){
						$transfer = Bank::instant_transfer($class['join_players_id'], $class['join_bank_id'], $e['bank_id'], $e['classlists_divisions_prize05'], $note, 1);
					}

				}elseif($count == 6 AND $e['classlists_divisions_prize06']){
					$prize = $e['classlists_divisions_prize06'];
					$note = "Division prize: Horse #" . generateId($e['join_horses_id']) ." placed #". $count ." in Division " . $e['classlists_divisions_name'] . " and won $". $e['classlists_divisions_prize06'];
					$this->db->query('INSERT INTO horse_records(join_horses_id, horse_records_type, horse_records_notes) VALUES(?, ?, ?)', array($e['join_horses_id'], $event['events_type'], $note));
					if($prize){
						$transfer = Bank::instant_transfer($class['join_players_id'], $class['join_bank_id'], $e['bank_id'], $e['classlists_divisions_prize06'], $note, 1);
					}

				}elseif($count == 7 AND $e['classlists_divisions_prize07']){
					$prize = $e['classlists_divisions_prize07'];
					$note = "Division prize: Horse #" . generateId($e['join_horses_id']) ." placed #". $count ." in Division " . $e['classlists_divisions_name'] . " and won $". $e['classlists_divisions_prize07'];
					$this->db->query('INSERT INTO horse_records(join_horses_id, horse_records_type, horse_records_notes) VALUES(?, ?, ?)', array($e['join_horses_id'], $event['events_type'], $note));
					if($prize){
						$transfer = Bank::instant_transfer($class['join_players_id'], $class['join_bank_id'], $e['bank_id'], $e['classlists_divisions_prize07'], $note, 1);
					}

				}elseif($count == 8 AND $e['classlists_divisions_prize08']){
					$prize = $e['classlists_divisions_prize08'];
					$note = "Division prize: Horse #" . generateId($e['join_horses_id']) ." placed #". $count ." in Division " . $e['classlists_divisions_name'] . " and won $". $e['classlists_divisions_prize08'];
					$this->db->query('INSERT INTO horse_records(join_horses_id, horse_records_type, horse_records_notes) VALUES(?, ?, ?)', array($e['join_horses_id'], $event['events_type'], $note));
					if($prize){
						$transfer = Bank::instant_transfer($class['join_players_id'], $class['join_bank_id'], $e['bank_id'], $e['classlists_divisions_prize08'], $note, 1);
					}

				}elseif($count == 9 AND $e['classlists_divisions_prize09']){
					$prize = $e['classlists_divisions_prize09'];
					$note = "Division prize: Horse #" . generateId($e['join_horses_id']) ." placed #". $count ." in Division " . $e['classlists_divisions_name'] . " and won $". $e['classlists_divisions_prize09'];
					$this->db->query('INSERT INTO horse_records(join_horses_id, horse_records_type, horse_records_notes) VALUES(?, ?, ?)', array($e['join_horses_id'], $event['events_type'], $note));
					if($prize){
						$transfer = Bank::instant_transfer($class['join_players_id'], $class['join_bank_id'], $e['bank_id'], $e['classlists_divisions_prize09'], $note, 1);
					}

				}elseif($count == 10 AND $e['classlists_divisions_prize10']){
					$prize = $e['classlists_divisions_prize10'];
					$note = "Division prize: Horse #" . generateId($e['join_horses_id']) ." placed #". $count ." in Division " . $e['classlists_divisions_name'] . " and won $". $e['classlists_divisions_prize10'];
					$this->db->query('INSERT INTO horse_records(join_horses_id, horse_records_type, horse_records_notes) VALUES(?, ?, ?)', array($e['join_horses_id'], $event['events_type'], $note));
					if($prize){
						$transfer = Bank::instant_transfer($class['join_players_id'], $class['join_bank_id'], $e['bank_id'], $e['classlists_divisions_prize10'], $note, 1);
					}

				}elseif($count == 11 AND $e['classlists_divisions_prize11']){
					$prize = $e['classlists_divisions_prize11'];
					$note = "Division prize: Horse #" . generateId($e['join_horses_id']) ." placed #". $count ." in Division " . $e['classlists_divisions_name'] . " and won $". $e['classlists_divisions_prize11'];
					$this->db->query('INSERT INTO horse_records(join_horses_id, horse_records_type, horse_records_notes) VALUES(?, ?, ?)', array($e['join_horses_id'], $event['events_type'], $note));
					if($prize){
						$transfer = Bank::instant_transfer($class['join_players_id'], $class['join_bank_id'], $e['bank_id'], $e['classlists_divisions_prize11'], $note, 1);
					}

				}elseif($count == 12){
					$prize = $e['classlists_divisions_prize12'];
					$note = "Division prize: Horse #" . generateId($e['join_horses_id']) ." placed #". $count ." in Division " . $e['classlists_divisions_name'] . " and won $". $e['classlists_divisions_prize12'];
					$this->db->query('INSERT INTO horse_records(join_horses_id, horse_records_type, horse_records_notes) VALUES(?, ?, ?)', array($e['join_horses_id'], $event['events_type'], $note));
					if($prize){
						$transfer = Bank::instant_transfer($class['join_players_id'], $class['join_bank_id'], $e['bank_id'], $e['classlists_divisions_prize12'], $note, 1);
					}
				}


				if($note){
					//create division log
					$this->db->query('INSERT INTO events_divisions(join_horses_id, join_events_id, join_divisions_id, events_divisions_place, events_divisions_money) VALUES(?, ?, ?, ?, ?)', array($e['join_horses_id'], $event['events_id'], $e['join_divisions_id'], $count, $prize));
				}
			}

			//set the event as run
			$this->db->query("UPDATE events SET events_pending=-1 WHERE events_id=?", array($event['events_id']));
		}

	}

}
