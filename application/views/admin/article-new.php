<script>
  tinymce.init({
    selector: '#articles_content',
    height: 300,
    menubar: ' edit view format insert table tools',
    plugins: 'code textcolor colorpicker link lists searchreplace spellchecker preview table',
  	toolbar: 'undo redo styleselect bold italic forecolor backcolor link alignleft aligncenter alignright bullist numlist outdent indent code preview',
  	statusbar: false,
  });
  </script>

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


  <form method="post" action="/admin/articles/add">
	<?= hf_hidden('articles_type', 'Admin') ?>
  	<?= hf_input('articles_name', 'Article Name', $_POST, array(), $errors) ?>

    <textarea id="articles_content" name="articles_content"><?= $_POST['articles_content'] ?></textarea>

	<?= hf_submit('create', 'Create Article', array('class' => 'btn btn-primary col-sm-12')) ?>
  </form>
  <br/>