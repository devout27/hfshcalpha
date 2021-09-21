	<? if($this->session->flashdata('errors')): ?>
	<div class="center">
		<p class="error center">
			<? if(is_array($this->session->flashdata('errors'))): ?>
				<? foreach($this->session->flashdata('errors') AS $k): ?>
					<? if(is_array($k)): ?>
						<? foreach($k AS $v): ?>
							<?= $v ?><br/>
						<? endforeach; ?>
					<? else: ?>
						<?= $k ?><br/>
					<? endif; ?>
				<? endforeach; ?>
			<? else: ?>
				<?= $this->session->flashdata('errors'); ?>
			<? endif; ?>
		</p>
	</div>
	<? endif; ?>

<div class="row">
	<div class="col-md-12">
		<div class="card">
            <div class="card-body">
			<form method="post" action="/city/bank/transfer">
				<?= hf_dropdown('transfer_type', 'What kind of transfer?', $post, array('1' => 'Internal', '2' => 'External'), array('class' => 'col-sm-12'), $errors, 1) ?>

				<?= Bank::list_accounts_dropdown($this->session->userdata('players_id')); ?>
				<?= Bank::list_accounts_dropdown($this->session->userdata('players_id'), 'transfer_to', 'To Account'); ?>
				<?= hf_input('transfer_id', 'External Transfer Bank ID', $post, array(), $errors) ?>
				<?= hf_input('transfer_amount', 'Amount', $post, array(), $errors) ?>
				<?= hf_input('transfer_memo', 'Memo', $post, array(), $errors) ?>


				<?= hf_dropdown('transfer_recurring', 'Recurring Transfer?', $post, array('1' => 'No', '2' => 'Yes'), array('class' => 'col-sm-12'), $errors, 1) ?>
				<?= hf_input('transfer_start', 'Start Date', $post, array('placeholder' => 'YYYY-MM-DD', 'maxlength' => 10), $errors) ?>

				<div class="row">
					<div class="col-md-3">
						Transfer every...
					</div>
					<div class="col-md-3">
						<?= hf_dropdown('transfer_frequency', '', $post, array('Days', 'Months'), array(), $errors, 1) ?>
					</div>
					<div class="col-md-3">
						<?= hf_dropdown('transfer_months', '', $post, $months, array(), $errors) ?>
						<?= hf_dropdown('transfer_days', '', $post, $days, array(), $errors) ?>
					</div>
				</div>
			</div>
            <div class="card-footer">
				<?= hf_submit('transfer_money', 'Initiate Transfer', array('class' => 'btn btn-primary col-sm-12')) ?>
			</form>
			</div>
		</div>
		<br/>
	</div>
</div>




<div class="row">
	<div class="col-md-12">
		<h3>Recurring Transfers</h3>
		<div class="card">
            <div class="card-body">



<div class="container-fluid">
    <div class="table-responsive">
	<table class="table table-sm table-hover  no-wrap col-sm-12 w-100" id="dt-bank-incoming">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">From</th>
      <th scope="col">To</th>
      <th scope="col">Amount</th>
      <th scope="col">Start Date</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  	<? foreach((array)$transfers AS $t): ?>
    <tr>
      <td><?= $t['bank_recurring_id'] ?></td>
      <td data-priority="1"><a href="/city/bank/<?= $t['join_bank_id'] ?>"><?= $t['bank_nickname'] ?> #<?= $t['join_bank_id'] ?></td>
      <td data-priority="1"><a href="/city/bank/<?= $t['bank_recurring_to'] ?>"><?= $t['bank_nickname2'] ?> #<?= $t['bank_recurring_to'] ?></a><br/>
      		<small class="text-muted">
      			<?= $t['bank_recurring_memo'] ?><br/>
      			<? if($t['bank_recurring_days']): ?>
      				Transfers every <?= $t['bank_recurring_days'] ?> day(s)
      			<? else: ?>
      				Transfers every <?= $t['bank_recurring_months'] ?> month(s)
      			<? endif; ?>
      		</small>
  	  </td>
      <td data-priority="2">$<?= number_format($t['bank_recurring_amount']) ?></td>
      <td><?= $t['bank_recurring_start_date'] ?></td>
      <td data-priority="1">
		<form method="post" action="/city/bank/transfer/cancel/<?= $t['bank_recurring_id'] ?>">
		<div class="row">
			<div class="col-lg-12">
				<?= hf_submit('cancel_transfer', 'Cancel Transfer', array('class' => 'btn btn-primary col-sm-12')) ?>
			</div>
		</div>
		</form>
      </td>
    </tr>
	<? endforeach; ?>
  </tbody>
</table>
</div>
</div>
			</div>
		</div>
		<br/>
	</div>
</div>
