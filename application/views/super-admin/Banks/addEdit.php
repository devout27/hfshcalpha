<section class="content">
    <div class="section-area">
        <div class="inner-head-section">
            <div class="title dark">
                <h3><?= $page_title?></h3>
            </div>
        </div>
        <div class="card-box-area">
            <div class="card-box-area-inner">
                <div class="card my-4">                    
                    <div class="card-body ">
                    
                        <div class="row justify-content-center">
                            <div class="col-10">
                                <div class="inner-head-section">
                                    <div class="title dark">
                                        <h3>Bank Information</h3>
                                    </div>
                                </div>
                                <form method="post" action="<?=BASE_URL.$class_name?>addEdit/<?= $account['bank_id'] ?>">
                                    <?= hf_hidden('bank_id', $account['bank_id']) ?>
                                    <div class="row">                                    
                                        <div class="col-12">
                                          <?= hf_dropdown('join_players_id', 'Player', $account ?: $postData,$players, array('class' => 'col-sm-12'), $errors) ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-12">
                                        <label for="name">Name*</label>
                                      </div>
                                      <div class="col-12">
                                        <?= hf_input('bank_nickname', '', $account ?: $postData, array(), $errors) ?>
                                      </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                          <label for="name">Bank Balance*</label>
                                        </div>
                                        <div class="col-12">
                                          <?= hf_input('bank_balance', '', $account ?: $postData, array('placeholder' => '0.00','min'=>0), $errors,'number') ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                          <label for="bank_interest_accrued">Interest Accrued*</label>
                                        </div>
                                        <div class="col-12">
                                          <?= hf_input('bank_interest_accrued', '', $account ?: $postData, array('placeholder' => '0.00','min'=>0), $errors,'number') ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                          <label for="bank_interest_incurred">Interest Incurred*</label>
                                        </div>
                                        <div class="col-12">
                                          <?= hf_input('bank_interest_incurred', '', $account ?: $postData, array('placeholder' => '0.00','min'=>0), $errors,'number') ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                          <label for="bank_credit_payment_due">Account Credit Payment Due*</label>
                                        </div>
                                        <div class="col-12">
                                          <?= hf_input('bank_credit_payment_due', '', $account ?: $postData, array('placeholder' => '','min'=>0), $errors) ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                          <label for="name">Bank Credit Limit*</label>
                                        </div>
                                        <div class="col-12">
                                          <?= hf_input('bank_credit_limit', '', $account ?: $postData, array('placeholder' => '0.00','min'=>0), $errors,'number') ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                          <label for="special_list">Bank Tier</label>
                                        </div>
                                        <div class="col-6 text-right">
                                          <?= hf_dropdown('bank_tier', '', $account ?: $postData, array('A','B','C','D','E','F'), null, $errors, 1, 0) ?>
                                        </div>
                                        <div class="col-6">
                                          <label for="bank_default">Make Default Account?</label>
                                        </div>
                                        <div class="col-6 text-right">                                    
                                          <?= hf_dropdown('bank_default', '', $account ?: $postData, array('0' => 'No', '1' => 'Yes'), array(), $errors, 0, 0) ?>
                                        </div>
                                        <div class="col-6">
                                          <label for="bank_type">Account Type</label>
                                        </div>
                                        <div class="col-6 text-right">                                    
                                          <?= hf_dropdown('bank_type', '', $account ?: $postData, array('Checking' => 'Checking', 'Business' => 'Business','Savings','Loan'), array(), $errors, 0, 0) ?>
                                        </div>
                                        <div class="col-6">
                                          <label for="bank_closed">Account Closed</label>
                                        </div>
                                        <div class="col-6 text-right">                                    
                                          <?= hf_dropdown('bank_closed', '', $account ?: $postData, array('0' => 'No', '1' => 'Yes'), array(), $errors, 0, 0) ?>
                                        </div>
                                        <div class="col-6">
                                          <label for="bank_pending">Status</label>
                                        </div>
                                        <div class="col-6 text-right">                                    
                                          <?= hf_dropdown('bank_pending', '', $account ?: $postData, array('0' => 'Active', '1' => 'Inactive'), array(), $errors, 0, 0) ?>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <? $title = !empty($postData['bank_id']) ? 'Update Bank Item' : 'Create Bank Item'; ?>
                                            <?= hf_submit('submit', $title, array('class' => 'btn btn-primary col-12')) ?>
                                        </div>                            
                                    </div>                                        
                                </form>
                            </div>
                        </div>                            
                    </div>
                </div>                                                                                                        
            </div>
        </div>
    </div>
</section>