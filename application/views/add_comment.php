<div class="modal hide" id="myModal">

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">x</button>
    <h3>Post a Comment</h3>
  </div>

  <div class="modal-body">
    <form class="form-inline well" method="post" action='<?php echo site_url(); ?>/discussion/submit_comment'>

				<input type="hidden" name="diss_id" id="diss_id" value=<?=$diss_id;?> />

			<div class="control-group">
      	<textarea class="span12" style="resize:none" rows=8 name="content" id="content" placeholder="Leave a comment..."></textarea>
			</div>

			<div class="control-group">
      	<button type="submit" class="btn btn-primary">Post</button>
			</div>

    </form>
  </div>


</div>

