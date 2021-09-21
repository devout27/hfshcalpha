<div class="container-fluid">
    <div class="table-responsive">
<table class="table table-sm table-hover table-responsive no-wrap w-100" id="dt-horses-<?= $title ?>">
  <thead>
    <tr>
      <th scope="col">Owner</th>
      <th scope="col">Horses</th>
    </tr>
  </thead>
  <tbody>
  	<? foreach((array)$owners AS $owner): ?>
    <tr>
      <td><a href="/game/profile/<?= $owner['join_players_id'] ?>"><?= $owner['players_nickname'] ?> #<?= $owner['join_players_id'] ?></a></td>
      <td>
      		<div class="table-responsive w-100">
      		<table class="table w-100">
      			<? foreach((array)$owner['horses'] AS $horse): ?>
      			<tr>
      				<td><a href="/horses/view/<?= $horse['horses_id'] ?>"><?= $horse['horses_competition_title'] ?> <?= $horse['horses_breeding_title'] ?> <?= $horse['horses_name'] ?> #<?= generateId($horse['horses_id']) ?></a></td>
					<td><?= $horse['horse_records_date'] ?></td>
					<td><?= $horse['horses_birthyear'] ?></td>
					<td><?= $horse['horses_color'] ?></td>
					<td><?= $horse['horses_breed'] ?></td>
					<td><?= $horse['horses_gender'] ?></td>
				</tr>
			<? endforeach; ?>
			</table>
			</div>
    </tr>
	<? endforeach; ?>
  </tbody>
</table>
</div>
</div>