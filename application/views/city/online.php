
<div class="container-fluid">
<div class="table-responsive">
	<table class="table table-sm table-hover  no-wrap col-sm-12 w-100" id="dt-players-search">
	  <thead>
	    <tr>
	      <th scope="col">Player</th>
	      <th scope="col">Last Active</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<? foreach((array)$online AS $a): ?>
	    <tr>
	      <td><a href="/game/profile/<?= $a['players_id'] ?>"><?= $a['players_nickname'] ?> #<?= $a['players_id'] ?></a></td>
	      <td><?= $a['players_last_active2'] ?></td>
	    </tr>
		<? endforeach; ?>
	  </tbody>
	</table>
</div>
</div>
