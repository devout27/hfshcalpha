


<div class="row">
        <div class="col-lg-12">
      	  	<div class="float-right">
	  			<a href="/admin/stables/packages/delete/<?= $package['stables_packages_id'] ?>" class="btn btn-danger float-right confirm-link" data-custom="">Delete Package</a>
	  		</div><br/><br/>
	  	</div>
</div>
<div class="row">
        <div class="col-lg-12">
          <div class="card mb-4">
            <div class="card-body">
				<form method="post" action="/admin/stables/packages/view/<?= $package['stables_packages_id'] ?>">
				<?= hf_input('stables_packages_name', 'Name', $_POST ?: $package, array('placeholder' => 'Nickname'), $errors) ?>
				<?= hf_textarea('stables_packages_description', 'Description', $_POST ?: $package, array('class' => 'col-sm-12', 'rows' => '2'), $errors) ?>
				<div class="row">
					<div class="col-xs-12 col-sm-6">
						Packages Available for Purchase
					</div>
					<div class="col-xs-12 col-sm-6">
						<?= hf_input('stables_packages_available', '', $_POST ?: $package, array(), $errors) ?>
					</div>
					<div class="col-sm-2">
						Cost
					</div>
					<div class="col-sm-4">
						<?= hf_input('stables_packages_cost', '', $_POST ?: $package, array(), $errors) ?>
					</div>
					<div class="col-sm-2">
						PayPal Cost
					</div>
					<div class="col-sm-4">
						<?= hf_input('stables_packages_cost_usd', '', $_POST ?: $package, array(), $errors) ?>
					</div>
				</div>
            </div>
            <div class="card-footer text-muted">
				<?= hf_submit('update_package', 'Update Package', array('class' => 'btn btn-primary col-sm-12')) ?>
				</form>
            </div>
          </div>

</div>



</div>





<div class="row">

    <div class="col-sm-12">
        <div class="card mb-4">
          	<h4 class="card-header">Edit Amenities in Package</h4>
            <div class="card-body">


<form method="post" action="/admin/stables/packages/view/<?= $package['stables_packages_id'] ?>">
<table class="table table-sm table-hover" id="dt-admin-stables-packages-amenities">
  <thead>
    <tr>
      <th scope="col">Amenity</th>
      <th scope="col">Type</th>
      <th scope="col">Stalls</th>
      <th scope="col">Acres</th>
      <th scope="col">Cost</th>
      <th scope="col">Quantity</th>
    </tr>
  </thead>
<tbody>
<? foreach((array)$amenities AS $amenity): ?>
<tr>
	<input type="hidden" name="amenities_id[]" value="<?= $amenity['amenities_id'] ?>">

	<td><b><a href="/admin/stables/amenities/view/<?= $amenity['amenities_id'] ?>" data-toggle="tooltip" data-placement="bottom" title="<?= $amenity['amenities_description'] ?>"><?= $amenity['amenities_name'] ?></a></b></td>
	<td><?= $amenity['amenities_type'] ?></td>
	<td><?= $amenity['amenities_stalls'] ?></td>
	<td><?= $amenity['amenities_acres'] ?></td>
	<td>$<?= number_format($amenity['amenities_cost']) ?></td>
	<td><?= hf_input('stables_packages_x_amenities_quantity[]', '', $package['amenities'][$amenity['amenities_id']]['stables_packages_x_amenities_quantity'] ?: 0, array(), $errors) ?></td>
</tr>
<? endforeach; ?>
</tbody>
</table>
<br/>
<?= hf_submit('save_amenities', 'Update Amenities', array('class' => 'btn btn-primary col-sm-12')) ?>
</form>

            </div>
        </div>
    </div>

</div>