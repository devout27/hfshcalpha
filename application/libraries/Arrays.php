<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Arrays {

	/**
	 * function filter_keys
	 *
	 * used to sanitize $_POST and $_REQUEST data prior to processing (or any array you want)
	 *
	 * @param $array
	 * @param $keys
	 * @return array
	 */
	public static function filter_keys($array, $keys){
		$return_array = array();

		foreach ($keys as $key) {
			$return_array[$key] = $array[$key];
		}

		return $return_array;
	}

}