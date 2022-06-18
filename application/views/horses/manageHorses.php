<div class="row">
    <div class="col-sm-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover no-wrap" id="dt-my-horses-list">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>                                
                                <th scope="col">Name</th>
                                <th scope="col">Stable</th>
                                <th scope="col">Born</th>
                                <th scope="col">Color</th>
                                <th scope="col">Breed</th>
                                <th scope="col">Gender</th>
                                <th scope="col">HS</th>
                                <th scope="col">FS</th>
                                <th scope="col">V/F</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th scope="col">ID</th>                                
                                <th scope="col">Name</th>
                                <th scope="col">Stable</th>
                                <th scope="col">Born</th>
                                <th scope="col">Color</th>
                                <th scope="col">Breed</th>
                                <th scope="col">Gender</th>
                                <th scope="col">HS</th>
                                <th scope="col">FS</th>
                                <th scope="col">V/F</th>
                                <th scope="col">Status</th>                                
                                <th scope="col">Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- stables -->
    <div class="col-sm-12">
        <h2>Stables</h2>
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover no-wrap" <? /*id="dt-horses-<?= $title ?> */ ?>>
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Boarding</th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach((array)$stables AS $stable): ?>
                                <tr>
                                    <td><a href="/city/stable/<?= $stable['stables_id'] ?>"><?= $stable['stables_name'] ?></a></td>
                                    <td><?= $stable['stables_boarding_public'] ? '$'.$stable['stables_boarding_fee'] : 'Private' ?></td>
                                </tr>
                            <? endforeach; ?>
                            <? if(!count($stables)): ?>
                                <tr><td class="text-center"colspan="100%">No stables</td></tr>
                            <? endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--stables end-->
