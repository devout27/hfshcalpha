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
                        <a href="<?= $BASE_URL_ADMIN ?>Packages/addEdit">
                            <button type="button"><i class="las la-plus-circle"></i> <?=$sub_page_title?></button>
                        </a>
                    </div>
                </div>
            </div>
        </div>        
        <div class="card-box-area">
            <div class="card-box-area-inner">
                <div class="x-scroll">
                    <table id="packagesList" class="table w-100" role="grid" aria-describedby="packagesList">
                        <thead>
                            <tr role="row">
                                <th scope="col">Sr No.</th>
                                <th scope="col">Details</th>
                                <th scope="col">Cost</th>
                                <th scope="col">Cost USD</th>                                
                                <th scope="col">Available</th>                                
                                <th scope="col">Created</th>
                                <th scope="col">Action</th>
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