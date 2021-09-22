<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<title><?php echo SITE_NAME.'-'.'Admin-'.$page_title;?></title>
    <?php echo $before_head;?>
	<link href="<?php echo $BASE_URL;?>assets/admin/css/plugin-min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo $BASE_URL;?>assets/admin/css/style.css" rel="stylesheet" type="text/css" />	
	<link href="<?= $BASE_URL;?>assets/admin/css/dataTables.min.css" rel="stylesheet" type="text/css" />	
	<link rel="shortcut icon" href="<?=SITE_FAV_LOGO?>" type="image/x-icon">
	<script src="<?php echo $BASE_URL;?>assets/admin/js/plugin-min.js" type="text/javascript"></script>
	<script src="<?php echo $BASE_URL?>/assets/admin/js/validation.js"></script>
	<!--multiselect dropdown -->
	<link href="<?php echo $BASE_URL;?>assets/admin/js/chosen_v1.8.7/chosen.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo $BASE_URL;?>assets/admin/js/chosen_v1.8.7/chosen.jquery.js" type="text/javascript"></script>
	<!--Dropzone -->
	<link rel="stylesheet" type="text/css" href="<?php echo $BASE_URL;?>assets/admin/js/dropzone/dist/dropzone.css" />
	<script type="text/javascript" src="<?php echo $BASE_URL;?>assets/admin/js/dropzone/dist/dropzone.js"></script> 	
</head>
<body>	
<div class="wrapper">
	<header class="header-area ubg-dark d-lg-none">
		<div class="menu-icon">
			<i class="la la-bars"></i>
			<i class="la la-times" style="display: none;"></i>
		</div>
		<div class="desktop-tagline ubg-dark light text-center">
			<h3>
			<a href="<?php echo $BASE_URL_ADMIN ?>Dashboards"><?php echo SITE_NAME?></a>
			</h3>
		</div>
	</header>
	<div class="layer"></div>
	<? $this->load->view('templates/_parts/admin_master_sidebar_view'); ?>	
</div>
<div id="loder-img">
	<div class="spinner spinner-border text-warning" role="status">
		<span class="sr-only">Loading...</span>
	</div>
</div>
<div class="content-wrapper">		