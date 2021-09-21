
<div class="card mb-4">
    <h5 class="card-header">Current Veterinarians</h5>
    <div class="card-body">
		<table class="table table-sm table-hover w-100 no-wrap">
    		<thead>
			<tr>
    			<th>Player</th>
    			<? if($privileges['privileges_members']): ?>
    				<th></th>
    			<? endif; ?>
			</tr>
			</thead>
			<tbody>
				<? foreach((array)$vets AS $a): ?>
				<tr>
					<td><a href="/game/profile/<?= $a['players_id'] ?>"><?= $a['players_nickname'] ?> #<?= $a['players_id'] ?></a><br/><small class="text-muted"><?= $a['players_last_active2'] ?></small></td>
    				<? if($privileges['privileges_admin']): ?>
    					<td>
    						<a href="/admin/members/vets/revoke/<?= $a['players_id'] ?>" class="btn btn-danger col-sm-12">Revoke</a>
    					</td>
    				<? endif; ?>
				</tr>
				<? endforeach; ?>
			</tbody>
		</table>
	</div>
</div>



<div class="card mb-4">
    <h5 class="card-header">Add Veterinarian</h5>
    <div class="card-body">
	  	<form method="post" action="/admin/members/vets/add">
			<?= hf_input('players_id', 'Player ID', $post, array(), $errors) ?>
			<?= hf_submit('add', 'Add Vet', array('class' => 'btn btn-primary col-sm-12')) ?>
	  	</form>
    </div>
</div>