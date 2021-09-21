<?
$errors = $this->session->flashdata('errors');
$post = $this->session->flashdata('post');
?>

<div class="row">
	<div class="col-md-12">
		<div class="card">
            <div class="card-body">
			<form method="post" action="/admin/bank/transfer">

				<?= hf_input('admin_transfer_from', 'From Account', $post ?: ADMIN_BANK_ID, array(), $errors) ?>
				<?= hf_input('admin_transfer_id', 'To Account', $post, array(), $errors) ?>
				<?= hf_input('admin_transfer_amount', 'Amount', $post, array(), $errors) ?>
				<?= hf_input('admin_transfer_memo', 'Memo', $post, array(), $errors) ?>

			</div>
            <div class="card-footer">
				<?= hf_submit('admin_transfer_money', 'Initiate Transfer', array('class' => 'btn btn-primary col-sm-12')) ?>
			</form>
			</div>
		</div>
		<br/>
	</div>
</div>



