
 <div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
          	<h4 class="card-header">Filters</h4>
            <div class="card-body">
				<form method="post" action="/game/profile/search">
				<div class="row">
					<div class="col-sm-6">
						<?= hf_input('players_nickname', 'Player Name', $_POST, array(), $errors) ?>
					</div>
					<div class="col-sm-6">
						<?= hf_checkbox('active', 'Players active within the last 30 days', $_POST, array(), $errors, 1) ?>
					</div>
					<div class="col-sm-6">
						<?= hf_input('stables_name', 'Stable Name', $_POST, array(), $errors) ?>
					</div>
					<div class="col-sm-6">
						<?= hf_input('stables_boarding_fee', 'Boarding Fee', $_POST, array(), $errors) ?>
					</div>					
				</div>
            </div>
            <div class="card-footer text-muted">
				<?= hf_submit('search', 'Search', array('class' => 'btn btn-primary col-sm-12')) ?>
				</form>
            </div>
        </div>
    </div>
</div>
