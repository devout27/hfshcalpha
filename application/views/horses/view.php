<? if($horse['horses_deceased']): ?>
<h2>Horse is deceased.</h2>
<? endif; ?>


<div class="row">
    <div class="col-lg-12">
          <div class="card mb-4">
            <!--<img class="card-img-top" src="<?= $profile['players_banner'] ?: "http://placehold.it/750x300" ?>" alt="Card image cap">-->
            <div class="card-body">
              <!--<h2 class="card-title">About</h2>-->
              <? if($horse['horses_pending_export']): ?>
              	<b><font color="red">Horse is pending export.</font></b><br/>
              <? endif; ?>
              <b><?= $horse['horses_competition_title'] ?> <?= $horse['horses_breeding_title'] ?> <?= $horse['horses_name'] ?></b><br/>
              <?= $horse['horses_birthyear'] . " " . $horse['horses_color'] . " " . $horse['horses_breed'] . " " . $horse['horses_line'] . " " . $horse['horses_gender'] . "<br/><i>" . $horse['horses_pattern'] . "</i> " . $horse['horses_breed2'] ?><br/><br/>
<? if($horse['horses_sire'] != 0): ?>
	Sire: <a href="/horses/view/<?= $horse['horses_sire'] ?>"><?= $horse['horses_sire_name'] ?> #<?= $horse['horses_sire'] ?></a><br/>
	Dam: <a href="/horses/view/<?= $horse['horses_dam'] ?>"><?= $horse['horses_dam_name']  ?> #<?= $horse['horses_dam'] ?></a><br/><br/>
<? else: ?>
	Sire: N/A<br/>
	Dam: N/A<br/>
<? endif; ?>
Owner: <a href="/game/profile/<?= $horse['join_players_id'] ?>"><?= $horse['players_nickname'] . " #" . $horse['join_players_id'] ?></a><br/>
Stable: <a href="/game/stables/<?= $horse['join_stables_id'] ?>"><?= $horse['stables_name'] . " #" . $horse['join_stables_id'] ?></a><br/><br/>
<?= date('Y') - $horse['horses_birthyear'] ?> years old<br/>          

Breeding Years: <?= ($horse['horses_birthyear'] + 3) ?> to <?= ($horse['horses_birthyear'] + 32) ?> inclusive<br/>


<? if($horse['horses_bred'] == 1): ?>
    Horse Bred <?= date('Y') ?><br/>
<? elseif($horse['horses_breeding_fee'] > 0 AND $horse['horses_gender'] == "Stallion"): ?>
	<b><a href="/horses/breed/<?= $horse['horses_id'] ?>">Breed for $<?= number_format($horse['horses_breeding_fee']) ?></a></b><br/>
<? elseif($horse['horses_breeding_fee'] > 0 AND $horse['horses_gender'] == "Mare"): ?>
		Breeding Fee : $<?= $horse['horses_breeding_fee'] ?><br>
<? endif; ?>
<? if($horse['horses_sale'] == 1): ?>
    <font color=green><b>For Sale</font></b><br />
    <b><a href="<?php echo $horse['join_players_id'] == $this->session->userdata('players_id')  ? 'javascript:void(0);'  : '/horses/buy/'.$horse['horses_id'] ?>" style="text-decoration:none;">Price $<?= number_format($horse['horses_sale_price'], 2, ".", ",") ?></a></b><br/>
		
<? endif; ?><br/><br/>

Points: <?= $horse['horses_points'] ?><br/><br/>


Competing at <b><?= $horse['horses_level'] ?: 'N/A' ?></b><br/>
Disciplines:<br/>
<? foreach((array)$horse['disciplines'] AS $k => $d): ?>
<?= $d['disciplines_name'] ?><br/>
<? endforeach; ?>
<? if(!$d['disciplines_name']): ?>
	<i>None</i>
<? endif; ?>



            </div>
            <div class="card-footer text-muted">
              Notes: <?= $horse['horses_notes'] ?: 'None' ?>
            </div>
          </div>

