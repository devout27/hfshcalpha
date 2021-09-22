<?php if($this->session->flashdata('message_error')){?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= $this->session->flashdata('message_error');?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
<?php 
}?>
<?php if($this->session->flashdata('message_success')){?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= $this->session->flashdata('message_success');?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
<?php 
}?>










