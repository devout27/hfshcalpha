<?php
//-- form helper functions!

if(!function_exists('hf_input')){

	function hf_input($name, $label, $value, $params = null, $errors = null,$type="text"){
		//generate the element, then call function to add standard html		
		$params['id'] = $params['id'] ?: $name;
		$params['name'] = $name;
		if($params['class']){
			$params['class'] .= " col-sm-12";
		}else{
			$params['class'] = " col-sm-12";
		}

		if(is_array($value)){
			$value = $value[$name];
		}

		$element = form_input($params,$value,'',$type);

		$html = hf_build_form_html($element, $name, $label, $value, $params, $errors);
		return $html;
	}

	function hf_textarea($name, $label, $value, $params = null, $errors = null){
		//generate the element, then call function to add standard html
		$params['id'] = $params['id'] ?: $name;
		$params['name'] = $name;

		if(is_array($value)){
			$value = $value[$name];
		}

		$element = form_textarea($params, $value);
		$params['textarea'] = true;

		$html = hf_build_form_html($element, $name, $label, $value, $params, $errors);
		return $html;
	}

	function hf_upload($name, $label, $value, $params = null, $errors = null){
		//generate the element, then call function to add standard html
		$params['id'] = $params['id'] ?: $name;
		$params['name'] = $name;

		if(is_array($value)){
			$value = $value[$name];
		}

		$element = form_upload($params, $value);

		$html = hf_build_form_html($element, $name, $label, $value, $params, $errors);
		return $html;
	}

	function hf_hidden($name, $value){
		if(is_array($value)){
			$value = $value[$name];
		}

		return form_hidden($name, $value);
	}

	function hf_checkbox($name, $label, $value, $params = null, $errors = null){
		//generate the element, then call function to add standard html
		$params['id'] = $params['id'] ?: $name;
		$params['name'] = $name;

		if(is_array($value)){
			$value = $value[$name];
		}

		$params['checked'] = $value;
		$params['value'] = 1;
		$element = form_checkbox($params);
		$params['label'] = $label;
		$params['checkbox'] = true;

		$html = hf_build_form_html($element, $name, $label, $value, $params, $errors);
		return $html;
	}

	function hf_radio($name, $label, $values, $params = null, $errors = null){
		//generate the element, then call function to add standard html
		$params['id'] = $params['id'] ?: $name;
		$params['name'] = $name;
		$element .= "<div>";
		foreach((array)$values AS $v){
			$params['value'] = $v;
			$params['class'] = 'radio-padding';
			$element .= form_radio($params);
			$element .= " " . ucfirst($v);
		}
		$element .= "</div>\n";
		$params['label'] = $label;
		$params['radio'] = true;

		$html = hf_build_form_html($element, $name, $label, $value, $params, $errors);
		return $html;
	}

	function hf_dropdown($name, $label, $value = array(), $options = array(), $params = null, $errors = '', $vToK = 0, $insert_blank = 1){
		//generate the element, then call function to add standard html
				//form_dropdown('archived', array('0' => 'Current Tickets', '1' => 'Archived Tickets', '' => 'All Tickets'), 'current', 'class="form-control" id="archived"');

		//$vToK means the value is the index
		//$blank means a blank value is inserted at the beginning

		$params['id'] = $params['id'] ?: $name;
		$params['name'] = $name;

		//-- must flatten params for the built-in dropdown function
		foreach($params AS $k => $v){
			$params_flat .= $k . "=\"" . $v . "\"";
		}

		if(count($options) < 1){
			$options = array('' => 'Default');
		}

		if($vToK){
			//set all keys to values
			foreach($options AS $k => $v){
				$options2[$v] = $v;
			}
			$options = $options2;
			unset($options2);
		}

		if($insert_blank){
			$options = array('' => '-- Choose --') + $options;
		}



		if(is_array($value)){
			$value = $value[$name];
		}

		$element = form_dropdown($name, $options, $value, $params_flat);

		$html = hf_build_form_html($element, $name, $label, $value, $params, $errors);
		return $html;
	}

	function hf_multiselect($name, $label, $value = array(), $options = array(), $params = null, $errors = '', $vToK = 0){

		$params['id'] = $params['id'] ?: $name;
		$params['name'] = $name;

		if(is_array($value)){
			$values = $value;
			$value = $value[$name];
		}

		//-- must flatten params for the built-in dropdown function
		foreach($params AS $k => $v){
			$params_flat .= $k . "=\"" . $v . "\"";
		}


		if($vToK){
			//set all keys to values
			foreach($options AS $k => $v){
				$options2[$v] = $v;
			}
			$options = $options2;
			unset($options2);
		}

		$element = form_multiselect($name, $options, $values, $params_flat);

		$html = hf_build_form_html($element, $name, $label, $value, $params, $errors);
		return $html;
	}

	function hf_submit($name, $label, $params = null){
		//generate the element, then call function to add standard html
		$params['id'] = $params['id'] ?: $name;
		$params['name'] = $name;

		return form_submit($name, $label, $params);

		$html = hf_build_form_html($element, $name, $label, $value, $params, $errors);
		return $html;
	}

	function hf_build_form_html($element, $name, $label, $value, $params = null, $errors = ''){
		$column_width = "col-sm-12";
		if($params['checkbox']){
			$style = "style=\"margin-bottom: 0px; font-weight: normal;\"";
			$column_width = "col-sm-12 pull-right";
		}elseif(($params['textarea'] AND !$label) || $params['no_label']){
			$column_width = "col-sm-12";
		}
		$html = "\n<div class=\"row form-group\" {$style}>\n";
		if($label AND !$params['checkbox']){
			$html .= "<label class=\"col-sm-12 col-form-label\" for=\"". $name ."\">{$label}</label>";
		}elseif($params['checkbox'] AND $label){
			$element = "<label for=\"{$name}\" {$style}>{$element} {$label}</label>";
		}elseif($params['checkbox']){
			$element = "{$element}";
		}
		$params['id'] ?: $name;
		$params['name'] = $name;
		if(count($errors[$name]) >= 1){
			$hidden = "";
		}else{
			$hidden = "hidden";
		}
		$error = "\n<div class=\"form-error pull-right $hidden\">" . $errors[$name] . "</div>\n";
		$html .= "<div class=\" {$column_width}\">$element $error</div>\n</div>\n";
		return $html;
	}

}

