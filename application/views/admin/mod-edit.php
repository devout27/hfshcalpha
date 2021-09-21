	<? if($this->session->flashdata('errors')): ?>
	<div class="center">
		<p class="error center">
			<? if(is_array($this->session->flashdata('errors'))): ?>
				<? foreach($this->session->flashdata('errors') AS $k): ?>
					<? if(is_array($k)): ?>
						<? foreach($k AS $v): ?>
							<?= $v ?><br/>
						<? endforeach; ?>
					<? else: ?>
						<?= $k ?><br/>
					<? endif; ?>
				<? endforeach; ?>
			<? else: ?>
				<?= $this->session->flashdata('errors'); ?>
			<? endif; ?>
		</p>
	</div>
	<? endif; ?>
<div class="row">
	<div class="col-md-12">
		<a href="/admin/mods/delete/<?= $admin['players_id'] ?>" class="float-right btn btn-danger col-md-4">Remove Admin Privileges</a>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
	  	<form method="post" action="/admin/mods/edit/<?= $admin['players_id'] ?>">
			<?= hf_input('players_id', 'Player ID', $admin['players_id'], array('disabled' => 'true'), $errors) ?>

		<div class="card mb-4">
		  	<h5 class="card-header">Privileges</h5>
		    <div class="card-body">
				<?= hf_checkbox('privileges_admin', 'Master Admin <small>Can add/edit/remove other admins</small>', $admin['privileges']['privileges_admin'], array(), $errors) ?>
				<?= hf_checkbox('privileges_news', 'Edit News', $admin['privileges']['privileges_news'], array(), $errors) ?>
				<?= hf_checkbox('privileges_adoption', 'Adopt-a-Thon', $admin['privileges']['privileges_adoption'], array(), $errors) ?>
				<?= hf_checkbox('privileges_members', 'Member Management', $admin['privileges']['privileges_members'], array(), $errors) ?>
				<?= hf_checkbox('privileges_bank', 'Bank Management', $admin['privileges']['privileges_bank'], array(), $errors) ?>
				<?= hf_checkbox('privileges_articles', 'Articles', $admin['privileges']['privileges_articles'], array(), $errors) ?>
				<?= hf_checkbox('privileges_horses', 'Horses', $admin['privileges']['privileges_horses'], array(), $errors) ?>
				<?= hf_checkbox('privileges_cabs', 'CABs', $admin['privileges']['privileges_cabs'], array(), $errors) ?>
				<?= hf_checkbox('privileges_events', 'Events', $admin['privileges']['privileges_events'], array(), $errors) ?>
			</div>
		</div>

		<?= hf_submit('edit', 'Update Administrator', array('class' => 'btn btn-primary col-sm-12')) ?>
	  	</form>
  	</div>
</div>

<br/>