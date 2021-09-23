<? $class = $classlist[0]; ?>
<div class="row">
	<div class="col-lg-12">
		<button class="btn btn-danger col-md-2 float-right" id="delete-classlist" data-id="<?= $class['classlists_id'] ?>">Delete Classlist</button>
	</div>
</div><br/>
<div class="row">
    <div class="col-lg-12">
	    <div class="card mb-4">
            <div class="card-body">
				<form method="post" action="/admin/events/classlists/view/<?= $classlist[0]['classlists_id'] ?>">

				<?= hf_input('classlists_name', 'Classlist Name', $classlist[0], array(), $errors) ?>
      			<?= hf_dropdown('join_cabs_id', 'CAB', $classlist[0], array('0' => 'None') + $cabs, null, $errors, 0, 0) ?>
      			<?= hf_dropdown('classlists_special', 'Special?', $classlist[0], array('0' => 'No', '1' => 'Yes'), null, $errors, 0, 0) ?>

			</div>

            <div class="card-footer text-muted">
            	<div class="row">
					<div class=" col-sm-12 col-md-4 offset-md-8">
						<?= hf_submit('save_classlist', 'Save Changes', array('class' => 'btn btn-success col-sm-12')) ?>
					</div>
				</div>
            </div>
				</form>
		</div>
	</div>




	<div class="col-lg-12">
    	<div class="card my-4">
            <h5 class="card-header">Divisions</h5>
            <div class="card-body">
            	<div class="row">
            		<div class="col-md-4 offset-md-8">
      					<button type="button" class="btn btn-primary admin-new-division float-right col-sm-12" data-toggle="modal" data-target="#dialog-events-divisions-edit" data-classlistsid="<?= $class['classlists_id'] ?>">Add Division</button>
      				</div>
            	</div><br/>
				<? $this->load->view('partials/events-divisions-table-edit-admin', array('divisions' => $divisions, 'classlists_id' => $classlist[0]['classlists_id'], 'title' => 'admin-divisions')); ?>
				<br/>
            	<div class="row">
            		<div class="col-md-4 offset-md-8">
      					<button type="button" class="btn btn-primary admin-new-division float-right col-sm-12" data-toggle="modal" data-target="#dialog-events-divisions-edit" data-classlistsid="<?= $class['classlists_id'] ?>">Add Division</button>
      				</div>
            	</div>
			</div>
		</div>
	</div>




	<div class="col-lg-12">
    	<div class="card my-4">
            <h5 class="card-header">Classes</h5>
            <div class="card-body">
            	<div class="row">
            		<div class="col-md-4 offset-md-8">
      					<button type="button" class="btn btn-primary admin-new-class float-right col-sm-12" data-toggle="modal" data-target="#dialog-events-classes-edit" data-id="<?= $class['classlists_classes_id'] ?>" data-classlistsid="<?= $class['classlists_id'] ?>" data-name="<?= $class['classlists_classes_name'] ?>" data-minage="<?= $class['classlists_classes_min_age'] ?>" data-maxage="<?= $class['classlists_classes_max_age'] ?>" data-fee="<?= $class['classlists_classes_fee'] ?>" data-desc="<?= $class['classlists_classes_description'] ?>" data-strenuous="<?= $class['classlists_classes_strenuous'] ?>">Add Class</button>
      				</div>
            	</div><br/>
				<? $this->load->view('partials/events-class-table-edit-admin', array('classes' => $classlist, 'title' => 'admin-classes')); ?>
				<br/><br/>
            	<div class="row">
            		<div class="col-md-4 offset-md-8">
      					<button type="button" class="btn btn-primary admin-new-class float-right col-sm-12" data-toggle="modal" data-target="#dialog-events-classes-edit" data-id="<?= $class['classlists_classes_id'] ?>" data-classlistsid="<?= $class['classlists_id'] ?>" data-name="<?= $class['classlists_classes_name'] ?>" data-minage="<?= $class['classlists_classes_min_age'] ?>" data-maxage="<?= $class['classlists_classes_max_age'] ?>" data-fee="<?= $class['classlists_classes_fee'] ?>" data-desc="<?= $class['classlists_classes_description'] ?>" data-strenuous="<?= $class['classlists_classes_strenuous'] ?>">Add Class</button>
      				</div>
            	</div>
			</div>
		</div>
	</div>
</div>






<div class="modal fade" id="dialog-admin-confirm-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Delete Class</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	Are you sure you want to delete this class?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="admin-delete-class-confirm" data-id="">Delete it!</button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="dialog-admin-confirm-delete-division" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Delete Division</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	Are you sure you want to delete this division?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="admin-delete-division-confirm" data-id="">Delete it!</button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="dialog-admin-confirm-delete-classlist" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Delete Classlist</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	Are you sure you want to delete this classlist?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="admin-delete-classlist-confirm" data-id="">Delete it!</button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="dialog-events-divisions-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Division</h5>
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
      			<?= hf_input('classlists_divisions_name', '', '', array(), $errors) ?>

      			<input type=hidden name="join_classlists_id" id="join_classlists_id">
      			<input type=hidden name="classlists_divisions_id" id="classlists_divisions_id">
      		</div>
      	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="admin-save-division">Save Changes</button>
      </div>
    </div>
  </div>
</div>






