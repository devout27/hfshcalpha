
<div class="row">
    <div class="col-lg-12">
    	<?= $article['articles_content'] ?>
    </div>
</div>


 <div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
          	<h4 class="card-header">Horses Available for Adoption</h4>
            <div class="card-body">
				<? $this->load->view('partials/horse-table', array('horses' => $search, 'title' => 'adopt')); ?>

            </div>
        </div>
    </div>
</div>