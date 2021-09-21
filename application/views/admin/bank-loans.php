
<div class="container-fluid">
    <div class="table-responsive">
	<table class="table table-sm table-hover  no-wrap col-sm-12 w-100" id="dt-bank-loans">
  <thead>
    <tr>
      <th scope="col">Account</th>
      <th scope="col">Balance</th>
      <th scope="col">Credit Limit</th>
      <th scope="col">Overdue Since</th>
    </tr>
  </thead>
  <tbody>
  	<? foreach((array)$bank_loans AS $b): ?>
    <tr>
      <td><a href="/city/bank/<?= $b['bank_id'] ?>"><?= $b['bank_nickname'] ?> #<?= $b['bank_id'] ?></a><br/><small class="text-muted"><a href="/game/profile/<?= $b['join_players_id'] ?>"><?= $b['players_nickname'] ?> #<?= $b['join_players_id'] ?></a></td>
      <td data-priority="1">$<?= number_format($b['bank_balance'], 2) ?></td>
      <td>$<?= number_format($b['bank_credit_limit'], 2) ?></td>
      <td data-priority="2"><?= $b['bank_credit_payment_due'] ?></td>
    </tr>
	<? endforeach; ?>
  </tbody>
</table>
</div>
</div>