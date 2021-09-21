

<div class="row">
        <div class="col-lg-8">
        	<br/>

          <div class="card mb-4">
            <div class="card-body">
              <h2 class="card-title">About</h2>
              <p class="card-text">
				<form method="post" action="/game/update-profile">
				<?= hf_input('players_nickname', 'Nickname', $_POST ?: $profile, array('placeholder' => 'Nickname'), $errors) ?>
				<?= hf_input('players_banner', 'Banner', $_POST ?: $profile, array('placeholder' => 'http://link.to.image/'), $errors) ?>
				<?= hf_textarea('players_about', 'About', $_POST ?: $profile, array('class' => 'col-sm-12', 'placeholder' => 'All about you and your horses!', 'rows' => '10'), $errors) ?>
              </p>
            </div>
            <div class="card-footer text-muted">
				<?= hf_submit('update_profile', 'Update Profile', array('class' => 'btn btn-primary col-sm-12')) ?>
				</form>
            </div>
          </div>



          <div class="card mb-4">
            <div class="card-body">
              <h2 class="card-title">Password</h2>
              <p class="card-text">
				<form method="post" action="/game/update-profile">

				<?= hf_input('current_password', 'Current Password', '', array('type' => 'password', 'placeholder' => 'Current Password'), $errors) ?>
				<?= hf_input('new_password', 'New Password', '', array('type' => 'password', 'placeholder' => 'Password'), $errors) ?>
				<?= hf_input('confirm_password', 'Confirm Password', '', array('type' => 'password', 'placeholder' => 'Confirm Password'), $errors) ?>

			  </p>
            </div>
            <div class="card-footer text-muted">
				<?= hf_submit('change_password', 'Change Password', array('class' => 'btn btn-primary col-sm-12')) ?>
				</form>
            </div>
          </div>



          <div class="card mb-4">
            <div class="card-body">
              <h2 class="card-title">Email</h2>
              <p class="card-text">
				<form method="post" action="/game/update-profile">
					<?= hf_input('current_email', 'Current Email', '', array('placeholder' => 'Current Email'), $errors) ?>
					<?= hf_input('new_email', 'New Email', '', array('placeholder' => 'New Email'), $errors) ?>
					<?= hf_input('confirm_email', 'Confirm Email', '', array('placeholder' => 'Confirm Email'), $errors) ?>

              </p>
            </div>
            <div class="card-footer text-muted">
				<?= hf_submit('change_email', 'Change Email', array('class' => 'btn btn-primary col-sm-12')) ?>
				</form>
            </div>
          </div>

        </div>

        <!-- Sidebar Widgets Column -->
        <div class="col-lg-4">

          <div class="card my-4">
            <h5 class="card-header">Stats</h5>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-4">
                	<b>Joined</b>
                </div>
                <div class="col-sm-8">
                	<?= $profile['players_join_date2'] ?>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-4">
                	<b>AMI</b>
                </div>
                <div class="col-sm-8">
                	<?= $profile['players_ami'] ?>
                </div>
              </div>
              <? if($profile['players_admin']): ?>
              <div class="row">
              	<div class="col-sm-12 text-center">
              		<i>Administrator</i>
              	</div>
              </div>
          	  <? endif; ?>
            </div>
          </div>



      	  	<div class="center"><br/><br/><br/>
	  			<a href="/game/quit" class="btn btn-danger center">Quit Game</a><br/><br/>
	  		</div>

        </div>
</div>