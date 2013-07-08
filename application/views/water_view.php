<select id="methodSelect">
  <option value="-1">Choose a Collection Method</option>
	<?php foreach($water_methods->result() as $row){ ?>
  	<option value="<?=$row->id;?>">
			<?=$row->method;?>
		</option>
	<?php } ?>
  <option value="3">Well</option>
</select>

<div id="body" style="display:none;">
	<dl class="dl-horizontal">
		<dt>Collecting Method:</dt>
		<dd id="method"></dd>
		<dt>Collecting Hours:</dt>
	  <dd id="hours"></dd>
		<dt>Collecting Yield:</dt>
 	 	<dd id="rate"></dd>
	</dl>

	<hr/>

	<div class="input-prepend">
	<div class="input-append">
		<span class="add-on">
			<i class="icon-time"></i>
		</span>
		<input class="span5" id="updatedHours" type="text" placeholder="Collecting Hours">
		<button id="button" class="btn btn-info" type="button">Update Hours</button>
	</div>
	</div>
	
	<div id="update_well" style="display:none;">
		<div class="input-prepend">
		<div class="input-append">

			<span class="add-on">
				<i class="icon-cog"></i>
			</span>
			<select class="span5" id="well_select">
				<?php foreach($well_options->result() as $well){ ?>
 					<option value="<?=$well->id;?>" data-cost="<?=$well->cost?>">
						Type: <?=$well->type;?> / Rate: <?=$well->pumpingRate;?> / Cost: $<?=$well->cost;?> 
					</option>
				<?php } ?>
			</select>
			<button class="btn btn-info" id="buy_well">Update Well</button>	

		</div>
		</div>
	</div>

</div>

<div id="water_error" class="alert alert-block alert-error span6" style="display:none; position:fixed; bottom:10px;">  
  <a class="close" onclick="$('#water_error').hide();">X</a>  
  <h4 class="alert-heading">Error!</h4>  
	<p id="water_error_message"></p>
</div> 

<script>
var well = "";

$('#methodSelect').change(function () {
	if($('#methodSelect option:selected').val() == -1){
		$('#body').hide();
		$('#error').hide();
	}
	else if($('#methodSelect option:selected').val() == 3){
		$('#water-error').hide();
		update_well();
	}
	else{
		update();
		$('#water-error').hide();
		$('#body').show();
	}
});

$('#button').click(function () {
  $.ajax({
    type: "POST",
		url: "<?=site_url()?>/water/check_hours",
		data: "hours=" + $('#updatedHours').val(),
		dataType: "json",
		success: function(data){
			if(data.success == 1){
				if($('#methodSelect option:selected').val() == 3){
			  	var post = {
						'lmu_id': <?=$lmu_id?>, 
						'hours': $('#updatedHours').val()
					};
			  	$.ajax({
			    	type: "POST",
				    url: "<?=site_url()?>/water/update_well_hours",
						data: post,
				    dataType: "json",
						success: function(data){
							update_well();
			    	}
					});
				}
				else{
			  	var post = {
						'method_id': $('#methodSelect option:selected').val(), 
						'hours': $('#updatedHours').val()
					};
			  	$.ajax({
			    	type: "POST",
				    url: "<?=site_url("/water/update_method")?>",
						data: post,
				    dataType: "json",
						success: function(data){
							update();
			    	}
					});
				}
			}
			else{
				if(data.fail == 'form')
					$('#water_error_message').text("Please enter a numerical value.");
				else
					$('#water_error_message').text("You don't have enough family members to start this task.  Adjust your other management decisions to release a family member's time");
					$('#water_error').show("slide", { direction: "down" }, 'fast');
			}
		}
	});
});

$('#buy_well').click(function () {
	$('#water-error').hide();
	if(well == $('#well_select option:selected').val()){
		$('#water_error_message').text("The well is already of this type.");
		$('#water_error').show("slide", { direction: "down" }, 'fast');
	}
	else{
	  var post = {
			'well_type_id': $('#well_select option:selected').val(), 
			'lmu_id': <?=$lmu_id?>,
			'cost': $('#well_select option:selected').data('cost') 
		};
		$.ajax({
			type: "POST",
	 	  url: "<?=site_url("/water/buy_well")?>",
	    data: post,
	    dataType: "json",
	    success: function(data){
				if(data.success == 1){
					update_well();
				}
				else{
					$('#water_error_message').text("You do not have the funds to upgrade to this well");
					$('#water_error').show("slide", { direction: "down" }, 'fast');
				}
 	   }
	  });
	}
});

function update(){
	$.ajax({
    type: 'POST',
    url: '<?=site_url("/water/get_method")?>',
    data: 'method_id=' + $('#methodSelect option:selected').val(),
    dataType: 'json',
    success: function(data){
			$('#update_well').hide();
			$('#method').text(data[0].method);
			$('#hours').text(data[0].hours);
			var rate = data[0].hours * data[0].rate;
			$('#rate').text(rate);
    }
  });
}

function update_well(){
	$.ajax({
    type: 'POST',
    url: '<?=site_url("/water/get_well")?>',
    data: 'lmu_id=<?=$lmu_id?>',
    dataType: 'json',
    success: function(data){
				$('#update_well').show();
				$('#body').show();
				$('#method').text(data[0].type + ' well');
				$('#hours').text('Hours: ' + data[0].hours);
				var rate = data[0].hours * data[0].pumpingRate;
				$('#rate').text('Current Water Yield: ' + rate);
				well = data[0].well_type_id;
    }
  });
}
</script>
