
<div class="row">
	<div class="col-sm-12">
	  	<form method="post" action="/admin/mods/add">
			<?= hf_input('players_id', 'Player ID', $post, array(), $errors) ?>

		<div class="card mb-4">
		  	<h5 class="card-header">Privileges</h5>
		    <div class="card-body">
				<?= hf_checkbox('privileges_admin', 'Master Admin <small>Can add/edit/remove other admins</small>', $post, array(), $errors) ?>
				<?= hf_checkbox('privileges_news', 'Edit News', $post, array(), $errors) ?>
				<?= hf_checkbox('privileges_adoption', 'Adopt-a-Thon', $post, array(), $errors) ?>
				<?= hf_checkbox('privileges_members', 'Member Management', $post, array(), $errors) ?>
				<?= hf_checkbox('privileges_bank', 'Bank Management', $post, array(), $errors) ?>
				<?= hf_checkbox('privileges_articles', 'Articles', $post, array(), $errors) ?>
				<?= hf_checkbox('privileges_horses', 'Horses', $post, array(), $errors) ?>
				<?= hf_checkbox('privileges_cabs', 'CABs', $post, array(), $errors) ?>
			</div>
		</div>

		<?= hf_submit('add', 'Add Administrator', array('class' => 'btn btn-primary col-sm-12')) ?>
	  	</form>
  	</div>
</div>

<br/>