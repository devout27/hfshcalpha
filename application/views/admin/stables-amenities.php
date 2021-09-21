
<div class="row">
	<div class="col-md-12">
  		<button type="button" class="btn btn-primary create-amenity float-right" data-toggle="modal" data-target="#dialog-events-classlists-add" data-id="<?= $class['events_x_classes_id'] ?>" >New Amenity</button>
  	</div><br/><br/>
  	<div class="col-md-12">

<table class="table table-sm table-hover no-wrap" id="dt-admin-amenities">
  <thead>
    <tr>
      <th scope="col">Picture</th>
      <th scope="col">Details</th>
      <th scope="col">Cost</th>
      <th scope="col">Type</th>
      <th scope="col">Stalls</th>
      <th scope="col">Acres</th>
    </tr>
  </thead>
  <tbody>
  	<? foreach((array)$amenities AS $a): ?>
    <tr>
    	<? if($a['amenities_picture']): ?>
      		<td><img src="<?= $a['amenities_picture'] ?>" height="50"></td>
    	<? else: ?>
      		<td></td>
      	<? endif; ?>
      <td><b><a href="/admin/stables/amenities/view/<?= $a['amenities_id'] ?>"><?= $a['amenities_name'] ?></a></b><br/><p><small><?= $a['amenities_description'] ?></td>
      <td>$<?= $a['amenities_cost'] ?></td>
      <td><?= $a['amenities_type'] ?></td>
      <td><?= $a['amenities_stalls'] ?></td>
      <td><?= $a['amenities_acres'] ?></td>
    </tr>
	<? endforeach; ?>
	<? if(!count($amenities)): ?>
		<tr><td colspan=100%>No Amenities</td></tr>
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
        <h5 class="modal-title" id="exampleModalLongTitle">Amenity Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      	<form action="/admin/stables/amenities" method="POST">
      <div class="modal-body">
      	<div class="row">
      		<div class="col-sm-4">
      			<label for="name">Name*</label>
      		</div>
      		<div class="col-sm-8">
      			<?= hf_input('amenities_name', '', $post, array(), $errors) ?>
      		</div>
      	</div>


      	<div class="row">
      		<div class="col-sm-4">
      			<label for="description">Description*</label>
      		</div>
      		<div class="col-sm-8">
      			<?= hf_textarea('amenities_description', '', $post, array('class' => 'col-sm-12', 'rows' => '2'), $errors) ?>
      		</div>
      	</div>

      	<div class="row">
      		<div class="col-sm-4">
      			<label for="cab">Picture</label>
      		</div>
      		<div class="col-sm-8">
      			<?= hf_input('amenities_picture', '', $post, array('placeholder' => '/images/example.jpg'), $errors) ?>
      		</div>
      	</div>

      	<div class="row">
      		<div class="col-sm-4">
      			<label for="cab">Cost*</label>
      		</div>
      		<div class="col-sm-8">
      			<?= hf_input('amenities_cost', '', $post, array(), $errors) ?>
      		</div>
      	</div>

      	<div class="row">
      		<div class="col-sm-4">
      			<label for="special_list">Type*</label>
      		</div>
      		<div class="col-sm-8">
      			<?= hf_dropdown('amenities_type', '', $post, array('Building','Course','Land','Stall','Paddock','Farm','Miscellaneous','Special'), null, $errors, 1, 0) ?>
      		</div>
      	</div>


      	<div class="row">
      		<div class="col-sm-4">
      			<label for="cab">Limit</label>
      		</div>
      		<div class="col-sm-8">
      			<?= hf_input('amenities_limit', '', $post, array('placeholder' => 'limit per stable, 0 is unlimited'), $errors) ?>
      		</div>
      	</div>

      	<div class="row">
      		<div class="col-sm-4">
      			<label for="cab">Acres</label>
      		</div>
      		<div class="col-sm-8">
      			<?= hf_input('amenities_acres', '', $post, array('placeholder' => 'fill this in if it takes up land or adds land to the stable'), $errors) ?>
      		</div>
      	</div>

      	<div class="row">
      		<div class="col-sm-4">
      			<label for="cab">Stalls</label>
      		</div>
      		<div class="col-sm-8">
      			<?= hf_input('amenities_stalls', '', $post, array('placeholder' => 'fill this in if this adds stalls to the stable'), $errors) ?>
      		</div>
      	</div>



      </div>
      <div class="modal-footer">
        <input type="submit" class="btn btn-primary" id="new-amenity" name="add_amenity" value="Create Amenity">
      </div>
	</form>
    </div>
  </div>
</div>

