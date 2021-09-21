
 <div class="row">


    <div class="col-md-12 col-xl-8">
        <div class="card mb-4">
          	<h4 class="card-header">List of Blueprints</h4>
            <div class="card-body">
				<div class="row">
					<div class="col-sm-12">
<div class="container-fluid">
    <div class="table-responsive">
<table class="table table-sm table-hover" id="dt-admin-blueprints">
  <thead>
    <tr>
      <th scope="col">Blueprint</th>
      <th scope="col">Category</th>
      <th scope="col">Genes</th>
      <th scope="col">Special</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
  	<? foreach((array)$blueprints AS $b): ?>
    <tr>
      <td><?= $b['genes_blueprints_name'] ?></td>
      <td><?= $b['join_genes_categories_name'] ?></td>
      <td><?= count($b['genes']) ?></td>
      <td><?= $b['genes_blueprints_special'] ? 'Yes' : 'No' ?></td>
      <td><a href="/admin/horses/genes/blueprints/edit/<?= $b['genes_blueprints_id'] ?>"><button type="button" class="btn btn-primary">Edit</button></a></td>
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

    <div class="col-md-6 col-xl-4">
        <div class="card mb-4">
          	<h4 class="card-header">Add Blueprint</h4>
            <div class="card-body">
				<div class="row">
					<div class="col-sm-12">
						<form method="post" action="/admin/horses/genes/blueprints">
							<?= hf_input('genes_blueprints_name', 'Blueprint Name', $post, array(), $errors) ?>
							<?= hf_dropdown('join_genes_categories_name', 'Category', $post ?: 'Color', $genes_categories, array(), $errors, 1) ?>
							<?= hf_checkbox('genes_blueprints_special', 'Is this a special blueprint?', $post['genes_blueprints_special'], array(), $errors, 1) ?>
							<?= hf_textarea('genes_blueprints_description', 'Description', $post, array('class' => 'col-sm-12', 'placeholder' => '', 'rows' => '4'), $errors) ?>
							<?= hf_submit('a_blueprint', 'Add Blueprint', array('class' => 'btn btn-primary col-sm-12')) ?>
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>

    <div class="col-md-6 col-xl-6">
        <div class="card mb-4">
          	<h4 class="card-header">Remove Blueprint</h4>
            <div class="card-body">
				<div class="row">
					<div class="col-sm-12">
						<form method="post" action="/admin/horses/genes/blueprints">
							<?= hf_dropdown('remove_blueprint', 'Blueprint', $post, $blueprints_normalized, array(), $errors) ?>
							<?= hf_submit('r_blueprint', 'Remove Blueprint', array('class' => 'btn btn-primary col-sm-12')) ?>
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>