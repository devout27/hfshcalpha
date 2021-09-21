
<? if($player['privileges']['privileges_cabs']): ?>
<div class="row">
	<div class="col-lg-12">
		<? if($cabs['cabs_disabled']): ?>
			<a href="/admin/cabs/enable/<?= $cabs['cabs_id'] ?>" class="btn btn-success col-md-2 float-right">Enable CAB</a>
		<? else: ?>
			<a href="/admin/cabs/disable/<?= $cabs['cabs_id'] ?>" class="btn btn-danger col-md-2 float-right">Disable CAB</a>
		<? endif; ?>
	</div>
</div>
<? endif; ?>

<div class="row">
    <div class="col-lg-12">
    	<?= $cabs['cabs_content'] ?>
    </div>
</div>

<div class="row">

        <div class="col-lg-12">

          <div class="card my-4">
            <h5 class="card-header">Details</h5>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-4 col-md-3">
                	<b>Type</b>
                </div>
                <div class="col-sm-8 col-md-9">
                	<?= $cabs['cabs_type'] ?>
                </div>
              </div>
            <div class="row">
                <div class="col-sm-4 col-md-3">
                	<b>Owner</b>
                </div>
                <div class="col-sm-8 col-md-9">
                	<a href="/game/profile/<?= $cabs['join_players_id'] ?>"><?= $cabs['players_nickname'] . " #". $cabs['join_players_id'] ?></a>
                </div>
              </div>
            <div class="row">
                <div class="col-sm-4 col-md-3">
                	<b>Last Active</b>
                </div>
                <div class="col-sm-8 col-md-9">
                	<?= $cabs['players_last_active'] ?>
                </div>
              </div>
            </div>
          </div>


          <div class="card my-4">
            <h5 class="card-header">Events</h5>
            <div class="card-body">
				<? $this->load->view('partials/events-table', array('events' => $cabs['events'], 'title' => 'search')); ?>
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