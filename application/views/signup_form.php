<div class="container-fluid">
<div class="row-fluid">
<div class="span6 offset3">
<form id="new_family" class="form-horizontal">
	<fieldset>
 		<div id="legend">
			<legend class="">Create a Family</legend>
		</div>

        <div class="control-group">
          <!-- First Name -->
          <label class="control-label"  for="name">Family Name</label>
          <div class="controls">
           <input type="text" id="name" name="name" placeholder="Ex: Smith" class="input-xlarge">
          </div>
        </div>
 
        <div class="control-group">
          <!-- Email -->
          <label class="control-label"  for="email_address">Email Address</label>
          <div class="controls">
            <input type="text" id="email_address" name="email_address" placeholder="Ex: John_Smith@gmail.com" class="input-xlarge">
          </div>
        </div>
 
        <div class="control-group">
          <!-- Password -->
          <label class="control-label"  for="password1">Password</label>
          <div class="controls">
            <input type="password" id="password1" name="password1" placeholder="Password" class="input-xlarge">
          </div>
        </div>
 
        <div class="control-group">
          <!-- Password 2 -->
          <label class="control-label" for="password2">Confirm Password</label>
          <div class="controls">
            <input type="password" id="password2" name="password2" placeholder="Confirm Password" class="input-xlarge">
          </div>
        </div>

				<div class="control-group">
		 			<div class="controls">
						<button class="btn btn-success" type="submit">Create</button>
					</div>
				</div>

		</fieldset>
    </form>
</div>
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


$("button").on("click", function(event){
	event.preventDefault();
  var data = $("#new_family").serialize();
  
	$.ajax({
		type: "POST",
		url: "<?=site_url("/family/create_family");?>",
		data: data,
	  dataType: "json",
    success: function(data){
			if(data.success) window.location.assign('<?=site_url("dashboard");?>');
			else{
				$('#error').slideDown();
				$('#error_message').html(data.message);	
			}
    }
  });
});

</script>
