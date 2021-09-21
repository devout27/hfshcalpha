
<?
$post = $this->session->flashdata('post');
$errors = $this->session->flashdata('errors');
?>
<div class="row">
        <div class="col-lg-12">
        	<br/>

          <div class="card mb-4">
            <div class="card-body">
              <h2 class="card-title">Transfer Horse</h2>
              <p class="card-text">
              	<b>Please only select Export if you have received payment for your horse from HFSHC Export Brokerage Firm, otherwise horse may be forfeited. </b><br/>
				<form method="post" action="/horses/transfer/<?= $horse['horses_id'] ?>">
				<?= hf_dropdown('recipient', 'Recipient', $_POST, $recipients, array(), $errors, 1) ?>
				<?= hf_input('players_id', 'Member ID', $_POST, array('placeholder' => ''), $errors) ?>
              </p>
            </div>
            <div class="card-footer text-muted">
				<?= hf_submit('transfer', 'Transfer Horse', array('class' => 'btn btn-primary col-sm-12')) ?>
				</form>
            </div>
          </div>





        </div>

</div>