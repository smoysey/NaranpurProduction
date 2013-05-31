<script src="<?php echo base_url("/includes/js/raphael.js");?>"></script>

<div class="container-fluid">

	<div class="row-fluid">
		<div style="text-align:center;" id="rsr"></div>
	</div>

	<div class="row-fluid">
		<div style="text-align:center;">
			<a href="#family" role="button" class="btn btn-success" data-toggle="modal">View Family</a>
			<a href="#cultivate" role="button" class="btn btn-success" data-toggle="modal">Manage Crops</a>
			<a href="#plant" role="button" class="btn btn-success" data-toggle="modal">Plant Crops</a>
			<a href="#water" role="button" class="btn btn-success" data-toggle="modal">Collect Water</a>
			<a href="#feed" role="button" class="btn btn-success" data-toggle="modal">Feed Animals</a>
		</div>
	</div>

	<a class="pull-left" href="<?=site_url('world')?>" id="back"></a>

</div>

		<div id="cultivate" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="cultivateLabel" aria-hidden="true">
		  <div class="modal-header">
		  	<h4>Manage Crops<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button></br></h4>
		  </div>
		  <div class="modal-body">
				<?php $this->load->view('cultivate_crop'); ?>
		  </div>
		</div>
 
		<div id="plant" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="plantLabel" aria-hidden="true">
		  <div class="modal-header">
		    <h4>Plant Crops<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button></br></h4>
		  </div>
		  <div class="modal-body">
				<?php $this->load->view('plant_crop'); ?>
		  </div>
		</div>
 
		<div id="water" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="waterLabel" aria-hidden="true">
		  <div class="modal-header">
		    <h4>Collect Water<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button></br></h4>
		  </div>
		  <div class="modal-body">
				<?php $this->load->view('water_view'); ?>
		  </div>
		</div>

		<div id="feed" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="feedLabel" aria-hidden="true">
		  <div class="modal-header">
		    <h4>Manage Livestock<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button></br></h4>
		  </div>
		  <div class="modal-body">
				<?php $this->load->view('animal_view'); ?>
		  </div>
		</div>
	</div>

		<div id="family" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="familyLabel" aria-hidden="true">
		  <div class="modal-header">
		    <h4>Family Members<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button></br></h4>
		  </div>
		  <div class="modal-body">
				<?php $this->load->view('family_modal'); ?>
		  </div>
		</div>
	</div>

<script>
$(function() {

	<?php
		$js_array = json_encode($planted_crops->result_array());
		echo "var crops = ". $js_array . ";\n";
	?>

	var images = Array();
	var z = 0;
	for(var x = 0; x < crops.length; x++){
		for(var y = 0; y < crops[x]['land_percentage']; y++){
			images[z] = crops[x]['image'];
			z++;
		}
	} 

	for(var x = images.length; x < 100; x++) images[x] = "field.png";

	var rsr = Raphael('rsr', '1200', '550');

	rsr.image('<?=base_url("/images/bg$lmu_type.jpg")?>',0,0,1200,550);

	var hut = rsr.image("<?=base_url("/images/hut.png")?>", 270, 300, 170, 100);
	var barn = rsr.image("<?=base_url("/images/barn.png")?>", 860, 300, 300, 210);
	var well = rsr.image("<?=base_url("/images/well.png")?>", 500, 350, 100, 65);
	var farmer = rsr.image("<?=base_url("/images/farmer.png")?>", 600, 380, 167, 170);

	var field = rsr.set();
	var height = 18;
	var width = 20;
	z = 0;
	for(var i = 0; i < 10; i++){
		for(var j = 0; j < 10; j++){
			var image = "<?=base_url("/images")?>" + "/" + images[z];
			field.push(
				rsr.image(image, 30 + width * j, 350 + height * i, width, height)
			);
			z++
		}
	}

	hut.click(function() {$('#family').modal();});
	barn.click(function() {$('#feed').modal();});
	well.click(function() {$('#water').modal();});
	farmer.click(function() {$('#plant').modal();});
	field.click(function() {$('#cultivate').modal();});

	hut.mouseover(function(){this.attr({cursor: 'pointer'});});
	barn.mouseover(function(){this.attr({cursor: 'pointer'});});
	well.mouseover(function(){this.attr({cursor: 'pointer'});});
	farmer.mouseover(function(){this.attr({cursor: 'pointer'});});
	field.mouseover(function(){this.attr({cursor: 'pointer'});});

	var back = "M12.981,9.073V6.817l-12.106,6.99l12.106,6.99v-2.422c3.285-0.002,9.052,0.28,9.052,2.269c0,2.78-6.023,4.263-6.023,4.263v2.132c0,0,13.53,0.463,13.53-9.823C29.54,9.134,17.952,8.831,12.981,9.073z";

	var back_icon = Raphael('back', 40, 40);
	back_icon.path(back).attr({"fill": "#333"});

});

</script>
