<div class="row">
    <div class="col-md-12 create-stable-btn-container">
      <a class="create-stable-btn" href="<?= $BASE_URL; ?>Stables/manage"><button type="button"><i class="las la-plus-circle"></i> <?=$sub_page_title?></button></a>
    </div>    
    <div class="col-sm-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover no-wrap" id="myStablesList">
                        <thead class="text-center">
                            <tr>
                              <th scope="col">Sr No.</th>
                              <th scope="col">ID</th>
                              <th scope="col">Name</th>                              
                              <th scope="col">Boarding Fee</th>
                              <th scope="col">Status</th>
                              <th scope="col">Created On</th>
                              <th scope="col">Action</th>                                
                            </tr>
                        </thead>
                        <tbody class="text-center">
                        </tbody>
                        <tfoot class="text-center">
                            <tr>
                              <th scope="col">Sr No.</th>
                              <th scope="col">ID</th>
                              <th scope="col">Name</th>      
                              <th scope="col">Boarding Fee</th>
                              <th scope="col">Status</th>
                              <th scope="col">Created On</th>
                              <th scope="col">Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>