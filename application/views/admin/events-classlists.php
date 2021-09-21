
<div class="row">
	<div class="col-md-12">
  		<button type="button" class="btn btn-primary create-classlist float-right" data-toggle="modal" data-target="#dialog-events-classlists-add" data-id="<?= $class['events_x_classes_id'] ?>" data-name="<?= $class['events_x_classes_name'] ?>" data-minage="<?= $class['events_x_classes_min_age'] ?>" data-maxage="<?= $class['events_x_classes_max_age'] ?>" data-fee="<?= $class['events_x_classes_fee'] ?>" data-desc="<?= $class['events_x_classes_description'] ?>" data-strenuous="<?= $class['events_x_classes_strenuous'] ?>" data-prize01="<?= $class['events_x_classes_prize01'] ?>">New Classlist</button>
  	</div><br/><br/>
  	<div class="col-md-12">

<table class="table table-sm table-hover no-wrap" id="dt-admin-classlists">
  <thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Classes</th>
      <th scope="col">CAB</th>
      <th scope="col">Special</th>
    </tr>
  </thead>
  <tbody>
  	<? foreach((array)$classlists AS $list): ?>
    <tr>
      <td><a href="/admin/events/classlists/view/<?= $list['classlists_id'] ?>"><?= $list['classlists_name'] ?></a></td>
      <td><?= count($list['classes']) ?></td>
      <? if($list['join_cabs_id']): ?>
      	<td><a href="/city/cabs/view/<?= $list['join_cabs_id'] ?>"><?= $list['cabs_name'] ?></a></td>
      <? else: ?>
      	<td>N/A</td>
      <? endif; ?>
      <td><?= $list['classlists_special'] ? 'Yes' : 'No' ?></td>
    </tr>
	<? endforeach; ?>
	<? if(!count($classlists)): ?>
		<tr><td colspan=100%>No Classlists</td></tr>
	<? endif; ?>
  </tbody>
</table>


	</div>
</div>
<br/>

<div class="modal fade" id="dialog-events-classlists-add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Classlist Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="save_status" data-id="0">
      	</div>
      	<div class="row">
      		<div class="col-sm-4">
      			<label for="name">Name</label>
      		</div>
      		<div class="col-sm-8">
      			<?= hf_input('classlists_name', '', '', array(), $errors) ?>

      			<input type=hidden name="events_x_classes_id" id="events_x_classes_id">
      		</div>
      	</div>

      	<div class="row">
      		<div class="col-sm-4">
      			<label for="strenuous">CAB</label>
      		</div>
      		<div class="col-sm-8">
      			<?= hf_dropdown('join_cabs_id', '', '', array('0' => 'None') + $cabs, null, $errors, 0, 0) ?>
      		</div>
      	</div>

      	<div class="row">
      		<div class="col-sm-4">
      			<label for="strenuous">Special List?</label>
      		</div>
      		<div class="col-sm-8">
      			<?= hf_dropdown('classlists_special', '', '', array('0' => 'No', '1' => 'Yes'), null, $errors, 0, 0) ?>
      		</div>
      		<div class="col-sm-12"><i>A special classlist is not available to the general public. Only an admin may select a special classlist when creating an event.</i></div>
      	</div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="new-classlist">Create Classlist</button>
      </div>
    </div>
  </div>
</div>

