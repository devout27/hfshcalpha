
<div class="row">
    <div class="col-md-7 col-lg-8 col-xl-9">
    	<?= $article['articles_content'] ?>
    </div>

    <div class="col-md-5 col-lg-4 col-xl-3">
        <div class="card mb-4">
          	<h4 class="card-header">Your Credits</h4>
            <div class="card-body">
				<table width=100%>
					<tr>
						<td><b>Adoption</b></td>
						<td><?= $player['players_credits_adoptathon'] ?: '0' ?></td>
					</tr>
					<tr>
						<td><b>Creation</b></td>
						<td><?= $player['players_credits_creation'] ?: '0' ?></td>
					</tr>
				</table>
            </div>
        </div>
    </div>


</div>

