
<? if($player['privileges']['privileges_evsents'] || $this->data['player']['players_id'] == $event['join_players_id']): ?>
<div class="row">
	<div class="col-lg-12">
		<a href="/city/events/edit/<?= $event['events_id'] ?>" class="btn btn-success col-md-2 float-right">Edit Event</a>
	</div>
</div>
<? endif; ?>

<div class="row">
    <div class="col-lg-12">
    	<?= $event['events_description'] ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 col-md-12">
    	<div class="card my-4">
            <h5 class="card-header"><a href="/city/events/view/<?= $event['events_id'] ?>"><?= $event['events_name'] ?></a></h5>
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
                	<?= $event['events_pending'] > 0 ? 'TBD' : $event['events_date1'] ?>
                </div>
            </div>
            </div>
          </div>


    </div>
</div>


<div class="row">
    <div class="col-md-8">
    	<div class="card my-4">
            <h5 class="card-header">Class Details</h5>
            <div class="card-body">
            	<h3><?= $class['events_x_classes_name'] ?></h3>
            	<i><?= $class['events_x_classes_description'] ?></i>
            	<div class="row">
            		<div class="col-sm-6 col-md-3"><b>Ages:</b></div>
            		<div class="col-sm-6 col-md-3"><?= $class['events_x_classes_min_age'] ?> - <?= $class['events_x_classes_max_age'] ?></div>
            		<div class="col-sm-6 col-md-3"><b>Strenuous:</b></div>
            		<div class="col-sm-6 col-md-3"><?= $class['events_x_classes_strenuous'] ? "Yes" : "No" ?></div>
            		<div class="col-sm-6 col-md-3"><b>Division:</b></div>
            		<div class="col-sm-6 col-md-3"><?= $class['classlists_divisions_name'] ?></div>
            		<div class="col-sm-6 col-md-3"><b>Fee:</b></div>
            		<div class="col-sm-6 col-md-3">$<?= $class['events_x_classes_fee'] ?></div>
            	</div>
            	<div class="row">
            		<? if(strlen($class['events_x_classes_disciplines'])): ?>
            			<div class="col-sm-6 col-md-3"><b>Disciplines:</b></div>
            			<div class="col-sm-6 col-md-3"><?= str_replace('|', '<br/>', $class['events_x_classes_disciplines']) ?></div>
            		<? endif; ?>

            		<? if(strlen($class['events_x_classes_breeds_types'])): ?>
	            		<div class="col-sm-6 col-md-3"><b>Breed Types:</b></div>
	            		<div class="col-sm-6 col-md-3"><?= str_replace('|', '<br/>', $class['events_x_classes_breeds_types']) ?></div>
            		<? endif; ?>

            		<? if(strlen($class['events_x_classes_breeds'])): ?>
	            		<div class="col-sm-6 col-md-3"><b>Breeds:</b></div>
	            		<div class="col-sm-6 col-md-3"><?= str_replace('|', '<br/>', $class['events_x_classes_breeds']) ?></div>
            		<? endif; ?>

            	</div>
            	<br/>

            	<h3>Entrants (<?= count($class['entrants']) ?>)</h3>
            	<div class="row">
            		<? if($event['events_pending'] == -1): //display the results ?>
	            		<? foreach((array)$class['entrants'] AS $horse): ?>
	            			<div class="col-sm-4"><b>#<?= $horse['events_entrants_place'] ?>. <a href="/horses/view/<?= $horse['join_horses_id'] ?>"><?= $horse['horses_competition_title'] ?> <?= $horse['horses_breeding_title'] ?> <?= $horse['horses_name'] ?></b></a></div>
	            			<div class="col-sm-4"><?= $horse['horses_breed'] ?></div>
	            			<div class="col-sm-4"><a href="/game/profile/<?= $horse['join_players_id'] ?>"><?= $horse['players_nickname'] ?></a></div>
	            		<? endforeach; ?>
            		<? else: ?>
	            		<? foreach((array)$class['entrants'] AS $horse): ?>
	            			<div class="col-sm-4"><b><a href="/horses/view/<?= $horse['join_horses_id'] ?>"><?= $horse['horses_competition_title'] ?> <?= $horse['horses_breeding_title'] ?> <?= $horse['horses_name'] ?></b></a></div>
	            			<div class="col-sm-4"><?= $horse['horses_breed'] ?></div>
	            			<div class="col-sm-4"><a href="/game/profile/<?= $horse['join_players_id'] ?>"><?= $horse['players_nickname'] ?></a></div>
	            		<? endforeach; ?>
	            	<? endif; ?>
        		</div>
			</div>
		</div>
	</div>
    <div class="col-sm-12 col-md-4">
    	<div class="card my-4">
            <h5 class="card-header"><?= $class['join_divisions_id'] ? 'Division' : '' ?> Prizes</h5>
            <div class="card-body">
            	<table class="table table-borderless table-sm">
            		<? //pre($class); ?>
            		<? if($class['join_divisions_id']): ?>
	            		<tr><td>1st:</td><td>$<?= $class['classlists_divisions_prize01'] ?></td>
	            		    <td>2nd:</td><td>$<?= $class['classlists_divisions_prize02'] ?></td></tr>
	            		<tr><td>3rd:</td><td>$<?= $class['classlists_divisions_prize03'] ?></td>
	            			<td>4th:</td><td>$<?= $class['classlists_divisions_prize04'] ?></td></tr>
	            		<tr><td>5th:</td><td>$<?= $class['classlists_divisions_prize05'] ?></td>
	            			<td>6th:</td><td>$<?= $class['classlists_divisions_prize06'] ?></td></tr>
	            		<tr><td>7th:</td><td>$<?= $class['classlists_divisions_prize07'] ?></td>
	            			<td>8th:</td><td>$<?= $class['classlists_divisions_prize08'] ?></td></tr>
	            		<tr><td>9th:</td><td>$<?= $class['classlists_divisions_prize09'] ?></td>
	            			<td>10th:</td><td>$<?= $class['classlists_divisions_prize10'] ?></td></tr>
	            		<tr><td>11th:</td><td>$<?= $class['classlists_divisions_prize11'] ?></td>
	            			<td>12th:</td><td>$<?= $class['classlists_divisions_prize12'] ?></td></tr>
            		<? else: ?>
	            		<tr><td>1st:</td><td>$<?= $class['events_x_classes_prize01'] ?></td>
	            		    <td>2nd:</td><td>$<?= $class['events_x_classes_prize02'] ?></td></tr>
	            		<tr><td>3rd:</td><td>$<?= $class['events_x_classes_prize03'] ?></td>
	            			<td>4th:</td><td>$<?= $class['events_x_classes_prize04'] ?></td></tr>
	            		<tr><td>5th:</td><td>$<?= $class['events_x_classes_prize05'] ?></td>
	            			<td>6th:</td><td>$<?= $class['events_x_classes_prize06'] ?></td></tr>
	            		<tr><td>7th:</td><td>$<?= $class['events_x_classes_prize07'] ?></td>
	            			<td>8th:</td><td>$<?= $class['events_x_classes_prize08'] ?></td></tr>
	            		<tr><td>9th:</td><td>$<?= $class['events_x_classes_prize09'] ?></td>
	            			<td>10th:</td><td>$<?= $class['events_x_classes_prize10'] ?></td></tr>
	            		<tr><td>11th:</td><td>$<?= $class['events_x_classes_prize11'] ?></td>
	            			<td>12th:</td><td>$<?= $class['events_x_classes_prize12'] ?></td></tr>
            		<? endif; ?>
				</table>
            </div>
        </div>
    </div>
