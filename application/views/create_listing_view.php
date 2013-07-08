<div id="create_listing_modal" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
    <h3>Create Listing</h3>
  </div>
  <div class="modal-body">
		<form class="form form-horizontal" action="<?php echo site_url("/listing/create_listing");?>" method="POST">
			<div class="control-group">
				<label class="control-label" for="resource_select">Resource</label>
				<div class="controls">
					<select id="resource_select" name="resource_id">
						<?php foreach($listing_inventory->result() as $row){ ?>
							<option data-quantity="<?=$row->quantity?>" value="<?=$row->id?>"><?=$row->name?></option>	
						<?php } ?>
					</select>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="quantity_select">Quantity</label>
				<div class="controls">
					<input id="quantity_select" type="number" name="quantity" min="1" max="<?=$listing_inventory->row()->quantity;?>" step='1' value="1"/>
				</div>
			</div>

			<div class="control-group" style="text-align:center;">
				<textarea rows="1" class="span6" name="message" placeholder="What are you looking for in return..."></textarea>
			</div>
			<div class="control-group">
				<div class="controls">
					<button id="list_button" type="submit" class="btn btn-primary"><i class="icon-list"></i> Create Listing</button>
				</div>
			</div>
		</form>
  </div>

	<div id="list_error" class="alert alert-block alert-error span6" style="display:none; position:fixed; bottom:10px;">  
	 	<a class="close" onclick="$('#list_error').hide()">X</a>  
		<h4 class="alert-heading">Error!</h4>  
		<p id="list_error_message"></p>
	</div> 
</div>


<script>
$(function() {
	$('#resource_select').change(function () {
		$('#quantity_select').val(1);
		$('#quantity_select').attr("max", $('option:selected', this).data("quantity"));
		$('#list_error').hide();
		$('#list_button').removeAttr("disabled");
	});

	$('#quantity_select').change(function () {
		if(isNaN($('#quantity_select').val()) == true || $('#quantity_select').val() == "" || $('#quantity_select').val() < 1){
			$('#list_button').attr("disabled", "disabled");
			$('#list_error_message').text("You must enter a valid number.");
			$('#list_error').show("slide", { direction: "down" }, 'fast');
		}
		else if(parseInt($('#quantity_select').val()) > parseInt($('#quantity_select').attr('max'))){
			$('#list_button').attr("disabled", "disabled");
			$('#list_error_message').text("You do not have sufficent inventory for this listing.");
			$('#list_error').show("slide", { direction: "down" }, 'fast');
		}
		else{
			$('#list_error').hide();
			$('#list_button').removeAttr("disabled");
		}
	});
});

</script>
