<footer class="main-footer text-center ubg-dark">
    <p>Copyright © 2021  <?php echo SITE_NAME?> - All Rights Reserved.</p>
</footer>
<?php $this->load->view('elements/admin/modals'); ?>
<script src="<?php echo $BASE_URL;?>assets/admin/js/custom.js" type="text/javascript"></script>
<?php echo $before_body;?> 
<script src="<?=$BASE_URL?>assets/admin/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $BASE_URL ?>assets/admin/js/flash.js"></script>
<!-- js components -->
    <?php $this->load->view('Components/admin/functions_js'); ?>
    <?php $this->load->view('Components/admin/main_js'); ?>    
    <?php $this->view('Components/admin/datatables_js'); ?>
    <script>
        $(document).on("click",'.my-del-btn',function(e){
            e.preventDefault()
            var url = $(this).attr('url')
            var msg = $(this).attr('msg')
            $("#msg-confirmation").modal('show');
            $("#msg-confirmation .modal-body").html('<p style="color:white !important;">'+msg+'</p>');
            $("#msg-confirmation .modal-footer").html("<input type='hidden' value='"+url+"' id='confirmationURlID'><button type='button' class='btn btn-primary' onclick='confirmationYes()'>Yes</button><button type='button' class='btn btn-secondary' data-dismiss='modal'>No</button>");
        })
    </script>
<!-- js components end-->
</body>
</html>
