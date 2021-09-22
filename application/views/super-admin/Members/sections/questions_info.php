<div class="step-details user-details">
    <div class="step-detail-single dark">
        <h5>Questions Information</h5>
        <ul>
            <? foreach($member['questions'] as $k=>$v):?>
                <li>
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12 col-xl-12">                            
                            <p><strong>Q:-<?=$k+1?> <?=$v['questions_question']?></strong></p>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                            <p><strong>Ans:-</strong><?=$v['players_x_questions_answer']?></p>
                        </div>
                    </div>
                </li>
            <? endforeach; ?>
            
        </ul>	                        
    </div>
</div>