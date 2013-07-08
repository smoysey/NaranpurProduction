<div class="container-fluid">
	<div class="row-fluid">
		<form class="span4 offset4 text-center" id="login">

    	<div id="legend">
     		<legend>Naranpur Login</legend>
	    </div>

			<div class="control-group">
				<div class="controls">
					<input type="text" id="family_name" name="family_name" placeholder="Family Name" class="input-xlarge">
				</div>
			</div>
 
			<div class="control-group">
				<div class="controls">
					<input type="password" id="password" name="password" placeholder="Password" class="input-xlarge">
				</div>
			</div>
 
			<div class="control-group">
 	    	<div class="controls">
 	      	<a id="login_button" class="btn btn-success pull-left">Login</a>
					<a href="<?php echo site_url();?>/family/signup" class="btn btn-primary pull-right">Create a Family</a>
				</div>
 	   	</div>

		</form>
	</div>
	
	<div class="row-fluid">
		<div class="span8 offset2">
			<div id="error" class="alert alert-block alert-error " style="display:none; bottom:10px;">  
  			<a class="close" onclick="$('#error').hide();">X</a>  
  			<h4 class="alert-heading">Error!</h4>  
				<p id="error_message"></p>
			</div> 
		</div>
	</div>

</div>


<script> 

$('input').change( function() { $('#error').hide();  });


$("#login_button").on("click", function(event){
  var data = $("#login").serialize();
  
	$.ajax({
		type: "post",
		url: "<?=site_url("/family/validate_credentials");?>",
		data: data,
	  dataType: "json",
    success: function(data){
			if(data.success) window.location.assign('<?=site_url("dashboard");?>');
			else{
				$('#error').slideDown();
				$('#error_message').text("Invalid Name or Password");	
			}
    }
  });
});

</script>
