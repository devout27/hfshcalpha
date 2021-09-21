
<table class="table table-sm table-hover no-wrap" id="dt-inventory-<?= $title ?>">
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
  	<? foreach((array)$inventory AS $i => $item): ?>
    <tr>
      <td><a href="/horses/view/<?= $item['itemid'] ?>"><?= $item['itemid'] ?></a></td>
      <td><a href="/horses/view/<?= $item['horses_id'] ?>"><?= $horse['horses_competition_title'] ?> <?= $horse['horses_breeding_title'] ?> <?= $horse['horses_name'] ?></a></td>
      <td><?= $item['horses_birthyear'] ?></td>
      <td><?= $item['itemtype'] ?></td>
      <td><?= $item['horses_breed'] ?></td>
    </tr>
	<? endforeach; ?>
	<? if(!count($inventory)): ?>
		<tr><td colspan=100%>No horses</td></tr>
	<? endif; ?>
  </tbody>
</table><BR><BR><?= $this->data['page']['title'] = $this->data['profile']['players_id']; 

("SELECT 'itemid', `join_players_id`, `itemtype`, `itemrarity`, `itemimg`, `itemname`, `itemdesc` FROM `inventory`")

['itemid'];

?>


<?php 

$profile['player_nickname']

?>