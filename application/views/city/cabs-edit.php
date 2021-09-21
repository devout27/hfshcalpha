<script>
  tinymce.init({
    selector: '#cabs_content',
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


  <form method="post" action="/city/cabs/edit/<?= $cabs['cabs_id'] ?>">
    <textarea id="cabs_content" name="cabs_content"><?= $cabs['cabs_content'] ?></textarea>

	<?= hf_submit('save', 'Save Changes', array('class' => 'btn btn-primary col-sm-12')) ?>
  </form>
  <br/>