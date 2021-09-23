<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bank extends CI_Model {

	function __construct(){
		$this->data['player_id'] = $this->session->userdata('players_id');
		$this->column_search=['bank_nickname','bank_balance','bank_id','join_players_id','bank_available_balance','bank_type','bank_status'];
		$this->column_order=['bank_nickname','bank_id','bank_balance','join_players_id','bank_available_balance','bank_type','bank_status'];
		$this->order = ['bank_id' => 'desc'];
	}


	function get($id, $skip_checks = 0){
		$account = $this->db->query("
				SELECT *
				FROM bank
				WHERE bank_id=? LIMIT 1
			", array($id))->row_array();

		//pending balance
		if($account['bank_pending']){
			$account['bank_status'] = "Pending";
		}elseif($account['bank_closed']){
			$account['bank_status'] = "Closed";
		}else{
			$account['bank_status'] = "Open";
		}
		$account['bank_available_balance'] = $account['bank_balance'];
		$account['bank_influx'] = 0;

		if($skip_checks == 0){
			//get checks, plus the details of the bank account they came from
			$checks = $this->db->query("
					SELECT
						bc.*,
						DATE_FORMAT(bc.bank_checks_date, '%Y/%m/%d') AS bank_checks_date,
						b1.bank_nickname AS b1_nickname,
						b2.bank_nickname AS b2_nickname
					FROM bank_checks bc
						LEFT JOIN bank b1 ON b1.bank_id=bc.join_bank_id
						LEFT JOIN bank b2 ON b2.bank_id=bc.bank_checks_to_id
					WHERE (join_bank_id=? OR bank_checks_to_id=?)
					ORDER BY bank_checks_date DESC
				", array($account['bank_id'], $account['bank_id']))->result_array();

			foreach((array)$checks AS $i => $check){
				//outgoing
				if($check['bank_checks_status'] == "Pending"){
					if($check['join_bank_id'] == $account['bank_id']){
						$account['bank_available_balance'] -= $check['bank_checks_amount'];
					}else{
						$account['bank_influx'] += $check['bank_checks_amount'];
					}
				}
				$checks[$i]['bank_checks_debit'] = 0;
				$checks[$i]['bank_checks_credit'] = 0;

				if($check['join_bank_id'] == $account['bank_id']){
					//from us
					$checks[$i]['bank_checks_debit'] = $check['bank_checks_amount'];
					$checks[$i]['bank_checks_memo2'] = "To " . $check['b2_nickname'] . " #" . $check['bank_checks_to_id'];
				}else{
					//to us
					$checks[$i]['bank_checks_credit'] = $check['bank_checks_amount'];
					$checks[$i]['bank_checks_memo2'] = "From " . $check['b1_nickname'] . " #" . $check['join_bank_id'];
				}


			}
			$account['checks'] = $checks;
		}

		return $account;
	}





	public static function get_balance($id){
		$CI =& get_instance();
		return $CI->db->query("SELECT bank_balance, join_players_id FROM bank WHERE bank_id=? AND bank_pending=0 AND bank_closed=0 LIMIT 1", array($id))->row_array();
	}



	public static function get_recurring($player){
		$CI =& get_instance();
		$accounts = self::get_accounts($player['players_id'], NULL, $active_only = 0, $skip_checks = 1);
		//pre($accounts);
		foreach((array)$accounts AS $a){
			$params []= $a['bank_id'];
			$wheres []= "?";
		}
		$recurring = $CI->db->query("
				SELECT br.*,
					bf.bank_nickname, bf.bank_balance, bf.bank_pending, bf.bank_closed, bf.bank_type,
					bt.bank_nickname AS bank_nickname2, bt.bank_balance AS bank_balance2, bt.bank_pending AS bank_pending2, bt.bank_closed AS bank_closed2, bt.bank_type AS bank_type2, bt.join_players_id AS join_players_id2
				FROM bank_recurring br
					LEFT JOIN bank bf ON br.join_bank_id=bf.bank_id
					LEFT JOIN bank bt ON br.bank_recurring_to=bt.bank_id
				WHERE join_bank_id IN (" . implode(',', $wheres) . ")
			", $params)->result_array();

		return $recurring;
	}


	public static function open_savings($player){
		$CI =& get_instance();
		$exists = $CI->db->query("
				SELECT bank_id
				FROM bank
				WHERE join_players_id=? AND bank_type='Savings' AND bank_pending=1 LIMIT 1
			", array($player['players_id']))->row_array();
		if(count($exists) > 0){
			$errors['savings_general'] = "You already have a pending savings account. You may create another one after your current pending account has been accepted/rejected.";
		}

		if(count($errors) > 0){
			return array('errors' => $errors);
		}

		//create account
		$data['join_players_id'] = $player['players_id'];
		$data['bank_type'] = 'Savings';
		$data['bank_balance'] = 0;
		$data['bank_interest_incurred'] = 0.01;
		$data['bank_nickname'] = 'Savings for ' . $player['players_nickname'];

		$CI->db->insert('bank', $data);

		$message = "You requested to open a Savings Account.";

		//create notice to remind user
		$CI->db->query("INSERT INTO notices(join_players_id, notices_body) VALUES(?, ?)", array($player['players_id'], $message));
		$CI->session->set_flashdata('notice', "Your Savings Account is now pending.");

		return array('errors' => $errors, 'notice' => $notice);
	}



	public static function open_business($player){
		$CI =& get_instance();
		$exists = $CI->db->query("
				SELECT bank_id
				FROM bank
				WHERE join_players_id=? AND bank_type='Business' AND bank_pending=1 LIMIT 1
			", array($player['players_id']))->row_array();
		if(count($exists) > 0){
			$errors['business_general'] = "You already have a pending business account. You may create another one after your current pending account has been accepted/rejected.";
		}

		if(count($errors) > 0){
			return array('errors' => $errors);
		}

		//create account
		$data['join_players_id'] = $player['players_id'];
		$data['bank_type'] = 'Business';
		$data['bank_balance'] = 0;
		$data['bank_nickname'] = 'Business for ' . $player['players_nickname'];

		$CI->db->insert('bank', $data);

		$message = "You requested to open a Business Account.";

		//create notice to remind user
		$CI->db->query("INSERT INTO notices(join_players_id, notices_body) VALUES(?, ?)", array($player['players_id'], $message));
		$CI->session->set_flashdata('notice', "Your Business Account is now pending.");

		return array('errors' => $errors, 'notice' => $notice);
	}



	public static function apply_loan($player, $data){
		$CI =& get_instance();
		$exists = $CI->db->query("
				SELECT bank_id
				FROM bank
				WHERE join_players_id=? AND bank_type='Loan' AND bank_pending=1 LIMIT 1
			", array($player['players_id']))->row_array();
		if(count($exists) > 0){
			$errors['loan_general'] = "You already have a pending loan application. You may apply for another one after your current pending application has been accepted/rejected.";
		}

		if($data['amount_requested'] < 1){
			$errors['amount_requested'] = "Invalid loan amount.";
		}
		if(!$data['membership']){
			$errors['membership'] = "Please let us know how long you have been a member.";
		}
		if(!$data['purpose']){
			$errors['purpose'] = "Please choose a reason for this loan.";
		}
		if($data['purpose'][4] AND !$data['purpose_other']){
			$errors['purpose_other'] = "Please fill out an Other reason.";
		}
		if(!$data['repayment']){
			$errors['repayment'] = "Please tell us how you will be repaying the loan.";
		}
		if(!$data['income_sources']){
			$errors['income_sources'] = "What income sources do you have that will allow you to repay the loan?";
		}
		if(!$data['boarding']){
			$errors['boarding'] = "What is your current boarding arrangement?";
		}
		if(!$data['comments']){
			$errors['comments'] = "Any other comments would be appreciated.";
		}
		if($data['terms'][0] != 1){
			$errors['terms'][0] = "You must agree to the terms to get a loan.";
		}

		$data_insert['join_players_id'] = $player['players_id'];
		$data_insert['amount_requested'] = $data['amount_requested'];
		$data_insert['membership'] = $data['membership'];

		foreach($data['purpose'] AS $i => $p){
			if($i == 0){$data_insert['purpose'] .= "To buy a Private Stable\n";
			}elseif($i == 1){$data_insert['purpose'] .= "To buy a Boarding Stable\n";
			}elseif($i == 2){$data_insert['purpose'] .= "To purchase a new horse\n";
			}elseif($i == 3){$data_insert['purpose'] .= "To make expansions to an existing stable\n";
			}elseif($i == 4){$data_insert['purpose'] .= "Other: " . $data['purpose_other'];
			}
		}

		$data_insert['repayment'] = $data['repayment'];
		$data_insert['income_sources'] = $data['income_sources'];
		$data_insert['boarding'] = $data['boarding'];
		$data_insert['comments'] = $data['comments'];
		$data_insert['terms'] = 1;

		if(count($errors) > 0){
			return array('errors' => $errors);
		}

		//create account
		$data2['join_players_id'] = $player['players_id'];
		$data2['bank_type'] = 'Loan';
		$data2['bank_balance'] = 0;
		$data2['bank_interest_incurred'] = 0.02;
		$data2['bank_nickname'] = 'Loan for ' . $player['players_nickname'];

		$CI->db->insert('bank', $data2);
		$loan_id = $CI->db->insert_id();
		$data_insert['join_bank_id'] = $loan_id;

		$CI->db->query("
			INSERT INTO bank_loans(join_players_id, amount_requested, membership, purpose, repayment, income_sources, boarding, comments, terms, join_bank_id) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array($data_insert['join_players_id'], $data_insert['amount_requested'], $data_insert['membership'], $data_insert['purpose'], $data_insert['repayment'], $data_insert['income_sources'], $data_insert['boarding'], $data_insert['comments'], $data_insert['terms'], $data_insert['join_bank_id']));

		$message = "You applied for a loan.";

		//create notice to remind user
		$CI->db->query("INSERT INTO notices(join_players_id, notices_body) VALUES(?, ?)", array($player['players_id'], $message));
		$CI->session->set_flashdata('notice', "Your loan application has been submitted.");

		return array('errors' => $errors, 'notice' => $notice);
	}

	public static function cancel_transfer($player, $id){
		$CI =& get_instance();
		//just delete it...!
		$CI->db->query("DELETE FROM bank_recurring WHERE bank_recurring_id=? AND join_bank_id IN (SELECT bank_id FROM bank WHERE join_players_id=?)", array($id, $player['players_id']));
		return array('errors' => $errors, 'notice' => "Transfer canceled.");
	}


	public static function process_check($player, $check_id, $action){
		//check if check is indeed to this player & pending
		$CI =& get_instance();
		$check = $CI->db->query("
				SELECT bc.*,
					bf.bank_balance, bf.bank_pending, bf.bank_closed, bf.bank_type,
					bt.bank_balance AS bank_balance2, bt.bank_pending AS bank_pending2, bt.bank_closed AS bank_closed2, bt.bank_type AS bank_type2, bt.join_players_id AS join_players_id2
				FROM bank_checks bc
					LEFT JOIN bank bf ON bc.join_bank_id=bf.bank_id
					LEFT JOIN bank bt ON bc.bank_checks_to_id=bt.bank_id
				WHERE bc.bank_checks_id=?
			", $check_id)->row_array();
		//validate check
		if($check['join_players_id2'] != $player['players_id']){
			$errors['bank_checks'] []= "You cannot process checks on accounts you don't own.";
		}
		if($check['bank_checks_status'] != "Pending"){
			$errors['bank_checks'] []= "This check has already been processed.";
		}
		if($check['bank_checks_amount'] > $check['bank_balance']){
			$errors['bank_checks'] []= "Check sender doesn't have enough money to cover this check.";
		}
		if($check['bank_pending'] || $check['bank_closed'] || $check['bank_type'] == "Loan"){
			$errors['bank_checks'] []= "Check was sent from an invalid account.";
		}
		if($check['bank_pending2'] || $check['bank_closed2'] || $check['bank_type2'] == "Loan"){
			$errors['bank_checks'] []= "Check was sent to an invalid account.";
		}
		if(!in_array($action, array('deposit', 'ignore', 'refuse'))){
			$errors['bank_checks'] []= "Invalid action.";
		}


		if(count($errors) > 0){
			return array('errors' => $errors, 'bank_id' => $check['bank_checks_to_id']);
		}

		if($action == "deposit"){
			$action = "Deposited";
		}elseif($action == "refuse"){
			$action = "Refused";
		}elseif($action == "ignore"){
			$action = "Ignored";
		}

		//perform the action (set check status to whatever)
		$CI->db->query("UPDATE bank_checks SET bank_checks_status=? WHERE bank_checks_id=?", array($action, $check_id));

		if($action == "Deposited"){
			//update bank accounts, if applicable
			$CI->db->query("UPDATE bank SET bank_balance=bank_balance+? WHERE bank_id=?", array($check['bank_checks_amount'], $check['bank_checks_to_id'])); //increase recipient
			$CI->db->query("UPDATE bank SET bank_balance=bank_balance-? WHERE bank_id=?", array($check['bank_checks_amount'], $check['join_bank_id'])); //decrease sender
		}

		$notice = "Check " . $action . ".";

		//return the good news
		return array('errors' => $errors, 'notice' => $notice, 'bank_id' => $check['bank_checks_to_id']);
	}


	public static function get_accounts($id, $data = NULL, $active_only = 0, $skip_checks = 0){
		$CI =& get_instance();

		$wheres []= "join_players_id=?";
		$params []= $id;
		if($data['bank_type']){
			$wheres []= "bank_type=?";
			$params []= $data['bank_type'];
		}

		if($active_only){
			$wheres []= "bank_pending=0";
			$wheres []= "bank_closed=0";
		}

		if(count($wheres) > 0){
			$wheres = 'WHERE ' . implode(' AND ', $wheres);
		}else{
			$wheres = "";
		}

		$accounts = $CI->db->query('
				SELECT *
				FROM bank
				'. $wheres .'
			', $params)->result_array();
		//pre($CI->db->last_query());exit;

		//pending balance and whwatnot
		foreach((array)$accounts AS $k => $v){
			if($v['bank_pending']){
				$accounts[$k]['bank_status'] = "Pending";
			}elseif($v['bank_closed']){
				$accounts[$k]['bank_status'] = "Closed";
			}else{
				$accounts[$k]['bank_status'] = "Open";
			}
			$accounts[$k]['bank_available_balance'] = $v['bank_balance'];

			if($skip_checks == 0){
				//update pending balance
				$checks = $CI->db->query("
						SELECT join_bank_id, bank_checks_amount, bank_checks_status
						FROM bank_checks
						WHERE (join_bank_id=? OR bank_checks_to_id=?) AND bank_checks_status='Pending'
					", array($v['bank_id'], $v['bank_id']))->result_array();
				foreach((array)$checks AS $i => $check){
					//outgoing
					if($check['join_bank_id'] == $v['bank_id']){
						$accounts[$k]['bank_available_balance'] -= $check['bank_checks_amount'];
					}else{
						//$accounts[$k]['bank_available_balance'] += $check['bank_checks_amount'];
					}
				}
			}
		}
		return $accounts;
	}


	public static function list_accounts_dropdown($id, $name = "transfer_from", $label = "From Account", $post = NULL, $errors = NULL, $account_type = NULL){
		$CI =& get_instance();
		$html = array();
		//get bank accounts for user
		if($account_type){
			$accounts = $CI->db->query("
				SELECT bank_nickname, bank_balance, bank_id, bank_type, bank_credit_limit
				FROM bank
				WHERE join_players_id=? AND bank_pending=0 AND bank_closed=0 AND bank_type=?
			", array($id, 'Checking'))->result_array();
		}else{
			$accounts = $CI->db->query("
				SELECT bank_nickname, bank_balance, bank_id, bank_type, bank_credit_limit
				FROM bank
				WHERE join_players_id=? AND bank_pending=0 AND bank_closed=0
			", array($id))->result_array();
		}

		//build dropdown HTML
		foreach($accounts AS $a){
			$options[$a['bank_id']] = "{$a[bank_type]} #{$a['bank_id']}: {$a['bank_nickname']} - $" . (number_format($a['bank_balance']));
			if($a['bank_type'] == "Loan"){
				$options[$a['bank_id']] .= " of $" . (number_format($a['bank_credit_limit']));
			}
		}

		return hf_dropdown($name, $label, $post, $options, array('class' => 'col-sm-12'), $errors);
	}


	public static function is_active($id){
		//check if bank account is valid
		$CI =& get_instance();
		$account = $CI->db->query("
				SELECT *
				FROM bank
				WHERE bank_id=? AND bank_pending=0 AND bank_closed=0 LIMIT 1
			", array($id))->row_array();
		if($account['bank_id']){
			return true;
		}
		return false;
	}


	public static function edit_account($player, $account, $data){
		// transfer money from one account to another with a log: create the check & messages
		$CI =& get_instance();

		//data checks
		if($player['players_id'] != $account['join_players_id']){
			$errors['bank_nickname'] = "You don't own this account.";
		}

		if(strlen($data['bank_nickname']) < 4){
			$errors['bank_nickname'] = "Invalid nickname.";
		}
		if($data['bank_default'] == 1 AND ($account['bank_type'] != "Checking" || $account['bank_pending'] != 0 || $account['bank_closed'] != 0)){
			$erorrs['bank_default'] = "Only open checking accounts may be a default account.";
		}


		if(count($errors) > 0){
			return array('errors' => $errors);
		}

		if($data['bank_default'] == 1){
			$CI->db->query("UPDATE bank SET bank_default=0 WHERE join_players_id=?", array($player['players_id']));
			$CI->db->query("UPDATE bank SET bank_default=1 WHERE bank_id=?", array($account['bank_id']));
		}


		$CI->db->query("UPDATE bank SET bank_nickname=? WHERE bank_id=?", array($data['bank_nickname'], $account['bank_id'])); //increase money
		//pre($CI->db->last_query());

		return array('errors' => $errors, 'notice' => "Account updated.");
	}



	public static function admin_transfer($data){
		// transfer money from one account to another with a log: create the check & messages
		$CI =& get_instance();

		//check bank accounts exist
		$from = $CI->bank->get($data['admin_transfer_from'], 1);
		$to = $CI->bank->get($data['admin_transfer_id'], 1);

		//data checks
		if(!$from['bank_id']){
			$errors['admin_transfer_from'] = "Invalid from account.";
		}
		if(!$to['bank_id']){
			$errors['admin_transfer_id'] = "Invalid to account.";
		}
		if($data['admin_transfer_amount'] < 1){
			$errors['admin_transfer_amount'] = "Invalid amount.";
		}
		if(!$data['admin_transfer_memo']){
			$errors['admin_transfer_memo'] = "Memo required for admin transactions.";
		}


		if(count($errors) > 0){
			return array('errors' => $errors);
		}

		$transfer = array(
				'transfer_from' => $data['admin_transfer_from'],
				'transfer_to' => $data['admin_transfer_id'],
				'transfer_amount' => $data['admin_transfer_amount'],
				'transfer_memo' => 'Admin transfer: ' . $data['admin_transfer_memo'],
			);

		//$player = array('players_id' => $v['horse_owner']);
		$CI->db->query("INSERT INTO bank_checks(join_bank_id, bank_checks_to_id, bank_checks_amount, bank_checks_memo, bank_checks_status) VALUES(?,?,?,?,'Deposited')", $transfer);

		$CI->db->query("UPDATE bank SET bank_balance=bank_balance+? WHERE bank_id=?", array($transfer['transfer_amount'], $data['admin_transfer_id'])); //increase money
		//pre($CI->db->last_query());
		$CI->db->query("UPDATE bank SET bank_balance=bank_balance-? WHERE bank_id=?", array($transfer['transfer_amount'], $data['admin_transfer_from'])); //decrease money
		//pre($CI->db->last_query());

		$message1 = "A moderator has adjusted your bank account #" . $data['admin_transfer_id'] . ". <font class='text-success'>+$" . $transfer['transfer_amount'] . "</font>";
		$message2 = "A moderator has adjusted your bank account #" . $data['admin_transfer_from'] . ". <font class='text-danger'>-$" . $transfer['transfer_amount'] . "</font>";

		$CI->db->query("INSERT INTO notices(notices_body, join_players_id) VALUES(?,?), (?,?)", array($message1, $from['join_players_id'], $message2, $to['join_players_id']));
		return array('errors' => $errors, 'notice' => $notice, 'bank_id' => $data['transfer_from'], 'check_id' => $check_id);
	}


	public static function transfer($player, $data){
		$CI =& get_instance();
		$accounts = self::get_accounts($player['players_id'], NULL, 1, 1);

		//normalize accounts
		foreach($accounts AS $k => $v){
			$accounts2[$v['bank_id']] = $v;
		}
		$accounts = $accounts2;
		unset($accounts2);


		if(count($accounts[$data['transfer_to']]) < 1){
			$external_transfer = 1;
		}else{
			$external_transfer = 0;
		}

		if(count($accounts[$data['transfer_from']]) < 1){
			$errors['transfer_from'] = "Invalid account.";
		}
		if($data['transfer_type'] != "Internal"){ //set to external ID
			$data['transfer_to'] = $data['transfer_id'];
			unset($data['transfer_id']);
		}
		if($data['transfer_amount'] < 1){
			$errors['transfer_amount'] = "Invalid amount.";
		}
		if($data['transfer_amount'] > $accounts[$data['transfer_from']]['bank_balance'] AND $accounts[$data['transfer_from']]['bank_type'] != "Loan"){
			$errors['transfer_amount'] = "You do not have enough in this account to transfer that much.";
		}elseif($data['transfer_amount'] > ($accounts[$data['transfer_from']]['bank_credit_limit'] - $accounts[$data['transfer_from']]['bank_balance']) AND $accounts[$data['transfer_from']]['bank_type'] == "Loan"){
			$errors['transfer_amount'] = "You do not have enough credit on this loan to transfer that much.";
		}
		//if it's a loan, you can only transfer internally.
		if($accounts[$data['transfer_from']]['bank_type'] == "Loan" AND count($accounts[$data['transfer_to']]) < 1){
			$errors['transfer_amount'] = "All loan transfers must be internal. To withdraw from your loan, please send the proper amount to one of your accounts. You may then send it on to an external account.";
		}


		//ensure account is valid and not pending
		if(!self::is_active($data['transfer_to'])){
			$errors['transfer_to'] = $errors['transfer_id'] = "Invalid recipient.";
		}

		if($data['transfer_recurring'] == "Yes"){
			if($data['transfer_frequency'] != "Days" AND $data['transfer_frequency'] != "Months"){
				$errors['transfer_frequency'] = "Invalid frequency.";
			}
			if($data['transfer_frequency'] == "Days" AND ($data['transfer_days'] < 1 || $data['transfer_days'] > 31)){
				$errors['transfer_days'] = "Invalid day selection.";
			}
			if($data['transfer_frequency'] == "Months" AND ($data['transfer_months'] < 1 || $data['transfer_months'] > 12)){
				$errors['transfer_months'] = "Invalid month selection.";
			}

			//reset data
			if($data['transfer_frequency'] == "Days"){
				$data['transfer_months'] = 0;
			}else{
				$data['transfer_days'] = 0;
			}
		}

		if(count($errors) > 0){
			return array('errors' => $errors);
		}


		//if not loan & not internal, create check.
		//otherwise, transfer instantly & update balance

		//first, is it recurring?
		if($data['transfer_recurring'] == "Yes"){
			//create recurring transfer log
			$insert_array = array();
			$insert_array ['join_bank_id']= $data['transfer_from'];
			$insert_array ['bank_recurring_to']= $data['transfer_to'];
			$insert_array ['bank_recurring_amount']= $data['transfer_amount'];
			$insert_array ['bank_recurring_start_date']= $data['transfer_start'];
			$insert_array ['bank_recurring_days']= $data['transfer_days'] ?: 0;
			$insert_array ['bank_recurring_months']= $data['transfer_months'] ?: 0;
			$insert_array ['bank_recurring_memo']= $data['transfer_memo'] ?: "Automatic Transfer";
			$CI->db->query("INSERT INTO bank_recurring(join_bank_id, bank_recurring_to, bank_recurring_amount, bank_recurring_start_date, bank_recurring_days, bank_recurring_months, bank_recurring_memo) VALUES(?, ?, ?, ?, ?, ?, ?)", $insert_array);


		}elseif($accounts[$data['transfer_from']]['bank_type'] == "Loan" AND !$external_transfer){
			//instant transfer from loan to account
			$CI->db->query("UPDATE bank SET bank_balance=bank_balance+? WHERE bank_id=?", array($data['transfer_amount'], $data['transfer_from'])); //increase loan balance (take away credit)
			$CI->db->query("UPDATE bank SET bank_balance=bank_balance+? WHERE bank_id=?", array($data['transfer_amount'], $data['transfer_to'])); //increase bank balance
			$insert_array = array();
			$insert_array ['bank_checks_from']= $data['transfer_from'];
			$insert_array ['bank_checks_to_id']= $data['transfer_to'];
			$insert_array ['bank_checks_amount']= $data['transfer_amount'];
			$insert_array ['bank_checks_memo']= $data['transfer_memo'] ?: "Loan Debit";
			$insert_array ['bank_checks_status']= "Deposited";
			$CI->db->query("INSERT INTO bank_checks(join_bank_id, bank_checks_to_id, bank_checks_amount, bank_checks_memo, bank_checks_status) VALUES(?,?,?,?,?)", $insert_array); //create log

		}elseif($accounts[$data['transfer_to']]['bank_type'] == "Loan" AND !$external_transfer){
			//instant transfer: loan payment!
			if($data['transfer_amount'] >= ($accounts[$data['transfer_to']]['bank_balance'] * .01)){
				//mark payment as made for the month
				$CI->db->query("UPDATE bank SET bank_balance=bank_balance-?, bank_credit_payment_due='0000-00-00' WHERE bank_id=?", array($data['transfer_amount'], $data['transfer_to'])); //decrease loan balance (add credit)
			}else{
				$CI->db->query("UPDATE bank SET bank_balance=bank_balance-? WHERE bank_id=?", array($data['transfer_amount'], $data['transfer_to'])); //decrease loan balance (add credit)
			}
			$CI->db->query("UPDATE bank SET bank_balance=bank_balance-? WHERE bank_id=?", array($data['transfer_amount'], $data['transfer_from'])); //decrease bank balance
			$insert_array = array();
			$insert_array ['bank_checks_from']= $data['transfer_from'];
			$insert_array ['bank_checks_to_id']= $data['transfer_to'];
			$insert_array ['bank_checks_amount']= $data['transfer_amount'];
			$insert_array ['bank_checks_memo']= $data['transfer_memo'] ?: "Loan Payment";
			$insert_array ['bank_checks_status']= "Deposited";
			$CI->db->query("INSERT INTO bank_checks(join_bank_id, bank_checks_to_id, bank_checks_amount, bank_checks_memo, bank_checks_status) VALUES(?,?,?,?,?)", $insert_array); //create log

		}elseif(!$external_transfer){
			//immediate transfer since it's internal
			$CI->db->query("UPDATE bank SET bank_balance=bank_balance+? WHERE bank_id=?", array($data['transfer_amount'], $data['transfer_to'])); //increase loan balance (take away credit)
			$CI->db->query("UPDATE bank SET bank_balance=bank_balance-? WHERE bank_id=?", array($data['transfer_amount'], $data['transfer_from'])); //increase bank balance
			$insert_array = array();
			$insert_array ['bank_checks_from']= $data['transfer_from'];
			$insert_array ['bank_checks_to_id']= $data['transfer_to'];
			$insert_array ['bank_checks_amount']= $data['transfer_amount'];
			$insert_array ['bank_checks_memo']= $data['transfer_memo'] ?: "Internal Transfer";
			$insert_array ['bank_checks_status']= "Deposited";
			$CI->db->query("INSERT INTO bank_checks(join_bank_id, bank_checks_to_id, bank_checks_amount, bank_checks_memo, bank_checks_status) VALUES(?,?,?,?,?)", $insert_array); //create log

		}elseif($data['transfer_recurring'] == "No"){
			//transfer it out via a check!
			$insert_array = array();
			$insert_array ['bank_checks_from']= $data['transfer_from'];
			$insert_array ['bank_checks_to_id']= $data['transfer_to'];
			$insert_array ['bank_checks_amount']= $data['transfer_amount'];
			$insert_array ['bank_checks_memo']= $data['transfer_memo'] ?: "External Transfer";
			$insert_array ['bank_checks_status']= "Pending";
			$CI->db->query("INSERT INTO bank_checks(join_bank_id, bank_checks_to_id, bank_checks_amount, bank_checks_memo, bank_checks_status) VALUES(?,?,?,?,?)", $insert_array); //create log
		}

		$check_id = $CI->db->insert_id();


		//create notice to remind user
		if($data['transfer_recurring'] == "No" || !$data['transfer_recurring']){
			$CI->session->set_flashdata('notice', "Transfer initiated.");
		}else{
			$CI->session->set_flashdata('notice', "Recurring payment created.");
		}
		return array('errors' => $errors, 'notice' => $notice, 'bank_id' => $data['transfer_from'], 'check_id' => $check_id);
	}


	public static function instant_transfer($player_id, $transfer_from, $transfer_to, $amount, $note, $allow_negative = NULL){
		$CI =& get_instance();
		//this should only be called from specific places, such as entering a horse into an event.
		$accounts = self::get_accounts($player_id, array('bank_type' => 'Checking', 'bank_default' => '1'), 1, 1);
		foreach((array)$accounts AS $a){
			$flat[$a['bank_id']] = $a;
		}
		unset($accounts);
		//pre($flat);
		//exit;

		if(!in_array($transfer_from, $flat[$transfer_from])){
			$errors []= "Invalid account.";
		}

		if($amount < 1 || $transfer_from == $transfer_to){
			return;
		}
		if($amount > $flat[$transfer_from]['bank_balance'] AND !$allow_negative){
			$errors []= "You cannot afford the entry fee.";
		}


		//ensure account is valid and not pending
		if(!self::is_active($transfer_to)){
			$errors []= "Show host has selected an invalid bank account. Please contact a game admin.";
		}


		if(count($errors) > 0){
			return array('errors' => $errors);
		}


		//apply instantly
		$CI->db->query("UPDATE bank SET bank_balance=bank_balance-? WHERE bank_id=?", array($amount, $transfer_from)); //remove from horse owner
		$CI->db->query("UPDATE bank SET bank_balance=bank_balance+? WHERE bank_id=?", array($amount, $transfer_to)); //add to event owner
		$insert_array = array();
		$insert_array ['bank_checks_from']= $transfer_from;
		$insert_array ['bank_checks_to_id']= $transfer_to;
		$insert_array ['bank_checks_amount']= $amount;
		$insert_array ['bank_checks_memo']= $note ?: "Event class entry";
		$insert_array ['bank_checks_status']= "Deposited";
		$CI->db->query("INSERT INTO bank_checks(join_bank_id, bank_checks_to_id, bank_checks_amount, bank_checks_memo, bank_checks_status) VALUES(?,?,?,?,?)", $insert_array); //create log
		return;
	}



	public static function admin_get_pending(){
		$CI =& get_instance();
		return $CI->db->query("SELECT bl.*, p.players_nickname, DATE_FORMAT(players_join_date, '%M %D, %Y at %l:%i %p') AS players_join_date2, DATE_FORMAT(players_last_active, '%M %D, %Y at %l:%i %p') AS players_last_active2 FROM bank_loans bl LEFT JOIN players p ON p.players_id=bl.join_players_id  WHERE bl.pending=1 ORDER BY bl.bank_loans_id ASC")->result_array();
	}

	public static function admin_get_pending_bank(){
		$CI =& get_instance();
		return $CI->db->query("SELECT b.*, p.players_nickname, DATE_FORMAT(players_join_date, '%M %D, %Y at %l:%i %p') AS players_join_date2, DATE_FORMAT(players_last_active, '%M %D, %Y at %l:%i %p') AS players_last_active2 FROM bank b LEFT JOIN players p ON p.players_id=b.join_players_id  WHERE b.bank_pending=1 ORDER BY b.bank_id ASC")->result_array();
	}

	public static function admin_accept_application($data){
		$CI =& get_instance();
		$loan = $CI->db->query("SELECT * FROM bank WHERE bank_id=?", array($data['bank_id']))->row_array();
		$notice = "Your bank account has been accepted.";
		$CI->db->query("INSERT INTO notices(notices_body, join_players_id) VALUES(?,?)", array($notice, $loan['join_players_id']));
		$CI->db->query("UPDATE bank SET bank_pending=0 WHERE bank_id=?", array($data['bank_id']));
		return true;
	}

	public static function admin_reject_application($data){
		$CI =& get_instance();
		$loan = $CI->db->query("SELECT * FROM bank WHERE bank_id=?", array($data['bank_id']))->row_array();
		$notice = "Your bank account has been rejected.";
		$CI->db->query("INSERT INTO notices(notices_body, join_players_id) VALUES(?,?)", array($notice, $loan['join_players_id']));
		$CI->db->query("DELETE FROM bank WHERE bank_id=? AND bank_pending=1 LIMIT 1", array($data['bank_id']));
		return true;
	}


	public static function admin_accept_loan_application($data){
		$CI =& get_instance();

		$loan = $CI->db->query("SELECT * FROM bank_loans WHERE bank_loans_id=?", array($data['bank_loans_id']))->row_array();

		//create account
		$insert_data['join_players_id'] = $loan['join_players_id'];
		$insert_data['bank_type'] = 'Loan';
		$insert_data['bank_balance'] = 0;
		$insert_data['bank_credit_limit'] = $loan['amount_requested'];
		$insert_data['bank_credit_payment_due'] = date("Y-m-t", strtotime("+1 month"));
		$insert_data['bank_nickname'] = 'Loan';
		$insert_data['bank_pending'] = '0';
		$insert_data['bank_interest_incurred'] = '0.02';

		$CI->db->insert('bank', $insert_data);

		$notice = "Your loan has been approved.";
		$CI->db->query("INSERT INTO notices(notices_body, join_players_id) VALUES(?,?)", array($notice, $loan['join_players_id']));

		$CI->db->query("UPDATE bank_loans SET pending=0 WHERE bank_loans_id=?", array($data['bank_loans_id']));
		return true;
	}

	public static function admin_reject_loan_application($data){
		$CI =& get_instance();

		$loan = $CI->db->query("SELECT * FROM bank_loans WHERE bank_loans_id=?", array($data['bank_loans_id']))->row_array();
		$notice = "Your loan has been rejected.";
		$CI->db->query("INSERT INTO notices(notices_body, join_players_id) VALUES(?,?)", array($notice, $loan['join_players_id']));

		$CI->db->query("DELETE FROM bank_loans WHERE bank_loans_id=?", array($data['bank_loans_id']));
		return true;
	}



	public static function admin_get_overdue_loans(){
		$CI =& get_instance();
		return $CI->db->query("
				SELECT b.*, p.players_nickname, DATEDIFF(NOW(), bank_credit_payment_due) AS days_late
				FROM bank b
					LEFT JOIN players p ON p.players_id=b.join_players_id
				WHERE
					b.bank_balance>0 AND b.bank_credit_payment_due!='0000-00-00' AND b.bank_credit_payment_due<NOW()
				ORDER BY bank_credit_payment_due ASC
			")->result_array();
	}

	public static function search_transactions($data){
		$CI =& get_instance(); //allow us to use the db...
		$selects = $joins = $wheres = $params = array();

        $selects = array(
        	'bc.*',
            'b.bank_type AS b1_bank_type',
            'b.bank_nickname AS b1_bank_nickname',
            'b2.bank_type AS b2_bank_type',
            'b2.bank_nickname AS b2_bank_nickname',
            'p.players_nickname AS p1_nickname',
            'p.players_id AS p1_id',
            'p2.players_nickname AS p2_nickname',
            'p2.players_id AS p2_id',
        );

        $joins[] = 'LEFT JOIN bank b ON b.bank_id=bc.join_bank_id';
        $joins[] = 'LEFT JOIN bank b2 ON b.bank_id=bc.bank_checks_to_id';
        $joins[] = 'LEFT JOIN players p ON p.players_id=b.join_players_id';
        $joins[] = 'LEFT JOIN players p2 ON p2.players_id=bc.bank_checks_to_id';

		//---------- WHERES --------------
		$wheres [] = "bc.bank_checks_id>0";

		if($data['bank_checks_memo']){
			$wheres [] = "bank_checks_memo LIKE ?";
			$params [] = '%' . $data['bank_checks_memo'] . '%';
		}
		if($data['bank_checks_status']){
			$wheres []= "bank_checks_status=?";
			$params []= $data['bank_checks_status'];
		}

		if($data['min_amount']){
			$wheres [] = "bank_checks_amount>=? ";
			$params [] = $data['min_amount'];
		}
		if($data['max_amount']){
			$wheres [] = "bank_checks_amount<=? ";
			$params [] = $data['max_amount'];
		}

		if($data['start_date']){
			$wheres [] = "bank_checks_date>=?";
			$params [] = $data['start_date'];
		}
		if($data['end_date']){
			$wheres [] = "bank_checks_date<=? ";
			$params [] = $data['end_date'];
		}


		if($data['hide_interest']){
			$wheres [] = "bank_checks_memo!=? ";
			$params [] = 'Interest accrued';
		}
		if($data['hide_interest2']){
			$wheres [] = "bank_checks_memo!=? ";
			$params [] = 'Interest incurred';
		}
		if($data['hide_monthly']){
			$wheres [] = "bank_checks_memo!=? ";
			$params [] = 'Monthly paycheck';
		}
		if($data['hide_import']){
			$wheres [] = "bank_checks_memo!=? ";
			$params [] = 'Horse Import';
		}
		if($data['hide_auctions']){
			$wheres [] = "bank_checks_memo NOT LIKE ? ";
			$params [] = '%auction bid%';
		}
		if($data['hide_internal']){
			$wheres [] = "bank_checks_memo!=? ";
			$params [] = 'Internal Transfer';
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
		$accounts = $CI->db->query('
			SELECT '. implode(', ', $selects) .'
			FROM bank_checks AS bc
			'. implode("\n", $joins) .'
			'. $wheres .'
		', $params)->result_array();
		//pre($CI->db->last_query());exit;

        return $accounts;
	}



	public static function search($data){
		$CI =& get_instance(); //allow us to use the db...
		$selects = $joins = $wheres = $params = array();

        $selects = array(
            'b.*',
            'p.players_nickname',
        );

        $joins[] = 'LEFT JOIN players p ON p.players_id=b.join_players_id';

		//---------- WHERES --------------
		if($data['bank_owner']){
			if((int)$data['bank_owner'] > 0){
				$wheres [] = "join_players_id=?";
				$params [] = $data['bank_owner'];
			}else{
				$wheres [] = "players_nickname LIKE ?";
				$params [] = '%' . $data['bank_owner'] . '%';
			}
		}
		if($data['bank_nickname']){
			$wheres [] = "bank_nickname LIKE ?";
			$params [] = '%' . $data['bank_nickname'] . '%';
		}
		if($data['bank_type']){
			$wheres []= "bank_type=?";
			$params []= $data['bank_type'];
		}
		if($data['bank_tier']){
			$wheres []= "bank_type=?";
			$params []= $data['bank_tier'];
		}

		if($data['min_credit_limit']){
			$wheres [] = "bank_balance>=? ";
			$params [] = $data['min_credit_limit'];
		}
		if($data['max_credit_limit']){
			$wheres [] = "bank_balance<=? ";
			$params [] = $data['max_credit_limit'];
		}

		if($data['min_balance']){
			$wheres [] = "bank_balance>=?";
			$params [] = $data['min_balance'];
		}
		if($data['max_balance']){
			$wheres [] = "bank_balance<=? ";
			$params [] = $data['max_balance'];
		}

		if($data['bank_status'] == "Pending"){
			$wheres [] = "bank_pending=1";
		}elseif($data['bank_status'] == "Closed"){
			$wheres [] = "bank_closed=1";
		}else{
			$wheres [] = "bank_pending=0 AND bank_closed=0";
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
		$accounts = $CI->db->query('
			SELECT '. implode(', ', $selects) .'
			FROM bank AS b
			'. implode("\n", $joins) .'
			'. $wheres .'
		', $params)->result_array();
		//pre($CI->db->last_query());exit;

        return $accounts;
	}

	/* datatable related functions */
		public function getMyBankAccountsList($player_id,$postData)
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
			$this->db->select('bank.*,p.players_nickname');			
			$this->db->join('players p','p.players_id=bank.join_players_id','LEFT');
			$this->db->from('bank');
			if(is_numeric($player_id))
			{
				$this->db->where('bank.join_players_id',$player_id);
			}			
			if($where)
			{
				$this->db->where($where);
			}
			$i = $_POST['start'];
			foreach($this->column_search as $item){            
				if($postData['search']['value']){                
					if($i===0){                    
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
