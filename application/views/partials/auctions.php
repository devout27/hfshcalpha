
<h3><?= ucfirst($type) ?></h3>
<div class="container-fluid">
    <div class="table-">
<table class="table table-sm table-hover table- no-wrap" id="dt-horses-<?= $type ?>" width=100%>
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">Bids</th>
      <th scope="col">High Bid</th>
      <th scope="col">Ends</th>
      <th scope="col">Place Bid</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
  	<? foreach((array)$horses AS $h => $horse): ?>
  		<? if(!$horse['horses_id']):
  			continue;
		endif; ?>
		<? //setup minimum bid

			$starting_bid = $horse['bids'][0]['auctions_bids_amount'] ?: $horse['auctions_starting_bid'];
			if(count($horse['bids'])){
				$suggested_bid = $starting_bid + $horse['auctions_increment'];
			}else{
				$suggested_bid = $starting_bid;
			}
		?>
    <tr>
      <td><a href="/horses/view/<?= $horse['horses_id'] ?>"><?= $horse['horses_id'] ?></a></td>
      <td><a href="/horses/view/<?= $horse['horses_id'] ?>"><?= $horse['horses_competition_title'] ?> <?= $horse['horses_breeding_title'] ?> <?= $horse['horses_name'] ?></a><br/>
      	<?= $horse['horses_birthyear'] ?> <?= $horse['horses_gender'] ?> <?= $horse['horses_breed'] ?>
      </td>
      <td><?= count($horse['bids']) ?></td>

      <td>
	      	$<?= number_format($horse['bids'][0]['auctions_bids_amount'] ?: $starting_bid) ?><br/><font color=gray>+$<?= $horse['auctions_increment'] ?></font>
	      	<? if($horse['bids'][0]['join_players_id'] == $player['players_id']): ?>
	      	<br/><font color=green><i><small>You have the high bid.</small></i></font><br/>
	      	<? endif; ?>
      </td>
      <td><?= $horse['auctions_end'] ?></td>
<form method="post" action="/city/colosseum/<?= $type ?>">
		<?
		if($post['join_auctions_id'] == $horse['auctions_id']){
			$errors2 = $this->session->flashdata('errors');
			$post2 = $this->session->flashdata('post');
		}else{
			$errors2 = NULL;
			$post2 = NULL;
		}
		?>
			<?= hf_hidden('join_auctions_id', $horse['auctions_id']) ?>
      <td style="max-width: 100px">
			<?= $bank_accounts ?>
			<?= hf_input('auctions_bids_amount', '', $post2, array('placeholder' => $suggested_bid), $errors2) ?>
		</td>
		<td>
			<?= hf_submit('bid', 'Place Bid', array('class' => 'btn btn-success float-left')) ?>
      </td>
</form>
    </tr>
	<? endforeach; ?>
  </tbody>
</table>
</div>
</div>