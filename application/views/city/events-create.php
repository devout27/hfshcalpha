
 <div class="row">

    <div class="col-md-12">
        <div class="card mb-4">
          	<h4 class="card-header">Create an Event</h4>
            <div class="card-body">
				<form method="post" action="/city/events/create/<?= $cab_id ?>">

				<?= hf_input('events_name', 'Name', $post, array(), $errors) ?>
				<?= Bank::list_accounts_dropdown($this->session->userdata('players_id'), 'join_bank_id', 'Bank Account', $post, $errors, 'Checking'); ?>
				<div class="row">
					<div class="col-sm-2">
						<?= hf_dropdown('events_type', 'Type', $post, array('Show', 'Race'), array(), $errors, 0, 0) ?>
					</div>
					<div class="col-sm-6 col-md-4">
						<?= hf_dropdown('events_host', 'Hosting As...', $cab_id ?: $post, $host_list, array(), $errors, 0, 0) ?>
					</div>
					<div class="col-sm-6">
						<?= hf_dropdown('events_classlist', 'Class List', $post, $events_classlist, array(), $errors, 0, 0) ?>
					</div>
				</div>
				<p>Please choose several different dates for your upcoming event. We will do our best to accomodate your request.</p>
				<div class="row showdates">
					<div class="col-sm-4">
						<?= hf_input('events_date1', 'Date One', $post, array('class' => 'datepicker_shows', 'autocomplete' => 'off'), $errors) ?>
					</div>
					<div class="col-sm-4">
						<?= hf_input('events_date2', 'Date Two', $post, array('class' => 'datepicker_shows', 'autocomplete' => 'off'), $errors) ?>
					</div>
					<div class="col-sm-4">
						<?= hf_input('events_date3', 'Date Three', $post, array('class' => 'datepicker_shows', 'autocomplete' => 'off'), $errors) ?>
					</div>
				</div>

				<div class="row racedates">
					<div class="col-sm-4">
						<?= hf_input('events_dater1', 'Date One', $post, array('class' => 'datepicker_races', 'autocomplete' => 'off'), $errors) ?>
					</div>
					<div class="col-sm-4">
						<?= hf_input('events_dater2', 'Date Two', $post, array('class' => 'datepicker_races', 'autocomplete' => 'off'), $errors) ?>
					</div>
					<div class="col-sm-4">
						<?= hf_input('events_dater3', 'Date Three', $post, array('class' => 'datepicker_races', 'autocomplete' => 'off'), $errors) ?>
					</div>
				</div>

            </div>
            <div class="card-footer text-muted">
				<?= hf_submit('create_event', 'Create Event', array('class' => 'btn btn-primary col-sm-12')) ?>
				</form>
            </div>
        </div>
    </div>


</div>
