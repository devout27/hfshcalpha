<div class="card-box-area my-5">
  <div class="card-box-area-inner">                                
            <!-- basic information -->				
                <div class="step-details user-details">
                    <div class="step-detail-single dark">
                        <h5 class="text-center">Basic Information</h5><hr/>
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
<!--                        <li>
                                <div class="row">
                                    <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                                        <p>Land</p>
                                    </div>
                                    <div class="col-12 col-md-7 col-lg-8 col-xl-9">
                                        <p><strong><?= $stable['used_acres'] ?? 'N/A' ?> of <?= $stable['land']  ?? 'N/A' ?> Acres Used</strong></p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row">
                                    <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                                        <p>Stalls</p>
                                    </div>
                                    <div class="col-12 col-md-7 col-lg-8 col-xl-9">
                                        <p><strong><?= $stable['stalls'] ?? 'N/A' ?></strong></p>
                                    </div>
                                </div>
                            </li>-->  
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
                <!-- <div class="step-details user-details">
                    <div class="step-detail-single dark">
                        <h5>Amenities Information</h5>
                        <div class="x-scroll">
                            <?/*  $this->load->view(strtolower($class_name).'sections/amenities-table', array('amenities' => $stable['amenities'], 'title' => 'search'));  */?>
                        </div>
                    </div>
                </div>-->
            <!-- Amenities information end -->
  </div>			
</div>
    