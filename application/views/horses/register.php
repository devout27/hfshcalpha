
<?
$post = $this->session->flashdata('post');
$errors = $this->session->flashdata('errors');
?>

 <div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
          	<h4 class="card-header">Links</h4>
            <div class="card-body">
            	<a href="/horses">Search Horses</a><br/>
            	<a href="/horses/register">Register Horse</a><br/>
            	<!--<a href="/horses/export">Export a Horse</a><br/>-->
            	<a href="/city/vet">Veterinarian</a><br/>
            	<a href="/city/farrier">Farrier</a><br/>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card mb-4">
          	<h4 class="card-header">Register Horse</h4>
            <div class="card-body"> <?php //if(isset($post)){ if(!empty($post)){ echo "<pre>"; print_r($post);  die; } } ?>
				<form method="post" action="/horses/register">
				<div class="center">					
					You have <b><?= $player['players_credits_creation'] ?: '0' ?></b> creation  credit(s).<br/>
					You have <b><?= $player['players_credits_adoptathon'] ?: '0' ?></b> adoption credit(s).<br/>
					You have Daily <b><?= $player['per_day_credits'] ?: '0' ?></b> creation credit(s).<br/>
					You have Today <b><?= $player['today_adoption'] ?: '0' ?></b> adoption credit(s).<br/>
					<a href="/city/articles/13">Buy More</a>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<?= hf_input('horses_name', 'Name', $post, array(), $errors) ?>
					</div>
					<div class="col-sm-3">
						<?= hf_dropdown('horses_gender', 'Gender', $post, array('', 'Stallion', 'Mare', 'Gelding'), array(), $errors, 1) ?>
					</div>
					<div class="col-sm-3">
						<?= hf_input('horses_birthyear', 'Birth Year', $post, array('placeholder' => '1984'), $errors,'number') ?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12"><p>Registration Type</p></div>
					<div class="col-md-12">																																							
						<label class="radio-inline">
							<input type="radio" id="horses_registration_type" name="horses_registration_type" value="creation" <?php if(isset($post) ){ if( $post['horses_registration_type']=='creation' ){ echo "checked"; } }else{ echo "checked"; } ?> > Creation
						</label>
						<label class="radio-inline">
							<input type="radio" name="horses_registration_type"  id="horses_registration_type" value="breed" <?php if(isset($post) ){ if( $post['horses_registration_type']=='breed' ){ echo "checked"; } } ?> > Breed
						</label>						
						<div class="form-error pull-right"><?php $errors["horses_registration_type"] ?></div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<?= hf_input('horses_sire', 'Sire', $post, array(), $errors,'number') ?>
					</div>
					<div class="col-sm-6">
						<?= hf_input('horses_dam', 'Dam', $post, array(), $errors,'number') ?>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<?= hf_dropdown('horses_breed', 'Breed', $post, $breeds, array(), $errors, 1) ?>
					</div>
					<div class="col-sm-6">
						<?= hf_input('horses_breed2', 'Secondary Breed/Pattern (optional)', $post, array(), $errors) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<?= hf_dropdown('horses_color', 'Base Color', $post, $base_colors, array(), $errors, 1) ?>
					</div>
					<div class="col-sm-6">
						<?= hf_dropdown('horses_pattern', 'Pattern Color', $post, $base_patterns, array(), $errors, 1) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<?= hf_dropdown('horses_line', 'Line (optional)', $post, $lines, array(), $errors, 1) ?>
					</div>
					<div class="col-sm-6">
						<?= hf_multiselect('disciplines[]', 'Discipline', $post['disciplines'], $disciplines, array(), $errors, 1) ?>
					</div>
				</div>
            </div>
            <div class="card-footer text-muted">
				<?= hf_submit('create', 'Register Horse', array('class' => 'btn btn-primary col-sm-12')) ?>
				</form>
            </div>
        </div>
    </div>
 </div>