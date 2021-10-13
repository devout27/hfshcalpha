<section class="content">
    <div class="section-area">
        <div class="inner-head-section">
            <div class="title dark">
                <h3><?= $page_title?></h3>
            </div>
        </div>
        <div class="card-box-area">
            <div class="card-box-area-inner">
                <div class="card">
                    <div class="card-body ">
                        <div class="row justify-content-center">
                            <div class="col-8">
                                <form method="post" action="<?=$BASE_URL.$class_name?>addEdit/<?= $postData['amenities_id'] ?>">
                                    <?= hf_hidden('amenities_id', $postData['amenities_id']) ?>                                
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="name">Name*</label>
                                            </div>
                                            <div class="col-12">
                                                <?= hf_input('amenities_name', '', $postData, array(), $errors) ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="description">Description*</label>
                                            </div>
                                            <div class="col-12">
                                                <?= hf_textarea('amenities_description', '', $postData, array('class' => 'col-12', 'rows' => '2'), $errors) ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <?= $postData['amenities_picture'] ? '<img src="'.getAmenityPic($postData['amenities_picture']).'" class="img-thumbnail">' : ''?>
                                            </div>                                            
                                            <div class="col-12">
                                                <label for="cab">Picture</label>
                                            </div>
                                            <div class="col-12">
                                                <?= hf_input('amenities_picture', '', $postData, array('placeholder' => '/images/example.jpg'), $errors) ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="cab">Cost*</label>
                                            </div>
                                            <div class="col-12">
                                                <?= hf_input('amenities_cost', '', $postData, array(), $errors) ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="special_list">Type*</label>
                                                <?= hf_dropdown('amenities_type', '', $postData, array('Building','Course','Land','Stall','Paddock','Farm','Miscellaneous','Special'), null, $errors, 1, 0) ?>
                                            </div>
                                            <div class="col-6">
                                                <label for="cab">Limit</label>
                                                <?= hf_input('amenities_limit', '', $postData, array('placeholder' => 'limit per amenity, 0 is unlimited'), $errors) ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="cab">Acres</label>
                                                <?= hf_input('amenities_acres', '', $postData, array('placeholder' => 'fill this in if it takes up land or adds land to the amenity'), $errors) ?>
                                            </div>
                                            <div class="col-6">
                                                <label for="cab">Stalls</label>
                                                <?= hf_input('amenities_stalls', '', $postData, array('placeholder' => 'fill this in if this adds stalls to the amenity'), $errors) ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <? $title = !empty($postData['amenities_id']) ? 'Update Stable' : 'Create Stable'; ?>
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