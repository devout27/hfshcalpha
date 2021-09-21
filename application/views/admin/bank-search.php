 <div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
          	<h4 class="card-header">Search</h4>
            <div class="card-body">
				<form method="post" action="/admin/bank/search">
				<div class="row">
					<div class="col-sm-6">
						<?= hf_input('bank_owner', 'Owner ID or Name or Partial Name', $_POST, array(), $errors) ?>
					</div>
					<div class="col-sm-6">
						<?= hf_dropdown('bank_type', 'Type', $_POST, array('', 'Checking', 'Savings', 'Business', 'Loan'), array(), $errors, 1) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<?= hf_dropdown('bank_status', 'Status', $_POST, array('', 'Open', 'Closed', 'Pending'), array(), $errors, 1) ?>
					</div>
					<div class="col-sm-6">
						<?= hf_dropdown('bank_tier', 'Tier', $_POST, array('', 'A', 'B', 'C', 'D', 'E', 'F'), array(), $errors, 1) ?>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-6">
						<?= hf_input('min_balance', 'Min Balance', $_POST, array(), $errors) ?>
					</div>
					<div class="col-sm-6">
						<?= hf_input('max_balance', 'Max Balance', $_POST, array(), $errors) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<?= hf_input('min_credit_limit', 'Min Credit Limit', $_POST, array(), $errors) ?>
					</div>
					<div class="col-sm-6">
						<?= hf_input('max_credit_limit', 'Max Credit Limit', $_POST, array(), $errors) ?>
					</div>
				</div>
				<br/>


            </div>
            <div class="card-footer text-muted">
				<?= hf_submit('search', 'Search Bank Accounts', array('class' => 'btn btn-primary col-sm-12')) ?>
				</form>
            </div>
        </div>
    </div>
</div>
