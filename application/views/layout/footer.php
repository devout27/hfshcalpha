


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



</div>
    <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; HFSHC.com <?= date('Y') ?><BR><BR><small>All pages and content found at HFSHC.COM are ©<?= date('Y') ?>, and are part of a game and completely fictional.<BR>All photographs and design elements are content copyright 1997 -  <?= date('Y') ?> HFSHC.com.<BR>No part may be reproduced either in whole or in part without express written permission.</small></p>
      </div>
      <!-- /.container -->
    </footer>


    <!-- Bootstrap core JavaScript -->
	<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <!--<script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>-->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous"></script>

  <? $this->load->view("partials/js/datatables")?>



  <script src="/js/main.js?<?= rand(999,84589385743) ?>"></script>

  </body>

</html>
