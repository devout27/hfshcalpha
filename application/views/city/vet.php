
<?
$post = $this->session->flashdata('post');
$errors = $this->session->flashdata('errors');
?>
<div class="row">
        <div class="col-lg-12">

        <p>Welcome to the newly re-modeled and re-opened Veterinary Office! Our staff of highly trained veterinarians are here to serve you around-the-clock, with state-of-the-art surgical centers, treatment facilities and recovery rooms. </p>

        <h3>Our Services</h3>
        <p>Currently, our services range from providing vaccinations, all the way through X-rays and surgical procedures for colic.</p>

<table>
<tr><th>Procedure</th><th>Pricing</th></tr>
<tr><td>Required Annual Care</td><td>$300.00</td></tr>
<tr><td>Disaster Care Package</td><td>$2000.00</td></tr>
</table><br/>

<p>The Required Care Package replaces the individual options, Annual Wellness Package, Stallion Wellness Program and Broodmare Wellness Program. It includes all required care (health certificate, vaccines, dental floating and worming) on an annual basis (required once per year for all horses). In addition, this package provides the following:<p>
<ul>
	<li>Youngstock: includes all initial vaccines and their repeats</li>
	<li>Pre-competition: includes xrays and other pre-competiton assessments</li>
	<li>Competition: includes basic lameness workups</li>
	<li>Studs: includes tests for transmissable viral diseases and hazard pay for stallion handling</li>
	<li>Broods: includes pre and postnatal care</li>
</ul>

<b>Notes:</b><br/>
<p>All expiration dates are determined by the date the appointment was scheduled, NOT when it was processed.
Any and all previous care packages, vaccines etc are valid until their regular expiration date - the RCP is not required until current care expires.</p>

<div class="row">
	<div class="offset-md-2 col-md-8">
          <div class="card mb-4">
            <div class="card-body">
		<? if(!$horse['horses_id']): ?>
			Please go to your horse's page and choose Vet to send your horse to the Vet.
		<? else: ?>
				<form method="post" action="/horses/vet/<?= $horse['horses_id'] ?>">
				<?= hf_dropdown('horses_id', 'Horse', $_POST, $owned_horses, array(), $errors, 1) ?>
				<?= hf_dropdown('appointment', 'Appointment Type', $_POST, array('Required Annual Care', 'Disaster Care Package'), array(), $errors, 1) ?>
            </div>
            <div class="card-footer text-muted">
				<?= hf_submit('vet', 'Setup Appointment', array('class' => 'btn btn-primary col-sm-12')) ?>
				</form>
      <? endif; ?>
            </div>
          </div>
    </div>
</div>


<? if($this->data['player']['players_vet']): ?>
<br/>
<div class="row">
	<div class="col-md-12">
        <div class="card mb-4">
			<h5 class="card-header">Pending Appointments</h5>
			<div class="card-body">
				<? $this->load->view('partials/vet-table', array('appts' => $appts, 'title' => 'search')); ?>
        	</div>
        </div>
    </div>
</div>

<? endif; ?>

        </div>

</div>