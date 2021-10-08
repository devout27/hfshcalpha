<div class="login-section">
    <div class="login-box">
        <div class="login-box-spacing">
            <div class="logo light">
               <!--<h1 class="text-center"><//?php echo SITE_NAME?></h1>-->	
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
                        <input type="text" placeholder="Username" name="username">
						<?php echo form_error('username');?>
                         <input type="password" placeholder="Password" name="password">
						<?php echo form_error('password');?>
                        <button type="submit" name="login">Login</button>
                    </div>
                <?php echo form_close();?>
            </div>
            <div class="forgot-password light">
               <p class="text-center"><a href="<?php echo $BASE_URL;?>super-admin/forgot-password">Forgot Password?</a></p>
            </div>
        </div>
    </div>
</div>