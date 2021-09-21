<? if($profile['players_pending']): ?>
	<h2>Player is pending.</h2>
<? elseif($profile['players_deleted']): ?>
	<h2>Player has been deleted.</h2>
<? endif; ?>
<? if((($profile['players_pending'] || $profile['players_deleted']) AND $player['privileges']['privileges_members']) OR (!$profile['players_pending'] AND !$profile['players_deleted'])): ?>

<div class="row">
        <div class="col-lg-8">
        	<br/>

          <div class="card mb-4">
            <img class="card-img-top" src="<?= $profile['players_banner'] ?: "http://placehold.it/750x300" ?>" alt="Card image cap">
            <div class="card-body">
              <h2 class="card-title">About</h2>
              <p class="card-text"><?= $profile['players_about'] ?></p>
            </div>
            <div class="card-footer text-muted">
              Last Active on <?= $profile['players_last_active2'] ?>
            </div>
          </div>

        </div>


        <!-- Sidebar Widgets Column -->
        <div class="col-lg-4">

          <div class="card my-4">
            <h5 class="card-header">Stats</h5>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-4">
                	<b>House</b>
                </div>
                <div class="col-sm-8">
                	<?= $profile['players_house'] ?>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-4">
                	<b>Joined</b>
                </div>
                <div class="col-sm-8">
                	<?= $profile['players_join_date2'] ?>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-4">
                	<b>AMI</b>
                </div>
                <div class="col-sm-8">
                	<?= $profile['players_ami'] ?>
                </div>
              </div>
              <? if($profile['players_admin']): ?>
              <div class="row">
              	<div class="col-sm-12"><br/>
              		<i>Administrator</i>
              		<?//= $profile['privileges']['privileges_admin'] ? '<br/>Master Admin' : '' ?>
              		<?= $profile['privileges']['privileges_news'] ? '<br/>News Updates' : '' ?>
              		<?= $profile['privileges']['privileges_members'] ? '<br/>Member Management' : '' ?>
              		<?= $profile['privileges']['privileges_horses'] ? '<br/>Horse Management' : '' ?>
              		<?= $profile['privileges']['privileges_adoption'] ? '<br/>Adopt-a-thon' : '' ?>
              		<?= $profile['privileges']['privileges_bank'] ? '<br/>Bank' : '' ?>
              		<?= $profile['privileges']['privileges_cabs'] ? '<br/>CABs' : '' ?>
              		<?= $profile['privileges']['privileges_articles'] ? '<br/>Articles/Help' : '' ?>
              	</div>
              </div>
          	  <? endif; ?>
            </div>
          </div>

          <div class="card my-4">
            <h5 class="card-header">Privileges</h5>
            <div class="card-body">
            	<? if($profile['players_vet']): ?>
            		Veterinarian<br/>
            	<? endif; ?>
            	<? if($profile['players_farrier']): ?>
            		Farrier<br/>
            	<? endif; ?>
            </div>
          </div>

          <? if($player['players_id'] == $profile['players_id']): ?>
          <div class="card my-4">
            <h5 class="card-header">Manage Account</h5>
            <div class="card-body">
              <a href="/game/update-profile">Update Profile</a>
            </div>
          </div>
      	  <? endif; ?>

      	  <? if($player['privileges']['privileges_members']): ?>
          <div class="card my-4">
            <h5 class="card-header">Admin Options</h5>
            <div class="card-body">
              <a href="/admin/members/manage/<?= $profile['players_id'] ?>">Manage Player</a><br/>
            </div>
          </div>
      	  <? endif; ?>

        </div>
</div>



<div class="row">
        <div class="col-lg-12">

          <div class="card mb-4">
            <div class="card-body">
              <h2 class="card-title">Stables</h2>
              <p class="card-text">
				<? $this->load->view('partials/stables-table', array('stables' => $profile['stables'], 'title' => 'search')); ?>
			</p>
            </div>
            <div class="card-footer text-muted">
            	<?= count($profile['stables']) ?> Stable(s) Owned
            </div>
          </div>

          <div class="card mb-4">
            <div class="card-body">
              <h2 class="card-title">CABs</h2>
              <p class="card-text">
				<? $this->load->view('partials/cabs-table', array('cabs' => $profile['cabs'], 'title' => 'search')); ?>
			</p>
            </div>
            <div class="card-footer text-muted">
            	<?= count($profile['cabs']) ?> CAB(s) Owned
            </div>
          </div>

          <div class="card mb-4">
            <div class="card-body">
              <h2 class="card-title">Events</h2>
              <p class="card-text">
				<? $this->load->view('partials/events-table', array('events' => $profile['events'], 'title' => 'search')); ?>
			</p>
            </div>
            <div class="card-footer text-muted">
            	<?= count($profile['events']) ?> Event(s)
            </div>
          </div>

          <div class="card mb-4">
            <div class="card-body">
              <h2 class="card-title">Horses</h2>
              <p class="card-text">

				<? $this->load->view('partials/horse-table-narrow', array('horses' => $profile['horses'], 'title' => 'search')); ?>
            </div>
          </div>
</div>
</div>
<? endif; ?>