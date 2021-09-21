<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Privileges extends CI_Model {

	function __construct(){
		$this->data['player_id'] = $this->session->userdata('players_id');
	}

	function get($id = NULL){
		if(!$id){$id = $this->session->userdata('players_id');}
		return $this->db->query("SELECT * FROM privileges WHERE join_players_id=?", array($id))->row_array();
	}

}
