
<p>
This horse is available to import to your account. If you choose to import it, the transaction is instantaneous and the fee will be removed from your bank account immediately.
</p>
<div class="row">

<div class="col-md-6">
        <div class="card mb-4">
          	<h5 class="card-header"><?= $horse['horses_competition_title'] ?> <?= $horse['horses_breeding_title'] ?> <?= $horse['horses_name'] ?></h5>
            <div class="card-body">
            	<?= $horse['horses_birthyear'] . " " . $horse['horses_color'] . " " . $horse['horses_breed'] . " " . $horse['horses_gender'] . "<br/><i>" . $horse['horses_pattern'] . "</i> " . $horse['horses_breed2']?><br/>
            	Stud Fee is $<?= number_format($horse['horses_breeding_fee']) ?>
            </div>
        </div>
</div>
<div class="col-md-6">
	<div class="card mb-4">
		<h5 class="card-header">Confirm Import</h5>
        <div class="card-body">
			<form method="post" action="/horses/import/<?= $horse['horses_id'] ?>">
				<? if($this->session->flashdata('errors')): ?>
				<? foreach((array)$this->session->flashdata('errors') AS $e): ?>
					<div class="form-error"><?= $e ?></div>
				<? endforeach; ?>
				<? endif; ?>
			<div class="center">
				<?= Bank::list_accounts_dropdown($this->session->userdata('players_id'), 'bank_id', 'From Account', NULL, NULL, 'Checking'); ?><br/>
				<?= hf_submit('confirm', '$' . number_format($horse['horses_sale']), array('class' => 'btn btn-primary col-sm-8 center')) ?>
			</div>
			</form>
		</div>
	</div>

</div>
</div>