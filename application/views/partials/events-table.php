
<table class="table table-sm table-hover no-wrap" id="dt-events-<?= $title ?>">
  <thead>
    <tr>
      <th scope="col">Type</th>
      <th scope="col">Name</th>
      <th scope="col">Date</th>
      <th scope="col">Host</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody>
  	<? foreach((array)$events AS $event): ?>
    <tr>
      <td><?= $event['events_type'] ?></td>
      <td><a href="/city/events/view/<?= $event['events_id'] ?>"><?= $event['events_name'] ?></a></td>
      <td><?= $event['events_pending'] != 0 ? 'TBD' : $event['events_date1'] ?></td>
      <td><?= $event['join_cabs_id'] ? '<a href="/city/cabs/view/'.$event['join_cabs_id'].'">' . $event['cabs_name'] . ' </a>' : 'Self' ?></td>
      <td><?= $event['events_status_english'] ?></td>
    </tr>
	<? endforeach; ?>
	<? if(!count($events)): ?>
		<tr><td colspan=100%>No Events</td></tr>
	<? endif; ?>
  </tbody>
</table>