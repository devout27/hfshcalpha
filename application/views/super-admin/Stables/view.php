<section class="content">
    <div class="section-area">
		<div class="inner-head-section">
			<div class="title dark">
				<h3><?php echo $page_title?></h3>
			</div>
		</div>		
		<div class="card-box-area">
			<div class="card-box-area-inner">                                
                <!-- basic information -->				
                    <div class="step-details user-details">
                        <div class="step-detail-single dark">
                            <h5>Basic Information</h5>
                            <ul>
                                <li>
                                    <div class="row">
                                        <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                                            <p>Name</p>
                                        </div>
                                        <div class="col-12 col-md-7 col-lg-8 col-xl-9">                                                                                            
                                            <p><strong><?= $stable['stables_name'] ? ucfirst($stable['stables_name']) : 'N/A';?></strong></p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                                            <p>Description</p>
                                        </div>
                                        <div class="col-12 col-md-7 col-lg-8 col-xl-9">
                                            <p><strong><?= $stable['stables_description'] ? ucfirst($stable['stables_description']) : 'N/A';?></strong></p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                                            <p>Player Name</p>
                                        </div>
                                        <div class="col-12 col-md-7 col-lg-8 col-xl-9">
                                            <p><strong><?= $stable['players_nickname'] ? ucfirst($stable['players_nickname']) : 'N/A';?></strong></p>
                                        </div>
                                    </div>
                                </li>                                
                                <li>
                                    <div class="row">
                                        <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                                            <p>Land</p>
                                        </div>
                                        <div class="col-12 col-md-7 col-lg-8 col-xl-9">
                                            <p><strong><?= $stable['used_acres'] ?> of <?= $stable['land'] ?> Acres Used</strong></p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                                            <p>Stalls</p>
                                        </div>
                                        <div class="col-12 col-md-7 col-lg-8 col-xl-9">
                                            <p><strong><?= $stable['stalls'] ?></strong></p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                                            <p>Boarding Fee</p>
                                        </div>
                                        <div class="col-12 col-md-7 col-lg-8 col-xl-9">                                                                    
                                            <p><strong><?= $stable['stables_boarding_public'] ? '$'.$stable['stables_boarding_fee'].' Per Month' : 'No Public Boarding';?></strong></p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                                            <p>Boarding Status</p>
                                        </div>
                                        <div class="col-12 col-md-7 col-lg-8 col-xl-9">                                            
                                            <p><strong><?= $stable['stables_boarding_public']==1 ? '<span class="badge badge-success pb-1">Public</span>' : '<span class="badge badge-success pb-1">Private</span>'; ?></strong></p>
                                        </div>
                                    </div>
                                </li>                                
                                <li>
                                    <div class="row">
                                        <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                                            <p>Created On</p>
                                        </div>
                                        <div class="col-12 col-md-7 col-lg-8 col-xl-9">                                            
                                            <p><strong><?=dateFormate($stable['created'])?></strong></p>
                                        </div>
                                    </div>
                                </li>
                            </ul>	                        
                        </div>
                    </div>
                <!-- basic information end -->				
                <!-- Amenities information -->                			
                    <div class="step-details user-details">
                        <div class="step-detail-single dark">
                            <h5>Amenities Information</h5>
                            <div class="x-scroll">
                                <? $this->load->view($class_name.'sections/amenities-table', array('amenities' => $stable['amenities'], 'title' => 'search')); ?>
                            </div>
                        </div>
                    </div>                
                <!-- Amenities information end -->
			</div>
			<div class="next-step-btn btn-on-view">
				<div class="secondry-btn">
					<a href="<?php echo $main_page_url ?>"><button type="button"><i class="las la-angle-left"></i> Back</button></a>
				</div>
			</div>
    	</div>
    </div>
</section>