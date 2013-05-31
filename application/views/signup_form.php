<div class="container-fluid">
<div class="row-fluid">
<div class="span3"></div>
<div class="span6">
<form class="form-horizontal" action='<?php echo site_url(); ?>/family/create_family' method="POST">
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
<div class="span3"></div>
</div>
</div>
