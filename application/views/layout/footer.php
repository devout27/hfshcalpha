


<div class="modal fade" id="dialog-confirm-general" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Confirm</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	Are you sure you want to do this?
      	<span id="div-confirm-custom"></span>
      	<div class="hidden" id="div-confirm-general-link"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="button-confirm-general">Confirm</button>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('elements/admin/modals'); ?>

</div>
    <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; HFSHC.com <?= date('Y') ?><BR><BR><small>All pages and content found at HFSHC.COM are ©<?= date('Y') ?>, and are part of a game and completely fictional.<BR>All photographs and design elements are content copyright 1997 -  <?= date('Y') ?> HFSHC.com.<BR>No part may be reproduced either in whole or in part without express written permission.</small></p>
      </div>
      <!-- /.container -->
    </footer>


    <!-- Bootstrap core JavaScript -->
	<script src="<?= base_url('assets/js/jquery-3.3.1.min.js') ?>" ></script>
  <script src="<?= base_url('assets/js/jquery.dataTables.min.js'); ?>" ></script>  
	<script src="<?= base_url('assets/js/bootstrap.min.js'); ?>" ></script>
	<script src="<?= base_url('assets/js/jquery-ui.min.js'); ?>" ></script>
  <script src="<?= base_url('assets/admin/js/flash.js'); ?>"></script>
  <script src="<?= base_url('assets/calendar/jquery.simple-calendar.js'); ?>"></script>
  <? $this->load->view("partials/js/datatables")?>
  <? $this->load->view("partials/js/custom")?>
  <? $this->load->view("partials/js/main")?>
  <script>
    $(document).ready(function(){
      /* alerts */
        <?php if($this->session->flashdata('message_error')){?>								
          error("<?=$this->session->flashdata('message_error')?>");
        <?php }elseif($this->session->flashdata('message_success')){ ?>
          success("<?=$this->session->flashdata('message_success')?>");
        <?php } ?>								
		  /* alerts end */
      $(document).on("click",'.my-del-btn',function(e){
            e.preventDefault()
            var url = $(this).attr('url')
            var msg = $(this).attr('msg')
            $("#msg-confirmation").modal('show');
            $("#msg-confirmation .modal-body").html('<p style="color:white !important;">'+msg+'</p>');
            $("#msg-confirmation .modal-footer").html("<input type='hidden' value='"+url+"' id='confirmationURlID'><button type='button' class='btn btn-primary' onclick='confirmationYes()'>Yes</button><button type='button' class='btn btn-secondary' data-dismiss='modal'>No</button>");
      })
    })
        
  </script>
  <script src="<?= base_url('assets/js/main.js?v='.rand(999,84589385743));  ?>"></script>
  </body>
</html>
