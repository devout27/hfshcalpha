
<? //pre($search) ?>
 <div class="row">
    <div class="col-sm-12">
        <div class="card mb-4">
          	<h4 class="card-header">Search Results</h4>
            <div class="card-body">


				<div class="container-fluid">
				    <div class="table-responsive">
					<table class="table table-sm table-hover  no-wrap col-sm-12 w-100" id="dt-players-search">
				  <thead>
				    <tr>
				      <th scope="col">Player</th>
				      <th scope="col">Stable</th>
				      <th scope="col">Fee</th>
				      <th scope="col">Last Active</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<? foreach((array)$search AS $a): ?>
				    <tr>
				      <td><a href="/game/profile/<?= $a['players_id'] ?>"><?= $a['players_nickname'] ?> #<?= $a['players_id'] ?></a></td>
				      <? if($a['stables_id']): ?>
							<td><b><?= $a['stables_boarding_public'] ? 'Public' : 'Private' ?>:</b> <a href="/city/stable/<?= $a['stables_id'] ?>"><?= $a['stables_name'] ?></a></td>
					  <td class="right"><?= $a['stables_boarding_fee'] ?></td>
					  <? else: ?>
							<td>N/A</td>
							<td></td>
					  <? endif; ?>
				      <td><?= $a['players_last_active2'] ?></td>
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