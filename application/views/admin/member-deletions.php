
<div class="card mb-4">
    <h5 class="card-header">DELETION Requests</h5>
    <div class="card-body">
		<table class="table table-sm table-hover w-100 no-wrap">
    		<thead>
			<tr>
    			<th>Player</th>
				<th>Reason</th>
				<th></th>
			</tr>
			</thead>
			<tbody>
				<? foreach((array)$accounts AS $a): ?>
				<tr>
					<td><a href="/game/profile/<?= $a['players_id'] ?>"><?= $a['players_nickname'] ?> #<?= $a['players_id'] ?></a><br/><small class="text-muted">Requested on: <?= $a['players_pending_delete_date2'] ?></small></td>
					<td><?= $a['players_pending_delete_reason'] ?></td>
					<td>
						<? if($a['players_pending_delete_ready']): ?>
							<a href="/admin/members/manage/<?= $a['players_id'] ?>" class="btn btn-danger float-right">Delete Account</a>
						<? else: ?>
							<input type="button" class="btn btn-danger float-right disabled" value="Delete Account">
						<? endif; ?>

					</td>
				</tr>
				<? endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
