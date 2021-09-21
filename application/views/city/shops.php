
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
          	<h4 class="card-header">Search</h4>
            <div class="card-body">
				<form method="post" action="/city/shops">
				<div class="row">
					<div class="col-sm-12">
						<?= hf_input('cabs_name', 'Name', $_POST, array(), $errors) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<?= hf_input('cabs_owner', 'Shop/Business Owner', $_POST, array('placeholder' => 'You can search by an ID or a name.'), $errors) ?>
					</div>
				</div>

				<? if($player['privileges']['privileges_cabs']): ?>
				<div class="row">
					<div class="col-sm-12">
						<?= hf_checkbox('cabs_pending', 'View Pending', $post, array(), $errors) ?>
						<?= hf_checkbox('cabs_disabled', 'View Disabled', $post, array(), $errors) ?>
					</div>
				</div>
				<? endif; ?>

            </div>
            <div class="card-footer text-muted">
				<?= hf_submit('search', 'Search Shops & Businesses', array('class' => 'btn btn-primary col-sm-12')) ?>
				</form>
            </div>
        </div>
    </div>
</div>
