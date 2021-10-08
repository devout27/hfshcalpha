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
                                            <p><strong><?= $amenity['amenities_name'] ? ucfirst($amenity['amenities_name']) : 'N/A';?></strong></p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                                            <p>Picture</p>
                                        </div>
                                        <div class="col-12 col-md-7 col-lg-8 col-xl-9">                                                                                            
                                            <?= $amenity['amenities_picture'] ? '<img src="'.getAmenityPic($amenity['amenities_picture']).'" class="img-thumbnail">' : 'N/A'?>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                                            <p>Description</p>
                                        </div>
                                        <div class="col-12 col-md-7 col-lg-8 col-xl-9">
                                            <p><strong><?= $amenity['amenities_description'] ? ucfirst($amenity['amenities_description']) : 'N/A';?></strong></p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                                            <p>Amenity Cost</p>
                                        </div>
                                        <div class="col-12 col-md-7 col-lg-8 col-xl-9">
                                            <p><strong>$<?=$amenity['amenities_cost']?></strong></p>
                                        </div>
                                    </div>
                                </li>                                
                                <li>
                                    <div class="row">
                                        <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                                            <p>Amenity Limit</p>
                                        </div>
                                        <div class="col-12 col-md-7 col-lg-8 col-xl-9">
                                            <p><strong><?= $amenity['amenities_limit'] ?></strong></p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                                            <p>Amenity Type</p>
                                        </div>
                                        <div class="col-12 col-md-7 col-lg-8 col-xl-9">
                                            <p><strong><?= $amenity['amenities_type'] ?></strong></p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                                            <p>Amenity Stalls</p>
                                        </div>
                                        <div class="col-12 col-md-7 col-lg-8 col-xl-9">                                                                    
                                            <p><strong><?=$amenity['amenities_stalls']?></strong></p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                                            <p>Boarding Acres</p>
                                        </div>
                                        <div class="col-12 col-md-7 col-lg-8 col-xl-9">                                            
                                            <p><strong><?=$amenity['amenities_acres']?></strong></p>
                                        </div>
                                    </div>
                                </li>                                
                                <li>
                                    <div class="row">
                                        <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                                            <p>Created On</p>
                                        </div>
                                        <div class="col-12 col-md-7 col-lg-8 col-xl-9">                                            
                                            <p><strong><?=dateFormate($amenity['ameneties_created'])?></strong></p>
                                        </div>
                                    </div>
                                </li>
                            </ul>	                        
                        </div>
                    </div>
                <!-- basic information end -->				                
			</div>
			<div class="next-step-btn btn-on-view">
				<div class="secondry-btn">
					<a href="<?php echo $main_page_url ?>"><button type="button"><i class="las la-angle-left"></i> Back</button></a>
				</div>
			</div>
    	</div>
    </div>
</section>