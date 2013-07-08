<div class="modal hide" id="myModal">

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">x</button>
    <h3>Post a Discussion</h3>
  </div>

  <div class="modal-body">
    <form id="discussion" class="form-inline well">
			
			<div class="control-group">
				<input class="span12" type="text" name="subject" placeholder="Subject">
			</div>

			<div class="control-group">
      	<textarea class="span12" style="resize:none" rows=6 name="content" id="content" placeholder="What is your discussion..."></textarea>
			</div>

			<div class="control-group">
      	<a id="discussion_button" class="btn btn-primary">Post</a>
			</div>

    </form>

	<div id="discussion_error" class="alert alert-block alert-error span4" style="display:none; position:fixed; bottom:10px;">  
	  <a class="close" onclick="$('#discussion_error').hide();">X</a>  
		<h4 class="alert-heading">Error!</h4>  
		<p id="discussion_error_message"></p>
	</div> 

  </div>


</div>

<script> 
$('#discussion_button').click(function() {
 	$.ajax({
		type: "post",
		url: "<?=site_url("/discussion/submit_discussion");?>",
		data: $("#discussion").serialize(),
	  dataType: "json",
    success: function(data){
			if(data.success) window.location.assign('<?=site_url("discussion/all");?>');
			else{
				$('#discussion_error').show("slide", { direction: "down" }, 'fast');
				$('#discussion_error_message').html(data.message);	
			}
    }
  });
});
</script>
