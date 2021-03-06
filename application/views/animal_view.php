<form id="feed_policy">

	<select id="animalSelect" name="animal_id">
  	<option value="-1">Choose an Animal</option>
		<?php foreach($animals->result() as $row){ ?>
  		<option value="<?=$row->id;?>" data-quantity="<?=$row->quantity;?>">
				<?=$row->resource;?>
			</option>
		<?php } ?>
	</select>

	<div id="animalBody" style="display:none;">
		<ul class="nav nav-list">
			<li class="nav-header">Animal Policy</li>
			<li>Collecting Manure: <i id="manure_icon" style="cursor:pointer;"></i></li>
	 	 	<li id="feed_method"></li>
			<li id="animal"></li>
		</ul>

		<ul id="reqs" class="nav nav-list">
		</ul>

		<ul class="nav nav-list">
			<li class="nav-header">Update Feeding Method</li>
			<li>
				<select id="feedMethodSelect" name="feed_method_id"></select>
				<a style="display:none;" id="updateFeedMethod" class="btn pull-right">Update</a>
			</li>
		</ul>
	</div>

</form>

<div id="manure_error" class="alert alert-block alert-error span6" style="display:none; position:fixed; bottom:10px;">
	<a class="close" onclick="$('#manure_error').hide();">X</a> 
	<h4 class="alert-heading">Error!</h4>  
	<p id="manure_error_message"></p>
</div>
 
<script>

$('#animalSelect').change(function () {
	if($('#animalSelect option:selected').val() == -1){
		$('#animalBody').hide();
	}
	else{
		populateMethods();
		updatePolicy();
		$('#updateFeedMethod').hide();
		$('#animalBody').show();
	}
});

$('#feedMethodSelect').change(function () {
	if($('#feedMethodSelect option:selected').text() == ''){
		$('#updateFeedMethod').hide();
	}
	else{
		$('#updateFeedMethod').show();
	}
});

$('#updateFeedMethod').click(function () {
	var data = $("#feed_policy").serialize();
  $.ajax({
    type: "POST",
    url: "<?=site_url()?>/animal/update_animal_policy",
    data: data,
    dataType: "json",
    success: function(data){
			$('#updateFeedMethod').hide();
			updatePolicy();
    }
  });
});

$('#manure_icon').click(function() {
	var data = $("#feed_policy").serialize();
	$.ajax({
    type: 'POST',
    url: '<?=site_url()?>/animal/toggle_manure',
    data: data,
    dataType: 'json',
    success: function(data){
			if(!data.success){
				$('#manure_error_message').text("You don't have enough family members to start this task.  Adjust your other management decisions to release a family member's time");
				$('#manure_error').show("slide", { direction: "down" }, 'fast');
			}
			if(data.manure){
				$('#manure_icon').removeClass('icon-remove');
				$('#manure_icon').addClass('icon-ok');
			}
			else{
				$('#manure_icon').removeClass('icon-ok');
				$('#manure_icon').addClass('icon-remove');
			}
		}
	});
});

function populateMethods(){
  $.ajax({
    type: "POST",
    url: "<?=site_url()?>/animal/get_feed_methods",
    dataType: "json",
    success: function(data){
			$('#feedMethodSelect').empty();
			$('#feedMethodSelect').append('<option value="-1"></option>');
			for(var i = 0; i < data.length; i++){
				$('#feedMethodSelect').append(
       		$('<option value="' + data[i].id + '">' + data[i].name + '</option>'));
			} 
    }
  });
}

function updatePolicy(){

	$.ajax({
    type: 'POST',
    url: '<?=site_url()?>/animal/get_animal_policy',
    data: 'animal_id=' + $('#animalSelect option:selected').val(),
    dataType: 'json',
    success: function(data){
			$('#feed_method').text('Feeding Method: ' + data[0].method);
			$('#animal').text('Animal: ' + data[0].animal);
			if(data[0].manure == 0){
				$('#manure_icon').removeClass('icon-ok');
				$('#manure_icon').addClass('icon-remove');
			}
			else{
				$('#manure_icon').removeClass('icon-remove');
				$('#manure_icon').addClass('icon-ok');
			}

			$.ajax({
    		type: 'POST',
    		url: '<?=site_url()?>/animal/get_feed_method',
    		data: 'id=' + data[0].id,
    		dataType: 'json',
    		success: function(data){
					$('#reqs').empty();
					$('#reqs').append('<li class="nav-header">Feeding Method Requirements</li>');
					for(var i = 0; i < data.length; i++){
						$('#reqs').append(
	       		$('<li><strong>Resource:</strong>&nbsp;' + data[i].resource + 
							'&nbsp;<strong>Quantity:</strong>&nbsp;' + data[i].quantity + '</li>'));
					} 
    		}
  		});

    }
  });
}


</script>
