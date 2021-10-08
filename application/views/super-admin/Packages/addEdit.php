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
                                        <h3>Package Information</h3>
                                    </div>
                                </div>
                                <form method="post" action="<?=$BASE_URL.$class_name?>addEdit/<?= $postData['stables_packages_id'] ?>">
                                    <?= hf_hidden('stables_packages_id', $postData['stables_packages_id']) ?>                                
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="name">Name*</label>
                                        </div>
                                        <div class="col-12">
                                            <?= hf_input('stables_packages_name', '', $postData, array(), $errors) ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="description">Description</label>
                                        </div>
                                        <div class="col-12">
                                            <?= hf_textarea('stables_packages_description', '', $postData, array('class' => 'col-12', 'rows' => '2'), $errors) ?>
                                        </div>
                                    </div>                                        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="cab">Cost*</label>
                                        </div>
                                        <div class="col-12">
                                            <?= hf_input('stables_packages_cost', '', $postData, array('placeholder'=>'leave 0 or blank if not available'), $errors) ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="cab">PayPal Cost*</label>
                                        </div>
                                        <div class="col-12">
                                            <?= hf_input('stables_packages_cost_usd', '', $postData, array('placeholder'=>'leave 0 or blank if not available'), $errors) ?>
                                        </div>
                                    </div>
                                    <div class="row">                                            
                                        <div class="col-12">
                                            <label for="stables_packages_available">Packages Available for Purchase</label>
                                            <?= hf_input('stables_packages_available', '', $postData, array('placeholder' => 'how many are available for purchase, 0 is unlimited'), $errors) ?>
                                        </div>                                                                                                                        
                                    </div>            
                                    <div class="inner-head-section">
                                        <div class="title dark">
                                            <h3>Package Amenities Information</h3>
                                        </div>
                                    </div>                                
                                    <div class="x-scroll">
                                        <table id="packageAmenitiesList" class="table w-100" role="grid" aria-describedby="packageAmenitiesList">
                                            <thead>
                                                <tr role="row">
                                                    <th scope="col">Picture</th>
                                                    <th scope="col">Details</th>
                                                    <th scope="col">Cost</th>
                                                    <th scope="col">Type</th>
                                                    <th scope="col">Stalls</th>
                                                    <th scope="col">Acres</th>
                                                    <th scope="col">Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <? $title = !empty($postData['stables_packages_id']) ? 'Update Stable' : 'Create Stable'; ?>
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