
<? if($player['privileges']['privileges_events'] || $this->data['player']['players_id'] == $event['join_players_id']): ?>
<div class="row">
	<div class="col-lg-12">
		<a href="/city/events/edit/<?= $event['events_id'] ?>" class="btn btn-success col-md-2">Edit Event</a>
		<a href="/city/events/cancel/<?= $event['events_id'] ?>" class="btn btn-danger col-md-2 float-right" id="btn-cancel-event">Cancel Event</a>
	</div>
</div>
<? endif; ?>

<div class="row">
    <div class="col-lg-12">
    	<?= $event['events_description'] ?>
    </div>
</div>

<div class="row">

    <div class="col-lg-12">

    	<div class="card my-4">
            <h5 class="card-header"><?= $event['events_name'] ?></h5>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-4 col-md-3">
                	<b>Type</b>
                </div>
                <div class="col-sm-8 col-md-9">
                	<?= $event['events_type'] ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 col-md-3">
                	<b>Owner</b>
                </div>
                <div class="col-sm-8 col-md-9">
                	<? if($event['join_cabs_id']): ?>
                		<a href="/city/cabs/view/<?= $event['join_cabs_id'] ?>"><?= $event['cabs_name'] ?></a>
                	<? else: ?>
                		<a href="/game/profile/<?= $event['join_players_id'] ?>"><?= $event['players_nickname'] . " #". $event['join_players_id'] ?></a>
                	<? endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 col-md-3">
                	<b>Status</b>
                </div>
                <div class="col-sm-8 col-md-9">
                	<?= $event['events_status_english'] ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4 col-md-3">
                	<b>Date</b>
                </div>
                <div class="col-sm-8 col-md-9">
                	<?= $event['events_pending'] != 0 ? 'TBD' : $event['events_date1'] ?>
                </div>
            </div>
            </div>
          </div>


          <? if($player['players_id'] == $cabs['join_players_id'] || $this->data['privileges']['privileges_cabs']): ?>
          <div class="card my-4">
            <h5 class="card-header">Manage CAB</h5>
            <div class="card-body">
            	<a href="/city/cabs/edit/<?= $cabs['cabs_id'] ?>">Update CAB</a><br/>
            	<a href="/city/events/create/<?= $cabs['cabs_id'] ?>">Create an Event</a>
            </div>
          </div>
      	  <? endif; ?>

        </div>
</div>




<div class="row">

    <div class="col-lg-12">

    	<div class="card my-4">
            <h5 class="card-header">Class List</h5>
            <div class="card-body">
				<? $this->load->view('partials/events-class-table', array('classes' => $event['classes'], 'title' => 'classes')); ?>
			</div>
		</div>
	</div>
</div>





<div class="modal fade" id="dialog-cancel-event" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Cancel Event</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	Are you sure you want to cancel this event?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="cancel-event" data-id="<?= $event['events_id'] ?>">Cancel it!</button>
      </div>
    </div>
  </div>
</div>
