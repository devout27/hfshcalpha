
<div>
	<form method="post" action="/game/messages">
	<?= hf_input('messages_2', 'Send to Player #', $this->session->flashdata('post'), array('placeholder' => '345'), $this->session->flashdata('errors')) ?>
	<?= hf_input('messages_subject', 'Subject', $this->session->flashdata('post'), array('placeholder' => 'A Friendly Hello!'), $this->session->flashdata('errors')) ?>
	<?= hf_textarea('messages_body', 'Body', $this->session->flashdata('post'), array('class' => 'col-sm-12', 'placeholder' => 'You\'re an awesome person!', 'rows' => '10'), $this->session->flashdata('errors')) ?>
	<?= hf_submit('send_message', 'Send Message', array('class' => 'btn btn-primary col-sm-12')) ?>
	</form>
</div>
