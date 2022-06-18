<div class="table-responsive">
	<table class="table table-sm table-hover no-wrap" <? /*id="dt-horses-<?= $title ?> */ ?>>
	<thead>
		<tr>
		<th scope="col">Name</th>
		<th scope="col">Type</th>
		<? if($player['privileges']['privileges_cabs']): ?>
			<th scope="col">Pending?</th>
			<th scope="col">Disabled?</th>
		<? endif; ?>
		</tr>
	</thead>
	<tbody>
		<? foreach((array)$cabs AS $cab): ?>
		<tr>
		<td><a href="/city/cabs/view/<?= $cab['cabs_id'] ?>"><?= $cab['cabs_name'] ?></a></td>
		<td><?= $cab['cabs_type'] ?></td>
		<? if($player['privileges']['privileges_cabs']): ?>
			<td><?= $cab['cabs_pending'] ? 'Yes' : 'No' ?></td>
			<td><?= $cab['cabs_disabled'] ? 'Yes' : 'No' ?></td>
		<? endif; ?>
		</tr>
		<? endforeach; ?>
		<? if(!count($cabs)): ?>
			<tr><td colspan=100%>No CABs</td></tr>
		<? endif; ?>
	</tbody>
	</table>
</div>