</div>
</div>


<!-- <div class="row">
    <div class="col-lg-12">
          <div class="card mb-4">
            <div class="card-body">
              <h2 class="card-title">Genetics (TODO: make invisible to players w/o perk)</h2>
				<div class="row"> -->
					<? //pre($horse['genes']); ?>
					<? // foreach((array)$horse['genes'] AS $g): ?>
						<!-- <div class="col-sm-6 col-md-4">
							<div class="row">
								<div class="col-sm-6">
									<b><? //$g['genes_name'] ?>:</b>
								</div>
								<div class="col-sm-4">
									<? //$g['horses_x_genes_value'] ?: $g['genes_code3'] ?>
								</div>
							</div>
						</div> -->
					<? //endforeach; ?>
				<!-- </div>
        	</div>  -->

			<!-- <div class="card-footer text-muted">
				<form method="post" action="/horses/view/offspring-genes/<?= $horse['horses_id'] ?>">
					<div class="row">
						<div class="col-sm-6">
							<?= hf_dropdown('horses_id', '', $post, $horses, array(), $errors) ?>
						</div>
						<div class="col-sm-6">
							<?= hf_submit('sample_breeding', 'Sample Breeding', array('class' => 'btn btn-primary col-sm-12')) ?>
						</div>
					</div>
				</form>
			</div> -->
              <?/*<a href="/horses/view/offspring-genes/<?= $horse['horses_id'] ?>" class="center">View Possible Offspring Genes</a><br/><br/>*/?>
          <!-- </div>

</div>
</div> -->

