
<div class="row">
	<div class="col-md-12">

		<p>Here's a list of horses waiting to be imported.</p>

		<div class="row">
			<div class="col-sm-12">
				<table class="table table-sm table-hover w-100 no-wrap">
		    		<thead>
					<tr>
		    			<th>Horse</th>
		    			<th>Actions</th>
					</tr>
					</thead>
					<tbody>
						<? foreach((array)$horses AS $horse): ?>
						<tr>
							<td >

              <b><?= $horse['horses_competition_title'] ?> <?= $horse['horses_breeding_title'] ?> <?= $horse['horses_name'] ?></b><br/>
              <?= $horse['horses_birthyear'] . " " . $horse['horses_color'] . " " . $horse['horses_breed'] . " " . $horse['horses_gender'] . "<br/><i>" . $horse['horses_pattern'] . "</i> " . $horse['horses_breed2'] ?><br/><br/>
<? if($horse['horses_sire'] != 0): ?>
	Sire: <a href="/horses/view/<?= $horse['horses_sire'] ?>"><?= $horse['horses_sire_name'] ?> #<?= $horse['horses_sire'] ?></a><br/>
	Dam: <a href="/horses/view/<?= $horse['horses_dam'] ?>"><?= $horse['horses_dam_name']  ?> #<?= $horse['horses_dam'] ?></a><br/><br/>
<? else: ?>
	Sire: N/A<br/>
	Dam: N/A<br/>
<? endif; ?>
Owner: <a href="/game/profile/<?= $horse['join_players_id'] ?>"><?= $horse['players_nickname'] . " #" . $horse['join_players_id'] ?></a><br/>
Stable: <a href="/game/stables/<?= $horse['join_stables_id'] ?>"><?= $horse['stables_name'] . " #" . $horse['join_stables_id'] ?></a><br/><br/>
<?= date('Y') - $horse['horses_birthyear'] ?> years old<br/>
Breeding Years: <?= ($horse['horses_birthyear'] + 3) ?> to <?= ($horse['horses_birthyear'] + 32) ?> inclusive<br/><br/>
Disciplines:
<? foreach((array)$horse['disciplines'] AS $k => $d): ?>
	<?= $d['disciplines_name'] ?><br/>
<? endforeach; ?>
<? if(!$d['disciplines_name']): ?>
	<i>None</i>
<? endif; ?>


			              	</td>
        					<td width="40%">

<form method="post" action="/admin/horses/import">
	<?= hf_hidden('horses_id', $horse['horses_id']) ?>
	Message to Player (optional):
	<?= hf_textarea('body', '', $post, array('class' => 'col-sm-12', 'placeholder' => '', 'rows' => '6'), $errors) ?>
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
