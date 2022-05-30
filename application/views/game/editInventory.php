<div class="card-box-area">
    <div class="card-box-area-inner">
        <div class="card my-4">
            <div class="card-body ">
                <div class="row justify-content-center">
                    <div class="col-8">
                        <h3><?= $page_title?></h3>
                        <form method="post" action="<?=$class_name?>editInventory/<?= $postData['itemid'] ?>">
                                <?= hf_hidden('itemid', $postData['itemid']) ?>
                                <div class="row"> 
                                    <div class="col-12">
                                        <label for="name">Transfer this inventory to another Player</label>
                                    </div>                                   
                                    <div class="col-12">
                                        <?= hf_dropdown('join_players_id', '', $postData,$players, array('class' => 'col-sm-12'), $errors)?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="name">Name*</label>
                                    </div>
                                    <div class="col-12">
                                        <?= hf_input('itemname', '', $postData, array(), $errors) ?>
                                    </div>
                                </div>                                
                                <div class="row">
                                    <div class="col-12">
                                        <label for="itemdesc">Description*</label>
                                    </div>
                                    <div class="col-12">
                                        <?= hf_textarea('itemdesc', '', $postData, array('class' => 'col-12', 'rows' => '2'), $errors) ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <?= $postData['itemimg'] ? '<img src="'.getAmenityPic($postData['itemimg']).'" class="img-thumbnail">' : ''?>
                                    </div>                                            
                                    <div class="col-12">
                                        <label for="cab">Image</label>
                                    </div>
                                    <div class="col-12">
                                        <?= hf_input('itemimg', '', $postData, array('placeholder' => '/images/example.jpg'), $errors) ?>
                                    </div>
                                </div>                             
                                <div class="row">                                    
                                    <div class="col-12">
                                        <?= hf_dropdown('itemrarity', 'Item Rarity*', $postData,INVENTRORY_ITEM_RARITY, array('class' => 'col-sm-12'), $errors)?>
                                    </div>
                                </div>
                                <div class="row">                                    
                                    <div class="col-12">
                                        <?= hf_dropdown('itemtype', 'Item Type*', $postData,INVENTRORY_ITEM_TYPES, array('class' => 'col-sm-12'), $errors)?>
                                    </div>
                                </div>                                
                                <div class="row">
                                    <div class="col-12">
                                        <? $title = !empty($postData['itemid']) ? 'Update Inventory Item' : 'Create Inventory Item'; ?>
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