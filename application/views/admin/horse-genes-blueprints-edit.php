
 <div class="row">

    <div class="col-sm-12">
        <div class="card mb-4">
          	<h4 class="card-header">Edit Blueprint</h4>
            <div class="card-body">
				<form method="post" action="/admin/horses/genes/blueprints/edit/<?= $blueprint['genes_blueprints_id'] ?>">
					<?= hf_input('genes_blueprints_name', 'Blueprint Name', $post ?: $blueprint, array(), $errors) ?>
					<?= hf_dropdown('join_genes_categories_name', 'Category', $post ?: $blueprint, $genes_categories, array(), $errors, 1) ?>
					<?= hf_checkbox('genes_blueprints_special', 'Is this a special blueprint?', $post ?: $blueprint, array(), $errors, 1) ?>
					<?= hf_textarea('genes_blueprints_description', 'Description', $post ?: $blueprint, array('class' => 'col-sm-12', 'placeholder' => '', 'rows' => '4'), $errors) ?>
					<?= hf_submit('save', 'Edit Blueprint', array('class' => 'btn btn-primary col-sm-12')) ?>
				</form>
			</div>
		</div>
	</div>


    <div class="col-sm-12">
        <div class="card mb-4">
          	<h4 class="card-header">Edit Genes Present</h4>
            <div class="card-body">


<form action="/admin/horses/genes/blueprints/edit/<?= $blueprint['genes_blueprints_id'] ?>" method="post">
<table class="table table-sm table-hover" id="dt-admin-blueprints-genes">
  <thead>
    <tr>
      <th scope="col">Gene</th>
      <th scope="col">Dominant</th>
      <th scope="col">Heterozygous</th>
      <th scope="col">Recessive</th>
    </tr>
  </thead>
<tbody>
<? foreach((array)$genes AS $i => $gene): ?>
<tr>
	<td><b><?= $gene['genes_name'] ?></b></td>
	<? $kflag = 0; for($k=0; $k<3; $k++): ?>
		<? if($blueprint['genes'][$gene['genes_id']][$k]['genes_blueprints_x_genes_value'] == $gene['genes_code1']): ?>
			<td><?= hf_checkbox('genes_code1['.$gene[genes_id].']', $gene['genes_code1'], 'SELECTED', array(), $errors, 1) ?></td>
			<? $kflag = 1; ?>
		<? endif; ?>
	<? endfor; ?>
	<? if(!$kflag): //show blank ?>
		<td><?= hf_checkbox('genes_code1['.$gene[genes_id].']', $gene['genes_code1'], '', array(), $errors, 1) ?></td>
	<? endif; ?>

	<? $kflag = 0; for($k=0; $k<3; $k++): ?>
		<? if($blueprint['genes'][$gene['genes_id']][$k]['genes_blueprints_x_genes_value'] == $gene['genes_code2']): ?>
			<td><?= hf_checkbox('genes_code2['.$gene[genes_id].']', $gene['genes_code2'], 'SELECTED', array(), $errors, 1) ?></td>
			<? $kflag = 1; ?>
		<? endif; ?>
	<? endfor; ?>
	<? if(!$kflag): //show blank ?>
		<td><?= hf_checkbox('genes_code2['.$gene[genes_id].']', $gene['genes_code2'], '', array(), $errors, 1) ?></td>
	<? endif; ?>

	<? $kflag = 0; for($k=0; $k<3; $k++): ?>
		<? if($blueprint['genes'][$gene['genes_id']][$k]['genes_blueprints_x_genes_value'] == $gene['genes_code3']): ?>
			<td><?= hf_checkbox('genes_code3['.$gene[genes_id].']', $gene['genes_code3'], 'SELECTED', array(), $errors, 1) ?></td>
			<? $kflag = 1; ?>
		<? endif; ?>
	<? endfor; ?>
	<? if(!$kflag): //show blank ?>
		<td><?= hf_checkbox('genes_code3['.$gene[genes_id].']', $gene['genes_code3'], '', array(), $errors, 1) ?></td>
	<? endif; ?>
</tr>
<? endforeach; ?>
</tbody>
</table>
<br/>
<?= hf_submit('save_genes', 'Update Genes in Blueprint', array('class' => 'btn btn-primary col-sm-12')) ?>
</form>

            </div>
        </div>
    </div>

</div>