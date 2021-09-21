
<div class="row">
	<div class="col-sm-12">
	  	<form method="post" action="/admin/members/adoptathon">

		<div class="card mb-4">
		    <div class="card-body">
				<?= hf_input('credits', 'Number of Credits', $post, array(), $errors) ?>
			</div>
			<div class="card-footer">
				<?= hf_submit('award', 'Award Credits', array('class' => 'btn btn-primary col-sm-12')) ?>
			</div>
		</div>

	  	</form>
  	</div>
</div>

<br/>