


    <header class="header-logo">
    	<img src="<?= SITE_LOGO ?>" class="img-fluid">
      <div class="container text-center">
        <!--<h1>Join the Game</h1>-->
        <!--<p class="lead">a simulated horse club for the mature enthusiast</p>-->
      </div>
    </header>


    <!-- Page Content -->
    <div class="container">

<br/>


      <!-- Features Section -->
      <div class="row">
        <div class="col-lg-12">
          <h2>Join HFSHC</h2>
          <p><b><font color=red>Each player is limited to ONE account! Duplicate accounts are not permitted!</font></b></p>

<p>Please note that HFSHC manually accepts or rejects all membership applications. You will not be able to login until a member of our team has accepted or rejected your application. You must answer all of the questions appropriately and in a desirable format in order to be accepted into HFSHC.</p>

<p>Our application process helps to insure that each new member is a good fit for our game. HFSHC is very rule- and realism-oriented, so please keep that in mind.</p>

<p><font color=blue><b>Please be sure that you have reviewed the <a href="tos">Terms of Service</a> before signing up.</b></font></p>



        </div>
      </div> <!-- /.row -->

      <div class="row">
      	<div class="col-lg-12">
          <div class="card">

			<form method="post" action="register">
            <!--<h4 class="card-header">Login</h4>-->
            <div class="card-body">
<p><b>Account Information</b></p>
				<?= hf_input('username', '', $_POST, array('placeholder' => 'Username'), $errors) ?>
				<?= hf_input('password', '', '', array('type' => 'password', 'placeholder' => 'Password'), $errors) ?>
				<?= hf_input('password2', '', '', array('type' => 'password', 'placeholder' => 'Confirm Password'), $errors) ?>
				<?= hf_input('email', '', $_POST, array('placeholder' => 'Email'), $errors) ?>
				<?= hf_input('nickname', '', $_POST, array('placeholder' => 'Nickname'), $errors) ?>
				<?= hf_input('dob', '', $_POST, array('placeholder' => 'Date of Birth (MM/DD/YYYY)'), $errors) ?>


<br/>
<p><b>Questionnaire</b></p>
<? $count = 0; ?>
<? foreach($questions AS $k => $q): ?>
	<div class="row form-group">
		<!--<option value="<?= $q['questions_id'] ?>" <?= $data['questions'][$i] == $q['questions_id'] ? 'SELECTED' : '' ?>>-->
		<div class="col-sm-12">
			<?= $q['questions_question'] ?>
			<?= hf_hidden('questions['.$k.']', $q['questions_id']); ?>
		</div>
		<div class="col-sm-12">
			<!--<option value="<?= $q['questions_id'] ?>" <?= $data['questions'][$i] == $q['questions_id'] ? 'SELECTED' : '' ?>>-->
			<?= hf_textarea('answers['.$count.']', '', $_POST['answers'][$count], array('class' => 'col-sm-12', 'placeholder' => 'Answer', 'rows' => '4'), $errors) ?>
		</div>
		<div class="col-sm-12">
			<?= $errors['questions['.$k.']'] ? '<p class="errors">' . $errors['questions['.$k.']'] . '</p>' : '' ?>
		</div>
	</div>
<? $count++; ?>
<? endforeach; ?>

            </div>
            <div class="card-footer">
				<div class="row">
					<div class="col-sm-12 align-middle">
						<?= hf_submit('register', 'Register!', array('class' => 'btn btn-primary col-sm-12')) ?>
					</div>
				</div>
            </div>
			</form>

		</div>
		</div>
	</div> <!-- /row -->


<br/>
    </div>
    <!-- /.container -->
