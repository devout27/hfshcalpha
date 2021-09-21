
<table class="table table-sm table-hover no-wrap" id="dt-events-<?= $title ?>">
  <thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Division</th>
      <th scope="col">Age</th>
      <th scope="col">Entry Fee</th>
		<? if(($player['privileges']['privileges_events'] AND $event['events_pending'] > 0) || ($this->data['player']['players_id'] == $event['join_players_id'] AND $event['events_pending'] == 1)): ?>
      		<th scope="col">Edit</th>
  		<? endif; ?>
    </tr>
  </thead>
  <tbody>
  	<? foreach((array)$classes AS $class): ?>
    <tr id="class-id-<?= $class['events_x_classes_id'] ?>">
      <td id="e-name-<?= $class['events_x_classes_id'] ?>"><?= $class['events_x_classes_strenuous'] ? '*' : '' ?><a href="/city/events/classes/<?= $class['events_x_classes_id'] ?>"><?= $class['events_x_classes_name'] ?></a></td>
      <td id="e-division-<?= $class['events_x_classes_id'] ?>"><?= $class['classlists_divisions_name'] ?></td>
      <td id="e-age-<?= $class['events_x_classes_id'] ?>"><?= $class['events_x_classes_min_age'] ?> - <?= $class['events_x_classes_max_age'] ?></td>
      <td id="e-fee-<?= $class['events_x_classes_id'] ?>">$<?= $class['events_x_classes_fee'] ?></td>
		<? if(($player['privileges']['privileges_events'] AND $event['events_pending'] > 0) || ($this->data['player']['players_id'] == $event['join_players_id'] AND $event['events_pending'] == 1)): ?>
      	<td>
      		<button type="button" class="btn btn-primary edit-class" data-toggle="modal" data-target="#dialog-events-classes-edit" data-id="<?= $class['events_x_classes_id'] ?>" data-name="<?= $class['events_x_classes_name'] ?>" data-minage="<?= $class['events_x_classes_min_age'] ?>" data-maxage="<?= $class['events_x_classes_max_age'] ?>" data-fee="<?= $class['events_x_classes_fee'] ?>" data-desc="<?= $class['events_x_classes_description'] ?>" data-divisionsid="<?= $class['join_divisions_id'] ?>" data-strenuous="<?= $class['events_x_classes_strenuous'] ?>" data-prize01="<?= $class['events_x_classes_prize01'] ?>"
      		data-prize02="<?= $class['events_x_classes_prize02'] ?>"
      		data-prize03="<?= $class['events_x_classes_prize03'] ?>"
      		data-prize04="<?= $class['events_x_classes_prize04'] ?>"
      		data-prize05="<?= $class['events_x_classes_prize05'] ?>"
      		data-prize06="<?= $class['events_x_classes_prize06'] ?>"
      		data-prize07="<?= $class['events_x_classes_prize07'] ?>"
      		data-prize08="<?= $class['events_x_classes_prize08'] ?>"
      		data-prize09="<?= $class['events_x_classes_prize09'] ?>"
      		data-prize10="<?= $class['events_x_classes_prize10'] ?>"
      		data-prize11="<?= $class['events_x_classes_prize11'] ?>"
      		data-prize12="<?= $class['events_x_classes_prize12'] ?>"


      			>Edit Class</button>
      		<div class="save_status float-right" data-id="<?= $class['events_x_classes_id'] ?>">
      		</div>
      	</td>
      	<? endif; ?>
    </tr>
	<? endforeach; ?>
	<? if(!count($classes)): ?>
		<tr><td colspan=100%>No classes</td></tr>
	<? endif; ?>
  </tbody>
</table>