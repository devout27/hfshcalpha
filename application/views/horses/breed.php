<?php $post = $this->session->flashdata('post'); $errors = (array)$this->session->flashdata('errors'); ?>
<p>Please choose a mare to breed with this stallion. Once you have made this request, be sure to send a check to the owner of the stallion for the amount of the breeding fee. The owner will have the option to accept or reject your breeding request.</p>
<br/>
<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <h5 class="card-header"><?= $horse['horses_competition_title'] ?> <?= $horse['horses_breeding_title'] ?> <?= $horse['horses_name'] ?></h5>
            <div class="card-body">
                <?= $horse['horses_birthyear'] . " " . $horse['horses_color'] . " " . $horse['horses_breed'] . " " . $horse['horses_gender'] . "<br/><i>" . $horse['horses_pattern'] . "</i> " . $horse['horses_breed2']?><br/>
                Stud Fee is $<?= number_format($horse['horses_breeding_fee']) ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-4">            
                <div class="form-error text-center"><?= @$errors['common']  ? @$errors['common'] : '' ?></div>
                <?php if($horse['horses_gender'] == "Stallion" || $horse['horses_gender'] == "Mare"):                     
                    ?>
                    <div class="card-body">
                        <form method="post" action="/horses/breed/<?= $horse['horses_id'] ?>">
                            <div class="row">
                                <?php if($horse['horses_gender'] == "Stallion"):                                     
                                    $mare_owner = 'Mare\'s Owner ( Me )';
                                    $stallion_owner = 'Sire\'s Owner ( '.$horse['players_nickname'].' )';
                                ?>
                                    <div class="col-md-12">
                                        <?= hf_dropdown('mare_id', 'Mare', $post, $mares, array('class' => 'col-sm-12'), $errors, 0) ?>
                                    </div>						
                                <?php elseif($horse['horses_gender'] == "Mare"): 
                                    $mare_owner = 'Mare\'s Owner ( '.$horse['players_nickname'].' )';
                                    $stallion_owner = 'Sire\'s Owner ( Me )';
                                ?>
                                    <div class="col-md-12">                                    
                                        <?= hf_dropdown('stallion_id', 'Stallion', $post, $stallions, array('class' => 'col-sm-12'), $errors, 0) ?>
                                    </div>						
                                <?php endif; ?>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <?= hf_input('horses_name', 'Name', isset($post['horses_name']) ? $post['horses_name'] : '', array(), $errors) ?>
                                </div>
                                <div class="col-sm-6">						
                                    <?= hf_input('horses_birthyear', 'Birth Year', isset($post['horses_birthyear']) ? $post['horses_birthyear'] : '', array('placeholder' => '1984'), $errors,'number') ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <?= hf_dropdown('horses_gender', 'Gender', isset($post['horses_gender']) ? $post['horses_gender'] : '', array('', 'Stallion', 'Mare', 'Gelding'), array(), $errors, 1) ?>
                                </div>
                                <div class="col-sm-6">
                                    <?= hf_dropdown('horses_owner', 'Owner', isset($post['horses_owner']) ? $post['horses_owner'] : '', array('',"Sire's Owner" => $stallion_owner,"Mare's Owner"=>$mare_owner), array(), $errors, 1) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <?= hf_dropdown('horses_breed', 'Breed', isset($post['horses_breed']) ? $post['horses_breed'] : '', $breeds, array(), $errors, 1) ?>
                                </div>
                                <div class="col-sm-6">
                                    <?= hf_input('horses_breed2', 'Secondary Breed/Pattern (optional)', isset($post['horses_breed2']) ? $post['horses_breed2'] : '', array(), $errors) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <!-- <?//= hf_dropdown('horses_color', 'Base Color', $post, $h['genes']['blueprints_available']['Color'], array(), $errors, 1) ?> -->
                                    <?= hf_dropdown('horses_color', 'Base Color', isset($post['horses_color']) ? $post['horses_color'] : '', $base_colors, array(), $errors, 1) ?>
                                </div>
                                <div class="col-sm-6">
                                    <!-- <?//= hf_dropdown('horses_pattern', 'Pattern Color', $post, $h['genes']['blueprints_available']['Pattern'], array(), $errors, 1) ?>-->
                                    <?= hf_dropdown('horses_pattern', 'Pattern Color', isset($post['horses_pattern']) ? $post['horses_pattern'] : '', $base_patterns, array(), $errors, 1) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <?= hf_dropdown('horses_line', 'Line (optional)', isset($post['horses_line']) ? $post['horses_line'] : '', $lines, array(), $errors, 1) ?>
                                </div>
                                <div class="col-sm-6">
                                    <?= hf_multiselect('disciplines[]', 'Discipline', isset($post['disciplines']) ? $post['disciplines'] : '', $disciplines, array(), $errors, 1) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <?= hf_submit('breed', 'Place Request', array('class' => 'btn btn-primary col-sm-12')) ?>
                                </div>
                            </div>                    
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card mb-4">
                <h5 class="card-header">Pending Requests</h5>
                <div class="card-body">
                    <table class="table table-sm table-hover no-wrap" <? /*id="dt-horses-<?= $title ?> */ ?>>
                    <thead>
                        <tr>
                        <? if($horse['join_players_id'] == $this->session->userdata('players_id')): ?>
                            <th class="w-50"></th>
                        <? endif;?>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Born</th>
                        <th scope="col">Breed</th>
                        <th scope="col">Fee</th>
                        <? if($horse['join_players_id'] == $this->session->userdata('players_id')): ?>
                            <th></th>
                        <? endif;?>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                            foreach((array)$requests AS $request):
                                $mare = $request['mare'];
                                $stallion = $request['stallion'];
                                $mare_owner = $mare['join_players_id'] == $this->session->userdata('players_id') ? 'Mare\'s Owner ( Me )': 'Mare\'s Owner ( '.$mare['players_nickname'].' )';
                                $stallion_owner = $stallion['join_players_id'] == $this->session->userdata('players_id') ? 'Sire\'s Owner ( Me )': 'Sire\'s Owner ( '.$stallion['players_nickname'].' )';
                                $h = $request['receiver_player_id'] == $this->session->userdata('players_id') ? $stallion : $mare;
                            ?>
                                <tr>
                                    <? if($h['join_players_id'] == $this->session->userdata('players_id')): ?>
                                        <td class="w-50">
                                            <? if($request['horses_breedings_accepted']): ?>
                                                <i>Pending Approval<br/>
                                                    <?= $request['horses_breedings_gender'] ?> to Player #<?= $request['horses_breedings_owner'] ?></i>
                                            <? else: ?>
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
                                                            <?= hf_dropdown('horses_owner', 'Owner', isset($post['horses_owner']) ? $post['horses_owner'] : $request['horses_owner'], array("Sire's Owner" => $stallion_owner,"Mare's Owner"=>$mare_owner), array(), $errors,1) ?>
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
                                                            <?= hf_multiselect('disciplines[]', 'Discipline', isset($post['disciplines']) ? $post['disciplines'] : $request['horses_breedings_disciplines'], $disciplines, array(), $errors, 1) ?>
                                                        </div>
                                                    </div>                    
                                                    <?= hf_submit('accept', 'Accept', array('class' => 'btn btn-success col-sm-12')) ?>
                                                </form>
                                            <? endif; ?>
                                        </td>
                                    <? endif; ?>
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