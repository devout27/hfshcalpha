

 <div class="row">

    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
				<form method="post" action="/city/events/edit/<?= $event['events_id'] ?>">

				<div class="row">
					<div class="col-sm-2">
						<b>Type:</b>
					</div>
					<div class="col-sm-2">
						<?= $event['events_type'] ?>
					</div>
					<div class="col-sm-2">
						<b>Host:</b>
					</div>
					<div class="col-sm-6">
	                	<? if($event['join_cabs_id']): ?>
	                		<a href="/city/cabs/view/<?= $event['join_cabs_id'] ?>"><?= $event['cabs_name'] ?></a>
	                	<? else: ?>
	                		<a href="/game/profile/<?= $event['join_players_id'] ?>"><?= $event['players_nickname'] . " #". $event['join_players_id'] ?></a>
	                	<? endif; ?>
					</div>
				</div>
				<?= hf_input('events_name', 'Name', $event, array(), $errors) ?>
				<p>Please choose several different dates for your upcoming show. We will do our best to accomodate your request.</p>
				<? if($event['events_type'] == "Show"): ?>
					<div class="row">
						<div class="col-sm-4">
							<?= hf_input('events_date1', 'Date One', $event, array('class' => 'datepicker_shows', 'autocomplete' => 'off'), $errors) ?>
						</div>
						<div class="col-sm-4">
							<?= hf_input('events_date2', 'Date Two', $event, array('class' => 'datepicker_shows', 'autocomplete' => 'off'), $errors) ?>
						</div>
						<div class="col-sm-4">
							<?= hf_input('events_date3', 'Date Three', $event, array('class' => 'datepicker_shows', 'autocomplete' => 'off'), $errors) ?>
						</div>
					</div>
				<? else: ?>
					<div class="row ">
						<div class="col-sm-4">
							<?= hf_input('events_dater1', 'Date One', str_replace('-', '/', $event['events_date1']), array('class' => 'datepicker_races', 'autocomplete' => 'off'), $errors) ?>
						</div>
						<div class="col-sm-4">
							<?= hf_input('events_dater2', 'Date Two', $event['events_date2'], array('class' => 'datepicker_races', 'autocomplete' => 'off'), $errors) ?>
						</div>
						<div class="col-sm-4">
							<?= hf_input('events_dater3', 'Date Three', $event['events_date3'], array('class' => 'datepicker_races', 'autocomplete' => 'off'), $errors) ?>
						</div>
					</div>
				<? endif; ?>

            </div>
            <div class="card-footer text-muted">
            	<div class="row">
						<? if($event['events_pending'] == 2 AND !$this->data['player']['privileges']['privileges_events']): ?>
            			<div class="col-sm-12 col-md-12">
							Event is pending finalization and may not be edited.
						<? elseif(($event['events_pending'] == 2 AND $this->data['player']['privileges']['privileges_events']) OR $event['events_pending'] == 1): ?>
            				<div class="col-sm-12 col-md-4">
								<?= hf_submit('edit_event', 'Edit Event', array('class' => 'btn btn-primary col-sm-12')) ?>
							</div>
							<div class="hidden-md-up"><br/><br/>
						<? endif; ?>
					</div>
					<div class=" col-sm-12 col-md-4 offset-md-4">
						<? if($event['events_pending'] == 1): ?>
							<?= hf_submit('finalize_event', 'Finalize Event', array('class' => 'btn btn-success col-sm-12')) ?>
						<? elseif($event['events_pending'] == 2 AND $this->data['player']['privileges']['privileges_events']): ?>
							<?= hf_submit('approve_event', 'APPROVE', array('class' => 'btn btn-warning col-sm-12')) ?>
						<? endif; ?>
					</div>
				</div>
            </div>
				</form>
        </div>
    </div>


</div>




<div class="row">
    <div class="col-lg-12">
    	<div class="card my-4">
            <h5 class="card-header">Class List</h5>
            <div class="card-body">
				<? $this->load->view('partials/events-class-table-edit', array('classes' => $event['classes'], 'event' => $event, 'title' => 'classes')); ?>
			</div>
		</div>
	</div>
</div>




