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
					          	<a class="active" data-toggle="pill" href="#Details"><h5>Personal Information</h5></a>
								<!-- <a data-toggle="pill" href="#subscriptions"><h5>Subscription History</h5></a> -->
								<a data-toggle="pill" href="#credits"><h5>Credits Information</h5></a>
								<a data-toggle="pill" href="#questions"><h5>Questions Information</h5></a>
					        </div>
				      	</div>
            		</div>
            		<div class="col-md-9">
            			<div class="tab-content">
    						<div id="Details" class="tab-pane fade active show">
								<? $this->load->view($class_name.'sections/personal_info') ?>
    						</div>    						
    						<div id="credits" class="tab-pane fade">
								<? $this->load->view($class_name.'sections/credits_info') ?>
    						</div>    						
    						<div id="questions" class="tab-pane fade">
								<? $this->load->view($class_name.'sections/questions_info') ?>
    						</div>    						
							<!-- subscription -->
							<div id="subscriptions" class="tab-pane fade">
									<div class="step-details user-details">
										<div class="step-detail-single dark"><h5>Subscriptions History</h5></div>
										<div class="x-scroll ml-5">
											<table id="userSubscriptionsList" class="table" role="grid" aria-describedby="userSubscriptionsList">
												<thead>
													<tr role="row">
														<th>S.No.</th>
														<th>Name</th>
														<th>Email</th>
														<th>Stripe Subscription ID</th>
														<th>Stripe Customer ID</th>
														<th>Plan Name</th>
														<th>Plan Interval</th>
														<th>Plan Price</th>
														<th>Tax</th>
														<th>Total</th>
														<th>Status</th>
														<th>Created On</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>                        
												</tbody>
											</table>
										</div>
									</div>
									
								</div>
							</div>
							<!-- end subscription  -->
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
</section>