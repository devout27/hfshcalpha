
<?
$post = $this->session->flashdata('post');
$errors = $this->session->flashdata('errors');
if($horse['horses_breeding_fee'] == 0){$horse['horses_breeding_fee'] = "";}
?>
<div class="row">
    <div class="col-lg-12">
        <br/>
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title">Send Purposal to <?php echo $horse['players_nickname'] ?></h2>
                <a href="javascript:void(0);" style="text-decoration:none;" >Sale Price $<?= number_format($horse['horses_sale_price']) ?></a>
                <p class="card-text">
                    <form method="post" action="/horses/buy/<?= $horse['horses_id'] ?>">				                    
                        <?= hf_input('title', 'Title', $_POST, array('placeholder' => ''), $errors) ?>
                        <?= hf_input('players_email', 'Email Address', $_POST ?: $player, array('placeholder' => ''), $errors,'email') ?>
                        <?= hf_textarea('description', 'Description', $_POST, array('placeholder' => '','cols'=>"142","rows"=>"10"), $errors) ?>
                </p>
            </div>
            <div class="card-footer text-muted">
                        <?= hf_submit('submit', 'Submit', array('class' => 'btn btn-primary col-sm-12')) ?>
                    </form>
            </div>
        </div>
    </div>
</div>