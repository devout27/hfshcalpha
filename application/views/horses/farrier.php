
<?
$post = $this->session->flashdata('post');
$errors = $this->session->flashdata('errors');
?>
<div class="row">
        <div class="col-lg-12">

        <p>Welcome to Farrier Office! Here you may schedule a farrier visit for your horses, plus you can search all past farrier records and pending appointments.</p>

        <h3>Our Services</h3>
        <p>Our professionally trained farriers specialize in many different types of shoeing, including corrective shoeing for navicular, laminitis and other ailments, plus shoeing for the gaited, race and competition horse. </p>


<p>Every horse must have one of the below required annual packages. Each package offers as much or as little care required based on the individual horse.<p>
<ul>
		<br>

		<li><b>Basic Care - $450/year:</b><br>
		All youngstock (age 3 and under, non-racing), non-competing horses

		<br><br></li><li><b>Performance/Race Package - $1,000/year:</b> <br>
		All horses &amp; ponies (age 3 and up) competing in any showing discipline<br>All horses (age 2 and up) competing in any racing discipline

		<br><br></li>
</ul>

<b>Notes:</b><br/>
<li>All expiration dates are determined by the date the appointment was scheduled, NOT when it was processed.</li>
<li>Any and all previous shoeing packages are valid until their regular expiration date - the new services are not required until current care expires.</li>

<div class="row">
	<div class="offset-md-2 col-md-8">
          <div class="card mb-4">
            <div class="card-body">
				<form method="post" action="/horses/farrier/<?= $horse['horses_id'] ?>">
				<?= hf_dropdown('appointment', 'Appointment Type', $_POST, array('Basic Care', 'Performance/Race Package'), array(), $errors, 1) ?>
            </div>
            <div class="card-footer text-muted">
				<?= hf_submit('farrier', 'Setup Appointment', array('class' => 'btn btn-primary col-sm-12')) ?>
				</form>
            </div>
          </div>
    </div>
</div>




        </div>

</div>