<div class="row">
	<div class="col-md-5">
<table class="w-100">
	<tr>
		<td>Balance:</td>
		<td class="text-right"><b>$<?= number_format($account['bank_balance']); ?></b></td>
	</tr>
	<tr>
		<td>Credit Limit:</td>
		<td class="text-muted text-right"><b>$<?= number_format($account['bank_credit_limit']); ?></b></td>
	</tr>
	<tr>
		<td>Credit Available:</td>
		<td class="text-muted text-right"><b>$<?= number_format($account['bank_credit_limit'] - $account['bank_balance']); ?></b></td>
	</tr>

</table>
	</div>
	<div class="col-md-4 offset-md-3">

<table class="w-100">
	<tr>
		<td>Status:</td>
		<td class="text-right"><b><?= $account['bank_status']; ?></td>
	</tr>
	<tr>
		<td>Interest Rate:</td>
		<td class="text-muted text-right"><b><?= $account['bank_interest_incurred']; ?>%</b></td>
	</tr>
	<tr>
		<td>Interest Accrued:</td>
		<td class="text-muted text-right"><b>$<?= number_format($account['bank_interest_accrued']); ?></b></td>
	</tr>
	<tr>
		<td>Minimum Payment:</td>
		<td class="text-muted text-right"><b>$<?= number_format(($account['bank_balance'] * .01)/* + ($account['bank_balance'] * ($account['bank_interest_incurred'] * .01))*/) ?></b></td>
	</tr>
	<tr>
		<td>Payment Due:</td>
		<td class="text-muted text-right"><b><?= $account['bank_credit_payment_due'] != "0000-00-00" ? $account['bank_credit_payment_due'] : "<i>None</i>"; ?></b></td>
	</tr>


</table>
	</div>
</div>
<br/>


<div class="container h-100 py-2">
    <ul class="nav nav-tabs nav-fill border-0" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active border border-muted border-bottom-0" id="overview-tab" data-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Overview</a>
        </li>
        <li class="nav-item">
            <a class="nav-link border border-muted border-bottom-0" id="outgoing-tab" data-toggle="tab" href="#outgoing" role="tab" aria-controls="outgoing" aria-selected="false">Recurring Payments</a>
        </li>
    </ul>

    <div class="tab-content h-75">
        <div class="tab-pane active h-100 p-3 border border-muted" id="overview" role="tabpanel" aria-labelledby="overview-tab">

<div class="container-fluid">
    <div class="table-responsive">
	<table class="table table-sm table-hover  no-wrap col-sm-12 w-100" id="dt-bank-ledger">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Date</th>
      <th scope="col">Transaction</th>
      <th scope="col">Credit</th>
      <th scope="col">Debit</th>
      <? /*<th scope="col d-none d-md-table-cell">Balance</th>*/ ?>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody>
  	<? foreach((array)$account['checks'] AS $check): ?>
  	<? // don't show pending... ?>
  	<? if($check['bank_checks_status'] == "Pending"){continue;} ?>
    <tr>
      <td><?= $check['bank_checks_id'] ?></td>
      <td data-priority="1"><?= $check['bank_checks_date'] ?></td>
      <td><?= $check['bank_checks_memo'] ?> <br/><small class="text-muted"><?= $check['bank_checks_memo2'] ?></small></td>
      <td data-priority="2"><?= number_format($check['bank_checks_credit']) ?></td>
      <td data-priority="2"><?= number_format($check['bank_checks_debit']) ?></td>
      <? /*<td><?= number_format($check['bank_checks_balance']) ?></td>*/ ?>
      <td data-priority="3"><?= $check['bank_checks_status'] ?></td>
    </tr>
	<? endforeach; ?>
  </tbody>
</table>
</div>
</div>
	</div>

        <div class="tab-pane h-100 p-3 border border-muted" id="outgoing" role="tabpanel" aria-labelledby="outgoing-tab">
<div class="container-fluid">
    <div class="table-responsive">
	<table class="table table-sm table-hover  no-wrap col-sm-12 w-100" id="dt-bank-outgoing">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Date</th>
      <th scope="col">Transaction</th>
      <th scope="col">Credit</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody>
  	<? foreach((array)$account['checks'] AS $check): ?>
  	<? if($check['bank_checks_status'] != "Pending" OR $check['join_bank_id'] != $account['bank_id']){continue;} ?>
    <tr>
      <td><?= $check['bank_checks_id'] ?></td>
      <td data-priority="1"><?= $check['bank_checks_date'] ?></td>
      <td><?= $check['bank_checks_memo'] ?> <br/><small class="text-muted"><?= $check['bank_checks_memo2'] ?></small></td>
      <td data-priority="2"><?= number_format($check['bank_checks_credit']) ?></td>
      <td data-priority="3"><?= $check['bank_checks_status'] ?></td>
    </tr>
	<? endforeach; ?>
  </tbody>
</table>
</div>
</div>
	</div>
</div>
</div>


