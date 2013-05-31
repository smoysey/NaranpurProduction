<div id="rsr"></div>

<script src="<?php echo base_url("/includes/js/raphael.js");?>"></script>

<script>
$(function() {
	var rsr = Raphael('rsr', '500', '500');

	rsr.image('<?=base_url("/images/world_map.jpg")?>',0,0,500,500);

	var url = "<?=site_url("lmu/view");?>";
	var paths = new Array();
	
	$.ajax({
		type: 'POST',
		url: "<?=site_url('world/get_paths')?>",
 		dataType:"json",
		success: function(data){
			for(var i in data){
				var path = "m";
				for(var j in data[i]){
					path = path + " " + data[i][j].x + ", " + data[i][j].y;
				}
				path = path + " z";

				var filler = ('<?=$family_name?>' == data[i].owner) ? '#00FF00' : '#00FFFF';

				paths[i] = rsr.path(path).attr({
					id: i,
		 	  	'stroke-width': '0',
		 	 		fill: filler,
					opacity: '.2',
		 	  	title: 'LMU ' + i + ' Owner: ' + data[i].owner
				});

				paths[i].data("owner", data[i].owner);

				(function(i, filler) {

		 	  	paths[i].mouseover(function() {
	 	     		this.toFront();
						this.attr({
	 	        	cursor: 'pointer'
		       	});
 		       	this.animate({
							opacity: '1',
 		        	transform: "s1.4"
 		       	}, 200);
 		   		});

					paths[i].mouseout(function() {
		      	this.animate({
							opacity: '.2',
		 	      	transform: "s1"
		 	     	}, 200);
			   	});

					paths[i].click(function() {
						if('<?=$family_name?>' == paths[i].data("owner")){
							window.location = url + "/" + i;
						}
						else{
							alert("LMU " + i + " Owner: " + paths[i].data("owner"));
						}
 			   	});
				})(i, filler); 
		 	  
			}

		}
	});

});


</script>

