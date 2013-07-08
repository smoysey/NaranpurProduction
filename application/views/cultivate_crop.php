<div class="container-fluid">
	<?php foreach($planted_crops->result() as $ac){ ?>
		<h5 style="color:green; cursor:pointer;" onclick="$('#<?=$ac->id;?>').toggle()"><?=$ac->name;?></h5>
		<div id="<?=$ac->id;?>" style="display:none;">
		<table  class="table table-striped table-condensed">
			<thead>
				<tr data-lmu_id="<?=$ac->lmu_id;?>" data-crop_id="<?=$ac->id;?>">
					<th data-field="irrigation">
						Irrigation
						<i style="cursor:pointer;" class="pull-right <?php echo ($ac->irrigation) ? 'icon-ok' : 'icon-remove';?>"></i>
					</th>
					<th data-field="fertilizer">
						Fertilizer
						<i style="cursor:pointer;" class="pull-right <?php echo ($ac->fertilizer) ? 'icon-ok' : 'icon-remove';?>"></i>
					</th>
					<th data-field="pesticide">
						Pesticide
						<i style="cursor:pointer;" class="pull-right <?php echo ($ac->pesticide) ? 'icon-ok' : 'icon-remove';?>"></i>
					</th>
					<th data-field="collect_seeds">
						Collect Seed
						<i style="cursor:pointer;" class="pull-right <?php echo ($ac->collect_seeds) ? 'icon-ok' : 'icon-remove';?>"></i>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Requires: <?=$ac->irr * $ac->land_percentage * $acres / 100;?> Water</td>
					<td>Requires: <?=$ac->frr * $ac->land_percentage * $acres / 100;?> Fertilizer</td>
					<td>Requires: <?=$ac->prr * $ac->land_percentage * $acres / 100;?> Pesticide</td>
					<td>Requires: <?=$ac->land_percentage * $acres / 100 * .5;?> Labor</td>
				</tr>
			</tbody>	
		</table>

		<dl class="dl-horizontal">
 		 <dt>Health:</dt>
 		 <dd>
				<div class="progress">
					<div class="bar" style="width: <?=$ac->health;?>%;"><?=$ac->health;?>%</div>
					<div class="bar bar-danger" style="width:<?=100 - $ac->health;?>%;"></div>
				</div>
			</dd>
	
			<dt>Progress:</dt>
			<dd>
				<div class="progress">
					<div class="bar" style="width: <?=$ac->percent_complete;?>%;"><?=$ac->percent_complete;?>%</div>
					<div class="bar bar-danger" style="width: <?=100 - $ac->percent_complete;?>%;"></div>
				</div>
			</dd>
		
			<dt>Yield:</dt>
			<dd>
				<div class="progress">
					<div class="bar" style="width: <?=$ac->yield;?>%;"><?=$ac->yield;?>%</div>
					<div class="bar bar-danger" style="width: <?=100-$ac->yield;?>%;"></div>
				</div>
			</dd>
	
			<dt>Land Percentage:</dt>
			<dd>
				<div class="progress">
					<div class="bar" style="width: <?=$ac->land_percentage;?>%;"><?=$ac->land_percentage;?>%</div>
					<div class="bar bar-danger" style="width: <?=100 - $ac->land_percentage;?>%;"></div>
				</div>
			</dd>
		
			<dt>Acres:</dt>
			<dd><?=$acres * $ac->land_percentage / 100;?></dd>
	
			<dt>Labor</dt>
 	 		<dd><?=$ac->clr * $acres * $ac->land_percentage / 100;?></dd>
		</dl>
		</div>
	<?php } ?> 
</div>


<div id="cult_warn" class="alert alert-block span6" style="display:none; position:fixed; bottom:10px;">
	<a class="close" onclick="$('#cult_warn').hide();">X</a> 
	<h4 class="alert-heading">Warning!</h4>  
	<p id="cult_warn_message"></p>
</div> 


<div id="seed_error" class="alert alert-block alert-error span6" style="display:none; position:fixed; bottom:10px;">
	<a class="close" onclick="$('#seed_error').hide();">X</a> 
	<h4 class="alert-heading">Error!</h4>  
	<p id="seed_error_message"></p>
</div> 


<script>

	$('i').on('click', function() {	
		var data = {lmu_id: $(this).closest('tr').data('lmu_id'), crop_id: $(this).closest('tr').data('crop_id'), field: $(this).closest('th').data('field')};
		var icon = $(this);
  	$.ajax({
	    type: "POST",
			url: "<?=site_url()?>/lmu/cultivate_crop",
			data: data,
	    dataType: "json",
    	success: function(data){
				if(!data['water']){
					$('#cult_warn').show("slide", { direction: "down" }, 'fast');
					$('#cult_warn_message').text("You don't have enough water available to irrigate this field, but irrigation will now be applied if water becomes available.");
				}
				else $('#cult_warn').hide();
				if(!data['seed']){
					$('#seed_error').show("slide", { direction: "down" }, 'fast');
					$('#seed_error_message').text("You don't have enough family members to start this task.  Adjust your other management decisions to release a family member's time");
				}
				else $('#seed_error').hide();

				if(data['checked'] == 1){
					icon.removeClass('icon-remove');
					icon.addClass('icon-ok');
				}
				else{
					icon.removeClass('icon-ok');
					icon.addClass('icon-remove');
				}
    	}
  	});
	});

</script>
