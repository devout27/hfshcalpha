<hr>

 <div class="row">
    <div class="col-sm-12">
        <div class="card mb-4">
          	<h4 class="card-header">Search Results</h4>
            <div class="card-body">
				<? $this->load->view('partials/owner-table', array('horses' => $search, 'title' => 'search')); ?>

            </div>
        </div>
    </div>
</div>