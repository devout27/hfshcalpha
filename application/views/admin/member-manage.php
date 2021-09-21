<h2><?= $profile['players_nickname'] ?> #<?= $profile['players_id'] ?></h3>
<div class="row">
	<div class="col-sm-12">
		<?//= hf_input('players_id', 'Player ID', $profile['players_id'], array('disabled' => 'disabled'), $errors) ?>


		<div class="card mb-4">
		  	<h5 class="card-header">Credits & More</h5>
		    <div class="card-body">

				<form method="post" action="/admin/members/manage/<?= $profile['players_id'] ?>">
				<?= hf_hidden('players_id', $profile['players_id']) ?>
				<div class="row">
					<div class="col-sm-12 col-md-4 col-xl-3">
						<?= hf_input('players_credits_creation', 'Creation Credits', $profile, array('placeholder' => '0'), $errors) ?>
					</div>					
					<div class="col-sm-12 col-md-4 col-xl-3">
						<?= hf_input('per_day_credits', 'Daily Creation Credits Limit', $profile, array('placeholder' => '0'), $errors) ?>
					</div>
					<div class="col-sm-12 col-md-4 col-xl-3">
						<?= hf_input('players_credits_adoptathon', 'Adoptathon Credits', $profile, array('placeholder' => '0'), $errors) ?>
					</div>
					<div class="col-sm-12 col-md-4 col-xl-3">
						<?= hf_input('players_ami', 'AMI', $profile, array('placeholder' => '0'), $errors) ?>
					</div>

				</div>
            </div>
            <div class="card-footer text-muted">
				<?= hf_submit('update_credits', 'Update Credits & More', array('class' => 'btn btn-primary col-sm-12')) ?>
				</form>
            </div>
          </div>
			</div>
		</div>

		<div class="card mb-4">
		  	<h5 class="card-header">About</h5>
		    <div class="card-body">

				<form method="post" action="/admin/members/manage/<?= $profile['players_id'] ?>">
				<?= hf_hidden('players_id', $profile['players_id']) ?>
				<?= hf_input('players_nickname', 'Nickname', $_POST ?: $profile, array('placeholder' => 'Nickname'), $errors) ?>
				<?= hf_dropdown('players_house', 'House', $_POST ?: $profile, array('Eclipse', 'Milton', 'King'), array(), $errors, 1) ?>
				<?= hf_input('players_dob', 'Date of Birth (MM/DD/YYYY)', $_POST ?: $profile, array('placeholder' => 'MM/DD/YYYY', 'disabled' => 'disabled'), $errors) ?>
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
		  	<h5 class="card-header">Bank Accounts</h5>
		    <div class="card-body">


<div class="row">
	<div class="col-sm-12">
		<table class="table table-sm table-hover w-100 no-wrap">
    		<thead>
			<tr>
    			<th>Account</th>
    			<th>Type</th>
    			<th>Status</th>
    			<th>Balance</th>
    			<th>Available</th>
			</tr>
			</thead>
			<tbody>
				<? foreach((array)$accounts AS $a): ?>
				<tr>
					<td><a href="/city/bank/<?= $a['bank_id'] ?>"><?= $a['bank_nickname'] ?> #<?= $a['bank_id'] ?></a></td>
					<td><?= $a['bank_type'] ?></td>
					<td><?= $a['bank_status'] ?></td>
					<td>$<?= number_format($a['bank_balance']) ?></td>
					<? if($a['bank_type'] != "Loan"): ?>
						<td>$<?= number_format($a['bank_available_balance']) ?></td>
					<? else: ?>
						<td>$<?= number_format($a['bank_credit_limit'] - $a['bank_balance']) ?></td>
					<? endif; ?>
				</tr>
				<? endforeach; ?>
			</tbody>
		</table>

    </div>
</div>


		    </div>
          </div>


		<div class="card mb-4">
		  	<h5 class="card-header">Remove Player</h5>
		    <div class="card-body">
		    	<p>You may permanently remove a player from the game. This will move their horses to the Humane Society, disable their account, and disable their bank accounts.</p>

				<form method="post" action="/admin/members/manage/<?= $profile['players_id'] ?>">
				<?= hf_hidden('players_id', $profile['players_id']) ?>
				<?= hf_submit('remove_player', 'Remove Player', array('class' => 'btn btn-danger col-sm-12', 'onClick' => 'return confirm(\'Are you sure you want to remove this player?\')')) ?>
				</form>
            </div>
          </div>

  	</div>
</div>

<br/>