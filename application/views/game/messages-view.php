<? $this->load->view('partials/msg-navbar', $this->data); ?>



<div class="container">
	<h4 class="center"><?= $msgs[0]['messages_subject'] ?></h4>
	<? foreach($msgs AS $msg): ?>
		<? if($msg['messages_sender'] != $this->session->userdata('players_id')): ?>
			<div class="row">
				<div class="col-sm-12 col-md-8">
		            <div id="tb-testimonial" class="testimonial testimonial-primary">
		                <div class="testimonial-section testimonial-section-one">
		                	<div class="testimonial-writer-name"><a href="/game/profile/<?= $msg['messages_sender'] ?>"><?= $msg['p2_name'] ?></a></div>
	                    	<?= $msg['messages_body'] ?>

		                	<div class="row">
		                		<div class="col-md-4 offset-md-8">
		                			<div class="extra-small-text"><?= $msg['messages_date_formatted'] ?></div>
		                		</div>
		                	</div>

		            	</div>
		            </div>
				</div>
			</div>

		<? else: ?>
			<div class="row">
				<div class="col-sm-12 offset-md-4 col-md-8">
		            <div id="tb-testimonial" class="testimonial testimonial-default">
		                <div class="testimonial-section testimonial-section-two">
		                	<div class="testimonial-writer-name"><a href="/game/profile/<?= $msg['messages_sender'] ?>"><?= $msg['p2_name'] ?></a></div>
	                    	<?= $msg['messages_body'] ?>

		                	<div class="row">
		                		<div class="col-md-4 offset-md-8">
		                			<div class="extra-small-text"><?= $msg['messages_date_formatted'] ?></div>
		                		</div>
		                	</div>
		            	</div>
		            </div>
				</div>
			</div>
		<? endif; ?>
	<? endforeach; ?>

</div>


<div class="container">

          <div class="card my-4">
            <h5 class="card-header">Reply to <?= $msgs[0]['messages_subject'] ?></h5>
            <div class="card-body">

	<form method="post" action="/game/messages/reply/<?= $msgs[0]['messages_id'] ?>">
	<?= hf_textarea('messages_body', '', $this->session->flashdata('post'), array('class' => 'col-sm-12', 'placeholder' => 'Sounds great!', 'rows' => '10'), $this->session->flashdata('errors')) ?>
	<?= hf_submit('respond', 'Send Message', array('class' => 'btn btn-primary col-sm-12')) ?>
	</form>
            </div>
          </div>
</div>



<?
/*
delete message
BUG: invalid inbox count + invalid header inbox count due to normalization and stuff
*/
?>