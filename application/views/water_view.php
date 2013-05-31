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
	<ul class="nav nav-list">
		<li id="method" class="nav-header"></li>
	  <li id="hours" class="nav-header">Current Hours</li>
 	 	<li id="rate" class="nav-header">Current Yield</li>
	</ul>

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

<div id="error" class="alert alert-blocki alert-error" style="display:none;">  
  <a class="close" onclick="$('#error').hide()">X</a>  
  <h4 class="alert-heading">Error!</h4>  
	<p id="error_message"></p>
</div> 

<script>
var well = "";

$('#methodSelect').change(function () {
	if($('#methodSelect option:selected').val() == -1){
		$('#body').hide();
		$('#error').hide();
	}
	else if($('#methodSelect option:selected').val() == 3){
		$('#error').hide();
		update_well();
	}
	else{
		update();
		$('#error').hide();
		$('#body').show();
	}
});

$('#button').click(function () {
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
	    url: "<?=site_url()?>/water/update_method",
			data: post,
	    dataType: "json",
			success: function(data){
				update();
    	}
		});
	}
});

$('#buy_well').click(function () {
	$('#error').hide();
	if(well == $('#well_select option:selected').val()){
		$('#error_message').text("The well is already of this type.");
		$('#error').show();
	}
	else{
	  var post = {
			'well_type_id': $('#well_select option:selected').val(), 
			'lmu_id': <?=$lmu_id?>,
			'cost': $('#well_select option:selected').data('cost') 
		};
		$.ajax({
			type: "POST",
	 	  url: "<?=site_url()?>/water/buy_well",
	    data: post,
	    dataType: "json",
	    success: function(data){
				if(data.success == 1){
					update_well();
				}
				else{
					$('#error_message').text("You do not have the funds to upgrade to this well");
					$('#error').show();
				}
 	   }
	  });
	}
});

function update(){
	$.ajax({
    type: 'POST',
    url: '<?=site_url()?>/water/get_method',
    data: 'method_id=' + $('#methodSelect option:selected').val(),
    dataType: 'json',
    success: function(data){
			$('#update_well').hide();
			$('#method').text(data[0].method);
			$('#hours').text('Hours: ' + data[0].hours);
			var rate = data[0].hours * data[0].rate;
			$('#rate').text('Current Water Yield: ' + rate);
    }
  });
}

function update_well(){
	$.ajax({
    type: 'POST',
    url: '<?=site_url()?>/water/get_well',
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
