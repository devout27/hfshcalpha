
<table class="table table-sm table-hover no-wrap" id="dt-events-<?= $title ?>">
  <thead>
    <tr>
    	<th scope="col">Name</th>
    	<th scope="col">Age</th>
		<th scope="col">Entry Fee</th>
		<th scope="col">Division</th>
		<th scope="col">Edit</th>
    </tr>
  </thead>
  <tbody>
  	<? foreach((array)$classes AS $class): ?>
  	<? if(!$class['classlists_classes_id'] AND !$class['classlists_classes_id']){continue;} ?>
    <tr id="class-id-<?= $class['classlists_classes_id'] ?>">
      <td id="e-name-<?= $class['classlists_classes_id'] ?>"><?= $class['classlists_classes_strenuous'] ? '*' : '' ?><?= $class['classlists_classes_name'] ?></td>
      <td id="e-age-<?= $class['classlists_classes_id'] ?>"><?= $class['classlists_classes_min_age'] ?> - <?= $class['classlists_classes_max_age'] ?></td>
      <td id="e-fee-<?= $class['classlists_classes_id'] ?>">$<?= $class['classlists_classes_fee'] ?></td>
      <td id="e-division-<?= $class['classlists_classes_id'] ?>"><?= $class['classlists_divisions_name'] ?></td>
  	<td>
  		<button type="button" class="btn btn-primary admin-edit-class" data-toggle="modal" data-target="#dialog-events-classes-edit" data-id="<?= $class['classlists_classes_id'] ?>" data-classlistsid="<?= $class['classlists_id'] ?>" data-name="<?= $class['classlists_classes_name'] ?>" data-minage="<?= $class['classlists_classes_min_age'] ?>" data-maxage="<?= $class['classlists_classes_max_age'] ?>" data-fee="<?= $class['classlists_classes_fee'] ?>" data-desc="<?= $class['classlists_classes_description'] ?>" data-strenuous="<?= $class['classlists_classes_strenuous'] ?>" data-divisionsid="<?= $class['join_divisions_id'] ?>" data-disciplines="<?= $class['classlists_classes_disciplines'] ?>" data-types="<?= $class['classlists_classes_breeds_types'] ?>" data-breeds="<?= $class['classlists_classes_breeds'] ?>">Edit Class</button>
  		<button type="button" class="btn btn-danger admin-delete-class float-right" data-id="<?= $class['classlists_classes_id'] ?>">X</button>
  		<div class="save_status float-right" data-id="<?= $class['classlists_classes_id'] ?>">
  		</div>
  	</td>
</tr>
	<? endforeach; ?>
	<? if(!count($classes)): ?>
		<tr><td colspan=100%>No classes</td></tr>
	<? endif; ?>
  </tbody>
</table>