<div class="modal fade" id="dialog-events-classes-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Class Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="save_status" data-id="0">
      	</div>
		<form action="javascript:void(0)" id="events-class-edit-form">
			<div class="row">
				<div class="col-sm-4">
					<label for="name">Name</label>
				</div>
				<div class="col-sm-8">
					<?= hf_input('events_x_classes_name', '', '', array(), $errors) ?>

					<input type=hidden name="events_x_classes_id" id="events_x_classes_id">
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<label for="description">Description</label>
				</div>
				<div class="col-sm-8">
					<?= hf_input('events_x_classes_description', '', '', array(), $errors) ?>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<label for="strenuous">Strenuous</label>
				</div>
				<div class="col-sm-8">
					<?= hf_dropdown('events_x_classes_strenuous', '', '', array('0' => "No", '1' => "Yes"), null, $errors, 0, 0) ?>
				</div>
			</div>


			<div class="row">
				<div class="col-sm-4">
					<label for="minage">Min Age</label>
				</div>
				<div class="col-sm-8">
					<?= hf_input('events_x_classes_min_age', '', '', array(), $errors) ?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<label for="maxage">Max Age</label>
				</div>
				<div class="col-sm-8">
					<?= hf_input('events_x_classes_max_age', '', '', array(), $errors) ?>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<label for="fee">Fee</label>
				</div>
				<div class="col-sm-8">
					<?= hf_input('events_x_classes_fee', '', '', array(), $errors) ?>
				</div>
			</div>

			<div class="row" id="events-prizes">
				<div class="col-sm-4">
					<strong>Prizes</strong>
				</div>
				<div class="col-sm-8">
					<div class="row">
						<div class="col-xs-6 col-sm-3">
							1st
						</div>
						<div class="col-xs-6 col-sm-3">
							<?= hf_input('events_x_classes_prize01', '', '', array(), $errors) ?>
						</div>
						<div class="col-xs-6 col-sm-3">
							2nd
						</div>
						<div class="col-xs-6 col-sm-3">
							<?= hf_input('events_x_classes_prize02', '', '', array(), $errors) ?>
						</div>

						<div class="col-xs-6 col-sm-3">
							3rd
						</div>
						<div class="col-xs-6 col-sm-3">
							<?= hf_input('events_x_classes_prize03', '', '', array(), $errors) ?>
						</div>

						<div class="col-xs-6 col-sm-3">
							4th
						</div>
						<div class="col-xs-6 col-sm-3">
							<?= hf_input('events_x_classes_prize04', '', '', array(), $errors) ?>
						</div>
						<div class="col-xs-6 col-sm-3">
							5th
						</div>
						<div class="col-xs-6 col-sm-3">
							<?= hf_input('events_x_classes_prize05', '', '', array(), $errors) ?>
						</div>
						<div class="col-xs-6 col-sm-3">
							6th
						</div>
						<div class="col-xs-6 col-sm-3">
							<?= hf_input('events_x_classes_prize06', '', '', array(), $errors) ?>
						</div>
						<div class="col-xs-6 col-sm-3">
							7th
						</div>
						<div class="col-xs-6 col-sm-3">
							<?= hf_input('events_x_classes_prize07', '', '', array(), $errors) ?>
						</div>
						<div class="col-xs-6 col-sm-3">
							8th
						</div>
						<div class="col-xs-6 col-sm-3">
							<?= hf_input('events_x_classes_prize08', '', '', array(), $errors) ?>
						</div>
						<div class="col-xs-6 col-sm-3">
							9th
						</div>
						<div class="col-xs-6 col-sm-3">
							<?= hf_input('events_x_classes_prize09', '', '', array(), $errors) ?>
						</div>
						<div class="col-xs-6 col-sm-3">
							10th
						</div>
						<div class="col-xs-6 col-sm-3">
							<?= hf_input('events_x_classes_prize10', '', '', array(), $errors) ?>
						</div>
						<div class="col-xs-6 col-sm-3">
							11th
						</div>
						<div class="col-xs-6 col-sm-3">
							<?= hf_input('events_x_classes_prize11', '', '', array(), $errors) ?>
						</div>
						<div class="col-xs-6 col-sm-3">
							12th
						</div>
						<div class="col-xs-6 col-sm-3">
							<?= hf_input('events_x_classes_prize12', '', '', array(), $errors) ?>
						</div>
					</div>
				</div>
			</div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save-events-class">Save Changes</button>
      </div>
    </div>
  </div>
</div>

