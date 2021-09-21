
<div class="row">
	<div class="col-md-12">
  		<button type="button" class="btn btn-primary create-package float-right" data-toggle="modal" data-target="#dialog-stables-packages-add" data-id="<?= $class['events_x_classes_id'] ?>">New Package</button>
  	</div><br/><br/>
  	<div class="col-md-12">

<table class="table table-sm table-hover no-wrap" id="dt-admin-packages">
  <thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Description</th>
      <th scope="col">Cost</th>
      <th scope="col">USD</th>
      <th scope="col">Available</th>
    </tr>
  </thead>
  <tbody>
  	<? foreach((array)$packages AS $p): ?>
  		<? $p = $p[0]; ?>
    <tr>
      <td><b><a href="/admin/stables/packages/view/<?= $p['stables_packages_id'] ?>"><?= $p['stables_packages_name'] ?></a></b></td>
      <td><?= $p['stables_packages_description'] ?><br/></td>
      <td class="text-right">$<?= number_format($p['stables_packages_cost']) ?></td>
      <td class="text-right">$<?= $p['stables_packages_cost_usd'] ?> </td>
      <td><?= $p['stables_packages_available'] ?></td>
    </tr>
	<? endforeach; ?>
	<? if(!count($packages)): ?>
		<tr><td colspan=100%>No Packages</td></tr>
	<? endif; ?>
  </tbody>
</table>


	</div>
</div>
<br/>

<div class="modal fade" id="dialog-stables-packages-add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Package Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/admin/stables/packages/" method="post">
      <div class="modal-body">
      	<div class="save_status" data-id="0">
      	</div>
      	<div class="row">
      		<div class="col-sm-4">
      			<label for="name">Name*</label>
      		</div>
      		<div class="col-sm-8">
      			<?= hf_input('stables_packages_name', '', '', array(), $errors) ?>
      		</div>
      	</div>


      	<div class="row">
      		<div class="col-sm-4">
      			<label for="description">Description</label>
      		</div>
      		<div class="col-sm-8">
      			<?= hf_textarea('stables_packages_description', '', '', array('class' => 'col-sm-12', 'rows' => '2'), $errors) ?>
      		</div>
      	</div>

      	<div class="row">
      		<div class="col-sm-4">
      			<label for="cab">Available</label>
      		</div>
      		<div class="col-sm-8">
      			<?= hf_input('stables_packages_available', '', '', array('placeholder' => 'how many are available for purchase, 0 is unlimited'), $errors) ?>
      		</div>
      	</div>


      	<div class="row">
      		<div class="col-sm-4">
      			<label for="cab">Cost</label>
      		</div>
      		<div class="col-sm-8">
      			<?= hf_input('stables_packages_cost', '', '', array('placeholder' => 'leave 0 or blank if not available'), $errors) ?>
      		</div>
      	</div>


      	<div class="row">
      		<div class="col-sm-4">
      			<label for="cab">PayPal Cost</label>
      		</div>
      		<div class="col-sm-8">
      			<?= hf_input('stables_packages_cost_usd', '', '', array('placeholder' => 'leave 0 or blank if not available'), $errors) ?>
      		</div>
      	</div>




      </div>
      <div class="modal-footer">
        <input type="submit" class="btn btn-primary" id="new-package" name="new_package" value="Create Package">
      </div>
  		</form>
    </div>
  </div>
</div>

