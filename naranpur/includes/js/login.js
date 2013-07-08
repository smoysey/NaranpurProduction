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
				$('#login_error').show();
				$('#login_error_message').text("Invalid Name or Password");	
			}
    }
  });
});
