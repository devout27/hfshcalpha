<div class="login-section">
    <div class="login-box">
        <div class="login-box-spacing">
            <div class="logo light">
                <h1 class="text-center"><img src="<?=SITE_LOGO?>" alt="logo"></h1>
            </div>
            <div class="login-field-section">
                <div class="text-center" style="color:red">
					<?php echo $this->session->flashdata('message_error');?></div>
				<div class="text-center" style="color:green">
					<?php echo $this->session->flashdata('message_success');?>
				</div>
				<?php echo form_open_multipart('',array('class'=>'form-horizontal'));?>
                    <div class="login-fields">
                        <input type="email" placeholder="Enter Email Id" name="email" >
						<?php echo form_error('email');?>
                        <button type="submit" name="login">Submit</button>
                    </div>
					
				<?php echo form_close();?>
            </div>
            <div class="forgot-password light">
                 <p class="text-center"><a href="<?php echo $BASE_URL;?>super-admin-login">Back  To Login</a></p>
            </div>
        </div>
    </div>
</div>