
<div class="row">
	<div class="col-md-12">

		<p>Here's a list of pending loan applications.</p>

		<div class="row">
			<div class="col-sm-12">
				<table class="table table-sm table-hover w-100 no-wrap">
		    		<thead>
					<tr>
		    			<th>Application</th>
		    			<th>Actions</th>
					</tr>
					</thead>
					<tbody>
						<? foreach((array)$bank_applications AS $a): ?>
						<tr>
							<td ><a href="/game/profile/<?= $a['join_players_id'] ?>"><?= $a['players_nickname'] ?> #<?= $a['join_players_id'] ?></a><br/><small class="text-muted"><?= $a['players_join_date2'] ?></small><br/><br/>

								<b>Amount Requested</b><br />
								$<?= number_format($a['amount_requested'], 2) ?><br/><br/>

								<b>What is the purpose of this loan?</b><br/>
								<?= $a['purpose'] ?><br/><br/>

								<b>What are your plans for paying off this loan?</b><br/>
								<?= $a['repayment'] ?><br/><br/>

								<b>What will be your source(s) of income that you will use to pay back the loan?</b><br/>
								<?= $a['income_sources'] ?><br/><br/>

								<b>Where do you currently board and how long have you been a boarder?</b><br/>
								<?= $a['boarding'] ?><br/><br/>

								<b>Additional info you would like to provide:</b><br/>
								<?= $a['comments'] ?>

			              	</td>
        					<td width="40%">

<form method="post" action="/admin/bank/applications/loan_process">
	<?= hf_hidden('bank_loans_id', $a['bank_loans_id']) ?>
	<div class="col-xs-12 button-wrapper">
		<?= hf_submit('accept', 'Accept', array('class' => 'btn btn-success col-md-5 float-left')) ?>
		<?= hf_submit('reject', 'X', array('class' => 'btn btn-danger col-md-2 float-right glyphicon glyphicon-remove')) ?>
	</div>

</form>
        					</td>
						</tr>
						<? endforeach; ?>
					</tbody>
				</table>

		    </div>
		</div><br/>

	</div>
</div>




<div class="row">
	<div class="col-md-12">

		<p>Here's a list of pending bank account applications.</p>

		<div class="row">
			<div class="col-sm-12">
				<table class="table table-sm table-hover w-100 no-wrap">
		    		<thead>
					<tr>
		    			<th>Application</th>
		    			<th>Type</th>
		    			<th>Tier</th>
		    			<th>Actions</th>
					</tr>
					</thead>
					<tbody>
						<? foreach((array)$bank_accounts AS $a): ?>
						<tr>
							<td><a href="/game/profile/<?= $a['join_players_id'] ?>"><?= $a['players_nickname'] ?> #<?= $a['join_players_id'] ?></a><br/><small class="text-muted"><?= $a['players_last_active2'] ?></small>

			              	</td>
			              	<td><?= $a['bank_type'] ?></td>
			              	<td><?= $a['bank_tier'] ?></td>
        					<td width="40%">

<form method="post" action="/admin/bank/applications/process">
	<?= hf_hidden('bank_id', $a['bank_id']) ?>
	<?= hf_hidden('bank_type', $a['bank_type']) ?>
	<div class="col-xs-12 button-wrapper">
		<?= hf_submit('accept', 'Accept', array('class' => 'btn btn-success col-md-5 float-left')) ?>
		<?= hf_submit('reject', 'X', array('class' => 'btn btn-danger col-md-3 float-right')) ?>
	</div>

</form>
        					</td>
						</tr>
						<? endforeach; ?>
					</tbody>
				</table>

		    </div>
		</div><br/>

	</div>
</div>