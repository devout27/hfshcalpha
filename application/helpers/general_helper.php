<?php

if(!function_exists('pre')){
	function pre($v){
		echo "<pre>";
		print_r($v);
		echo "</pre>";
	}

	function wordReplace($string){
		//swear filter, html smileys, etc.
		return $string;
	}


	function filter_keys($array, $keys){
		$return_array = array();
		foreach ((array)$keys as $key) {
			$return_array[$key] = $array[$key];
		}
		return $return_array;
	}

	function flatten_array_set_index($key, $value, $data){
		$return_array = array();
		foreach((array)$data AS $k => $v){
			$return_array[$v[$key]] = $v[$value];
		}
		return $return_array;
	}


	function substr_count_alt($str,$search,$offset,$len) {
	    return substr_count(substr($str,$offset,$len),$search);
	}


	function swear_filter($check){
		$cuss_array['fuck'] = 'fudge';
		$cuss_array['bitch'] = 'lady';
		$cuss_array['shit'] = 'crap';
		$cuss_array['piss'] = 'pee';

		foreach((array)$cuss_array as $badword => $beep){
			$check = str_replace($badword, $beep, $check);
	    }

		return($check);
	}
	function generateId($id)
	{
		$id = str_replace("-","",$id);
		if(strlen($id) < 6){
			$zero = "";
			$l = 5-strlen($id);
			for($i=1;$i<=$l;$i++)
			{				
				$zero .= '0';
			}
			return $zero.$id;
		}else
		{
			return $id;
		}
	}
	function setting($key)
	{
		return null;
	}
	function send_email($name, $email, $subject, $body){
		// load email library
		$CI =& get_instance();
		$CI->load->library('email');
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$CI->email->initialize($config);
		// from address
		$CI->email->from(ADMIN_EMAIL, ADMIN_NAME)->to($email)
		 //   ->cc($cc_email)
		 //   ->bcc($bcc_email)
		 //   ->subject('Welcome to Hurricane Farm')
		    ->subject($subject)
		 //   ->message('Welcome! You have successfully applied to join the game. A member of the team will review your application and be in touch.');
		    ->message($body);
		$CI->email->send(); // send Email
		//$this->email->print_debugger(array('headers', 'subject', 'body'));
		return array('notice' => 'Email sent.');
	}
	function dateFormate($date,$time=true){

		$newDate='';
		if($date !='' && $date !='0000-00-00 00:00:00' && $date !='0000-00-00' ){
			 if($time==false){
				  $newDate=date('M d, Y',strtotime($date));
			 }else{
				  $newDate=date('d M Y h:i:A',strtotime($date));
			 }
		}
		return $newDate;
   }   
   function getAmenityPic($path)
   {
	   return $path ? $path : site_url(AMENITY_DEFAULT_IMAGE);
   }
   function getInventoryItemImage($path)
   {
	   return $path ? $path : site_url(INVENTRORY_DEFAULT_IMAGE);
   }
}
