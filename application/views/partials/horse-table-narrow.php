
<table class="table table-sm table-hover no-wrap" id="dt-horses-<?= $title ?>">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">Born</th>
      <th scope="col">Gender</th>
      <th scope="col">Breed</th>
    </tr>
  </thead>
  <tbody>
  	<? foreach((array)$horses AS $h => $horse): ?>
    <tr>
      <td><a href="/horses/view/<?= $horse['horses_id'] ?>"><?= $horse['horses_id'] ?></a></td>
      <td><a href="/horses/view/<?= $horse['horses_id'] ?>"><?= $horse['horses_competition_title'] ?> <?= $horse['horses_breeding_title'] ?> <?= $horse['horses_name'] ?></a></td>
      <td><?= $horse['horses_birthyear'] ?></td>
      <td><?= $horse['horses_gender'] ?></td>
      <td><?= $horse['horses_breed'] ?></td>
    </tr>
	<? endforeach; ?>
	<? if(!count($horses)): ?>
		<tr><td colspan=100%>No horses</td></tr>
	<? endif; ?>
  </tbody>
</table>