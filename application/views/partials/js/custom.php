<script>
    function confirmationBox(msg,url){
		
	    $("#msg-confirmation").modal('show');
        $("#msg-confirmation .modal-body").html('<p style="color:white !important;">'+msg+'</p>');
		$("#msg-confirmation .modal-footer").html("<input type='hidden' value='"+url+"' id='confirmationURlID'><button type='button' class='btn btn-danger' style='background-color:#ff0000'  onclick='confirmationYes()'>Yes</button><button type='button' class='btn btn-secondary' data-dismiss='modal'>No</button>");
	}
    function confirmationYes(){
	  url=$("#confirmationURlID").val(); 
	  location.assign(url); 	
	}
    function error(msg)
	{
		flash(msg,{
				'autohide' : true,
				'bgColor' : '#4d4f3d',
				'vPosition' :'bottom',
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
					'bgColor' : '#4d4f3d',
					'vPosition' :'bottom',
					'hPosition' :'right',
					'fadeIn' : 400,
					'fadeOut' : 400,
					'clickable' :true,
					'duration' : 4000
				});
	}
</script>