<div class="row">
    <div class="col-lg-7">
          <div class="card mb-4">
            <h5 class="card-header">Progeny</h5>
            <div class="card-body">
				<? $this->load->view('partials/horse-table-narrow', array('horses' => $horse['progeny'], 'title' => 'progeny')); ?>
            </div>
          </div>

          <div class="card mb-4">
            <h5 class="card-header">Siblings via Sire</h5>
            <div class="card-body">
				<? $this->load->view('partials/horse-table-narrow', array('horses' => $horse['siblings_sire'], 'title' => 'siblings-sire')); ?>
            </div>
          </div>

          <div class="card mb-4">
            <h5 class="card-header">Siblings via Dam</h5>
            <div class="card-body">
				<? $this->load->view('partials/horse-table-narrow', array('horses' => $horse['siblings_dam'], 'title' => 'siblings-dam')); ?>
            </div>
          </div>


          <div class="card my-4">
            <h5 class="card-header">Ownership Records</h5>
            <div class="card-body">
            	<? if(count($horse['ownership_log']) > 0): ?>
                    <? $i = 0; ?>
	            	<? foreach((array)$horse['ownership_log'] AS $l): ?>
                        <? if($i == 0) { ?>
	            		    <b><a href="/game/profile/<?= $l['join_players_id'] ?>"><?= $l['owner_name'] ?> #<?= $l['join_players_id'] ?></a> on <?= $l['horse_records_date'] ?><br/></b>
                        <? } else { ?>
                        <a href="/game/profile/<?= $l['join_players_id'] ?>"><?= $l['owner_name'] ?> #<?= $l['join_players_id'] ?></a> on <?= $l['horse_records_date'] ?><br/>
                        <? } $i++; ?>
	            	<? endforeach; ?>
	            <? else: ?>
	            	No records available.
	            <? endif; ?>
            </div>
          </div>

          <div class="card my-4">
            <h5 class="card-header">Care Records</h5>
            <div class="card-body">
            	<table class="table table-sm table-borderless m-0 p-0">
            	<? if(count($horse['care_records']) > 0): ?>
	            	<? foreach((array)$horse['care_records'] AS $l): ?>
	            		<? //pre($l); ?>
	            		<tr class="m-0 p-0"><td class="m-0 p-0"><b><?= $l['horse_records_type'] ?></b></td><td class="m-0 p-0"><?= $l['horse_records_notes'] ?></td><td class="m-0 p-0"><?= $l['horse_records_date'] ?></td></tr>
	            	<? endforeach; ?>
	            <? else: ?>
	            	No records available.
	            <? endif; ?>
	        </table>
            </div>
          </div>

          <div class="card my-4">
            <h5 class="card-header">Event Records</h5>
            <div class="card-body">
            	<? if(count($horse['event_records']) > 0): ?>
	            	<? foreach((array)$horse['event_records'] AS $l): ?>
	            		<?= $l['horse_records_notes'] ?><br/>
	            	<? endforeach; ?>
	            <? else: ?>
	            	No records available.
	            <? endif; ?>
            </div>
          </div>



    </div>

        <!-- Sidebar Widgets Column -->
        <div class="col-lg-5">
          <? if($horse['join_players_id'] == $this->session->userdata('players_id') || $this->player->player['privileges']['privileges_horses']): ?>
          	<? if($this->player->player['privileges']['privileges_horses'] && ($horse['join_players_id'] != $this->session->userdata('players_id'))): ?>
          		<b><font color="red">FYI, you do not own this horse.</font></b>
          	<? endif; ?>
          <div class="card mb-4">
            <h5 class="card-header">Manage Horse</h5>
            <div class="card-body">
              <a href="/horses/update/<?= $horse['horses_id'] ?>">Update Horse</a><br/>
              <a href="/horses/transfer/<?= $horse['horses_id'] ?>">Transfer Horse</a><br/>
              <a href="/horses/auction/<?= $horse['horses_id'] ?>">Auction Horse</a><br/>
            </div>
          </div>
      	  <? endif; ?>

          <div class="card mn-4">
            <h5 class="card-header">Horse Care</h5>
            <div class="card-body">
              <a href="/horses/vet/<?= $horse['horses_id'] ?>">Vet</a>
              	<? if($horse['horses_vet'] == "0000-00-00"): ?>
              		(Never Visited Vet)
              	<? else: ?>
              		(Last Visited <?= $horse['horses_vet'] ?>)
              	<? endif; ?>
              	<br/>
              <a href="/horses/farrier/<?= $horse['horses_id'] ?>">Farrier</a>
              	<? if($horse['horses_farrier'] == "0000-00-00"): ?>
              		(Never Visited Farrier)
              	<? else: ?>
              		(Last Visited <?= $horse['horses_farrier'] ?>)
              	<? endif; ?>
              	<br/>
            </div>
          </div>
      	  <? if($horse['join_players_id'] == EXPORT_ID): ?>
          	  	<div class="center">
          	  		<? if($horse['horses_sale']): ?>
          	  			<a href="/horses/import/<?= $horse['horses_id'] ?>" class="btn btn-primary center">Import Horse for $<?= number_format($horse['horses_sale']) ?></a><br/><br/>
          	  		<? else: ?>
          	  			Import price not set.<br/><br/>
          	  		<? endif; ?>
          	  	</div>
      	  <? endif; ?>

      	  <? if($horse['join_players_id'] == HUMANE_ID): ?>
          	  	<div class="center">
          	  		<? if($horse['horses_adoptable']): ?>
          	  			<a href="/horses/adopt/<?= $horse['horses_id'] ?>/ac" onclick="return confirm('Are you sure you want to adopt the horse?');" class="btn btn-primary center">Adopt Horse for 1 Adoption Credit</a><br/><br/>
          	  			<a href="/horses/adopt/<?= $horse['horses_id'] ?>/cc" onclick="return confirm('Are you sure you want to adopt the horse?');" class="btn btn-primary center">Adopt Horse for 1/3 Creation Credit</a>
          	  		<? else: ?>
          	  			Not available for adoption.
          	  		<? endif; ?>
          	  	</div>
      	  <? endif; ?>



    </div>
</div>