<? //pre($stable) ?>

<div class="row">
    <div class="col-lg-12">
    	<?= $stable['stables_description'] ?>
    </div>
</div>

<div class="row">

        <div class="col-lg-12">
          <div class="card my-4">
            <h5 class="card-header">Details</h5>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-4 col-md-3">
                	<b>Name</b>
                </div>
                <div class="col-sm-8 col-md-9">
                	<?= $stable['stables_name'] ?>
                </div>
              </div>

            <div class="row">
                <div class="col-sm-4 col-md-3">
                	<b>Owner</b>
                </div>
                <div class="col-sm-8 col-md-9">
                	<a href="/game/profile/<?= $stable['join_players_id'] ?>"><?= $stable['players_nickname'] . " #". $stable['join_players_id'] ?></a>
                </div>
              </div>

            <div class="row">
                <div class="col-sm-3">
                	<b>Boarding Fee</b>
                </div>
                <div class="col-sm-9 col-md-9">
                	<? if($stable['stables_boarding_public']): ?>
                		$<?= $stable['stables_boarding_fee'] ?> per month
                	<? else: ?>
                		No public boarding
                	<? endif; ?>
                </div>
              </div>

              <div class="row">
              	<div class="col-sm-3">
              		<b>Land</b>
              	</div>
              	<div class="col-sm-3">
              		<?= $stable['used_acres'] ?> of <?= $stable['land'] ?> acres used
              	</div>

              	<div class="col-sm-3">
              		<b>Stalls</b>
              	</div>
              	<div class="col-sm-3">
              		<?= $stable['stalls'] ?>
              	</div>

              </div>
            </div>
          </div>


          <div class="card my-4">
            <h5 class="card-header">Amenities</h5>
            <div class="card-body">
				        <? $this->load->view('partials/amenities-table', array('amenities' => $stable['amenities'], 'title' => 'search')); ?>
            </div>
          </div>


          <? if($player['players_id'] == $stable['join_players_id'] || $this->data['privileges']['privileges_stables']): ?>
          <div class="card my-4">
            <h5 class="card-header">Manage Stable</h5>
            <div class="card-body">
            	<a href="/city/stable/edit/<?= $stable['stables_id'] ?>">Update Stable</a>
            </div>
          </div>
      	  <? endif; ?>

        </div>
</div>