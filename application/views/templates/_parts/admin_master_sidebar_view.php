<aside class="main-sidebar ubg-dark-light">
		<div class="desktop-tagline ubg-dark light text-center d-none d-lg-block">			
			<h3><a href="<?php echo $BASE_URL_ADMIN ?>Dashboards"><img src="<?=SITE_LOGO?>"></a></h3>
		</div>
        <section class="sidebar">
	        <ul class="sidebar-menu">
	            <li class="treeview <?php if(in_array($CLASS_NAME,array('dashboards'))) echo 'active'?>">
	              	<a href="<?php echo $BASE_URL_ADMIN ?>dashboard">
	                	<i class="las la-tachometer-alt"></i>
	                	<span>Dashboard</span>
	             	</a>
				</li>
				<li class="treeview <?php if(in_array($CLASS_NAME,array('members','horses','banks'))) echo 'active'?>" style="display:<?php if(in_array($CLASS_NAME,array('members','horses','banks'))) echo 'block;'?>">
	            	<a href="javascript:void(0)">
	                	<i class="las la-user-friends"></i>
	                	<span>Users Management</span>
	               		<i class="la la-angle-left pull-right"></i>
	              	</a>
	              	<ul class="treeview-menu" style="display:<?php if(in_array($CLASS_NAME,array('members','horses','banks'))) echo 'block;'?>">
					    <li  class="<?php echo $CLASS_NAME=='members' && $METHOD_NAME=='index'  ? 'active':''?>">
							<a href="<?php echo $BASE_URL_ADMIN ?>Members">
								<i class="las la-circle"></i> Members List
							</a>
						</li>                        
					    <li  class="<?php echo $CLASS_NAME=='horses' && $METHOD_NAME=='index'  ? 'active':''?>">
							<a href="<?php echo $BASE_URL_ADMIN ?>Horses">
								<i class="las la-circle"></i> Horses List
							</a>
						</li>
					    <li  class="<?php echo $CLASS_NAME=='banks' && $METHOD_NAME=='index'  ? 'active':''?>">
							<a href="<?php echo $BASE_URL_ADMIN ?>banks">
								<i class="las la-circle"></i> Banks List
							</a>
						</li>
						<li  class="<?php echo $CLASS_NAME=='activity' && $METHOD_NAME=='index'  ? 'active':''?>">
							<a href="<?php echo $BASE_URL_ADMIN ?>Activity">
								<i class="las la-circle"></i> Activity Logs
							</a>
						</li>
					</ul>
	            </li>
				<li class="treeview <?php if(in_array($CLASS_NAME,array('stables','amenities','packages'))) echo 'active'?>"   style="display:<?php if(in_array($CLASS_NAME,array('stables','amenities','packages'))) echo 'block;'?>">
	            	<a href="javascript:void(0)">
	                	<i class="las la-award"></i>
	                	<span>Stables Management</span>
	               		<i class="la la-angle-left pull-right"></i>
	              	</a>
	              	<ul class="treeview-menu  <?php if(in_array($CLASS_NAME,array('stables','amenities','packages'))) echo 'active'?>"   style="display:<?php if(in_array($CLASS_NAME,array('stables','amenities','packages'))) echo 'block;'?>">
					 	<li class="<?php  echo $CLASS_NAME=='stables' && $METHOD_NAME=='index'  ? 'active':''?>">
							<a href="<?php echo $BASE_URL_ADMIN ?>Stables">
								<i class="las la-circle"></i> Stables List
							</a>
						</li>					    
					 	<li class="<?php  echo $CLASS_NAME=='packages' && $METHOD_NAME=='index'  ? 'active':''?>">
							<a href="<?php echo $BASE_URL_ADMIN ?>Packages">
								<i class="las la-circle"></i> Packages List
							</a>
						</li>					    
					 	<li class="<?php  echo $CLASS_NAME=='amenities' && $METHOD_NAME=='index'  ? 'active':''?>">
							<a href="<?php echo $BASE_URL_ADMIN ?>Amenities">
								<i class="las la-circle"></i> Amenities List
							</a>
						</li>					    
					</ul>
	            </li>											           
				<li class="treeview <?php if(in_array($CLASS_NAME,array('accounts'))) echo 'active'?>"   style="display:<?php if(in_array($CLASS_NAME,array('accounts'))) echo 'block;'?>">
	            	<a href="javascript:void(0)">
	                	<i class="las la-award"></i>
	                	<span>Account</span>
	               		<i class="la la-angle-left pull-right"></i>
	              	</a>
	              	<ul class="treeview-menu  <?php if(in_array($CLASS_NAME,array('accounts'))) echo 'active'?>"   style="display:<?php if(in_array($CLASS_NAME,array('accounts'))) echo 'block;'?>">
					 	<li class="<?php  echo $CLASS_NAME=='accounts' && $METHOD_NAME=='changepassword'  ? 'active':''?>">
							<a href="<?php echo $BASE_URL_ADMIN ?>change-password">
								<i class="las la-circle"></i> Change Password
							</a>
						</li>					    
					</ul>
	            </li>											           
				<li class="treeview">
	              	<a href="<?php echo $BASE_URL_ADMIN ?>Accounts/logout">
	                	<i class="las la-sign-out-alt"></i>
	                	<span>Sign Out</span> 
	              	</a>
	            </li>	   
	        </ul>
    	</section>
	</aside> 