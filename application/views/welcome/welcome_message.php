


    <header class="header-logo">
    	<img src="<?= SITE_LOGO ?>" class="img-fluid">
      <div class="container text-center">
        <!--<h1>Hurricane Farms</h1>
        <p class="lead">a simulated horse club for the mature enthusiast</p>-->
      </div>
    </header>


    <!-- Page Content -->
    <div class="container">

<br/>


      <!-- Features Section -->
      <div class="row">
        <div class="col-lg-8">
          <h2>Welcome to <?= SITE_NAME; ?>!</h2>
          <p><?= SITE_ABBR ?> was established in 1997 and is quite possibly the leading SIM game on the internet today, endless possibilities for adults of all ages. As a club designed to educate members while they participate in enjoyable activities, HFSHC is structured to be as realistic as possible in a SIM game. We pride ourselves in the fact that the game is always evolving into something better, and hope that you will consider joining after reviewing our club policies.</p>

        </div>
        <div class="col-lg-4 mb-4">

          <div class="card">
			<form method="post" action="login">
            <div class="card-body">
				<?= hf_input('username', '', $_POST, array('placeholder' => 'Username'), $errors) ?>
				<?= hf_input('password', '', '', array('type' => 'password', 'placeholder' => 'Password'), $errors) ?>
            </div>
            <div class="card-footer">
				<div class="row">
					<div class="col-sm-12 align-middle col-md-12">
						<?= hf_submit('login', 'Login!', array('class' => 'btn btn-primary col-sm-12')) ?>
					</div>
				</div>
            </div>
			</form>
          </div>


        </div>
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-lg-5">
          <img class="img-fluid rounded" src="http://placehold.it/700x450" alt="">
        </div>
        <div class="col-lg-7">
          <p class="text-danger font-weight-bold">Intended for a general audience ages 18 and up.</p>

		  <p><?= SITE_NAME; ?> SIM Horse Club (HFSHC or HFSHC.COM) is created and maintained for entertainment purposes only. All contents found within HFSHC.COM and its sub-sites are completely fictional unless specifically stated otherwise, and any resemblance to actual persons, horses, events, companies or farms is purely coincidental. HFSHC.COM provides no guarantee of service, and maintains the right to refuse access to any person at any time, for any reason. All services are provided free of charge.</p>

        </div>
      </div>
      <!-- /.row -->

<br/>
    </div>
    <!-- /.container -->
