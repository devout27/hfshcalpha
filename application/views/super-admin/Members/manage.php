<section class="content">
    <div class="section-area">
        <div class="inner-head-section">
            <div class="title dark">
                <h3><?= $page_title?></h3>
            </div>
        </div>        
        <div class="card-box-area">
            <div class="card-box-area-inner">
                <h2><?= $postData['players_nickname'] ?> #<?= $postData['players_id'] ?></h3>
                <div class="row">
                    <div class="col-sm-12">		
                        <div class="card mb-4">
                            <h5 class="card-header">Credits & More</h5>
                            <div class="card-body">
                                <form method="post" action="<?=$BASE_URL.$class_name?>manage/<?= $postData['players_id'] ?>">
                                    <?= hf_hidden('players_id', $postData['players_id']) ?>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4 col-xl-3">
                                            <?= hf_input('players_credits_creation', 'Creation Credits', $postData, array('placeholder' => '0'), $errors) ?>
                                        </div>
                                        <div class="col-sm-12 col-md-4 col-xl-3">
                                            <?= hf_input('per_day_credits', 'Daily Creation Credits Limit', $postData, array('placeholder' => '0'), $errors) ?>
                                        </div>
                                        <div class="col-sm-12 col-md-4 col-xl-3">
                                            <?= hf_input('players_credits_adoptathon', 'Adoptathon Credits', $postData, array('placeholder' => '0'), $errors) ?>
                                        </div>
                                        <div class="col-sm-12 col-md-4 col-xl-3">
                                            <?= hf_input('players_ami', 'AMI', $postData, array('placeholder' => '0'), $errors) ?>
                                        </div>
                                    </div>
                            </div>
                            <div class="card-footer text-muted">
                                        <?= hf_submit('update_credits', 'Update Credits & More', array('class' => 'btn btn-primary col-sm-12')) ?>
                                </form>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <h5 class="card-header">About</h5>
                            <div class="card-body">
                                <form method="post" action="<?=$BASE_URL.$class_name?>manage/<?= $postData['players_id'] ?>">
                                <?= hf_hidden('players_id', $postData['players_id']) ?>
                                <?= hf_input('players_nickname', 'Nickname', $_POST ?: $postData, array('placeholder' => 'Nickname'), $errors) ?>
                                <?= hf_dropdown('players_house', 'House', $_POST ?: $postData, array('Eclipse', 'Milton', 'King'), array(), $errors, 1) ?>
                                <?= hf_input('players_dob', 'Date of Birth (MM/DD/YYYY)', $_POST ?: $postData, array('placeholder' => 'MM/DD/YYYY', 'disabled' => 'disabled'), $errors) ?>
                                <?= hf_input('players_banner', 'Banner', $_POST ?: $postData, array('placeholder' => 'http://link.to.image/'), $errors) ?>
                                <?= hf_textarea('players_about', 'About', $_POST ?: $postData, array('class' => 'col-sm-12', 'placeholder' => 'All about this Member and Member horses!', 'rows' => '10'), $errors) ?>
                            </p>
                            </div>
                            <div class="card-footer text-muted">
                                <?= hf_submit('update_profile', 'Update Profile', array('class' => 'btn btn-primary col-sm-12')) ?>
                                </form>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <h5 class="card-header">Change Member Role</h5>
                            <div class="card-body">
                                <form method="post" action="<?=$BASE_URL.$class_name?>manage/<?= $postData['players_id'] ?>">
                                <?= hf_hidden('players_id', $postData['players_id']) ?>
                                <input type="hidden" name="players_super_admin" value="0">
                                <div class="form-check">                                                                        
                                    <input type="checkbox" class="form-check-input" value="1" id="players_super_admin" <?=$postData['players_super_admin']==1 ? 'checked':'' ?> name="players_super_admin">
                                    <label class="form-check-label" for="players_super_admin">Super Admin</label>                                   
                                    <div class="form-error pull-right"><?=$errors['players_super_admin']?></div>
                                </div>                                                                
                            </p>
                            </div>
                            <div class="card-footer text-muted">
                                <?= hf_submit('update_role', 'Update Role', array('class' => 'btn btn-primary col-sm-12')) ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</section>