<div class="modal fade" id="dialog-events-classes-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Class Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="save_status" data-id="0">
      	</div>
		  <form action="javascript:void(0)" id="events-class-edit-form">
			<div class="row">
				<div class="col-sm-4">
					<label for="name">Name</label>
				</div>
				<div class="col-sm-8">
					<?= hf_input('classlists_classes_name', '', '', array(), $errors) ?>

					<input type=hidden name="classlists_classes_id" id="classlists_classes_id">
					<input type=hidden name="join_classlists_id" id="join_classlists_id">
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<label for="description">Description</label>
				</div>
				<div class="col-sm-8">
					<?= hf_input('classlists_classes_description', '', '', array(), $errors) ?>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<label for="description">Division</label>
				</div>
				<div class="col-sm-8">
					<?= hf_dropdown('join_divisions_id', '', '', array('0' => "None") + $divisions, null, $errors, 0, 0) ?>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<label for="description">Disciplines</label>
				</div>
				<div class="col-sm-8" id="col-classlists_classes_disciplines">
					<?= hf_multiselect('classlists_classes_disciplines', '', '', $disciplines, null, $errors, 1) ?>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<label for="description">Type</label>
				</div>
				<div class="col-sm-8" id="col-classlists_classes_breeds_types">
					<?= hf_multiselect('classlists_classes_breeds_types', '', '', $breeds_types, null, $errors, 1) ?>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<label for="description">Breeds</label>
				</div>
				<div class="col-sm-8" id="col-classlists_classes_breeds">
					<?= hf_multiselect('classlists_classes_breeds', '', '', $breeds, null, $errors, 1) ?>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<label for="strenuous">Strenuous</label>
				</div>
				<div class="col-sm-8">
					<?= hf_dropdown('classlists_classes_strenuous', '', '', array('0' => "No", '1' => "Yes"), null, $errors, 0, 0) ?>
				</div>
			</div>


			<div class="row">
				<div class="col-sm-4">
					<label for="minage">Min Age</label>
				</div>
				<div class="col-sm-8">
					<?= hf_input('classlists_classes_min_age', '', '', array(), $errors) ?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<label for="maxage">Max Age</label>
				</div>
				<div class="col-sm-8">
					<?= hf_input('classlists_classes_max_age', '', '', array(), $errors) ?>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<label for="fee">Fee</label>
				</div>
				<div class="col-sm-8">
					<?= hf_input('classlists_classes_fee', '', '', array(), $errors) ?>
				</div>
			</div>
	<? /*
			<div class="row">
				<div class="col-sm-4">
					<strong>Prizes</strong>
				</div>
				<div class="col-sm-8">
					<div class="row">
						<div class="col-xs-6 col-sm-3">
							1st
						</div>
						<div class="col-xs-6 col-sm-3">
							<?= hf_input('classlists_classes_prize01', '', '', array(), $errors) ?>
						</div>
						<div class="col-xs-6 col-sm-3">
							2nd
						</div>
						<div class="col-xs-6 col-sm-3">
							<?= hf_input('classlists_classes_prize02', '', '', array(), $errors) ?>
						</div>

						<div class="col-xs-6 col-sm-3">
							3rd
						</div>
						<div class="col-xs-6 col-sm-3">
							<?= hf_input('classlists_classes_prize03', '', '', array(), $errors) ?>
						</div>

						<div class="col-xs-6 col-sm-3">
							4th
						</div>
						<div class="col-xs-6 col-sm-3">
							<?= hf_input('classlists_classes_prize04', '', '', array(), $errors) ?>
						</div>
						<div class="col-xs-6 col-sm-3">
							5th
						</div>
						<div class="col-xs-6 col-sm-3">
							<?= hf_input('classlists_classes_prize05', '', '', array(), $errors) ?>
						</div>
						<div class="col-xs-6 col-sm-3">
							6th
						</div>
						<div class="col-xs-6 col-sm-3">
							<?= hf_input('classlists_classes_prize06', '', '', array(), $errors) ?>
						</div>
						<div class="col-xs-6 col-sm-3">
							7th
						</div>
						<div class="col-xs-6 col-sm-3">
							<?= hf_input('classlists_classes_prize07', '', '', array(), $errors) ?>
						</div>
						<div class="col-xs-6 col-sm-3">
							8th
						</div>
						<div class="col-xs-6 col-sm-3">
							<?= hf_input('classlists_classes_prize08', '', '', array(), $errors) ?>
						</div>
						<div class="col-xs-6 col-sm-3">
							9th
						</div>
						<div class="col-xs-6 col-sm-3">
							<?= hf_input('classlists_classes_prize09', '', '', array(), $errors) ?>
						</div>
						<div class="col-xs-6 col-sm-3">
							10th
						</div>
						<div class="col-xs-6 col-sm-3">
							<?= hf_input('classlists_classes_prize10', '', '', array(), $errors) ?>
						</div>
						<div class="col-xs-6 col-sm-3">
							11th
						</div>
						<div class="col-xs-6 col-sm-3">
							<?= hf_input('classlists_classes_prize11', '', '', array(), $errors) ?>
						</div>
						<div class="col-xs-6 col-sm-3">
							12th
						</div>
						<div class="col-xs-6 col-sm-3">
							<?= hf_input('classlists_classes_prize12', '', '', array(), $errors) ?>
						</div>
					</div>
				</div>
			</div>
			*/ ?>
		  </form>
      	

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="admin-save-events-class">Save Changes</button>
      </div>
    </div>
  </div>
</div>

