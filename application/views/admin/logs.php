 <div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
          	<h4 class="card-header">Search Logs</h4>
            <div class="card-body">
				<form method="post" action="/admin/members/log">
				<div class="row">
					<div class="col-sm-6">
						<?= hf_input('join_players_id', 'Player ID', $_POST, array(), $errors) ?>
					</div>
					<div class="col-sm-6">
						<?= hf_input('log_ip', 'IP Address (partial OK)', $_POST, array(), $errors) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<?= hf_input('log_activity', 'Activity', $_POST, array(), $errors) ?>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-6">
						<?= hf_input('start_date', 'Start Date', $_POST, array('placeholder' => 'YYYY/MM/DD'), $errors) ?>
					</div>
					<div class="col-sm-6">
						<?= hf_input('end_date', 'End Date', $_POST, array('placeholder' => 'YYYY/MM/DD'), $errors) ?>
					</div>
				</div>
				<br/>


            </div>
            <div class="card-footer text-muted">
				<?= hf_submit('search', 'Search Logs', array('class' => 'btn btn-primary col-sm-12')) ?>
				</form>
            </div>
        </div>
    </div>
</div>
