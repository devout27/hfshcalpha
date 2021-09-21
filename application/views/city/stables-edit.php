<? //pre($stable) ?>



<div class="row">

        <div class="col-lg-12">
          <div class="card my-4">
            <h5 class="card-header">Details</h5>
            <div class="card-body">
              <div class="row">



	<div class="col-sm-6">
		<?= hf_input('stables_name', 'Stable Name', $stable, array('placeholder' => 'Upton Downs'), $errors) ?>
	</div>
	<div class="col-sm-3">
		<?= hf_input('stables_boarding_fee', 'Boarding Fee', $stable, array('placeholder' => '$100'), $errors) ?>
	</div>
	<div class="col-sm-3">
		<?= hf_checkbox('stables_boarding_public', 'Public Boarding?', $stable, array(), $errors) ?>
	</div>
	<div class="col-sm-12">
		<?= hf_textarea('stables_description', 'Stable Description', $stable, array('class' => 'col-sm-12', 'placeholder' => 'A quiet place to call home.', 'rows' => '10'), $errors) ?>
	</div>

</div>
<div class="row">

		<?= hf_submit('edit', 'Update Stable', array('class' => 'btn btn-primary col-sm-12')) ?>

              </div>
            </div>
          </div>





        </div>
</div>