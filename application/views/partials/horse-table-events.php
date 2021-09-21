<div class="container-fluid">
    <div class="table-responsive">
<table class="table table-sm table-hover  no-wrap" id="dt-horses-<?= $title ?>">
  <thead>
    <tr>
      <th scope="col"></th>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">Breed</th>
      <th scope="col">Gender</th>
      <th scope="col">V/F</th>
    </tr>
  </thead>
  <tbody>
  	<? foreach((array)$horses AS $h => $horse): ?>
    <tr>
      <td rowspan="1">
      	<? if(in_array($horse['horses_id'], $class['entrants_ids'])): ?>
      		<button type="button" class="btn btn-disabled btn-light col-sm-12 float-right enterhorse" data-horseid="<?= $horse['horses_id'] ?>" data-classid="<?= $class['events_x_classes_id'] ?>" disabled>Already Entered</button>
      	<? else: ?>
      		<button type="button" class="btn btn-success col-sm-12 float-right enterhorse" data-horseid="<?= $horse['horses_id'] ?>" data-classid="<?= $class['events_x_classes_id'] ?>">Enter</button>
      	<? endif; ?>
      	</td>
      <td><a href="/horses/view/<?= $horse['horses_id'] ?>"><?= $horse['horses_id'] ?></a></td>
      <td><a href="/horses/view/<?= $horse['horses_id'] ?>"><?= $horse['horses_competition_title'] ?> <?= $horse['horses_breeding_title'] ?> <?= $horse['horses_name'] ?></a></td>
      <td><?= $horse['horses_breed'] ?></td>
      <td><?= $horse['horses_gender'] ?></td>
      <td><?= $horse['horses_vet'] ?> <?= $horse['horses_farrier'] ?></td>
    </tr>
	<? endforeach; ?>
  </tbody>
</table>
</div>
</div>