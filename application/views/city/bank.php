

<p>Welcome to the Grand Bank of HFSHC! We provide top quality service for all of your banking needs, and hope that you will enjoy each banking session. If you have any problems, concerns, or suggestions, please feel free to contact the Bank President at any time.
</p>

<p>The system is unique in that it looks and feels much like the online banking areas of real banks and offers an extensive amount of options, including automatic payments, instant statements, and automatic monthly income.</p>


<div class="row">
	<div class="col-sm-12">
		<table class="table table-sm table-hover w-100 no-wrap">
    		<thead>
			<tr>
    			<th>Account</th>
    			<th>Type</th>
    			<th>Status</th>
    			<th>Balance</th>
    			<th>Available</th>
			</tr>
			</thead>
			<tbody>
				<? foreach((array)$accounts AS $a): ?>
				<tr>
					<td><?= $a['bank_default'] == 1 ? '*' : '' ?> <a href="/city/bank/<?= $a['bank_id'] ?>"><?= $a['bank_nickname'] ?> #<?= $a['bank_id'] ?></a></td>
					<td><?= $a['bank_type'] ?></td>
					<td><?= $a['bank_status'] ?></td>
					<td>$<?= number_format($a['bank_balance']) ?></td>
					<? if($a['bank_type'] != "Loan"): ?>
						<td>$<?= number_format($a['bank_available_balance']) ?></td>
					<? else: ?>
						<td>$<?= $a['bank_balance'] == $a['bank_credit_limit'] ? number_format($a['bank_available_balance']) : number_format($a['bank_credit_limit'] - $a['bank_balance']) ?></td>
					<? endif; ?>
				</tr>
				<? endforeach; ?>
			</tbody>
		</table>

			<div class="float-right">
				<a href="/city/bank/transfer" class="btn btn-primary">Transfer Money</a>
			</div>
    </div>
</div>



<br/><br/>
<div class="row">
	<div class="col-md-12">
		<h3>Checking Accounts</h3>

		<p>With the advent of the online system, there is no longer a need to open a checking account, as it done for you when your membership is processed.</p>
		<p>Your personal checking account is what you will use on a day-to-day basis and where your $10,000 monthly income will be paid to. For full instructions on dealing with checks, please see the Online Accounting FAQ.</p>
	</div>
	<div class="col-md-0">
        <!--<div class="card mb-4">
          	<h5 class="card-header">Open Checking Account</h5>
            <div class="card-body">
            </div>
        </div>-->
    </div>
</div><br/>



<div class="row">
	<div class="col-md-6">
<h3>Savings Accounts</h3>

<p>If you would like a personal savings account to help keep your finances organized, you may make your request using the below form. Please note that requests are not automatically approved and you must await for a response from the bank.</p>
<p>Savings accounts earn .01% APR.</p>

	</div>
	<div class="col-md-6">
        <div class="card mb-4">
          	<h5 class="card-header">Open Savings Account</h5>
            <div class="card-body">

				<form method="post" action="/city/bank/open_account">
					<? if($this->session->flashdata('errors')['savings_general']): ?>
						<div class="form-error"><?= $this->session->flashdata('errors')['savings_general'] ?></div>
					<? endif; ?>
					<?= hf_submit('open_savings', 'Open Savings Account', array('class' => 'btn btn-primary col-sm-12')) ?>
				</form>
            </div>
        </div>
    </div>
</div>
<br/>

<div class="row">
	<div class="col-md-6">
<h3>Business Accounts</h3>

<p>If you are a stable, association, or business owner and would like to open an additional checking account to keep your finances organized, you may make your request using the below form. Please note that requests are not automatically approved and you must await for a response from the bank.</p>


	</div>
	<div class="col-md-6">
        <div class="card mb-4">
          	<h5 class="card-header">Open Business Account</h5>
            <div class="card-body">

				<form method="post" action="/city/bank/open_account">
					<? if($this->session->flashdata('errors')['business_general']): ?>
						<div class="form-error"><?= $this->session->flashdata('errors')['business_general'] ?></div>
					<? endif; ?>
					<?= hf_submit('open_business', 'Open Business Account', array('class' => 'btn btn-primary col-sm-12')) ?>
				</form>
            </div>
        </div>
    </div>
</div>




<br/><br/>
<h3>Loan Accounts</h3>

<p>Are you planning the purchase of a new farm? How about property to build a farm? Maybe there's this really expensive horse you want, but just don't have the money for? Well now you can have all you've ever wanted and more!! The Grand Bank of HFSHC will consider granting cash loans for the following:</p>
<ul>
<li>Farms (building or buying)</li>
<li>HFSHC Registered SIMs worth $15,000 or more</li>
<li>Trucks & Trailers worth $30,000 or more</li>
<li>Tack Purchases of $50,000 or more</li>
<li>Debt Payments of $8,000 or more</li>
</ul>
<p>All loans must be pre-approved, and require that the member be in good standing. Loans carry a .02% interest rate and payments must be made no less than once a month in the minimum of 1% of the current balance each month. Bills are not sent and failure to pay for more than two months in a row may result in all moneys lost and forfeiture of loan-acquired properties. To apply for a loan, use the form below. If you have any questions concerning a loan or loans, please email the Bank President.</p>

