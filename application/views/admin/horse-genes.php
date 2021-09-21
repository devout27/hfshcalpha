
 <div class="row">


    <div class="col-md-12 col-xl-6">
        <div class="card mb-4">
          	<h4 class="card-header">List of Genes</h4>
            <div class="card-body">
				<div class="row">
					<div class="col-sm-12">
<div class="container-fluid">
    <div class="table-responsive">
<table class="table table-sm table-hover" id="dt-admin-genes">
  <thead>
    <tr>
      <th scope="col">Gene</th>
      <th scope="col">Codes</th>
      <th scope="col">Category</th>
      <!--<th scope="col">Required</th>-->
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
  	<? foreach((array)$genes AS $g => $gene): ?>
    <tr>
      <td><?= $gene['genes_name'] ?></td>
      <td><?= $gene['genes_code1'] ?> <?= $gene['genes_code2'] ?> <?= $gene['genes_code3'] ?></td>
      <td><?= $gene['join_genes_categories_name'] ?></td>
      <!--<td><?= $gene['genes_required'] ? 'Yes' : 'No' ?></td>-->
      <td><a href="/admin/horses/genes/edit/<?= $gene['genes_id'] ?>"><button type="button" class="btn btn-primary">Edit</button></a></td>
    </tr>
	<? endforeach; ?>
  </tbody>
</table>
</div>
</div>
					</div>

				</div>
			</div>
		</div>
	</div>

    <div class="col-md-8 col-xl-6">
        <div class="card mb-4">
          	<h4 class="card-header">Add Gene</h4>
            <div class="card-body">
				<div class="row">
					<div class="col-sm-12">
						<form method="post" action="/admin/horses/genes">
							<?= hf_input('genes_name', 'Gene Name', $post, array(), $errors) ?>
							<div class="row">
								<div class="col-sm-4">
									<?= hf_input('genes_code[0]', 'Dominant (EE)', $post['genes_code'][0], array(), $errors) ?>
								</div>
								<div class="col-sm-4">
									<?= hf_input('genes_code[1]', 'Heterozygous (Ee)', $post['genes_code'][1], array(), $errors) ?>
								</div>
								<div class="col-sm-4">
									<?= hf_input('genes_code[2]', 'Recessive (ee)', $post['genes_code'][2], array(), $errors) ?>
								</div>
							</div>
							<?= hf_dropdown('genes_categories_name', 'Category', $post ?: 'Color', $genes_categories, array(), $errors, 1) ?>
							<?//= hf_checkbox('genes_required', 'Is this a required gene for all horses? (such as height)', $post['genes_required'], array(), $errors, 1) ?>

							<?= hf_textarea('genes_notes', 'Notes', $post, array('class' => 'col-sm-12', 'placeholder' => '', 'rows' => '2'), $errors) ?>
							<?= hf_submit('a_gene', 'Add Gene', array('class' => 'btn btn-primary col-sm-12')) ?>
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>

    <div class="col-md-4 col-xl-6">
        <div class="card mb-4">
          	<h4 class="card-header">Remove Gene</h4>
            <div class="card-body">
				<div class="row">
					<div class="col-sm-12">
						<form method="post" action="/admin/horses/genes">
							<?= hf_dropdown('remove_gene', 'Gene', $post, $genes_normalized, array(), $errors) ?>
							<?= hf_dropdown('remove_gene2', 'What gene should these become?', $post, array('none' => 'none') + $genes_normalized, array(), $errors) ?>
							<?= hf_submit('r_gene', 'Remove Gene', array('class' => 'btn btn-primary col-sm-12')) ?>
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
    <div class="col-md-6 col-xl-4">
        <div class="card mb-4">
          	<h4 class="card-header">Add Gene Category</h4>
            <div class="card-body">
				<div class="row">
					<div class="col-sm-12">
						<form method="post" action="/admin/horses/genes">
							<?= hf_input('genes_categories_name', 'Category Name', $post, array(), $errors) ?>
							<?= hf_submit('a_category', 'Add Category', array('class' => 'btn btn-primary col-sm-12')) ?>
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>


    <div class="col-md-6 col-xl-4">
        <div class="card mb-4">
          	<h4 class="card-header">Remove Gene Category</h4>
            <div class="card-body">
				<div class="row">
					<div class="col-sm-12">
						<form method="post" action="/admin/horses/genes">
							<?= hf_dropdown('genes_categories_name', 'Gene', $post, $genes_categories, array(), $errors, 1) ?>
							<?= hf_dropdown('genes_categories_name2', 'What category should these genes become?', $post, $genes_categories, array(), $errors, 1) ?>
							<?= hf_submit('r_category', 'Remove Category', array('class' => 'btn btn-primary col-sm-12')) ?>
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>


