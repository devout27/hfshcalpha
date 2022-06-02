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
                    <div class="all-vol-btn text-right main-btn">						
                        <a href="<?= $BASE_URL_ADMIN ?>Banks/addEdit">
                            <button type="button"><i class="las la-plus-circle"></i> <?=$sub_page_title?></button>
                        </a>
                    </div>
                </div>
            </div>
        </div>        
        <div class="card-box-area">
            <div class="card-box-area-inner">
                <div class="x-scroll">
                    <table id="myBankAccountsList" class="table w-100" role="grid" aria-describedby="myBankAccountsList">
                        <thead>
                            <tr role="row">
                                <th scope="col">Sr No.</th>
                                <th >Bank ID</th>
                                <th>Account</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Balance</th>
                                <th>Available</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>