
<table class="table table-sm table-hover no-wrap" id="dt-events-<?= $title ?>">
  <thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Age</th>
      <th scope="col">Entry Fee</th>
      <th scope="col">Division</th>
      <th scope="col">Details</th>
    </tr>
  </thead>
  <tbody>
  	<? foreach((array)$classes AS $class): ?>
    <tr>
      <td><a href="/city/events/classes/<?= $class['events_x_classes_id'] ?>"><?= $class['events_x_classes_name'] ?></a></td>
      <td><?= $class['events_x_classes_min_age'] ?> - <?= $class['events_x_classes_max_age'] ?></td>
      <td>$<?= $class['events_x_classes_fee'] ?></td>
      <td><?= $class['classlists_divisions_name'] ?></td>
      <td><?= $class['events_x_classes_description'] ?></td>
    </tr>
	<? endforeach; ?>
	<? if(!count($classes)): ?>
		<tr><td colspan=100%>No classes</td></tr>
	<? endif; ?>
  </tbody>
</table>