</div>
<!-- Pending Breeding Requests -->
<?php $errors = $this->session->flashdata('errors'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card mb-4">
                <h5 class="card-header">Breeding Pending Requests</h5>
                <div class="card-body">
                    <table class="table table-sm table-hover no-wrap" <? /*id="dt-horses-<?= $title ?> */ ?>>
                    <thead>
                        <tr>                        
                        <th class="w-50"></th>                        
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Born</th>
                        <th scope="col">Breed</th>
                        <th scope="col">Fee</th>                        
                        <th></th>                        
                        </tr>
                    </thead>
                    <tbody>
                        <? 
                        foreach((array)$requests AS $request):                                  
                            $mare = $request['mare'];
                            $stallion = $request['stallion'];
                            $mare_owner = $mare['join_players_id'] == $this->session->userdata('players_id') ? 'Mare\'s Owner ( Me )': 'Mare\'s Owner ( '.$mare['players_nickname'].' )';
                            $stallion_owner = $stallion['join_players_id'] == $this->session->userdata('players_id') ? 'Sire\'s Owner ( Me )': 'Sire\'s Owner ( '.$stallion['players_nickname'].' )';
                            $h = $stallion['join_players_id'] == $this->session->userdata('players_id') ? $stallion : $mare;
                            $request['horses_owner'] = strpos($stallion_owner,"( Me )") !== false ? $stallion_owner : $mare_owner;
                        ?>
                            <tr>                                
                                <? $post = $this->session->flashdata('post'); ?>
                                    <td class="w-50">
                                        <? if($request['horses_breedings_accepted']): ?>
                                            <i>Pending Approval<br/>
                                            <?= $request['horses_breedings_gender'] ?> to Player #<?= $request['horses_breedings_owner'] ?></i>
                                        <? elseif($request['receiver_player_id'] != $this->session->userdata('players_id') && !$request['horses_breedings_accepted']): ?>
                                            <i>Request Sent<br/>
                                            <?= $request['horses_breedings_gender'] ?> to Player #<?= $request['horses_breedings_owner'] ?></i>
                                        <? elseif($request['receiver_player_id'] == $this->session->userdata('players_id')): ?>
                                            <form method="post" action="/horses/breed/<?= $request['join_horses_id'] ?>">
                                                <?= hf_hidden('horses_breedings_id', $request['horses_breedings_id']) ?>
                                                <div class="row">
                                                        <div class="col-sm-6">
                                                            <?= hf_input('horses_name', 'Name', isset($post['horses_name']) ? $post['horses_name'] : $request['horses_breedings_name'], array(), $errors) ?>
                                                        </div>
                                                        <div class="col-sm-6">						
                                                            <?= hf_input('horses_birthyear', 'Birth Year', isset($post['horses_birthyear']) ? $post['horses_birthyear']  : $request['horses_birthyear'], array('placeholder' => '1984'), $errors,'number') ?>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <?= hf_dropdown('horses_gender', 'Gender', isset($post['horses_gender']) ? $post['horses_gender'] : $request['horses_breedings_gender'], array('', 'Stallion', 'Mare', 'Gelding'), array(), $errors, 1) ?>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <?= hf_dropdown('horses_owner', 'Owner', isset($post['horses_owner']) ? $post['horses_owner'] : $request['horses_owner'], array("Sire's Owner" => $stallion_owner,"Mare's Owner"=>$mare_owner), array(), $errors, 1) ?>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <?= hf_dropdown('horses_breed', 'Breed', isset($post['horses_breed']) ? $post['horses_breed'] : $request['horses_breedings_breed'], $breeds, array(), $errors, 1) ?>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <?= hf_input('horses_breed2', 'Secondary Breed/Pattern (optional)', isset($post['horses_breed2']) ? $post['horses_breed2'] : $request['horses_breedings_breed2'], array(), $errors) ?>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <!-- <?//= hf_dropdown('horses_color', 'Base Color', $post, $h['genes']['blueprints_available']['Color'], array(), $errors, 1) ?> -->
                                                            <?= hf_dropdown('horses_color', 'Base Color', isset($post['horses_color']) ? $post['horses_color'] : $request['horses_breedings_color'], $base_colors, array(), $errors, 1) ?>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <!-- <?//= hf_dropdown('horses_pattern', 'Pattern Color', $post, $h['genes']['blueprints_available']['Pattern'], array(), $errors, 1) ?>-->
                                                            <?= hf_dropdown('horses_pattern', 'Pattern Color', isset($post['horses_pattern']) ? $post['horses_pattern'] : $request['horses_breedings_pattern'], $base_patterns, array(), $errors, 1) ?>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <?= hf_dropdown('horses_line', 'Line (optional)', isset($post['horses_line']) ? $post['horses_line'] : $request['horses_breedings_line'], $lines, array(), $errors, 1) ?>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <?= hf_multiselect('disciplines[]', 'Discipline', isset($post['disciplines']) ? $post['disciplines'] : explode(",",$request['horses_breedings_disciplines']), $disciplines, array(), $errors, 1) ?>
                                                        </div>
                                                    </div>                                  
                                                <?= hf_submit('accept', 'Accept', array('class' => 'btn btn-success col-sm-12')) ?>
                                            </form>
                                        <? endif; ?>
                                    </td>                                
                                <td><a href="/horses/view/<?= $h['horses_id'] ?>"><?= $h['horses_id'] ?></a></td>
                                <td><a href="/horses/view/<?= $h['horses_id'] ?>"><?= $h['horses_name'] ?></a></td>
                                <td><?= $h['horses_birthyear'] ?></td>
                                <td><?= $h['horses_breed'] ?></td>
                                <td>$<?= number_format($request['horses_breedings_fee']) ?></td>
                                <? if($request['receiver_player_id'] == $this->session->userdata('players_id')): ?>
                                    <td>
                                        <? if(!$request['horses_breedings_accepted']): ?>
                                            <form method="post" action="/horses/breed/<?= $h['horses_id'] ?>">
                                                <?= hf_hidden('horses_breedings_id', $request['horses_breedings_id']) ?>
                                                <?= hf_textarea('message', 'Message', $_POST, array('placeholder' => 'Describe why are you Reject this Breeding.','cols'=>"30","rows"=>"5"), $errors) ?>
                                                <?= hf_submit('reject', 'Reject', array('class' => 'btn btn-danger col-sm-12')) ?>
                                            </form>
                                        <? endif; ?>
                                    </td>
                                <? endif;?>
                            </tr>                    
                        <? endforeach; ?>
                        <? if(!count($requests)): ?>
                            <tr><td colspan="7">No requests</td></tr>
                        <? endif; ?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Pending Breeding Requests end -->