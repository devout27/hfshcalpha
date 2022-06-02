<section class="content">
  <div class="section-area">
      <div class="inner-head-section">
          <div class="row align-items-center">
            <div class="col-md-5">
                <div class="title dark">
                  <h3><?= ucfirst($page_title); ?></h3>
                </div>
            </div>
            <div class="col-md-7">
            </div>
          </div>
      </div>
      <div class="card-box-area">
          <div class="card-box-area-inner">
            <? if($this->session->flashdata('errors')): ?>
            <div class="center">
                <p class="error center">
                  <? if(is_array($this->session->flashdata('errors'))): ?>
                  <? foreach($this->session->flashdata('errors') AS $k): ?>
                  <? if(is_array($k)): ?>
                  <? foreach($k AS $v): ?>
                  <?= $v ?><br/>
                  <? endforeach; ?>
                  <? else: ?>
                  <?= $k ?><br/>
                  <? endif; ?>
                  <? endforeach; ?>
                  <? else: ?>
                  <?= $this->session->flashdata('errors'); ?>
                  <? endif; ?>
                </p>
            </div>
            <? endif; ?>
            <div class="row">
                <div class="col-md-5">
                  <table class="w-100">
                      <tr>
                        <td>Balance:</td>
                        <td class="text-right"><b>$<?= number_format($account['bank_balance']); ?></b></td>
                      </tr>
                      <tr>
                        <td>Available Balance:</td>
                        <td class="text-muted text-right"><b>$<?= number_format($account['bank_available_balance']); ?></b></td>
                      </tr>
                      <tr>
                        <td>Pending Income:</td>
                        <td class="text-muted text-right"><b>$<?= number_format($account['bank_influx']); ?></b></td>
                      </tr>
                  </table>
                </div>
                <div class="col-md-3 offset-md-4">
                  <table class="w-100">
                      <tr>
                        <td>Tier:</td>
                        <td class="text-right"><b><?= $account['bank_tier']; ?></td>
                      </tr>
                      <tr>
                        <td>Status:</td>
                        <td class="text-right"><b><?= $account['bank_status']; ?></td>
                      </tr>
                  </table>
                </div>
            </div>
            <br/>
            <div class="container h-100 py-2">
                <ul class="nav nav-tabs nav-fill border-0" id="myTab" role="tablist">
                  <li class="nav-item">
                      <a class="nav-link   <?= count($errors) == 0 ? 'active' : '' ?>   border border-muted border-bottom-0" id="overview-tab" data-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="<?= count($errors) == 0 ? 'true' : 'false' ?>">Overview</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link border border-muted border-bottom-0" id="outgoing-tab" data-toggle="tab" href="#outgoing" role="tab" aria-controls="outgoing" aria-selected="false">Pending Outgoing</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link border border-muted border-bottom-0" id="incoming-tab" data-toggle="tab" href="#incoming" role="tab" aria-controls="incoming" aria-selected="false">Pending Incoming</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link border border-muted border-bottom-0  <?= count($errors) > 0 ? 'active' : '' ?>" id="edit" data-toggle="tab" href="#edit-tab" role="tab" aria-controls="edit-tab" aria-selected="<?= count($errors) > 0 ? 'true' : 'false' ?>">Edit</a>
                  </li>
                </ul>
                <div class="tab-content h-75">
                  <div class="tab-pane   <?= count($errors) == 0 ? 'active' : '' ?>   h-100 p-3 border border-muted" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                      <div class="container-fluid">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover  no-wrap col-sm-12 w-100" id="accountOverviewList">
                              <thead>
                                  <tr>
                                    <th scope="col">Sr No.</th>
                                    <th scope="col">ID</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Transaction</th>
                                    <th scope="col">Credit</th>
                                    <th scope="col">Debit</th>
                                    <? /*<th scope="col d-none d-md-table-cell">Balance</th> */ ?>
                                    <th scope="col">Status</th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                        </div>
                      </div>
                  </div>
                  <div class="tab-pane h-100 p-3 border border-muted" id="outgoing" role="tabpanel" aria-labelledby="outgoing-tab">
                      <div class="container-fluid">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover  no-wrap col-sm-12 w-100" id="accountOutgoingList">
                              <thead>
                                  <tr>
                                    <th scope="col">Sr No.</th>
                                    <th scope="col">ID</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Transaction</th>
                                    <th scope="col">Debit</th>
                                    <th scope="col">Status</th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                        </div>
                      </div>
                  </div>
                  <div class="tab-pane h-100 p-3 border border-muted" id="incoming" role="tabpanel" aria-labelledby="incoming-tab">
                      <div class="container-fluid">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover  no-wrap col-sm-12 w-100" id="accountIncomingList">
                              <thead>
                                  <tr>
                                    <th scope="col">Sr No.</th>
                                    <th scope="col">ID</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Transaction</th>
                                    <th scope="col">Credit</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                  </tr>
                              </thead>
                              <tbody>                                 
                              </tbody>
                            </table>
                        </div>
                      </div>
                  </div>
                  <div class="tab-pane h-100 p-3 border border-muted <?= count($errors) > 0 ? 'active' : '' ?> " id="edit-tab" role="tabpanel" aria-labelledby="edittab">
                     <div class="container-fluid">                        
                        <form method="post" action="<?= $BASE_URL.$class_name."view/".$account['bank_id'] ?>">
                           <div class="row">
                              <div class="col-12">
                                 <label for="name">Name*</label>
                              </div>
                              <div class="col-12">
                                 <?= hf_input('bank_nickname', '', $account ?: $post, array(), $errors) ?>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-12">
                                 <label for="name">Bank Balance*</label>
                              </div>
                              <div class="col-12">
                                 <?= hf_input('bank_balance', '', $account ?: $post, array('placeholder' => '0.00','min'=>0), $errors,'number') ?>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-12">
                                 <label for="name">Bank Credit Limit*</label>
                              </div>
                              <div class="col-12">
                                 <?= hf_input('bank_credit_limit', '', $account ?: $post, array('placeholder' => '0.00','min'=>0), $errors,'number') ?>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-6">
                                 <label for="special_list">Bank Tier</label>
                              </div>
                              <div class="col-6 text-right">
                                 <?= hf_dropdown('bank_tier', '', $account, array('A','B','C','D','E','F'), null, $errors, 1, 0) ?>
                              </div>
                              <div class="col-6">
                                 <label for="bank_default">Make Default Account?</label>
                              </div>
                              <div class="col-6 text-right">                                    
                                 <?= hf_dropdown('bank_default', '', $account ?: $post, array('0' => 'No', '1' => 'Yes'), array(), $errors, 0, 0) ?>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-12">                                    
                                 <?= hf_submit('update_bank_balance_details', "Save Changes", array('class' => 'btn btn-primary col-12')) ?>
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
  </div>
</section>