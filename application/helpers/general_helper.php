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
}
