<?
$errors = $this->session->flashdata('errors');
?>

<div class="row">
        <div class="offset-md-2 col-md-8 offset-md-2 ">

          <div class="card mb-4">
            <div class="card-body">
              <p class="card-text">
              	<p>You may quit the game at any time. If you choose to quit the game, an admin will be notified of your request. An admin will need to perform the actual deletion of your account (to help prevent accidental deletions). Your horses will be sent to the Humane Society. All personally identifiable information with your account will be deleted. Some aspects of your account may be preserved to ensure logs are retained (such as bank transactions).</p>
              	<p>You will have one week to cancel your request before the deletion goes through. During this time, you may click the "Cancel Request" link at the top of the page to cancel the deletion request.</p>
              	<p><b>Quitting the game and deleting your account is permanent and cannot be undone!</b></p>
				<form method="post" action="/game/quit" onsubmit="return confirm('Are you sure you want to delete your account and permanently quit the game?');">
				<?= hf_input('password', '', '', array('type' => 'password', 'placeholder' => 'Password'), $errors) ?>
				Why do you want to quit the game?<br/>
				<small>Your response is valuable and will help us improve the game in the future.</small>
				<?= hf_textarea('reason', '', $post, array('class' => 'col-sm-12', 'placeholder' => '', 'rows' => '4'), $errors) ?>
              </p>
            </div>
            <div class="card-footer text-muted center">
				<?= hf_submit('quit_now', 'Quit the Game', array('class' => 'btn btn-danger')) ?>
				</form>
            </div>
          </div>


        </div>
</div>