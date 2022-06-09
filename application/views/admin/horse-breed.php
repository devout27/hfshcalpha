
<div class="row">
	<div class="col-md-12">

		<p>Here's a list of pending accepted breeding requests.</p>

		<div class="row">
			<div class="col-sm-12">
				<table class="table table-sm table-hover w-100 no-wrap">
		    		<thead>
					<tr>
						<th scope="col">Parents</th>
						<th scope="col">Actions</th>
					</tr>
					</thead>
					<tbody>
						<? foreach((array)$breedings AS $horse): ?>
						<tr>
							<?
								// hacky way to swap errors for only the applicable horse :/
								if($horse['horses_id'] == $post['horses_id']){
									$errors = $this->session->flashdata('errors');								
								}else{
									$errors = "";
								}
							?>
							<form method="post" action="/admin/horses/breed">
				        <td><b>STALLION<br/><a href="/horses/view/<?= $horse['horses_id'] ?>"><?= $horse['horses_name'] ?> #<?= generateId($horse['horses_id']) ?></a></b><br/>
				        	Owned by <a href="/game/profile/<?= $horse['join_players_id'] ?>"><?= $horse['p1_nickname'] ?> #<?= $horse['join_players_id'] ?></a><br/>
				        	<?= $horse['horses_birthyear'] ?> <?= $horse['horses_gender'] ?> <?= $horse['horses_breed'] ?>
				        <br/><br/><b>MARE<br/><a href="/horses/view/<?= $horse['h2_id'] ?>"><?= $horse['h2_name'] ?> #<?= $horse['h2_id'] ?></a></b><br/>
				        	Owned by <a href="/game/profile/<?= $horse['p2_id'] ?>"><?= $horse['p2_nickname'] ?> #<?= $horse['p2_id'] ?></a><br/>
				        	<?= $horse['h2_birthyear'] ?> <?= $horse['h2_gender'] ?> <?= $horse['h2_breed'] ?>
				        <br/><br/><b>FOAL</b><br/>				         
								<b>Owner :</b> <?= $horse['horses_breedings_owner_nickname'].' #'.$horse['horses_breedings_owner'] ?><br/>
								<b>Name :</b> <?= $horse['horses_breedings_name'] ?><br/>
								<b>Gender :</b> <?= $horse['horses_breedings_gender'] ?><br/>
								<b>Birth Year: </b><?= $horse['horses_birthyear'] ?><br/> 
								<b>Breeding Fee: </b>$<?= number_format($horse['horses_breedings_fee']) ?><br/>
								<b>Breeding Date : </b><?= $horse['horses_breedings_date'] ?><br/> 
				        </td>
				        <td width="60%">
									<?= hf_hidden('horses_id', $horse['horses_id']) ?>
									<?= hf_hidden('horses_breedings_id', $horse['horses_breedings_id']) ?>
									<div class="row">
										<div class="col-sm-6">
											<?= hf_dropdown('horses_breedings_breed', 'Breed', $horse, $breeds, array(), $errors, 1) ?>
										</div>
										<div class="col-sm-6">
											<?= hf_input('horses_breedings_breed2', 'Secondary Breed/Pattern (optional)', $horse, array(), $errors) ?>
										</div>
									</div>
									<div class="row">
										<!-- <div class="col-sm-6">
											<? //hf_dropdown('horses_breedings_color', 'Base Color', $horse, $horse['genes']['blueprints_available']['Color'], array(), $errors, 1) ?>
										</div>
										<div class="col-sm-6">
											<? //hf_dropdown('horses_breedings_pattern', 'Pattern Color', $horse, $horse['genes']['blueprints_available']['Pattern'], array(), $errors, 1) ?>
										</div> -->
										<div class="col-sm-6">
											<?= hf_dropdown('horses_breedings_color', 'Base Color', $horse, $base_colors, array(), $errors, 1) ?>
										</div>
										<div class="col-sm-6">
											<?= hf_dropdown('horses_breedings_pattern', 'Pattern Color', $horse, $base_patterns, array(), $errors, 1) ?>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6">
											<?= hf_dropdown('horses_breedings_line', 'Line (optional)', $horse, $lines, array(), $errors, 1) ?>
										</div>
										<div class="col-sm-6">
											<?= hf_multiselect('horses_breedings_disciplines[]', 'Discipline', explode(',', $horse['horses_breedings_disciplines']), $disciplines, array(), $errors, 1) ?>
										</div>
									</div>
									Message to Players (optional):
									<?= hf_textarea('body', '', $post, array('class' => 'col-sm-12', 'placeholder' => '', 'rows' => '6'), $errors) ?>
									<br/>
									<div class="col-xs-12 button-wrapper">
										<?= hf_submit('accept', 'Accept Breeding', array('class' => 'btn btn-success col-md-5 float-left')) ?>
										<?= hf_submit('reject', 'Reject ', array('class' => 'btn btn-danger col-md-5 offset-md-2')) ?>
									</div>										
        				</td>
							</form>
						</tr>
						<? endforeach; ?>
					</tbody>
				</table>
		    </div>
		</div>
		<br/>
	</div>
</div>