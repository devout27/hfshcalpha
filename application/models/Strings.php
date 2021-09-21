<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Strings extends CI_Model {

	public function __construct(){
		parent::__construct();
		$CI =& get_instance(); //allow us to use the db...
	}

	public function __destruct(){
		//db destruction
	}
	public static function nl2br_limit($string, $num=2){
		$dirty = preg_replace('/\r/', '', $string);
		$clean = preg_replace('/\n{4,}/', str_repeat('<br/>', $num), preg_replace('/\r/', '', $dirty));
		return nl2br($clean);
	}

	public static function str_to_int($string){
		return preg_replace('/[^0-9]/', '', $string);
	}

	public static function get_datediff_english($date){
		$date = new DateTime($date);
		$now = new DateTime();
		$diff = $date->diff($now);


		$date_arr = array();

		if ($diff->d > 0) {
			$date_arr[] = $diff->d . 'd';
		}
		if ($diff->h > 0) {
			$date_arr[] = $diff->h . 'h';
		}
		if(count($date_arr) < 2){
			if ($diff->i > 0) {
				$date_arr[] = $diff->i . 'm';
			}
		}
		if(count($date_arr) < 2){
			if ($diff->s > 0) {
				$date_arr[] = $diff->s . 's';
			}
		}
		$return_date = implode(' ', $date_arr);
		return $return_date;
	}

	// get rid of html, white spaces
	public static function clean($string, $level = 1){
		switch($level){
			case 1: // no html, no end spaces
				$string = strip_tags(trim($string));
			case 2: // alphanumeric and underscores only
				$reg = "/[^a-zA-Z0-9_]+/";
				$string = preg_replace($reg, '', $string);
		}
		return $string;
	}

	//check if anything besides alphanumeric and underscores
	public static function valid_alphanumu($text){
		//must also start with alpha
		if(!ctype_alpha($text[0])){
			return false;
		}

		$reg = "#[^A-Za-z0-9_]#i";
		$count = preg_match($reg, $text, $matches);
		if($count == 0){
			return true; //no problems!
		}
		return false;
	}

	//works only on standard email addresses
	public static function valid_email($email){
		return filter_var($email,FILTER_VALIDATE_EMAIL);
	}

	public static function genRandomString($length = 20){
		return substr(str_shuffle(MD5(microtime())), 0, $length);
	}

	public static function password_hash($password, $user_salt){
		$password = htmlentities(md5($password));
		$code = md5('fr44fr4');
		$hash = md5($password.$code.$user_salt);
		return $hash;
	}


	public static function get_current_querystring(){
		return $_SERVER['QUERY_STRING'] ? '?'.$_SERVER['QUERY_STRING'] : '';
	}

	public static function remove_querystring_var($url, $varname){
		//http://davidwalsh.name/php-remove-variable
		$url = preg_replace('/(.*)(?|&)' . $varname . '=[^&]+?(&)(.*)/i', '$1$2$4', $url . '&');
		$url = substr($url, 0, -1);
		return $url;
	}

	public static function custom_orderby($field){
		$url = self::remove_querystring_var(self::get_current_querystring(), 'order');
		$url = self::remove_querystring_var($url, 'by');
		$url = strstr($url, "?") ? $url . '&order=' . $field : '?order=' . $field;

		if($_GET['order'] == $field){	//yes, we're sorting by this field
			if(strtolower($_GET['by']) == "asc"){
				$html = '<div class="sort_arrows">
							<a href="'.$url.'&by=desc"><img src="'.FULL_URL.'images/sort_arrow_asc.png" /></a>
						</div>';
			}else{
				$html = '<div class="sort_arrows">
							<a href="'.$url.'&by=asc"><img src="'.FULL_URL.'images/sort_arrow_desc.png" /></a>
						</div>';
			}
			return $html;
		}else{
			return '<div class="sort_arrows">
						<a href="'.$url.'&by=asc"><img src="'.FULL_URL.'images/sort_arrows.png" /></a>
					</div>';
		}
		return false;
	}

	// no longer needed
	/*public static function get_expiration($date){
		// I'm so sorry you tortured yourself with this... D:
		//takes a date in seconds and converts it
		$date2['days'] = floor($date / 60 / 60 / 24);
		$date2['hours'] = floor(($date - ($date2['days'] * 24 * 60 * 60)) / 60 / 60);
		$date2['mins'] = floor(($date - ($date2['days'] * 24 * 60 * 60) - ($date2['hours'] * 60 * 60)) / 60);
		$date2['seconds'] = floor(($date - ($date2['days'] * 24 * 60 * 60) - ($date2['hours'] * 60 * 60) - ($date2['mins'] * 60)));
		$date2['total_seconds'] = $date;

		return $date2;
	}*/

	public static function get_expiration_english($date){
		//$date = self::get_expiration($date);

		// we have a built-in class for that silly :)
		$date = new DateTime($date);
		$now = new DateTime();
		$diff = $date->diff($now);

		$date_arr = array();

		if ($diff->d > 0) {
			$date_arr[] = $diff->d . ' days';
		}
		if ($diff->h > 0) {
			$date_arr[] = $diff->h . ' hours';
		}
		if(count($date_arr) < 2){
			if ($diff->i > 0) {
				$date_arr[] = $diff->i . ' minutes';
			}
		}

		//let's make it english!
		/*if($date['days'] > 0){
			if($date['days'] > 0){
				$date2 []= '<span class="prod-date-days">'. $date['days'] .' days</span>';
			}
		}elseif($date['hours'] < 1){
			if($date['mins'] > 0){
				$date2 []= '<span class="prod-date-mins">'. $date['mins'] .' m</span>';
			}
			if($date['seconds'] > 0){
				$date2 []= '<span class="prod-date-seconds">'. $date['seconds'] .' seconds</span>';
			}
		}else{
			if($date['hours'] > 0){
				$date2 []= '<span class="prod-date-hours">'. $date['hours'] .' h</span>';
			}
			if($date['mins'] > 0){
				$date2 []= '<span class="prod-date-mins">'. $date['mins'] .' m</span>';
			}
		}*/

		$return_date = implode(' ', $date_arr);
		return $return_date;
	}

	public static function limit_words($str, $limit = 50, $end_str = '...') {
		$bits = explode(' ', $str);

		if (count($bits) > $limit) {
			$ret = array_splice($bits, 0, $limit);
			$ret[] = $end_str;
		} else {
			$ret = $bits;
		}

		$ret = implode(' ', $ret);
		return $ret;
	}
}


