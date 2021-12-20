
<?
$post = $this->session->flashdata('post');
$errors = $this->session->flashdata('errors');
if($horse['horses_breeding_fee'] == 0){$horse['horses_breeding_fee'] = "";}
?>
<div class="row">
        <div class="col-lg-12">
        	<br/>

          <div class="card mb-4">
            <div class="card-body">
              <h2 class="card-title">Update Horse</h2>
              <p class="card-text">
				<form method="post" action="/horses/update/<?= $horse['horses_id'] ?>">
				<? if($player['privileges']['privileges_horses']): ?>
					<?= hf_input('horses_name', 'Name', $_POST ?: $horse, array('placeholder' => ''), $errors) ?>
				<? else: ?>
					<?= hf_input('horses_name', 'Name', $_POST ?: $horse, array('placeholder' => '', 'disabled' => 'disabled'), $errors) ?>
				<? endif; ?>				
				<?= hf_checkbox('horses_sale', 'For Sale?', $_POST ?: $horse, array(), $errors) ?>
				<?= hf_input('horses_sale_price', 'Sale Price', $_POST ?: $horse, array('placeholder' => 'Enter a number higher than 0 to put horse up for sale'), $errors) ?>
				<?= hf_input('horses_breeding_fee', 'Breeding Fee', $_POST ?: $horse, array('placeholder' => 'Enter a number higher than 0 to put horse up for breeding'), $errors) ?>


				<? if($player['privileges']['privileges_horses']): ?>
				<hr/>
				<b>Admin Options:</b><br/>
					<? if($horse['join_players_id'] == EXPORT_ID): ?>
						<?= hf_input('horses_sale2', 'Import Fee', $_POST ?: $horse['horses_sale'], array(), $errors) ?>
					<? endif; ?>
					<?= hf_dropdown('horses_created', 'Reg. Type', $_POST ?: $horse, array('0' => 'Bred', '1' => 'Created'), array(), $errors) ?>
					<?= hf_input('horses_birthyear', 'Year of Birth', $_POST ?: $horse, array(), $errors) ?>
					<?= hf_dropdown('horses_gender', 'Gender', $_POST ?: $horse, array('', 'Stallion', 'Mare', 'Gelding'), array(), $errors, 1) ?>

					<?= hf_dropdown('horses_breed', 'Breed', $_POST ?: $horse, $breeds, array(), $errors, 1) ?>
					<?= hf_input('horses_breed2', 'Secondary Breed/Pattern (optional)', $_POST ?: $horse, array(), $errors, 1) ?>
					<?//= hf_dropdown('horses_color', 'Base Color', $_POST ?: $horse, $base_colors, array(), $errors, 1) ?>
					<?//= hf_dropdown('horses_pattern', 'Pattern Color', $_POST ?: $horse, $base_patterns, array(), $errors, 1) ?>
					<?= hf_dropdown('horses_line', 'Line (optional)', $_POST ?: $horse, $lines, array(), $errors, 1) ?>
					<?= hf_input('horses_sire', 'Sire ID', $_POST ?: $horse, array(), $errors) ?>
					<?= hf_input('horses_dam', 'Mare ID', $_POST ?: $horse, array(), $errors) ?>


					<?= hf_checkbox('horses_adoptable', 'Adoptable?', $_POST ?: $horse, array(), $errors) ?>
					<? if($horse['horses_deceased']): ?>
						<?= hf_checkbox('horses_deceased', 'Deceased? (Checking this box is permanent!)', $horse, array('disabled' => 'disabled'), $errors) ?>
					<? else: ?>
						<?= hf_checkbox('horses_deceased', 'Deceased? (Checking this box is permanent!)', $_POST ?: $horse, array(), $errors) ?>
					<? endif; ?>
					<?= hf_textarea('horses_notes', 'Comments/Notes', $_POST ?: $horse, array('class' => 'col-sm-12', 'rows' => '5'), $errors) ?>
				<? endif; ?>
              </p>
            </div>
            <div class="card-footer text-muted">
				<?= hf_submit('update', 'Update Horse', array('class' => 'btn btn-primary col-sm-12')) ?>
				</form>
            </div>
          </div>

<!-- my comment -->
<!-- 		<? if($player['privileges']['privileges_horses']): ?>
          <div class="card mb-4">
            <div class="card-body">
              <h2 class="card-title">Genetics</h2>
              <p class="card-text">

<form action="/horses/update/<?= $horse['horses_id'] ?>" method="post">
<table class="table table-sm table-hover" id="dt-admin-blueprints-genes">
  <thead>
    <tr>
      <th scope="col">Category</th>
      <th scope="col">Gene</th>
      <th scope="col">Value</th>
    </tr>
  </thead>
<tbody>
<? foreach((array)$genes AS $i => $gene): ?>
<tr>
	<td><?= $gene['join_genes_categories_name'] ?></b></td>
	<td><?= $gene['genes_name'] ?></b></td>
	<td>
		<? if(!$horse['genes'][$gene['genes_id']]['horses_x_genes_value']): ?>
			<? $horse['genes'][$gene['genes_id']]['horses_x_genes_value'] = $gene['genes_code3']; ?>
		<? endif; ?>
		<?= hf_dropdown('genes['.$gene[genes_id].']', '', $horse['genes'][$gene['genes_id']]['horses_x_genes_value'], array($gene['genes_code1'], $gene['genes_code2'], $gene['genes_code3']), array('class' => 'col-sm-12'), $errors, 1, 0) ?>

		<? /* if($horse['genes'][$gene['genes_id']]['horses_x_genes_value'] == $gene['genes_code1']): ?>
			<td><?= hf_checkbox('genes_code1['.$gene[genes_id].']', $gene['genes_code1'], 'SELECTED', array(), $errors, 1) ?></td>
		<? else: ?>
			<td><?= hf_checkbox('genes_code1['.$gene[genes_id].']', $gene['genes_code1'], '', array(), $errors, 1) ?></td>
		<? endif; ?>

		<? if($horse['genes'][$gene['genes_id']]['horses_x_genes_value'] == $gene['genes_code2']): ?>
			<td><?= hf_checkbox('genes_code2['.$gene[genes_id].']', $gene['genes_code2'], 'SELECTED', array(), $errors, 1) ?></td>
		<? else: ?>
			<td><?= hf_checkbox('genes_code2['.$gene[genes_id].']', $gene['genes_code2'], '', array(), $errors, 1) ?></td>
		<? endif; ?>

		<? if($horse['genes'][$gene['genes_id']]['horses_x_genes_value'] == $gene['genes_code3']): ?>
			<td><?= hf_checkbox('genes_code3['.$gene[genes_id].']', $gene['genes_code3'], 'SELECTED', array(), $errors, 1) ?></td>
		<? else: ?>
			<td><?= hf_checkbox('genes_code3['.$gene[genes_id].']', $gene['genes_code3'], '', array(), $errors, 1) ?></td>
		<? endif; */?>
</tr>
<? endforeach; ?>
</tbody>
</table>

              </p>
            </div>
            <div class="card-footer text-muted">
				<?= hf_submit('update_genes', 'Update Genes', array('class' => 'btn btn-primary col-sm-12')) ?>
				</form>
            </div>
          </div>
      <? endif; ?>


        </div>

</div> -->
<!-- my comment end -->

<? //pre($genes);pre($horse['genes']); ?>