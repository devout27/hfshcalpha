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

<div class="row">
	<div class="col-sm-12">
		<a href="/admin/articles/delete/<?= $article['articles_id'] ?>" class="btn btn-danger col-md-2 float-right">Delete Article</a>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
  <form method="post" action="/admin/articles/<?= $article['articles_id'] ?>">
  	Article URL<br/>
  	<a href="/city/articles/<?= $article['articles_id'] ?>">/city/articles/<?= $article['articles_id'] ?></a>
  	<?= hf_input('articles_name', 'Article Name', $article['articles_name'], array(), $errors) ?>
    <textarea id="articles_content" name="articles_content"><?= $article['articles_content'] ?></textarea>

	<?= hf_submit('save', 'Save Changes', array('class' => 'btn btn-primary col-sm-12')) ?>
  </form>
  <br/>
</div>
</div>