
<div class="row">
	<div class="col-md-12">

		<p>Here's a list of horses waiting to be registered.</p>

		<div class="row">
			<div class="col-sm-12">
				<table class="table table-sm table-hover w-100 no-wrap">
		    		<thead>
					<tr>
		    			<th>Horse</th>
		    			<th>Actions</th>
					</tr>
					</thead>
					<tbody>
						<? foreach((array)$horses AS $horse): ?>
						<tr>
							<td >

<?
//  swap errors for only the applicable horse
if($horse['horses_id'] == $post['horses_id']){
	$errors = $this->session->flashdata('errors');
	$horse = $post;
}else{
	$errors = "";
}
?>

<form method="post" action="/admin/horses/register">
				<div class="row">
					<div class="col-sm-12">
						<b>Owner</b><br/>
						<a href="/game/profile/<?= $horse['join_players_id'] ?>"><?= $horse['players_nickname'] ?> #<?= $horse['join_players_id'] ?></a>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<?= hf_input('horses_name', 'Name', $horse, array(), $errors) ?>
					</div>
					<div class="col-sm-3">
						<?= hf_dropdown('horses_gender', 'Gender', $horse, array('', 'Stallion', 'Mare', 'Gelding'), array(), $errors, 1) ?>
					</div>
					<div class="col-sm-3">
						<?= hf_input('horses_birthyear', 'Birth Year', $horse, array('placeholder' => '1984'), $errors) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<?= hf_input('horses_sire', 'Sire <a href=/horses/view/' . $horse['horses_sire'] .'>(View)</a>', $horse, array(), $errors) ?>
					</div>
					<div class="col-sm-6">
						<?= hf_input('horses_dam', 'Dam <a href=/horses/view/' . $horse['horses_dam'] .'>(View)</a>', $horse, array(), $errors) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<?= hf_dropdown('horses_breed', 'Breed', $horse, $breeds, array(), $errors, 1) ?>
					</div>
					<div class="col-sm-6">
						<?= hf_input('horses_breed2', 'Secondary Breed/Pattern (optional)', $horse, array(), $errors) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<?= hf_dropdown('horses_color', 'Base Color', $horse, $base_colors, array(), $errors, 1) ?>
					</div>
					<div class="col-sm-6">
						<?= hf_dropdown('horses_pattern', 'Pattern Color', $horse, $base_patterns, array(), $errors, 1) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<?= hf_dropdown('horses_line', 'Line (optional)', $horse, $lines, array(), $errors, 1) ?>
					</div>
					<div class="col-sm-6">
						<?= hf_multiselect('disciplines[]', 'Discipline', $horse['disciplines'], $disciplines, array(), $errors, 1) ?>
					</div>
				</div>
            </div>


			              	</td>
        					<td width="40%">

	<?= hf_hidden('horses_id', $horse['horses_id']) ?>
	<?= hf_hidden('join_players_id', $horse['join_players_id']) ?>
	Message to Player (optional):
	<?= hf_textarea('body', '', $post, array('class' => 'col-sm-12', 'placeholder' => '', 'rows' => '6'), $errors) ?>
	<br/>
	<div class="col-xs-12 button-wrapper">
		<?= hf_submit('accept', 'Accept', array('class' => 'btn btn-success col-md-5 float-left')) ?>
		<?= hf_submit('reject', 'Reject', array('class' => 'btn btn-danger col-md-5 offset-md-2')) ?>
	</div>

</form>
        					</td>
						</tr>
						<? endforeach; ?>
					</tbody>
				</table>

		    </div>
		</div><br/>

	</div>
</div>