</div>


<? if($event['events_pending'] == -1 AND $class['join_divisions_id']): ?>
<div class="row">
    <div class="col-lg-12">
    	<div class="card my-4">
            <h5 class="card-header">Division Results</h5>
            <div class="card-body">
        		<? foreach((array)$class['division_results'] AS $horse): ?>
        		<div class="row">
        			<div class="col-sm-4"><b>#<?= $horse['events_divisions_place'] ?>. <a href="/horses/view/<?= $horse['join_horses_id'] ?>"><?= $horse['horses_competition_title'] ?> <?= $horse['horses_breeding_title'] ?> <?= $horse['horses_name'] ?></b></a></div>
        			<div class="col-sm-4"><?= $horse['horses_breed'] ?></div>
        			<div class="col-sm-4"><a href="/game/profile/<?= $horse['join_players_id'] ?>"><?= $horse['players_nickname'] ?></a></div>
        		</div>
        		<? endforeach; ?>
			</div>
		</div>
	</div>
</div>
<? endif; ?>


<div class="row">
    <div class="col-lg-12">
    	<div class="card my-4">
            <h5 class="card-header">Enter a Horse</h5>
            <div class="card-body">
            	<? if($event['events_pending'] > 0): ?>
            		This event is not yet open.
            	<? elseif($event['events_pending'] == -1): ?>
            		This event has already run.
            	<? else: ?>
					<? $this->load->view('partials/horse-table-events', array('horses' => $horses, 'class' => $class, 'title' => 'enter-class')); ?>
            	<? endif; ?>
			</div>
		</div>
	</div>
</div>