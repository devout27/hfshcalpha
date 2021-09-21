
 <div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
          	<h4 class="card-header">Links</h4>
            <div class="card-body">
            	<a href="/city/clubs">Search Clubs & Associations</a><br/>
            	<a href="/city/shops">Search Shops & Businesses</a><br/>
            	<a href="/city/cabs/create">Create a CAB</a><br/>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card mb-4">
          	<h4 class="card-header">Create a CAB</h4>
            <div class="card-body">
				<form method="post" action="/city/cabs/create">
				<div class="row">
					<div class="col-sm-8">
						<?= hf_input('cabs_name', 'Name', $_POST, array(), $errors) ?>
					</div>
					<div class="col-sm-4">
						<?= hf_dropdown('cabs_type', 'Type', $_POST, array('Association', 'Business', 'Club',), array(), $errors, 1) ?>
					</div>
				</div>

            </div>
            <div class="card-footer text-muted">
				<?= hf_submit('create', 'Create CAB', array('class' => 'btn btn-primary col-sm-12')) ?>
				</form>
            </div>
        </div>
    </div>
</div>
