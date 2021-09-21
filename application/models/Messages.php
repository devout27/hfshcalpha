<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Messages extends CI_Model {

	function __construct(){
		$this->data['player_id'] = $this->session->userdata('players_id');
	}


	function get_unread(){
		$unread = $this->db->query("SELECT messages_id FROM messages WHERE messages_to=? AND messages_read=0 AND join_messages_id=0", array($this->player_id))->num_rows();
		$unread += $this->db->query("SELECT messages_id FROM messages WHERE messages_to=? AND messages_read=0 AND join_messages_id!=0 GROUP BY join_messages_id", array($this->player_id))->num_rows();
		return $unread;
	}

	function get_unread_notices(){
		$notices = $this->db->query("
				SELECT notices_id
				FROM notices
				WHERE join_players_id=? AND notices_read=0
			", array($this->player_id))->num_rows();
		return $notices;
	}

	function get_notices(){
		$notices = $this->db->query("
				SELECT *,
					DATE_FORMAT(notices_date, '%b %D, %Y at %l:%i %p') AS notices_date_formatted
				FROM notices
				WHERE join_players_id=?
				ORDER BY notices_read ASC, notices_date DESC
			", array($this->player_id))->result_array();
		return $notices;
	}

	function mark_notices_read(){
		$this->db->query("UPDATE notices SET notices_read=1 WHERE join_players_id=? ORDER BY notices_read ASC, notices_date DESC LIMIT 100", array($this->player_id));
	}


	function get($id){
		$msg = $this->db->query("
				SELECT m.*,
					DATE_FORMAT(m.messages_date, '%b %D, %Y at %l:%i %p') AS messages_date_formatted,
					p1.players_nickname AS p1_name, p2.players_nickname AS p2_name
				FROM messages m
					LEFT JOIN players p1 ON p1.players_id=m.messages_to
					LEFT JOIN players p2 ON p2.players_id=m.messages_sender
				WHERE m.messages_id=? LIMIT 1
			", array($id))->row_array();
		if($msg['join_messages_id'] != 0){
			return self::get($msg['join_messages_id']);
		}

		// get responses to message
		$msgs = $this->db->query("
				SELECT m.*,
					DATE_FORMAT(m.messages_date, '%b %D, %Y at %l:%i %p') AS messages_date_formatted,
					p1.players_nickname AS p1_name, p2.players_nickname AS p2_name
				FROM messages m
					LEFT JOIN players p1 ON p1.players_id=m.messages_to
					LEFT JOIN players p2 ON p2.players_id=m.messages_sender
				WHERE m.join_messages_id=?
				ORDER BY m.messages_id ASC
			", array($id))->result_array();

		if(count($msgs) > 0){
			array_unshift($msgs, $msg);
		}else{
			$msgs []= $msg;
		}
		return $msgs;
	}

	function get_all(){
		$msgs = $this->db->query("
				SELECT m.*,
					LEFT(m.messages_body, 50) AS messages_body,
					DATE_FORMAT(m.messages_date, '%b %D, %Y at %l:%i %p') AS messages_date_formatted,
					p1.players_nickname AS p1_name, p2.players_nickname AS p2_name
				FROM messages m
					LEFT JOIN players p1 ON p1.players_id=m.messages_to
					LEFT JOIN players p2 ON p2.players_id=m.messages_sender
				WHERE m.messages_to=? AND m.join_messages_id=0
				ORDER BY m.messages_read ASC, m.messages_id DESC
			", array($this->player_id))->result_array();


		//get messages player didn't start BUT did respond to
		$msgs2 = $this->db->query("
				SELECT m.*, m2.messages_subject AS messages_subject,
					DATE_FORMAT(m.messages_date, '%b %D, %Y at %l:%i %p') AS messages_date_formatted,
					p1.players_nickname AS p2_name, p2.players_nickname AS p1_name
				FROM messages m
					LEFT JOIN players p1 ON p1.players_id=m.messages_to
					LEFT JOIN players p2 ON p2.players_id=m.messages_sender
					LEFT JOIN messages m2 ON m2.messages_id=m.join_messages_id
				WHERE m.messages_to=? AND m.join_messages_id!=0
				ORDER BY m.messages_id DESC
			", array($this->player_id))->result_array();

		foreach($msgs2 AS $m){
			array_push($msgs, $m);
		}

		//normalize data
		foreach($msgs AS $k => $v){
			if($v['join_messages_id'] != 0){
				foreach($msgs AS $i => $x){
					if($x['messages_id'] == $v['join_messages_id']){
						//echo "unsetting $k<br>";
						if(!$v['messages_read']){
							$msgs[$i]['messages_read'] = 0;
						}
						unset($msgs[$k]);
					}elseif($x['join_messages_id'] == $v['join_messages_id'] AND $x['messages_id'] != $v['messages_id'] AND $x['messages_id'] < $v['messages_id']){
						if(!$x['messages_read']){
							$msgs[$k]['messages_read'] = 0;
						}
						unset($msgs[$i]);
					}
				}
			}
		}


		return $msgs;
	}

	function get_sent(){
		//get messages player started
		$msgs = $this->db->query("
				SELECT m.*,
					DATE_FORMAT(m.messages_date, '%b %D, %Y at %l:%i %p') AS messages_date_formatted,
					p1.players_nickname AS p2_name, p2.players_nickname AS p1_name
				FROM messages m
					LEFT JOIN players p1 ON p1.players_id=m.messages_to
					LEFT JOIN players p2 ON p2.players_id=m.messages_sender
				WHERE m.messages_sender=? AND m.join_messages_id=0
				ORDER BY m.messages_id DESC
			", array($this->player_id))->result_array();

		//get messages player didn't start BUT did respond to
		$msgs2 = $this->db->query("
				SELECT m.*, m2.messages_subject AS messages_subject,
					DATE_FORMAT(m.messages_date, '%b %D, %Y at %l:%i %p') AS messages_date_formatted,
					p1.players_nickname AS p2_name, p2.players_nickname AS p1_name
				FROM messages m
					LEFT JOIN players p1 ON p1.players_id=m.messages_to
					LEFT JOIN players p2 ON p2.players_id=m.messages_sender
					LEFT JOIN messages m2 ON m2.messages_id=m.join_messages_id
				WHERE m.messages_sender=? AND m.join_messages_id!=0
				ORDER BY m.messages_id DESC
			", array($this->player_id))->result_array();

		foreach($msgs2 AS $m){
			array_push($msgs, $m);
		}

		//normalize data
		foreach($msgs AS $k => $v){
			if($v['join_messages_id'] != 0){
				foreach($msgs AS $i => $x){
					if($x['messages_id'] == $v['join_messages_id']){
						//echo "unsetting $k<br>";
						if(!$v['messages_read']){
							$msgs[$i]['messages_read'] = 0;
						}
						unset($msgs[$k]);
					}elseif($x['join_messages_id'] == $v['join_messages_id'] AND $x['messages_id'] != $v['messages_id'] AND $x['messages_id'] < $v['messages_id']){
						if(!$x['messages_read']){
							$msgs[$k]['messages_read'] = 0;
						}
						unset($msgs[$i]);
					}
				}
			}
		}

		return $msgs; //for now just the msgs
	}

	function mark_read($id){
		$master_id = $this->db->query("SELECT join_messages_id FROM messages WHERE messages_id=? LIMIT 1", array($id))->row_array();
		$master_id = $master_id['join_messages_id'];
		$this->db->query("UPDATE messages SET messages_read=1 WHERE (messages_id=? OR join_messages_id=? OR messages_id=? OR join_messages_id=?) AND messages_to=?", array($id, $id, $master_id, $master_id, $this->player_id));
	}

	function send($data){
		// send a message!
		if($data['messages_to']){
			//this is sent internally, not from a form.
			$allowed_fields = array(
				'messages_to',
				'messages_subject',
				'messages_body',
				'messages_sender',
			);
			$update_data = filter_keys($data, $allowed_fields);
			$this->db->insert('messages', $update_data);
			return true;
		}else{
			$this->form_validation->set_rules(array(
				array(
					'field' => 'messages_2',
					'label' => 'Send to Player #',
					'rules' => 'required|numeric'
				),
				array(
					'field' => 'messages_subject',
					'label' => 'Subject',
					'rules' => 'required|strip_tags'
				),
				array(
					'field' => 'messages_body',
					'label' => 'Body',
					'rules' => 'required|xss_clean'
				),
			));
			$data['messages_to'] = $data['messages_2']; //swap

			$exists = $this->db->query("SELECT players_id FROM players WHERE players_id=?", array($data['messages_to']))->row_array();
			if(!$exists['players_id']){
				$errors['messages_to'] = "Invalid recipient.";
			}

			if ($this->form_validation->run() !== false AND count($errors) < 1){
				$data['messages_sender'] = $this->session->userdata('players_id');
				$allowed_fields = array(
					'messages_to',
					'messages_subject',
					'messages_body',
					'messages_sender',
				);
				$update_data = filter_keys($data, $allowed_fields);
				$this->db->insert('messages', $update_data);

				$this->session->set_flashdata('notice', "Your message has been sent.");
				redirect('game/messages#sent');
			}

			foreach($data AS $v => $e){
				$e = form_error($v);
				if($e){
					$errors[$v] = $e;
				}
			}
		}

		return $errors;
	}


	function respond($id, $data){
		// send a message!
		$this->form_validation->set_rules(array(
			array(
				'field' => 'messages_body',
				'label' => 'Body',
				'rules' => 'required|xss_clean'
			),
		));

		//check if player exists
		$exists = $this->db->query("SELECT players_id FROM players WHERE players_id=?", array($data['messages_to']))->row_array();
		if(!$exists['players_id']){
			$errors['messages_to'] = "Invalid recipient.";
		}

		//get original message
		$msg = self::get($id);
		$id = $msg[0]['messages_id'];
		if($msg[0]['messages_to'] != $this->player_id){
			$to = $msg[0]['messages_to'];
		}else{
			$to = $msg[0]['messages_sender'];
		}


		if ($this->form_validation->run() !== false) {
			$data['messages_sender'] = $this->player_id;
			$data['join_messages_id'] = $id;
			$data['messages_to'] = $to;
			$allowed_fields = array(
				'messages_to',
				'messages_body',
				'messages_sender',
				'join_messages_id',
			);
			$update_data = filter_keys($data, $allowed_fields);
			$this->db->insert('messages', $update_data);

			//$this->db->query("UPDATE messages SET messages_read=0 WHERE messages_id=?", array($id));

			$this->session->set_flashdata('notice', "Your message has been sent.");
			redirect('game/messages#sent');
		}

		foreach($data AS $v => $e){
			$e = form_error($v);
			if($e){
				$errors[$v] = $e;
			}
		}

		return $errors;
	}

}
