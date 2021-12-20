<!--

		Search
		Register a Horse
		Your Horses
	-->

 <div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
          	<h4 class="card-header">Links</h4>
            <div class="card-body">
            	<a href="/horses">Search Horses</a><br/>
            	<a href="/horses/register">Breeding through the horses</a><br/>
            	<!--<a href="/horses/export">Export a Horse</a><br/>-->
            	<a href="/city/vet">Veterinarian</a><br/>
            	<a href="/city/farrier">Farrier</a><br/>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card mb-4">
          	<h4 class="card-header">Search</h4>
            <div class="card-body">
				<form method="post" action="/horses">
				<div class="row">
					<div class="col-sm-6">
						<?= hf_input('horses_name', 'Name', $_POST, array(), $errors) ?>
					</div>
					<div class="col-sm-3">
						<?= hf_dropdown('horses_gender', 'Gender', $_POST, array('', 'Stallion', 'Mare', 'Gelding'), array(), $errors, 1) ?>
					</div>
					<div class="col-sm-3">
						<?= hf_input('horses_birthyear', 'Birth Year', $_POST, array('placeholder' => '1984'), $errors) ?>
					</div>
					
				</div>
				<div class="row">
					<div class="col-sm-6">
						<?= hf_dropdown('horses_breed', 'Breed', $_POST, $breeds, array(), $errors, 1) ?>
					</div>
					<div class="col-sm-6">
						<?= hf_input('horses_breed2', 'Secondary Breed/Pattern', $_POST, array(), $errors) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<?= hf_dropdown('horses_color', 'Base Color', $_POST, $base_colors, array(), $errors) ?>
					</div>
					<div class="col-sm-6">
						<?= hf_dropdown('horses_pattern', 'Pattern Color', $_POST, $base_patterns, array(), $errors) ?>
					</div>
				</div>
				<? /*<div class="row">
					<div class="col-sm-6">
						<?= hf_dropdown('horses_line', 'Line', $_POST, $lines, array(), $errors) ?>
					</div>
					<div class="col-sm-6">
						<?= hf_dropdown('disciplines', 'Discipline', $_POST, $disciplines, array(), $errors) ?>
					</div>
				</div> */?>
				<div class="row">
					<div class="col-sm-6">
						<?= hf_input('owner_name', 'Owner Name', $_POST, array(), $errors) ?>
					</div>
					<div class="col-sm-6">
						<?= hf_dropdown('horses_status', 'Status', $_POST, array('0' => 'Living', '1' => 'Deceased', '2' => 'Exported'), array(), $errors) ?>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-6">
						<?= hf_input('min_price', 'Min Sale Price', $_POST, array(), $errors) ?>
					</div>
					<div class="col-sm-6">
						<?= hf_input('max_price', 'Max Sale Price', $_POST, array(), $errors) ?>
					</div>
				</div>
				<br/>

				<div class="row">
					<div class="col-sm-6">
						<?= hf_input('min_breed', 'Minimum Breeding Price', $_POST, array(), $errors) ?>
					</div>
					<div class="col-sm-6">
						<?= hf_input('max_breed', 'Maximum Breeding Price', $_POST, array(), $errors) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<?= hf_checkbox('for_sale', 'For Sale', $_POST, array(), $errors) ?>
					</div>
				</div>

            </div>
            <div class="card-footer text-muted">
				<?= hf_submit('search', 'Search Horses', array('class' => 'btn btn-primary col-sm-12')) ?>
				</form>
            </div>
        </div>
    </div>
</div>
