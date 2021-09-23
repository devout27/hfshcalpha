<section class="content">
    <div class="section-area">
		<div class="inner-head-section">
			<div class="title dark">
				<h3><?php echo $page_title?></h3>
			</div>
		</div>		
		<div class="card-box-area">
			<div class="card-box-area-inner">
				<div class="user-profile-box ubg-grey back-color">
					<? $this->load->view($class_name.'sections/basic_info') ?>
					<div class="user-details-area row">
						<div class="col-md-3">
							<div class="users-tabs">
								<div class="nav nav-pills dark">                           
									<a class="active" data-toggle="pill" href="#Details"><h6>Personal Information</h6></a>
									<a data-toggle="pill" href="#credits"><h6>Credits Information</h6></a>
									<a data-toggle="pill" href="#questions"><h6>Questions Information</h6></a>
									<a data-toggle="pill" href="#horses"><h6>Horses Information</h6></a>
									<a data-toggle="pill" href="#activity"><h6>Activity Information</h6></a>
									<a data-toggle="pill" href="#banks"><h6>Bank Accounts</h6></a>
								</div>
							</div>
						</div>
						<div class="col-md-9">
							<div class="tab-content">
								<div id="Details" class="tab-pane fade active show">
									<? $this->load->view($class_name.'sections/personal_info') ?>
								</div>    						
								<div id="banks" class="tab-pane fade">
									<? $this->load->view($class_name.'sections/banks_info') ?>
								</div>    						
								<div id="credits" class="tab-pane fade">
									<? $this->load->view($class_name.'sections/credits_info') ?>
								</div>    						
								<div id="questions" class="tab-pane fade">
									<? $this->load->view($class_name.'sections/questions_info') ?>
								</div>    													
								<div id="horses" class="tab-pane fade">
									<? $this->load->view($class_name.'sections/horses_info') ?>
								</div>							
								<div id="activity" class="tab-pane fade">
									<? $this->load->view($class_name.'sections/activity_info') ?>
								</div>							
							</div>						
						</div>
					</div>
				</div>
			</div>            
			<div class="next-step-btn btn-on-view">
				<div class="secondry-btn">
					<a href="<?php echo $BASE_URL.$class_name.$main_page_url ?>"><button type="button"><i class="las la-angle-left"></i> Back</button></a>
				</div>
			</div>
    	</div>
    </div>
</section>