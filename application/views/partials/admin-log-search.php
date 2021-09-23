<hr>
<div class="row">
    <div class="col-sm-12">
        <div class="card mb-4">
          	<h4 class="card-header">Search Results</h4>
            <div class="card-body">
				<div class="container-fluid">
				    <div class="table-responsive">
					<table class="table table-sm table-hover  no-wrap col-sm-12 w-100" id="dt-logs">
				  <thead>
				    <tr>
				      <th scope="col">Player</th>
				      <th scope="col">Activity</th>
				      <th scope="col">IP</th>
				      <th scope="col">Date</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<? foreach((array)$search AS $a): ?>
				    <tr>
				      <td><a href="/game/profile/<?= $a['join_players_id'] ?>"><?= $a['players_nickname'] ?> #<?= $a['join_players_id'] ?></a></td>
				      <td><?= $a['log_activity'] ?></td>
				      <td><?= $a['log_ip'] ?></td>
				      <td><?= $a['log_date'] ?></td>
				    </tr>
					<? endforeach; ?>
				  </tbody>
				</table>
				</div>
				</div>
            </div>
        </div>
    </div>
</div>