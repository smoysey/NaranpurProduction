<script src="<?php echo base_url();?>/application/includes/js/raphael.js"></script>
<div class="container-fluid">
	<?php foreach($planted_crops->result() as $ac){ ?>
		<h5 style="color:green; text-align:center; cursor:pointer;" onclick="$('#<?=$ac->id;?>').toggle()"><?=$ac->name;?></h5>
		<table id="<?=$ac->id;?>" class="table table-striped table-condensed" style="display:none;">
			<thead>
				<tr>
					<th>Irrigation</th>
					<th>Fertilizer</th>
					<th>Pesticide</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td id="irr<?=$ac->crop_id;?>" data-bool="<?=$ac->irrigation;?>"></td>
					<td id="fer<?=$ac->crop_id;?>" data-bool="<?=$ac->fertilizer;?>"></td>
					<td id="pes<?=$ac->crop_id;?>" data-bool="<?=$ac->pesticide;?>"></td>
				</tr>
				<tr>
					<td>Requires: <?=$ac->irr * $ac->land_percentage * $acres / 100;?> units</td>
					<td>Requires: <?=$ac->frr * $ac->land_percentage * $acres / 100;?> units</td>
					<td>Requires: <?=$ac->prr * $ac->land_percentage * $acres / 100;?> units</td>
				</tr>
				<tr>
					<th>Health</th>
					<td>
						<div class="progress">
							<div class="bar" style="width: <?=$ac->health;?>%;"><?=$ac->health;?>%</div>
							<div class="bar bar-danger" style="width:<?=100 - $ac->health;?>%;"></div>
						</div>
					</td>
				</tr>
				<tr>
					<th>Progress</th>
					<td>
						<div class="progress">
							<div class="bar" style="width: <?=$ac->percent_complete;?>%;"><?=$ac->percent_complete;?>%</div>
							<div class="bar bar-danger" style="width: <?=100 - $ac->percent_complete;?>%;"></div>
						</div>
					</td>
				</tr>
				<tr>
					<th>Yield</th>
					<td>
						<div class="progress">
							<div class="bar" style="width: <?=$ac->yield;?>%;"><?=$ac->yield;?>%</div>
							<div class="bar bar-danger" style="width: <?=100-$ac->yield;?>%;"></div>
						</div>
					</td>
				</tr>
				<tr>
					<th>Land %</th>
					<td>
						<div class="progress">
							<div class="bar" style="width: <?=$ac->land_percentage;?>%;"><?=$ac->land_percentage;?>%</div>
							<div class="bar bar-danger" style="width: <?=100 - $ac->land_percentage;?>%;"></div>
						</div>
					</td>
				</tr>
				<tr>
					<th>Acres</th>
					<td><?=$acres * $ac->land_percentage / 100;?></td>
				</tr>
				<tr>
					<th>Labor</th>
					<td><?=$ac->clr * $acres * $ac->land_percentage / 100;?></td>
				</tr>
			</tbody>	
		</table>
	<?php } ?> 
</div>

<script>
	var fer = Array();
	var pes = Array();
	var irr = Array();

	var check = "M29.548,3.043c-1.081-0.859-2.651-0.679-3.513,0.401L16,16.066l-3.508-4.414c-0.859-1.081-2.431-1.26-3.513-0.401c-1.081,0.859-1.261,2.432-0.401,3.513l5.465,6.875c0.474,0.598,1.195,0.944,1.957,0.944c0.762,0,1.482-0.349,1.957-0.944L29.949,6.556C30.809,5.475,30.629,3.902,29.548,3.043zM24.5,24.5h-17v-17h12.756l2.385-3H6C5.171,4.5,4.5,5.171,4.5,6v20c0,0.828,0.671,1.5,1.5,1.5h20c0.828,0,1.5-0.672,1.5-1.5V12.851l-3,3.773V24.5z";
	var uncheck = "M26,27.5H6c-0.829,0-1.5-0.672-1.5-1.5V6c0-0.829,0.671-1.5,1.5-1.5h20c0.828,0,1.5,0.671,1.5,1.5v20C27.5,26.828,26.828,27.5,26,27.5zM7.5,24.5h17v-17h-17V24.5z";

	<?php
		$js_array = json_encode($planted_crops->result_array());
		echo "var crops = ". $js_array . ";\n";
	?>

	$(document).ready(function() {
		for(var x = 0; x < crops.length; x++){
			(function(x) {
				fer[x] = Raphael('fer'+crops[x]['crop_id'], 30, 30);
				pes[x] = Raphael('pes'+crops[x]['crop_id'], 30, 30);
				irr[x] = Raphael('irr'+crops[x]['crop_id'], 30, 30);

				cultivate('fer'+crops[x]['crop_id'], crops[x]['fertilizer'], fer[x]);
				cultivate('pes'+crops[x]['crop_id'], crops[x]['pesticide'], pes[x]);
				cultivate('irr'+crops[x]['crop_id'], crops[x]['irrigation'], irr[x]);
	
				$('#fer'+crops[x]['crop_id']).click(function() {
					flip(crops[x]['lmu_id'], crops[x]['crop_id'], 'fertilizer');
					$('#fer'+crops[x]['crop_id']).data('bool', !$('#fer'+crops[x]['crop_id']).data('bool'));
					cultivate('fer'+crops[x]['crop_id'], $('#fer'+crops[x]['crop_id']).data('bool'), fer[x]);
				});
				$('#pes'+crops[x]['crop_id']).click(function() {
					flip(crops[x]['lmu_id'], crops[x]['crop_id'], 'pesticide');
					$('#pes'+crops[x]['crop_id']).data('bool', !$('#pes'+crops[x]['crop_id']).data('bool'));
					cultivate('pes'+crops[x]['crop_id'], $('#pes'+crops[x]['crop_id']).data('bool'), pes[x]);
				});
				$('#irr'+crops[x]['crop_id']).click(function() {
					flip(crops[x]['lmu_id'], crops[x]['crop_id'], 'irrigation');
					$('#irr'+crops[x]['crop_id']).data('bool', !$('#irr'+crops[x]['crop_id']).data('bool'));
					cultivate('irr'+crops[x]['crop_id'], $('#irr'+crops[x]['crop_id']).data('bool'), irr[x]);
				});
	
			})(x);
		}
	});

	function cultivate(id, bool, paper){
		paper.clear();
		if(bool == 1)	paper.path(check).attr({"fill": "#333"});
		else paper.path(uncheck).attr({"fill": "#333"});
	}

	function flip(lmu_id, crop_id, field){
		var data = {lmu_id: lmu_id, crop_id: crop_id, field: field};;
  	$.ajax({
	    type: "POST",
			url: "<?=site_url()?>/lmu/cultivate_crop",
			data: data,
	    dataType: "json",
    	success: function(data){
				return(true);
    	}
  	});
	}

</script>
