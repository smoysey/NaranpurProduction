<div class="container-fluid">
<div class=row-fluid>
<div class="span4 offset4">

  <fieldset style="text-align:center;">
		<form action='<?php echo site_url(); ?>/family/validate_credentials' method="POST">
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
 	     <!-- Button -->
 	    	<div class="controls">
 	       	<button class="btn btn-success pull-left" type="submit">Login</button>
					<a href="<?php echo site_url();?>/family/signup" class="btn btn-primary pull-right">Create a Family</a>
				</div>
 	   </div>
		</form>
 	</fieldset>

</div>
</div>
</div>
