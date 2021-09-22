<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>	  
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <title><?php echo SITE_NAME.'-'.'Super-Admin-'.$page_title;?></title>
	<link rel="shortcut icon" href="<?=SITE_FAV_LOGO?>" type="image/x-icon">
    <link href="<?php echo $BASE_URL;?>assets/admin/css/plugin-min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $BASE_URL;?>assets/admin/css/style.css" rel="stylesheet" type="text/css" />
	<style>
	.form_vl_error{
		box-sizing: border-box;
        color: red;
        text-align: left;
	}
	</style>
</head>
<body>