<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Passwords extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function crypt($str, $salt, $rounds = 5000, $type = 6) {
		$return = explode('$', crypt($str, '$' . $type . '$rounds=' . $rounds . '$' . $salt . '$'));
		return array_pop($return);
	}

	public function generate_salt($length = 6) {
		$min = 33;
		$max = 126;

		$str = '';

		for ($i = 0; $i < $length; $i++) {
			$asc = rand($min, $max);
			$str .= chr($asc);
		}

		return $str;
	}

}
