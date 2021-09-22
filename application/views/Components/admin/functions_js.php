<script>
  

    function error(msg)
	{
		flash(msg,{
				'autohide' : true,
				'bgColor' : '#2A4252',
				'vPosition' :'top',
				'hPosition' :'right',
				'fadeIn' : 400,
				'fadeOut' : 400,
				'clickable' : true,
				'duration' : 4000
			});
		
	}
	function success(msg)
	{
		flash(msg,{
					'autohide' : true,
					'bgColor' : '#397800',
					'vPosition' :'top',
					'hPosition' :'right',
					'fadeIn' : 400,
					'fadeOut' : 400,
					'clickable' :true,
					'duration' : 4000
				});
	}
    function confirmationBox(msg,url){
		
	    $("#msg-confirmation").modal('show');
        $("#msg-confirmation .modal-body").html('<p style="color:white !important;">'+msg+'</p>');
		$("#msg-confirmation .modal-footer").html("<input type='hidden' value='"+url+"' id='confirmationURlID'><button type='button' class='btn btn-danger' style='background-color:#ff0000'  onclick='confirmationYes()'>Yes</button><button type='button' class='btn btn-secondary' data-dismiss='modal'>No</button>");
	}
    function confirmationYes(){
	  url=$("#confirmationURlID").val(); 
	  location.assign(url); 	
	}

    function showLodear(){
        $("#loder-img").show();
    }
    function updateInteger(act,elementId){
			var setValue = 0;
			
			if( $("#"+elementId).val()!='' ){
              setValue = parseInt($("#"+elementId).val()); 
			}

			if(act=='increase'){
				setValue = setValue + 1;
			}else if(act=='decrease'){
              
			  if(setValue>0){
				setValue = setValue - 1;
			  }
			}
             
			$("#"+elementId).val(setValue);
		 }

         	//for image preview
	function readUrl(input,elementid) {	 
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
            
            if(elementid=="card-image-preview" || elementid=="banner-image-preview"){	
                
                $('#'+elementid+'-wrap').show(); 
                $('#'+elementid).attr('src', e.target.result); 
                var height = ''; var width='';
               if(elementid=="card-image-preview"){
                 height = 70; width = 100;
               }                                
 
                $('#'+elementid).css('width', width); 	
                $('#'+elementid).css('height', height); 	
            
            }else
            {
                $('#'+elementid+'-wrap').show(); 
                $('#'+elementid).attr('src', e.target.result); 
                if(elementid=="banner-image-preview"){
                    height = 200;  width = 500;                           
                }else if(elementid=="sponsor-image-preview"){
                    height = 200;  width = 500;
                }
            }
            
            if(elementid=="user-profile-pic-preview"){
            
                $('#'+elementid).css('background-image', 'url(' + e.target.result + ')'); 

            }
            
            
            }
            
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }else{
            $('#'+elementid).hide(); 
        }
    }
    function isNumber(evt,id) {
		
        var iKeyCode = (evt.which) ? evt.which : evt.keyCode
        if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57)){
		  
		    $("#"+id).html("Please enter a numeric value.");
                
            return false;
		}else{
			$("#"+id).html("");
            return true;
		}
    }


    function removeImagePreview(elementId,inputFieldId){

    $("#"+elementId).hide();

        $("#"+inputFieldId).val('');    

    }
    function deleteCardImage(id){

        url = '<?php echo BASE_URL_ADMIN; ?>Cards/deleteCardImage';
        
        $.ajax({
            url:url,
            type:"post",
            data:"id="+id,
            success:function(data){
                let response = JSON.parse(data);
            let msg = response.msg;
            let status = response.status;

            if(status=="success"){
            
                $("#card-image-wrap-"+id).hide();
            
            }else{

                    alert(msg);

            }	      
                            

            },

        }); 

    }
    var loadFile = function(event) {
                var output = document.getElementById('output');	
                if(typeof event.target.files[0] != "undefined")
                {
                    $('.img-preview').html('<img src="'+URL.createObjectURL(event.target.files[0])+'" class="img-thumbnail"/><br>');    
                }else
                {
                    $('.img-preview').html('');
                }	
            };                        
            function linkTypeChange(link_type){  
             
             if(link_type!=''){   
                    
                  if(link_type=='custom'){
                  
                      $("#page-list").hide();
                      $("#category-list").hide();
                      
                      $("#url-input-section").show();        
                  
                  }else if(link_type=='category'){
                      
                      $("#page-list").hide();
                      $("#category-list").show();
                      
                      $("#url-input-section").hide();
                  
                  }else if(link_type=='page'){
                      
                      $("#page-list").show();
                      $("#category-list").hide();
                      
                      $("#url-input-section").hide();
                  
                  }
              }else{
                      $("#page-list").show();
                      $("#category-list").show();
                      
                      $("#url-input-section").show();

                      
              }
          }

          function fileCheckOnSelect(fyl){
            var input_field_id = $(fyl).attr('id');
            var file_check = 'passed';
            var file_check_error_msg = '';
             return_back = new Array();
            $("#"+input_field_id+"-show-error").html('');  

            var file_allowed_types = '<?php echo FILE_ALLOWED_TYPES; ?>';
            var file_max_size = '<?php echo FILE_MAX_SIZE; ?>';

            var file_allowed_types_arr = file_allowed_types.split('|');
        
            var file_extension = fyl.files[0].name.split('.').pop();
            var file_size = fyl.files[0].size;
            
            
            
            file_extension=file_extension.trim();

            if(file_extension!='jpg' && file_extension!='jpeg' && file_extension!='png' && file_extension!='gif'){
                
                file_check = 'failed';
                file_check_error_msg = 'File type not allowed.';
                
                }else if(file_size>file_max_size){
                
                file_check = 'failed';
                file_check_error_msg = 'File is too big to upload. allowed size is 10MB';
                
            }
            

            
            if(file_check=='passed'){                 
                readUrl(fyl,input_field_id+'-preview');
            }else{
                var d = {file_check_error_msg,status:false}
                return d; 
            }    
          }

          
				function deleteBannerImage(id){
					url = '<?php echo BASE_URL_ADMIN; ?>Banners/deleteBannerImage';
					
					$.ajax({
						url:url,
						type:"post",
						data:"id="+id,
						success:function(data){
							$("#msg-confirmation").modal('hide'); 
						let response = JSON.parse(data);
						let msg = response.msg;
						let status = response.status;

						if(status=="success"){
						
							$("#banner-image-wrap-"+id).hide();
						
						}else{

								alert(msg);

						}	      
									

						},

					});

                }
                function deleteSponsorImage(id){
					url = '<?php echo BASE_URL_ADMIN; ?>Sponsors/deleteSponsorImage';					
					$.ajax({
						url:url,
						type:"post",
						data:"id="+id,
						success:function(data){
							$("#msg-confirmation").modal('hide'); 
                            let response = JSON.parse(data);
                            let msg = response.msg;
                            let status = response.status;
                            if(status=="success"){                            
                                $("#sponsor-image-wrap-"+id).hide();                            
                            }else{
                                    alert(msg);
                            }	      									
						},

					});

                }

</script>