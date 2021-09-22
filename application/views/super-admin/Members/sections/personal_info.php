
<div class="step-details user-details">
    <div class="step-detail-single dark">
        <h5>Personal Information</h5>
        <ul>
            <li>
                <div class="row">
                    <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                        <p>Username</p>
                    </div>
                    <div class="col-12 col-md-7 col-lg-8 col-xl-9">
                        <p>
                            <strong><?php echo ucfirst($member['players_username']);?></strong>
                        </p>
                    </div>
                </div>
            </li>
            <li>
                <div class="row">
                    <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                        <p>Email</p>
                    </div>
                    <div class="col-12 col-md-7 col-lg-8 col-xl-9">
                        <p>
                            <strong><?php echo $member['players_email'];?></strong>
                        </p>
                    </div>
                </div>
            </li>
            <li>
                <div class="row">
                    <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                        <p>About</p>
                    </div>
                    <div class="col-12 col-md-7 col-lg-8 col-xl-9">
                        <p>
                            <strong><?= $member['players_about'] ? $member['players_about'] :'N/A';?></strong>
                        </p>
                    </div>
                </div>
            </li>
            <li>
                <div class="row">
                    <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                        <p>House</p>
                    </div>
                    <div class="col-12 col-md-7 col-lg-8 col-xl-9">
                        <p>
                            <strong><?= $member['players_house'] ? $member['players_house'] :'N/A';?></strong>
                        </p>
                    </div>
                </div>
            </li>
            
            <li>
                <div class="row">
                    <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                        <p>Role</p>
                    </div>
                    <div class="col-12 col-md-7 col-lg-8 col-xl-9">
                        <?php
                            $role = "Member";
                            if($memeber['players_admin']==1)
                            {
                                $role = "Member Management Admin";
                            }
                            if($memeber['players_super_admin']==1)
                            {
                                $role = "Super Admin";
                            }
                        ?>
                        <p><strong class="badge badge-info"><?=$role?></strong></p>
                    </div>
                </div>
            </li>
            <li>
                <div class="row">
                    <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                        <p>Privileges</p>
                    </div>
                    <div class="col-12 col-md-7 col-lg-8 col-xl-9">
                        <p>                        
                            <strong>
                                <? if($member['players_vet']): ?>
                                    Veterinarian<br/>
                                <? endif; ?>
                                <? if($member['players_farrier']): ?>
                                    Farrier<br/>
                                <? endif;  ?>
                                <?=($member['players_vet'] == 0 && $member['players_farrier']  == 0) ? "N/A":'';?>
                            </strong>
                        </p>
                    </div>
                </div>
            </li>
            <li>
                <div class="row">
                    <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                        <p>AMI</p>
                    </div>
                    <div class="col-12 col-md-7 col-lg-8 col-xl-9">
                        <p><strong><?=$member['players_ami'] ? $member['players_ami'] : 'N/A'?></strong></p>
                    </div>
                </div>
            </li>            
            <li>
                <div class="row">
                    <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                        <p>Date Of Birth</p>
                    </div>
                    <div class="col-12 col-md-7 col-lg-8 col-xl-9">
                        <p>                            
                            <strong><?= $member['players_dob'] ? dateformate($member['players_dob']) : 'N/A'; ?></strong>
                        </p>
                    </div>
                </div>
            </li>
            <li>
                <div class="row">
                    <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                        <p>Last Active</p>
                    </div>
                    <div class="col-12 col-md-7 col-lg-8 col-xl-9">
                        <p>                        
                            <strong><?=$member['players_last_active']  && $member['players_last_active']!="0000-00-00 00:00:00" ? dateformate($member['players_last_active']) : 'N/A'; ?></strong>
                        </p>
                    </div>
                </div>
            </li>
            <li>
                <div class="row">
                    <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                        <p>Join On</p>
                    </div>
                    <div class="col-12 col-md-7 col-lg-8 col-xl-9">
                        <p>
                            <strong><?php echo dateformate($member['players_join_date']); ?></strong>
                        </p>
                    </div>
                </div>
            </li>
        </ul>	                        
    </div>
</div>