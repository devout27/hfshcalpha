<section class="content">
    <div class="section-area">
        <div class="inner-head-section">
            <div class="title dark">
                <h3><?= $page_title?></h3>
            </div>
        </div>        
        <div class="card-box-area">
            <div class="card-box-area-inner">
                <?= form_open_multipart('',array('class'=>'form-horizontal'));?>
                <input class="form-control" name="id" type="hidden"  value="<?= isset($postData['id']) ? $postData['id']:'';?>">
                <?php $readOnly=isset($postData['id'])  && !empty($postData['id']) ? 'readonly':''; ?>
                    <div class="form-role-area">
                        <div class="control-group">
                            <div class="row">
                                <div class="col-md-3 col-lg-3 col-xl-4">
                                    <label class="span2">Name:</label>
                                </div>
                                <div class="col-md-9 col-lg-9 col-xl-8">
                                    <div class="controls">
        
                                       <input class="form-control" name="name" id="name" type="text" placeholder="Enter name" value="<?= isset($postData['name']) ? $postData['name']:'';?>" maxlength="50">
										<?= form_error('name');?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="row">
                                <div class="col-md-3 col-lg-3 col-xl-4">
                                    <label class="span2">Email Address:</label>
                                </div>
                                <div class="col-md-9 col-lg-9 col-xl-8">
                                    <div class="controls">
                                        <input class="form-control" name="email" id="email" type="email" placeholder="Enter email" value="<?= isset($postData['email']) ? $postData['email']:'';?>" maxlength="150" <?= $readOnly?>>
										<?= form_error('email');?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="row">
                                <div class="col-md-3 col-lg-3 col-xl-4">
                                    <label class="span2">Phone Number:</label>
                                </div>
                                <div class="col-md-9 col-lg-9 col-xl-8">
                                    <div class="controls">
                                        <input class="form-control"  name="mobile" placeholder="Enter phone number" value="<?= isset($postData['mobile']) ? $postData['mobile']:'';?>"  type="tel">
										<?= form_error('mobile');?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php if(empty($readOnly)){?>
                            <div class="control-group">
                                <div class="row">
                                    <div class="col-md-3 col-lg-3 col-xl-4">
                                        <label class="span2">Password:</label>
                                    </div>
                                    <div class="col-md-9 col-lg-9 col-xl-8">
                                        <div class="controls">
                                            <input class="form-control"  type="password" name="password"  placeholder="Enter password" value="">
                                            <?= form_error('password');?>
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
                                            <input class="form-control"  type="password" name="confirm_password"  placeholder="Enter Confirm Password" value="">
                                            <?= form_error('confirm_password');?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php 
                         }?>
                        <div class="next-step-btn">
                            <div class="secondry-btn">
                                <a href="<?= $BASE_URL.$class_name.$main_page_url ?>"><button type="button"><i class="las la-angle-left"></i> Back</button></a>
                            </div>
                            <div class="main-btn">
                               <button type="submit"  onclick="showLodear()">Submit</button>
                            </div>
                        </div>
                    </div>
                <?= form_close();?>
            </div>
        </div>
    </div>
</section>