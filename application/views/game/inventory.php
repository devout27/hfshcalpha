<? if($profile['players_pending']): ?>
	<h2>Player is pending.</h2>
<? elseif($profile['players_deleted']): ?>
	<h2>Player has been deleted.</h2>
<? endif; ?>
<? if((($profile['players_pending'] || $profile['players_deleted']) AND $player['privileges']['privileges_members']) OR (!$profile['players_pending'] AND !$profile['players_deleted'])): ?>


<div class="row">
    <div class="col-lg-12">
          <div class="card mb-4">
            <div class="card-body">
              <p class="card-text">
              	<p>Inventory<BR><BR><? $this->load->view('partials/inventory', array('inventory' => $profile['inventory'], 'title' => 'search')); ?></p>

            </div>
          </div>


        </div>
</div>

<? endif; ?>