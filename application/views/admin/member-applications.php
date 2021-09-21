
<div class="row">
	<div class="col-md-12">

		<p>Here's a list of pending member applications.</p>

		<div class="row">
			<div class="col-sm-12">
				<table class="table table-sm table-hover w-100 no-wrap">
		    		<thead>
					<tr>
		    			<th>Application</th>
		    			<th>Actions</th>
					</tr>
					</thead>
					<tbody>
						<? foreach((array)$pending_applications AS $a): ?>
						<tr>
							<td ><?= $a['players_nickname'] ?> #<?= $a['players_id'] ?></a><br/><small class="text-muted"><?= $a['players_join_date2'] ?></small><br/><br/>
								<b>Email</b><br/>
								<?= $a['players_email'] ?><br/><br/>

								<? foreach($a['questions'] AS $q): ?>
									<b><?= $q['questions_question'] ?></b><br/>
									<?= $q['players_x_questions_answer'] ?><br/><br/>
								<? endforeach ?>

			              	</td>
        					<td width="40%">

<form method="post" action="/admin/members/applications/process">
	<?= hf_checkbox('send_email_checkbox', 'Send email with accept/reject?', $post['purpose'][0], array(), $errors, 1) ?>
	<?= hf_hidden('players_id', $a['players_id']) ?>
	<div id="email_body_div">
		<?= hf_textarea('body', '', $post, array('class' => 'col-sm-12', 'placeholder' => '', 'rows' => '6'), $errors) ?>
	</div>
	<br/>
	<div class="col-xs-12 button-wrapper">
		<?= hf_submit('accept', 'Accept', array('class' => 'btn btn-success col-md-5 float-left')) ?>
		<?= hf_submit('reject', 'Reject', array('class' => 'btn btn-danger col-md-5 offset-md-2')) ?>
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
