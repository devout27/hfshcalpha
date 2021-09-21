
<div class="row">
	<div class="col-md-12">

		<p>Here's a list of horses waiting to be exported.</p>

		<div class="row">
			<div class="col-sm-12">
				<table class="table table-sm table-hover w-100 no-wrap">
		    		<thead>
					<tr>
						<th scope="col">ID</th>
						<th scope="col">Name</th>
						<th scope="col">Born</th>
						<th scope="col">Gender</th>
						<th scope="col">Breed</th>
		    			<th>Actions</th>
					</tr>
					</thead>
					<tbody>
						<? foreach((array)$horses AS $horse): ?>
						<tr>

<?
// hacky way to swap errors for only the applicable horse :/
if($horse['horses_id'] == $post['horses_id']){
	$errors = $this->session->flashdata('errors');
	$horse = $post;
}else{
	$errors = "";
}
?>

<form method="post" action="/admin/horses/export">
				        <td><a href="/horses/view/<?= $horse['horses_id'] ?>"><?= $horse['horses_id'] ?></a></td>
				        <td><a href="/horses/view/<?= $horse['horses_id'] ?>"><?= $horse['horses_name'] ?></a></td>
				        <td><?= $horse['horses_birthyear'] ?></td>
				        <td><?= $horse['horses_gender'] ?></td>
				        <td><?= $horse['horses_breed'] ?></td>

        					<td width="40%">

	<?= hf_hidden('horses_id', $horse['horses_id']) ?>
	Message to Player (optional):
	<?= hf_textarea('body', '', $post, array('class' => 'col-sm-12', 'placeholder' => '', 'rows' => '6'), $errors) ?>
	<br/>
	<div class="col-xs-12 button-wrapper">
		<?= hf_submit('accept', 'Confirm Export', array('class' => 'btn btn-success col-md-5 float-left')) ?>
		<?= hf_submit('reject', 'Reject ', array('class' => 'btn btn-danger col-md-5 offset-md-2')) ?>
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
