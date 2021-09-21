<hr>

 <div class="row">
    <div class="col-sm-12">
        <div class="card mb-4">
          	<h4 class="card-header">Search Results</h4>
            <div class="card-body">
<div class="container-fluid">
    <div class="table-responsive">
	<table class="table table-sm table-hover  no-wrap col-sm-12 w-100" id="dt-bank-loans-search">
  <thead>
    <tr>
      <th scope="col">Account</th>
      <th scope="col">Owner</th>
      <th scope="col">Type</th>
      <th scope="col">Balance</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody>
  	<? foreach((array)$accounts AS $b): ?>
    <tr>
      <td><a href="/city/bank/<?= $b['bank_id'] ?>"><?= $b['bank_nickname'] ?> #<?= $b['bank_id'] ?></a></td>
      <td><a href="/game/profile/<?= $b['join_players_id'] ?>"><?= $b['players_nickname'] ?> #<?= $b['join_players_id'] ?></a></td>
      <td><?= $b['bank_type'] ?></td>
      <td>$<?= number_format($b['bank_balance'], 2) ?></td>
      <td>
      	<? if($b['bank_closed']): ?>
      		Closed
  		<? elseif($b['bank_pending']): ?>
      		Pending
      	<? else: ?>
	      	Open
	    <? endif; ?>
      </td>
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