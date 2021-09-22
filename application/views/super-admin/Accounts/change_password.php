<section class="content">
    <div class="section-area">
        <div class="inner-head-section">
            <div class="title dark">
                <h3><?php echo $page_title?></h3>
            </div>
        </div>        
        <div class="card-box-area">
            <div class="card-box-area-inner">

<form action="<?php echo $BASE_URL_ADMIN; ?>change-password" method="post">
  <div class="row">

    <div class="col-md-3"></div>
      
        	
		<div class="col-md-6">
		
			<div class="form-group">
				<label for="site_name" class="col-form-label">Current Password</label>
				<input  name="current_password" type="password" class="form-control" value="<?php echo $postData['current_password']; ?>">
				<span class="error"><?php if( isset($errors['current_password']) ){ echo $errors['current_password'];  } ?></span>
			</div>    
			<div class="form-group">
				<label for="new-password" class="col-form-label">New Password</label>
				<input id="new-password"  name="new_password" type="password" class="form-control" value="<?php echo $postData['new_password']; ?>">      
				<span class="error"><?php if( isset($errors['new_password']) ){ echo $errors['new_password'];  } ?></span>
			</div>  
			<div class="form-group">
				<label for="confirm-password" class="col-form-label">Confirm Password</label>
				<input id="confirm-password"  name="confirm_password" type="password" class="form-control" value="<?php echo $postData['confirm_password']; ?>">      
				<span class="error"><?php if( isset($errors['confirm_password']) ){ echo $errors['confirm_password'];  } ?></span>
			</div>                             
				
			<div class="form-group">                
				<label class="col-form-label"></label>
				<input id="submit" type="submit" class="form-control btn btn-primary" value="Save">
				<div class="invalid-feedback"></div>
			</div>            
			
		</div>
		<div class="col-md-3"></div> 
	
	  </div>
    </form>
          </div>
        </div>
    </div>
</section>     