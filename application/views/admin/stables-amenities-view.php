


<div class="row">
        <div class="col-lg-8">
          <div class="card mb-4">
			<? if($amenity['amenities_picture']): ?>
           		<img class="card-img-top" src="<?= $amenity['amenities_picture'] ?>" alt="Amenity picture">
           	<? endif; ?>
            <div class="card-body">
				<form method="post" action="/admin/stables/amenities/view/<?= $amenity['amenities_id'] ?>">
				<?= hf_input('amenities_name', 'Name', $_POST ?: $amenity, array('placeholder' => 'Nickname'), $errors) ?>
				<?= hf_textarea('amenities_description', 'Description', $_POST ?: $amenity, array('class' => 'col-sm-12', 'rows' => '2'), $errors) ?>
				<?= hf_input('amenities_picture', 'Picture', $_POST ?: $amenity, array(), $errors) ?>
				<?= hf_input('amenities_cost', 'Cost', $_POST ?: $amenity, array(), $errors) ?>
				<div class="row">
					<div class="col-sm-2">
						Type
					</div>
					<div class="col-sm-4">
						<?= hf_dropdown('amenities_type', '', $_POST ?: $amenity, array('Building','Course','Land','Farm','Stall','Paddock','Miscellaneous','Special'), null, $errors, 1, 0) ?>
					</div>
					<div class="col-sm-2">
						Limit
					</div>
					<div class="col-sm-4">
						<?= hf_input('amenities_limit', '', $_POST ?: $amenity, array(), $errors) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2">
						Acres
					</div>
					<div class="col-sm-4">
						<?= hf_input('amenities_acres', '', $_POST ?: $amenity, array(), $errors) ?>
					</div>
					<div class="col-sm-2">
						Stalls
					</div>
					<div class="col-sm-4">
						<?= hf_input('amenities_stalls', '', $_POST ?: $amenity, array(), $errors) ?>
					</div>
				</div>
            </div>
            <div class="card-footer text-muted">
				<?= hf_submit('update_amenity', 'Update Amenity', array('class' => 'btn btn-primary col-sm-12')) ?>
				</form>
            </div>
          </div>

</div>
        <div class="col-lg-4">
          <div class="card mb-4">
          	<h5 class="card-header">Stats</h5>
            <div class="card-body">
              <p class="card-text">
              	<div class="row">
              		<div class="col-sm-6">
              			Owned
              		</div>
              		<div class="col-sm-6">
              			<?= $amenities_owned ?>
              		</div>
              	</div>
              </p>
          </div>
         </div>



      	  	<div class="center"><br/><br/><br/>
	  			<a href="/admin/stables/amenities/delete/<?= $amenity['amenities_id'] ?>" class="btn btn-danger center confirm-link" data-custom="All existing amenities will be deleted as well!">Delete Amenity</a><br/><br/>
	  		</div>

        </div>

</div>