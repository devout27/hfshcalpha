<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_Validation extends CI_Form_validation {

	public function __construct($rules = array()) {
		parent::__construct($rules);
	}

	public function get_errors() {
		return $this->_error_array;
	}

    function valid_url($str){
       $pattern = "/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i";
        if (!preg_match($pattern, $str)){
            return FALSE;
        }
        return TRUE;
    }


}
