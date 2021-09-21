
<table class="table table-sm table-hover no-wrap" id="dt-events-<?= $title ?>">
  <thead>
    <tr>
    	<th class="col-sm-6 col-md-8" scope="col">Name</th>
		<th class="col-sm-6 col-md-4" scope="col" colspan="2">Actions</th>
    </tr>
  </thead>
  <tbody>
  	<? foreach((array)$divisions AS $i => $d): ?>
    <tr id="divisions-id-<?= $i ?>">
      <td class="col-sm-6 col-md-8" id="e-name-<?= $i ?>"><?= $d ?></td>
  	<td class="col-sm-6 col-md-4">
  		<button type="button" class="btn btn-primary admin-edit-division" data-toggle="modal" data-target="#dialog-events-divisions-edit" data-id="<?= $i ?>" data-name="<?= $d ?>" data-classlistsid="<?= $classlists_id ?>">Edit Division</button>
  	</td>
  	<td>
  		<button type="button" class="btn btn-danger admin-delete-division float-right" data-id="<?= $i ?>">X</button>
  		<div class="save_status_division float-right" data-id="<?= $i ?>">
  		</div>
  	</td>
  	</td>
</tr>
	<? endforeach; ?>
	<? if(!count($divisions)): ?>
		<tr><td colspan=100%>No divisions</td></tr>
	<? endif; ?>
  </tbody>
</table>