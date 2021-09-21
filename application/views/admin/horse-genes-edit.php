
 <div class="row">

    <div class="col-sm-12 col-md-8">
        <div class="card mb-4">
          	<h4 class="card-header">Edit Gene</h4>
            <div class="card-body">
				<form method="post" action="/admin/horses/genes/edit/<?= $gene['genes_id'] ?>">
					<?= hf_input('genes_name', 'Gene Name', $post ?: $gene, array(), $errors) ?>
					<div class="row">
						<div class="col-sm-4">
							<?= hf_input('genes_code[0]', 'Dominant (EE)', $post['genes_code'][0] ?: $gene['genes_code1'], array(), $errors) ?>
						</div>
						<div class="col-sm-4">
							<?= hf_input('genes_code[1]', 'Heterozygous (Ee)', $post['genes_code'][1] ?: $gene['genes_code2'], array(), $errors) ?>
						</div>
						<div class="col-sm-4">
							<?= hf_input('genes_code[2]', 'Recessive (ee)', $post['genes_code'][2] ?: $gene['genes_code3'], array(), $errors) ?>
						</div>
					</div>
					<?= hf_dropdown('genes_categories_name', 'Category', $post ?: $gene['join_genes_categories_name'], $genes_categories, array(), $errors, 1) ?>
					<?= hf_checkbox('genes_required', 'Is this a required gene for all horses? (such as height)', $post ?: $gene, array(), $errors, 1) ?><br/>

					<?= hf_textarea('genes_notes', 'Notes', $post ?: $gene, array('class' => 'col-sm-12', 'placeholder' => '', 'rows' => '2'), $errors) ?>
					<?= hf_submit('save', 'Save Changes', array('class' => 'btn btn-primary col-sm-12')) ?>
				</form>
			</div>
		</div>
	</div>


    <div class="col-sm-12 col-md-4">
        <div class="card mb-4">
          	<h4 class="card-header">Blueprints</h4>
            <div class="card-body">
            	<? foreach((array)$gene['blueprints'] AS $bp): ?>
            		<a href="/admin/horses/genes/blueprints/edit/<?= $bp['genes_blueprints_id'] ?>"><?= $bp['genes_blueprints_name'] ?></a><br/>
            	<? endforeach; ?>
            </div>
        </div>
    </div>

</div>