<p>Any questions by our loan officer will be directed to you, the applicant, by email and must be answered quickly, honestly and to the best of your ability in order to process your loan.</p>

<p>You should remember that these funds are completely fake and are part of a simulated horse game and all payments you will be making towards this loan are also fake but should be taken seriously. You are expected to pay back the loan amount, in full, over the course of your membership and will be unable to apply for additional loans while your current loan is outstanding.</p>

<p>Loans carry a .02% interest rate and payments must be made no less than once a month in the amount of at least 1% of the current balance each month. Notices for repayment, or bills, are not sent and failure to pay for more than two months in a row may result in all moneys lost and forfeiture of loan-acquired properties.</p>


<div class="card mb-4">
  	<h5 class="card-header">Request Loan</h5>
    <div class="card-body">

		<form method="post" action="/city/bank/open_account">
			<? if($this->session->flashdata('errors')['loan_general']): ?>
				<div class="form-error"><?= $this->session->flashdata('errors')['loan_general'] ?></div>
			<? endif; ?>

			<?= hf_input('amount_requested', 'Amount Requested', $post, array(), $errors) ?>
			<?= hf_dropdown('membership', 'How long have you been a member?', $post, $membership, array('class' => 'col-sm-12'), $errors, 1) ?>
			What is the purpose of this loan?
			<?= hf_checkbox('purpose[0]', 'To buy a Private Stable', $post['purpose'][0], array(), $errors, 1) ?>
			<?= hf_checkbox('purpose[1]', 'To buy a Boarding Stable', $post['purpose'][1], array(), $errors, 1) ?>
			<?= hf_checkbox('purpose[2]', 'To purchase a new horse', $post['purpose'][2], array(), $errors, 1) ?>
			<?= hf_checkbox('purpose[3]', 'To make expansions to an existing stable', $post['purpose'][3], array(), $errors,1) ?>
			<div class="row">
				<div class="col-sm-3 col-md-2">
					<?= hf_checkbox('purpose[4]', 'Other:', $post['purpose'][4], array(), $errors, 1) ?>
				</div>
				<div class="col-sm-9 col-md-10">
					<?= hf_input('purpose_other', '', $post, array('placeholder' => 'Describe other reason'), $errors) ?>
				</div>
			</div>


			What are your plans for paying off this loan?<br/>
			<small>ie. How much do you intend to pay back monthly, over how many months/years will you be paying back the loan.</small>
			<?= hf_textarea('repayment', '', $post, array('class' => 'col-sm-12', 'placeholder' => '', 'rows' => '4'), $errors) ?>


What will be your source(s) of income that you will use to pay back the loan?<br/>
<small>ie. What securities do you have (breeding stock you can use to earn money, etc.) what jobs do you work at and what is your monthly income tier vs. expenses.</small>
			<?= hf_textarea('income_sources', '', $post, array('class' => 'col-sm-12', 'placeholder' => '', 'rows' => '4'), $errors) ?>

Where do you currently board and how long have you been a boarder?<br/>
<small>If you already own your own stable, please note that.</small>
			<?= hf_textarea('boarding', '', $post, array('class' => 'col-sm-12', 'placeholder' => '', 'rows' => '2'), $errors) ?>


Additional info you would like to provide.<br/>
<small>Any supporting information you can provide to help us process your loan. You may also include references if you have any (ie. employers within the game, people who can vouch for your good reputation, etc.)</small>
			<?= hf_textarea('comments', '', $post, array('class' => 'col-sm-12', 'placeholder' => '', 'rows' => '4'), $errors) ?>

<br/>
<b>Terms of Loan</b>
I hereby state that all information provided is true and accurate to the best of my knowledge. I also declare that I am a member in good standing within the game and have no outstanding fines nor do I owe any other members of the club outstanding payment for services rendered. I also hereby agree to pay back this loan, should it be granted, during the course of my game membership. I will pay monthly payments of at least 1% of the current amount owing. I understand that failure to pay back this loan with reasonable effort can result in funds being confiscated (this includes property purchased with the loan funds). Lastly, I am aware that I cannot apply for future loans until any existing loan is paid off or at least paid down to 50% of the original amount and that secondary loans are only granted on case by case basis under special circumstance.

			<?= hf_checkbox('terms[0]', 'I Agree', $post, array('id' => 'terms_agree'), $errors) ?>
			<?= hf_checkbox('terms[1]', 'I Do Not Agree', $post, array('id' => 'terms_disagree'), $errors) ?>
			<? if($errors['terms'][0]): ?>
				<div class="form-error pull-right"><?= $errors['terms'][0] ?></div>
			<? endif; ?>

<br/>
			<?= hf_submit('apply_loan', 'Apply for Loan', array('class' => 'btn btn-primary col-sm-12')) ?>
		</form>

    </div>
</div>


