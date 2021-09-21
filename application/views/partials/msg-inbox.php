
<table class="table table-sm table-hover" id="dt-inbox">
  <thead>
    <tr>
      <th scope="col"></th>
      <th scope="col">Subject</th>
      <th scope="col">From</th>
      <th scope="col">Date</th>
    </tr>
  </thead>
  <tbody>
  	<? foreach($msgs AS $k => $msg): ?>
  	<? if(!$msg['messages_id']){continue;} ?>
    <tr>
      <td><?= $msg['messages_date'] ?></td>
      <td><?= $msg['messages_read'] ? '' : '<b>' ?><a href="/game/messages/view/<?= $msg['messages_id'] ?>"><?= $msg['messages_subject'] ?: 'Untitled' ?></a></b></td>
      <td><?= $msg['messages_read'] ? '' : '<b>' ?><a href="/game/profile/<?= $msg['messages_sender'] ?>"><?= $msg['p2_name'] ?></a></b></td>
      <td><?= $msg['messages_read'] ? '' : '<b>' ?><?= $msg['messages_date_formatted'] ?></b></td>
    </tr>
	<? endforeach; ?>
  </tbody>
</table>
