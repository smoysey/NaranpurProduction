<div class="modal hide" id="myModal">

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">x</button>
    <h3>Post a Discussion</h3>
  </div>

  <div class="modal-body">
    <form class="form-inline well" method="post" action='<?php echo site_url(); ?>/discussion/submit'>
			
			<div class="control-group">
				<input class="span12" type="text" name="subject" placeholder="Subject">
			</div>

			<div class="control-group">
      	<textarea class="span12" style="resize:none" rows=6 name="content" id="content" placeholder="What is your discussion..."></textarea>
			</div>

			<div class="control-group">
      	<button type="submit" class="btn btn-primary">Post</button>
			</div>

    </form>
  </div>


</div>

