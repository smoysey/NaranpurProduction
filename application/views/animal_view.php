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
		<div class="row-fluid">
			<div class="span5">
				<h4 class="pull-left">Collecting Manure:</h4>
				<div id="manure" class="pull-right"></div>
				<input id="manureToggled" type="hidden" name="manure" />
			</div>
		</div>

		<ul class="nav nav-list">
			<li class="nav-header">Feeding Method</li>
 		 	<li id="feed_method"></li>
			<li id="animal"></li>
		</ul>

		<ul id="reqs" class="nav nav-list">
		</ul>

		<select id="feedMethodSelect" name="feed_method_id"></select>
		</br>
		<a style="display:none;" id="updateFeedMethod" class="btn btn-primary">Update</a>

	</div>

</form>

<script>
	var paper = Raphael("manure", 30, 30);
	var check = "M29.548,3.043c-1.081-0.859-2.651-0.679-3.513,0.401L16,16.066l-3.508-4.414c-0.859-1.081-2.431-1.26-3.513-0.401c-1.081,0.859-1.261,2.432-0.401,3.513l5.465,6.875c0.474,0.598,1.195,0.944,1.957,0.944c0.762,0,1.482-0.349,1.957-0.944L29.949,6.556C30.809,5.475,30.629,3.902,29.548,3.043zM24.5,24.5h-17v-17h12.756l2.385-3H6C5.171,4.5,4.5,5.171,4.5,6v20c0,0.828,0.671,1.5,1.5,1.5h20c0.828,0,1.5-0.672,1.5-1.5V12.851l-3,3.773V24.5z";
	var uncheck = "M26,27.5H6c-0.829,0-1.5-0.672-1.5-1.5V6c0-0.829,0.671-1.5,1.5-1.5h20c0.828,0,1.5,0.671,1.5,1.5v20C27.5,26.828,26.828,27.5,26,27.5zM7.5,24.5h17v-17h-17V24.5z";

$('#animalSelect').change(function () {
	if($('#animalSelect option:selected').text() == ''){
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

$('#manure').click(function() {
	var data = $("#feed_policy").serialize();
	$.ajax({
    type: 'POST',
    url: '<?=site_url()?>/animal/toggle_manure',
    data: data,
    dataType: 'json',
    success: function(data){
			updateManureCSS(data.manure);
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

function updateManureCSS(manure){
	$('#manureToggled').val(manure);
	paper.clear();
	if(manure == 1)	paper.path(check).attr({"fill": "#333"});
	else paper.path(uncheck).attr({"fill": "#333"});
}

function updatePolicy(){

	$.ajax({
    type: 'POST',
    url: '<?=site_url()?>/animal/get_animal_policy',
    data: 'animal_id=' + $('#animalSelect option:selected').val(),
    dataType: 'json',
    success: function(data){
			$('#feed_method').text('Method Name: ' + data[0].method);
			$('#animal').text('Animal: ' + data[0].animal);
			updateManureCSS(data[0].manure);

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
