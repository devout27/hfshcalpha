
<p>
Please choose a mare to breed with this stallion. Once you have made this request, be sure to send a check to the owner of the stallion for the amount of the breeding fee. The owner will have the option to accept or reject your breeding request.
</p>
<br/>
<div class="row">

<div class="col-md-6">
        <div class="card mb-4">
          	<h5 class="card-header"><?= $horse['horses_competition_title'] ?> <?= $horse['horses_breeding_title'] ?> <?= $horse['horses_name'] ?></h5>
            <div class="card-body">
            	<?= $horse['horses_birthyear'] . " " . $horse['horses_color'] . " " . $horse['horses_breed'] . " " . $horse['horses_gender'] . "<br/><i>" . $horse['horses_pattern'] . "</i> " . $horse['horses_breed2']?><br/>
            	Stud Fee is $<?= number_format($horse['horses_breeding_fee']) ?>
            </div>
        </div>
</div>
<div class="col-md-6">
	<div class="card mb-4">		
		<h5 class="card-header">Mares</h5>	
		<div class="card-body">
			<form method="post" action="/horses/breed/<?= $horse['horses_id'] ?>">
				<? if($errors = $this->session->flashdata('errors')): ?>
					<? foreach((array)$this->session->flashdata('errors') AS $e): ?>
						<div class="form-error"><?= $e ?></div>
					<? endforeach; ?>
				<? endif; ?>
				<div class="row">
					<div class="col-md-6">
						<?= hf_dropdown('mare_id', '', $_POST, $mares, array('class' => 'col-sm-12'), $errors, 0) ?>										
					</div>
					<div class="col-md-6">
						<?= hf_submit('breed', 'Place Request', array('class' => 'btn btn-primary col-sm-12')) ?>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
</div>
<div class="row">
	<div class="col-sm-12">
        <div class="card mb-4">
          	<h5 class="card-header">Pending Requests</h5>
            <div class="card-body">
            	<table class="table table-sm table-hover no-wrap" <? /*id="dt-horses-<?= $title ?> */ ?>>
				  <thead>
				    <tr>
				      <? if($horse['join_players_id'] == $this->session->userdata('players_id')): ?>
				      	<th class="w-50"></th>
					<? endif;?>
				      <th scope="col">ID</th>
				      <th scope="col">Name</th>
				      <th scope="col">Born</th>
				      <th scope="col">Breed</th>
				      <th scope="col">Fee</th>
				      <? if($horse['join_players_id'] == $this->session->userdata('players_id')): ?>
				      	<th></th>
					<? endif;?>
				    </tr>
				  </thead>
				  <tbody>
				  	<? foreach((array)$requests AS $h): ?>
				    <tr>
				      <? if($horse['join_players_id'] == $this->session->userdata('players_id')): ?>
				      	<td class="w-50">
				      		<? if($h['horses_breedings_accepted']): ?>
				      			<i>Pending Approval<br/>
				      				<?= $h['horses_breedings_gender'] ?> to Player #<?= $h['horses_breedings_owner'] ?></i>
				      		<? else: ?>
								<form method="post" action="/horses/breed/<?= $horse['horses_id'] ?>">
								<?= hf_hidden('horses_breedings_id', $h['horses_breedings_id']) ?>
								<div class="row">
									<div class="col-sm-6">						
										<?= hf_input('horses_name', 'Name', isset($post['horses_name']) ? $post['horses_name'] : '', array(), $errors) ?>
									</div>
									<div class="col-sm-6">						
										<?= hf_input('horses_birthyear', 'Birth Year', isset($post['horses_birthyear']) ? $post['horses_birthyear'] : '', array('placeholder' => '1984'), $errors,'number') ?>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<?= hf_dropdown('horses_gender', 'Gender', isset($post['horses_gender']) ? $post['horses_gender'] : '', array('', 'Stallion', 'Mare', 'Gelding'), array(), $errors, 1) ?>
									</div>
									<div class="col-sm-6">
										<?= hf_dropdown('horses_owner', 'Owner', isset($post['horses_owner']) ? $post['horses_owner'] : '', array('', 'Me', 'Mare\'s Owner'), array(), $errors, 1) ?>
									</div>
								</div>
								<div class="row">
					<div class="col-sm-6">
						<?= hf_dropdown('horses_breed', 'Breed', isset($post['horses_breed']) ? $post['horses_breed'] : '', $breeds, array(), $errors, 1) ?>
					</div>
					<div class="col-sm-6">
						<?= hf_input('horses_breed2', 'Secondary Breed/Pattern (optional)', isset($post['horses_breed2']) ? $post['horses_breed2'] : '', array(), $errors) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<?= hf_dropdown('horses_color', ' Color', isset($post['horses_color']) ? $post['horses_color'] : '', $h['genes']['blueprints_available']['Color'], array(), $errors, 1) ?>
					</div>
					<div class="col-sm-6">
						<?= hf_dropdown('horses_pattern', 'Pattern Color', isset($post['horses_pattern']) ? $post['horses_pattern'] : '', $h['genes']['blueprints_available']['Pattern'], array(), $errors, 1) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<?= hf_dropdown('horses_line', 'Line (optional)', isset($post['horses_line']) ? $post['horses_line'] : '', $lines, array(), $errors, 1) ?>
					</div>
					<div class="col-sm-6">
						<?= hf_multiselect('disciplines[]', 'Discipline', isset($post['disciplines']) ? $post['disciplines'] : '', $disciplines, array(), $errors, 1) ?>
					</div>
				</div>
				

								<?= hf_submit('accept', 'Accept', array('class' => 'btn btn-success col-sm-12')) ?>
								</form>
							<? endif; ?>
						</td>
					<? endif;?>
				      <td><a href="/horses/view/<?= $h['horses_id'] ?>"><?= $h['horses_id'] ?></a></td>
				      <td><a href="/horses/view/<?= $h['horses_id'] ?>"><?= $h['horses_name'] ?></a></td>
				      <td><?= $h['horses_birthyear'] ?></td>
				      <td><?= $h['horses_breed'] ?></td>
				      <td>$<?= number_format($h['horses_breedings_fee']) ?></td>
				      <? if($horse['join_players_id'] == $this->session->userdata('players_id')): ?>
				      	<td>
				      		<? if(!$h['horses_breedings_accepted']): ?>
								<form method="post" action="/horses/breed/<?= $horse['horses_id'] ?>">
								<?= hf_hidden('horses_breedings_id', $h['horses_breedings_id']) ?>
								<?= hf_textarea('message', 'Message', $_POST, array('placeholder' => 'Describe why are you Reject this Breeding.','cols'=>"30","rows"=>"5"), $errors) ?>
								<?= hf_submit('reject', 'Reject', array('class' => 'btn btn-danger col-sm-12')) ?>
								</form>
							<? endif; ?>
						</td>
					<? endif;?>
				    </tr>
					<? endforeach; ?>
					<? if(!count($requests)): ?>
						<tr><td colspan=100%>No requests</td></tr>
					<? endif; ?>
				  </tbody>
				</table>
            </div>
        </div>
	</div>
</div>