<div class="container-fluid">
    <div class="table-responsive">
<table class="table table-sm table-hover table-responsive no-wrap" id="dt-horses-<?= $title ?>">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">Owner</th>
      <th scope="col">Born</th>
      <th scope="col">Color</th>
      <th scope="col">Breed</th>
      <th scope="col">Gender</th>
      <th scope="col">HS</th>
      <th scope="col">FS</th>
      <th scope="col">V/F</th>
      <th scope="col">Status</th>
      <th scope="col">Sale Price</th>
    </tr>
  </thead>
  <tbody>
  	<? foreach((array)$horses AS $h => $horse): ?>
    <tr>
      <td><a href="/horses/view/<?= $horse['horses_id'] ?>"><?= generateId($horse['horses_id']) ?></a></td>
      <td><a href="/horses/view/<?= $horse['horses_id'] ?>"><?= $horse['horses_competition_title'] ?> <?= $horse['horses_breeding_title'] ?> <?= $horse['horses_name'] ?></a></td>
      <td><?= $horse['players_nickname'] ?></td>
      <td><?= $horse['horses_birthyear'] ?></td>
      <td><?= $horse['horses_color'] ?></td>
      <td><?= $horse['horses_breed'] ?></td>
      <td><?= $horse['horses_gender'] ?></td>
      <td><?= $horse['horses_hs'] ?></td>
      <td><?= $horse['horses_fs'] ?></td>
      <td><?= $horse['horses_vet'] ?> <?= $horse['horses_farrier'] ?></td>
      <td><?= $horse['horses_sale'] == 1 ? '<span class="badge badge-success">For Sale</span>' : '<span class="badge badge-info">Not For Sale</span>'?></td>
      <td><?= $horse['horses_sale'] == 1 ? '$ '.(float)$horse['horses_sale_price'] : 'N/A'?></td>
    </tr>
	<? endforeach; ?>
  </tbody>
</table>
</div>
</div>