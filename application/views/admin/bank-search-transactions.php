 <div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
          	<h4 class="card-header">Search Transactions</h4>
            <div class="card-body">
				<form method="post" action="/admin/bank/search_transactions">

				<div class="row">
					<div class="col-sm-6">
						<?= hf_dropdown('bank_checks_status', 'Status', $_POST, array('Pending', 'Deposited', 'Refused', 'Ignored'), array(), $errors, 1) ?>
					</div>
					<div class="col-sm-6">
						<?= hf_input('bank_checks_memo', 'Memo', $_POST, array(), $errors) ?>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-6">
						<?= hf_input('min_amount', 'Min Amount', $_POST, array(), $errors) ?>
					</div>
					<div class="col-sm-6">
						<?= hf_input('max_amount', 'Max Amount', $_POST, array(), $errors) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<?= hf_input('start_date', 'Start Date', $_POST, array(), $errors) ?>
					</div>
					<div class="col-sm-6">
						<?= hf_input('end_date', 'End Date', $_POST, array(), $errors) ?>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-6">
						<?= hf_checkbox('hide_interest', 'Hide interest payments?', $_POST, array(), $errors) ?>
						<?= hf_checkbox('hide_interest2', 'Hide interest incurred?', $_POST, array(), $errors) ?>
						<?= hf_checkbox('hide_monthly', 'Hide monthly checks?', $_POST, array(), $errors) ?>
						<?= hf_checkbox('hide_import', 'Hide horse imports?', $_POST, array(), $errors) ?>
						<?= hf_checkbox('hide_auctions', 'Hide auctions?', $_POST, array(), $errors) ?>
						<?//= hf_checkbox('hide_internal', 'Hide internal transfers?', $_POST, array(), $errors) ?>
						<?//= hf_checkbox('hide_internal', 'Hide internal transfers?', $_POST, array(), $errors) ?>
					</div>
					<div class="col-sm-6">
					</div>
				</div>
				<br/>


            </div>
            <div class="card-footer text-muted">
				<?= hf_submit('search', 'Search Transactions', array('class' => 'btn btn-primary col-sm-12')) ?>
				</form>
            </div>
        </div>
    </div>
</div>
