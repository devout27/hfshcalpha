
<table class="table table-sm table-hover no-wrap" <? /*id="dt-horses-<?= $title ?> */ ?>>
  <thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Boarding</th>
    </tr>
  </thead>
  <tbody>
  	<? foreach((array)$stables AS $stable): ?>
    <tr>
      <td><a href="/city/stable/<?= $stable['stables_id'] ?>"><?= $stable['stables_name'] ?></a></td>
      <td><?= $stable['stables_boarding_public'] ? '$'.$stable['stables_boarding_fee'] : 'Private' ?></td>
    </tr>
	<? endforeach; ?>
	<? if(!count($stables)): ?>
		<tr><td colspan=100%>No stables</td></tr>
	<? endif; ?>
  </tbody>
</table>