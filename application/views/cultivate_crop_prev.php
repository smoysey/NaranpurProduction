<div class="accordion" id="accordion2">
  <div class="accordion-group">

	<?php foreach($planted_crops->result() as $ac){ ?>

		<div class="accordion-heading">
			<strong><a class="accordion-toggle" data-toggle="collapse"  data-target="#<?php echo $ac->crop_id;?>" href="#<?php echo $ac->crop_id;?>">
				<?php echo $ac->name; ?>
			</a></strong>
		</div>

		<div id="<?php echo $ac->crop_id;?>" class="accordion-body collapse">
      <div class="accordion-inner">

				<ul class="nav nav-list">
					<li class="nav-header">Current Health: <?=$ac->health;?>%</li>
					<li class="nav-header">Percent Complete: <?=$ac->percent_complete;?>%</li>
					<li class="nav-header">Current Yield: <?=$ac->yield;?>%</li>
					<li class="nav-header">Planted Acres: <?=$acres * $ac->land_percentage / 100;?></li>
					<li class="nav-header">Percentage of Land: <?=$ac->land_percentage;?>%</li>
					<li class="nav-header">Labor Requirements: <?=$ac->clr * $acres * $ac->land_percentage / 100;?> units</li>
					<li class="divider"></li>
				</ul>				

				<div class="row-fluid">
					<div class="span4">
						<form action='<?php echo site_url(); ?>/lmu/cultivate_crop' method="POST">
							<input type="hidden" name="lmu_id" value="<?php echo $lmu_id;?>"/>
							<input type="hidden" name="crop_id" value="<?php echo $ac->crop_id;?>"/>
							<input type="hidden" name="field" value="irrigation"/>
							<button
							class="btn <?php echo ($ac->irrigation)? "btn-danger" : "btn-primary"?>"
							type="submit">
									<i class="<?php echo ($ac->irrigation)? "icon-remove" : "icon-ok"?>"></i>
							Irrigation
							</button>
						</form>
					</div>

					<div class="span8">
						Resource Requirements: <?=$ac->irr * $ac->land_percentage * $acres / 100;?> units 
					</div>
				</div>

				<div class="row-fluid">
					<div class="span4">
						<form action='<?php echo site_url(); ?>/lmu/cultivate_crop' method="POST">
							<input type="hidden" name="lmu_id" value="<?php echo $lmu_id;?>"/>
							<input type="hidden" name="crop_id" value="<?php echo $ac->crop_id;?>"/>
							<input type="hidden" name="field" value="fertilizer"/>
							<button 
								class="btn <?php echo ($ac->fertilizer)? "btn-danger" : "btn-primary"?>"
								type="submit">
								<i class="<?php echo ($ac->fertilizer)? "icon-remove" : "icon-ok"?>"></i>
								Feritlizer
							</button>
						</form>
					</div>
	
					<div class="span8">
						Resource Requirements: <?=$ac->frr * $ac->land_percentage * $acres / 100;?> units 
					</div>
				</div>

				<div class="row-fluid">
					<div class="span4">
						<form action='<?php echo site_url(); ?>/lmu/cultivate_crop' method="POST">
							<input type="hidden" name="lmu_id" value="<?php echo $lmu_id;?>"/>
							<input type="hidden" name="crop_id" value="<?php echo $ac->crop_id;?>"/>
							<input type="hidden" name="field" value="pesticide"/>
							<button 
								class="btn <?php echo ($ac->pesticide)? "btn-danger" : "btn-primary"?>"
								type="submit">
								<i class="<?php echo ($ac->pesticide)? "icon-remove" : "icon-ok"?>"></i>
								Pesticide
							</button>
						</form>
					</div>

					<div class="span8">
						Resource Requirements: <?=$ac->prr * $ac->land_percentage * $acres / 100;?> units 
					</div>
				</div>
	
			</div>
		</div>

	<?php } ?>


	</div>
</div>

<script>
	var fert = Raphael("fert", 30, 30);
	var check = "M29.548,3.043c-1.081-0.859-2.651-0.679-3.513,0.401L16,16.066l-3.508-4.414c-0.859-1.081-2.431-1.26-3.513-0.401c-1.081,0.859-1.261,2.432-0.401,3.513l5.465,6.875c0.474,0.598,1.195,0.944,1.957,0.944c0.762,0,1.482-0.349,1.957-0.944L29.949,6.556C30.809,5.475,30.629,3.902,29.548,3.043zM24.5,24.5h-17v-17h12.756l2.385-3H6C5.171,4.5,4.5,5.171,4.5,6v20c0,0.828,0.671,1.5,1.5,1.5h20c0.828,0,1.5-0.672,1.5-1.5V12.851l-3,3.773V24.5z";
	var uncheck = "M26,27.5H6c-0.829,0-1.5-0.672-1.5-1.5V6c0-0.829,0.671-1.5,1.5-1.5h20c0.828,0,1.5,0.671,1.5,1.5v20C27.5,26.828,26.828,27.5,26,27.5zM7.5,24.5h17v-17h-17V24.5z";

	$(document).ready(function() {
		cultivate("fert", <?=$ac->fertilizer;?>, fert);
	});

	function cultivate(id, bool, paper){
		paper.remove();
		paper = Raphael(id, 30, 30);
		if(bool == 1)	paper.path(check).attr({"fill": "#333", transform: "s.75"});
		else paper.path(uncheck).attr({"fill": "#333", transform: "s.75"});
	}

</script>
