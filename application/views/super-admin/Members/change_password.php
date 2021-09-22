<section class="content">
    <div class="section-area">
        <div class="inner-head-section">
            <div class="title dark">
                <h3><?php echo $page_title?></h3>
            </div>
        </div>
        <div class="card-box-area">
            <div class="card-box-area-inner">
                <?php echo form_open_multipart('',array('class'=>'form-horizontal'));?>
                <input class="form-control" name="players_id" type="hidden"  value="<?php echo $id?>">
                <?php 
                $readOnly=isset($postData['players_id'])  && !empty($postData['players_id']) ? 'readonly':'';
                ?>
                    <div class="form-role-area">
                            <div class="control-group">
                                <div class="row">
                                    <div class="col-md-3 col-lg-3 col-xl-4">
                                        <label class="span2">Set New Password:</label>
                                    </div>
                                    <div class="col-md-9 col-lg-9 col-xl-8">
                                        <div class="controls">
                                            <input class="form-control"  type="password" name="password"  placeholder="Enter password" value="" maxlength="20" minlength="8">
                                            <?php echo form_error('password');?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="row">
                                    <div class="col-md-3 col-lg-3 col-xl-4">
                                        <label class="span2">Confirm Password:</label>
                                    </div>
                                    <div class="col-md-9 col-lg-9 col-xl-8">
                                        <div class="controls">
                                            <input class="form-control"  type="password" name="confirm_password"  placeholder="Enter Confirm Password" value="" maxlength="20" minlength="8">
                                            <?php echo form_error('confirm_password');?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        <div class="next-step-btn">
                            <div class="secondry-btn">
                                <a href="<?php echo $BASE_URL.$class_name.$main_page_url ?>"><button type="button"><i class="las la-angle-left"></i> Back</button></a>
                            </div>
                            <div class="main-btn">
                               <button type="submit" onclick="showLodear()">Submit</button>
                            </div>
                        </div>
                    </div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</section>