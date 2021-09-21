
<?
$post = $this->session->flashdata('post');
$errors = $this->session->flashdata('errors');
?>
<div class="row">
        <div class="col-lg-12">
        	<br/>

          <div class="card mb-4">
            <div class="card-body">
              <p class="card-text">
              	You may put this horse up for auction by filling out this form. <b>This action is irreversible, so if someone bids on the auction, the horse will be sold to the highest bidder.</b> If no one bids, the horse will remain yours once the auction closes. Please be 100% sure you want to sell your horse before you place it up for auction!<br/>
				<form method="post" action="/horses/auction/<?= $horse['horses_id'] ?>">
				<?= hf_input('min_bid', 'Minimum Bid', $post, array('placeholder' => '100'), $errors) ?>
				<?= hf_input('bid_increment', 'Bid Increment', $post, array('placeholder' => '10'), $errors) ?>
				<?= hf_input('auction_ends', 'Days Until Close', $post, array('placeholder' => '21'), $errors) ?>
				<?= Bank::list_accounts_dropdown($this->session->userdata('players_id'), 'join_bank_id', 'Deposit to:', NULL, $errors, 'Checking'); ?>
              </p>
            </div>
            <div class="card-footer text-muted">
				<?= hf_submit('auction', 'Auction Horse', array('class' => 'btn btn-primary col-sm-12')) ?>
				</form>
            </div>
          </div>





        </div>

</div>