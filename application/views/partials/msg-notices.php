
<table class="table table-sm table-hover" id="dt-notices">
  <thead>
    <tr>
      <th scope="col">Notice</th>
      <th scope="col">Date</th>
    </tr>
  </thead>
  <tbody>
  	<? foreach($notices AS $k => $n): ?>
  	<? if(!$n['notices_id'] || !$n['notices_body']){continue;} ?>
    <tr>
      <td><?= $n['notices_read'] ? '' : '<b>' ?><?= $n['notices_body'] ?></b></td>
      <td><?= $n['notices_read'] ? '' : '<b>' ?><?= $n['notices_date_formatted'] ?></b></td>
    </tr>
	<? endforeach; ?>
  </tbody>
</table>
