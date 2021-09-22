<script>
    $(document).ready(function(){
        /* alerts */
			<?php if($this->session->flashdata('message_error')){?>								
				error("<?=$this->session->flashdata('message_error')?>");
			<?php }elseif($this->session->flashdata('message_success')){ ?>
				success("<?=$this->session->flashdata('message_success')?>");
			<?php } ?>								
		/* alerts end */
        if($('#example1').length)
        {
            $('#example1').DataTable({
                "order": [[ 0, "desc" ]]
            });        
        }        
        $("#default_currency").change(function(){
            var option = $('option:selected', this).attr('symbol');
            $("input[name='default_currency_symbol']").val(option)
        })
        $("#user-profile-pic").change(function() { 
            readUrl(this,'user-profile-pic-preview');
            $('#profile-pic-edit-form').submit();
        });
        $("#myTab7 .nav-link").click(function(){
            $("input[name='currentTab']").val($(this).attr('id'))
        })
        // Animate the element's value from x to y:
        $({ someValue: 0 }).animate({ someValue: Math.floor(Math.random() * 3000) }, {
            duration: 3000,
            easing: 'swing', // can be anything
            step: function () { // called on every step
                // Update the element's text with rounded-up value:
                $('.count').text(commaSeparateNumber(Math.round(this.someValue)));
            }
        });
        
        function commaSeparateNumber(val) {
            while (/(d+)(d{3})/.test(val.toString())) {
                val = val.toString().replace(/(d)(?=(ddd)+(?!d))/g, "$1,");
            }
            return val;
        } 
        
    })
</script>