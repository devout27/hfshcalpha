
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?= SITE_ABBR ?>: <?= $this->data['page']['title'] ?></title>	  
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">    
    <!-- Custom styles for this template -->
    <link href="<?= base_url('assets/css/jquery-ui.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/jquery.dataTables.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/line-awesome.min.css'); ?>">
    <link href="<?= base_url('assets/css/main.css?date='.date('YmdHis')); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/calendar/simple-calendar.css'); ?>" rel="stylesheet">
    <script src='<?= base_url('assets/js/tinymce/tinymce.min.js'); ?>'></script>
    <script src="https://kit.fontawesome.com/f2d012e2d7.js" crossorigin="anonymous"></script>
  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="/game">Hurricane Farms SIM Horse Club</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <!--<li class="nav-item">
              <a class="nav-link" href="about.html">About</a>
            </li>-->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAccount" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Your Account
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownAccount">
                <a class="dropdown-item" href="/game/profile">Profile</a>                
                <a class="dropdown-item <?= $this->data['player']['unread'] ? ' new_msg' : '' ?>" href="/game/messages" >Messages (<?= $this->data['player']['unread'] ?: '0' ?>)</a>
                <a class="dropdown-item" href="/city/credits">Credits</a>
                <?php if($player['players_admin']): ?>
                	<a class="dropdown-item" href="/admin">Admin</a>
                <?php endif; ?>
                <a class="dropdown-item" href="/logout">Logout</a>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPortfolio" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                All Things SIM
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPortfolio">
                <a class="dropdown-item" href="/game/inventory">Inventory</a>
                <a class="dropdown-item" href="/city/humane">Humane Society</a>
                <a class="dropdown-item" href="/city/events">Event House</a>
                <a class="dropdown-item" href="/city/vet">Veterinary Office</a>
                <a class="dropdown-item" href="/city/farrier">Farrier Office</a>
                <a class="dropdown-item" href="/manage-horses">Manage Horses</a>
                <a class="dropdown-item" href="/stables">Manage Stables</a>
                <a class="dropdown-item" href="/manage-sale-purposals">My Horses for Sale</a>
                <a class="dropdown-item" href="/horses">Horses</a>
                <a class="dropdown-item" href="/game/profile/search">Stables</a>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownBlog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                City Place
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownBlog">
                <a class="dropdown-item" href="/city/articles/14">Active Member Incentive (AMI)</a>
                <a class="dropdown-item" href="http://www.hfshc.com/community/index.php">Community Center</a>
                <a class="dropdown-item" href="/game">News Stand</a>
                <a class="dropdown-item" href="/city/colosseum">The Colosseum</a>
                <a class="dropdown-item" href="/city/bank">Grand Bank</a>
                <a class="dropdown-item" href="/city/ideal-dreams">Ideal Dreams</a>
                <a class="dropdown-item" href="/city/clubs">Clubs & Associations</a>
                <a class="dropdown-item" href="/city/shops">Shops & Businesses</a>
                <a class="dropdown-item" href="/city/online"><?= $this->data['online_players'] ?> Currently Online</a>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownBlog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Help
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownBlog">
                <a class="dropdown-item" href="/city/articles/3">FAQ</a>
                <a class="dropdown-item" href="/city/articles/9">New Member Center</a>
                <a class="dropdown-item" href="/city/articles/10">Rules to Play By</a>
                <a class="dropdown-item" href="/city/articles/11">Mentor Program</a>
                <a class="dropdown-item" href="/city/articles/12">The Committee</a>
                <a class="dropdown-item" href="/city/articles/2">Help & Resources</a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>

<?php if(!$this->data['page']['hide_logo']): ?>
    <header class="header-logo">
    	<img src="<?= SITE_LOGO ?>" class="img-fluid">
      <div class="container text-center">
        <!--<h1>Hurricane Farms</h1>
        <p class="lead">a simulated horse club for the mature enthusiast</p>-->
      </div>
    </header>
<?php else: ?>
    <header class="header-logo">
    </header>
<?php endif; ?>


    <!-- Page Content -->
    <div class="container">
    	<br/>

    	<?php if($this->data['player']['players_pending_delete']): ?>
    	<div class="center">
    		<p class="text-danger font-weight-bold">This account is pending deletion.</p>
    		<a href="/game/cancel-quit" class="btn btn-warning">Cancel Request</a>
    	</div>
    	<?php endif; ?>

    	<h2><?= $this->data['page']['title'] ?></h2>

	<?php if($this->session->flashdata('notice')): ?>
	<div class="center">
		<p class="error center">
			<?php if(is_array($this->session->flashdata('notice'))): ?>
				<?php foreach($this->session->flashdata('notice') AS $k): ?>
					<?php if(is_array($k)): ?>
						<?php foreach($k AS $v): ?>
							<?= $v ?><br/>
						<?php endforeach; ?>
					<?php else: ?>
						<?= $k ?><br/>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php else: ?>
				<?= $this->session->flashdata('notice'); ?>
			<?php endif; ?>
		</p>
	</div>
	<?php endif; ?>