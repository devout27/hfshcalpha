
<table class="table table-sm table-hover" id="dt-appts-<?= $title ?>">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">Born</th>
      <th scope="col">Gender</th>
      <th scope="col">Requested</th>
      <th scope="">Action</th>
    </tr>
  </thead>
  <tbody>
  	<? foreach((array)$appts AS $h => $horse): ?>
    <tr>
      <td><a href="/horses/view/<?= $horse['horses_id'] ?>"><?= $horse['horses_id'] ?></a></td>
      <td><a href="/horses/view/<?= $horse['horses_id'] ?>"><?= $horse['horses_name'] ?></a></td>
      <td><?= $horse['horses_birthyear'] ?></td>
      <td><?= $horse['horses_gender'] ?></td>
      <td>
      	<b><?= $horse['horse_appointments_description'] ?></b><br/>
		<?= $horse['horse_appointments_date'] ?>
	  </td>
      <td>

<form method="post" action="/city/farrier/action">
	<?= hf_hidden('horse_appointments_id', $horse['horse_appointments_id']) ?>
	<div class="col-xs-12 button-wrapper">
		<?= hf_submit('perform', 'Perform Appt', array('class' => 'btn btn-success col-md-7 float-left')) ?>
		<?= hf_submit('reject', 'X', array('class' => 'btn btn-danger col-md-2 float-right glyphicon glyphicon-remove')) ?>
	</div>

</form>

      </td>
    </tr>
	<? endforeach; ?>
  </tbody>
</table>