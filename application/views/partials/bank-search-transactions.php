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
      <th scope="col">ID</th>
      <th scope="col">From</th>
      <th scope="col">To</th>
      <th scope="col">Status</th>
      <th scope="col">Amount</th>
      <th scope="col">Date</th>
    </tr>
  </thead>
  <tbody>
  	<? foreach((array)$transactions AS $b): ?>
    <tr>
    	<td><?= $b['bank_checks_id'] ?></td>
      <td>
      		<a href="/city/bank/<?= $b['join_bank_id'] ?>"><?= $b['b1_bank_nickname'] ?> #<?= $b['join_bank_id'] ?></a><br/><small><?= $b['b1_bank_type'] ?><br/>
      		<a href="/game/profile/<?= $b['p1_id'] ?>"><?= $b['p1_nickname'] ?> #<?= $b['p1_id'] ?></a></small>
      	</td>
      <td>
      		<a href="/city/bank/<?= $b['bank_checks_to_id'] ?>"><?= $b['b2_bank_nickname'] ?> #<?= $b['bank_checks_to_id'] ?></a><br/><small><?= $b['b2_bank_type'] ?><br/>
      		<a href="/game/profile/<?= $b['p2_id'] ?>"><?= $b['p2_nickname'] ?> #<?= $b['p2_id'] ?></a></small>
      	</td>
      <td><?= $b['bank_checks_status'] ?><br/><small><?= $b['bank_checks_memo'] ?></small></td>
      <td>$<?= number_format($b['bank_checks_amount'], 2) ?></td>
      <td><?= $b['bank_checks_date'] ?></td>
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