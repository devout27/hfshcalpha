<div class="card-box-area mb-3">
    <div class="card-box-area-inner">
        <div class="card">
            <div class="card-body ">
                <div class="row justify-content-center">
                    <form method="post" action="<?= BASE_URL.$class_name ?>manage/<?= $postData['stables_id'] ?>">
                        <?= hf_hidden('stables_id', $postData['stables_id']) ?>
                        <?= hf_hidden('stables_boarding_public',0) ?>                                          
                        <div class="col-12">
                            <?= hf_input('stables_name', 'Stable Name', $postData, array('placeholder' => 'Upton Downs'), $errors) ?>
                        </div>
                        <div class="col-12">
                            <?= hf_input('stables_boarding_fee', 'Boarding Fee', $postData, array('placeholder' => '$100'), $errors) ?>
                        </div>                                    
                        <div class="col-12">
                            <?= hf_textarea('stables_description', 'Stable Description', $postData, array('class' => 'col-sm-12', 'placeholder' => 'A quiet place to call home.', 'rows' => '10'), $errors) ?>
                        </div>
                        <div class="col-12 pb-3">
                            <?= hf_checkbox('stables_boarding_public', 'Public Boarding?', $postData, array(), $errors) ?>
                        </div>
                        <div class="col-12">
                            <?= hf_submit('submit', 'Update Stable', array('class' => 'btn btn-primary col-sm-12')) ?>
                        </div>                            
                    </form>
                </div>
            </div>                                                                                        
        </div>
    </div>
</div>