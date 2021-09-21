
<div class="row">
	<div class="col-md-12">

		<p>Here's a list of pending CAB applications.</p>

		<div class="row">
			<div class="col-sm-12">
				<table class="table table-sm table-hover w-100 no-wrap">
		    		<thead>
					<tr>
		    			<th>Name</th>
		    			<th>Type</th>
		    			<th>Owner</th>
		    			<th>Actions</th>
					</tr>
					</thead>
					<tbody>
						<? foreach((array)$applications AS $a): ?>
						<tr>
							<td><?= $a['cabs_name'] ?></td>
							<td><?= $a['cabs_type'] ?></td>
							<td><a href="/game/profile/<?= $a['join_players_id'] ?>"><?= $a['players_nickname'] ?> #<?= $a['join_players_id'] ?></a></td>
        					<td width="30%">

<form method="post" action="/admin/cabs/pending/process">
	<?= hf_hidden('cabs_id', $a['cabs_id']) ?>
	<div class="col-xs-12 button-wrapper">
		<?= hf_submit('accept', 'Accept', array('class' => 'btn btn-success col-md-5 float-left')) ?>
		<?= hf_submit('reject', 'X', array('class' => 'btn btn-danger col-md-2 float-right glyphicon glyphicon-remove')) ?>
	</div>

</form>
        					</td>
						</tr>
						<? endforeach; ?>
					</tbody>
				</table>

		    </div>
		</div><br/>

	</div>
</div>


