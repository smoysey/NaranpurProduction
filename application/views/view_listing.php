<script src="<?php echo base_url("/includes/js/raphael.js");?>"></script>
<div class="container-fluid">

	<h4 style="text-align:center;">Listing</h4>
	<div class="row-fluid" style="text-align:center;">
		<?php $lis = $listing->row(); ?>
		<div class="span3">
			<div id="fam"></div>
			<p><?=$lis->family_name;?></p>
		</div>
		<div class="span3">
			<div id="res"></div>
			<p><?=$lis->resource_name;?></p>
		</div>
		<div class="span3">
			<div id="qua"></div>
			<p><?=$lis->quantity;?></p>
		</div>
		<div class="span3">
			<div id="mes"></div>
			<p><?=$lis->message;?></p>
		</div>
	</div>

<hr></hr>

<h4 style="text-align:center;">Current Bids</h4>
<div class="row-fluid">
<?php if($bids->num_rows() > 0) { ?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Family</th>
				<th>Resource</th>
				<th>Quantity</th>
				<th>Message</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($bids->result() as $row){ ?>
				<tr>
					<td class="span1"><?=$row->family_name;?></td>
					<td class="span2"><?php echo $row->resource_name;?></td>
					<td class="span1"><?php echo $row->quantity;?></td>
					<td class="span8">
						<textarea rows="1" class="span12" placeholder="<?php echo $row->message;?>" disabled></textarea>
					</td>
					<?php if($listing->row()->family_name  == $family_name){ ?>
						<td>
							<form class="form" action="<?php echo site_url();?>/listing/accept_bid" method="POST">							
								<input type="hidden" name="bid_id" value="<?php echo $row->id;?>"/>
								<input type="hidden" name="listing_id" value="<?php echo $listing->row()->id;?>"/>
								<button type="submit" class="btn btn-primary"><i class="icon-ok"></i> Accept Bid</button>
							</form>
						</td>
					<?php } ?>
				</tr>
			<?php } ?>
		</tbody>
	</table>
<?php } else {?>
	<h3>No Bids Yet.</h3>
<?php } ?>

<?php if($listing->row()->family_name  != $family_name){ ?>
		<a href="<?php echo site_url();?>/listing/load_create_bid/<?php echo $listing->row()->id;?>" class="btn btn-primary">Make Bid</a>
<?php } else{ ?>
	<a href="<?php echo site_url();?>/listing/delete_listing/<?=$listing->row()->id;?>" class="btn btn-danger">Delete Listing</a>
<?php } ?>

</div>
</div>


<script>
	var fam = "M21.053,20.8c-1.132-0.453-1.584-1.698-1.584-1.698s-0.51,0.282-0.51-0.51s0.51,0.51,1.02-2.548c0,0,1.414-0.397,1.132-3.68h-0.34c0,0,0.849-3.51,0-4.699c-0.85-1.189-1.189-1.981-3.058-2.548s-1.188-0.454-2.547-0.396c-1.359,0.057-2.492,0.792-2.492,1.188c0,0-0.849,0.057-1.188,0.397c-0.34,0.34-0.906,1.924-0.906,2.321s0.283,3.058,0.566,3.624l-0.337,0.113c-0.283,3.283,1.132,3.68,1.132,3.68c0.509,3.058,1.019,1.756,1.019,2.548s-0.51,0.51-0.51,0.51s-0.452,1.245-1.584,1.698c-1.132,0.452-7.416,2.886-7.927,3.396c-0.511,0.511-0.453,2.888-0.453,2.888h26.947c0,0,0.059-2.377-0.452-2.888C28.469,23.686,22.185,21.252,21.053,20.8zM8.583,20.628c-0.099-0.18-0.148-0.31-0.148-0.31s-0.432,0.239-0.432-0.432s0.432,0.432,0.864-2.159c0,0,1.199-0.336,0.959-3.119H9.538c0,0,0.143-0.591,0.237-1.334c-0.004-0.308,0.006-0.636,0.037-0.996l0.038-0.426c-0.021-0.492-0.107-0.939-0.312-1.226C8.818,9.619,8.53,8.947,6.947,8.467c-1.583-0.48-1.008-0.385-2.159-0.336C3.636,8.179,2.676,8.802,2.676,9.139c0,0-0.72,0.048-1.008,0.336c-0.271,0.271-0.705,1.462-0.757,1.885v0.281c0.047,0.653,0.258,2.449,0.469,2.872l-0.286,0.096c-0.239,2.783,0.959,3.119,0.959,3.119c0.432,2.591,0.864,1.488,0.864,2.159s-0.432,0.432-0.432,0.432s-0.383,1.057-1.343,1.439c-0.061,0.024-0.139,0.056-0.232,0.092v5.234h0.575c-0.029-1.278,0.077-2.927,0.746-3.594C2.587,23.135,3.754,22.551,8.583,20.628zM30.913,11.572c-0.04-0.378-0.127-0.715-0.292-0.946c-0.719-1.008-1.008-1.679-2.59-2.159c-1.584-0.48-1.008-0.385-2.16-0.336C24.72,8.179,23.76,8.802,23.76,9.139c0,0-0.719,0.048-1.008,0.336c-0.271,0.272-0.709,1.472-0.758,1.891h0.033l0.08,0.913c0.02,0.231,0.022,0.436,0.027,0.645c0.09,0.666,0.21,1.35,0.33,1.589l-0.286,0.096c-0.239,2.783,0.96,3.119,0.96,3.119c0.432,2.591,0.863,1.488,0.863,2.159s-0.432,0.432-0.432,0.432s-0.053,0.142-0.163,0.338c4.77,1.9,5.927,2.48,6.279,2.834c0.67,0.667,0.775,2.315,0.746,3.594h0.48v-5.306c-0.016-0.006-0.038-0.015-0.052-0.021c-0.959-0.383-1.343-1.439-1.343-1.439s-0.433,0.239-0.433-0.432s0.433,0.432,0.864-2.159c0,0,0.804-0.229,0.963-1.841v-1.227c-0.001-0.018-0.001-0.033-0.003-0.051h-0.289c0,0,0.215-0.89,0.292-1.861V11.572z";

	var res = "M24.485,2c0,8-18,4-18,20c0,6,2,8,2,8h2c0,0-3-2-3-8c0-4,9-8,9-8s-7.981,4.328-7.981,8.436C21.239,24.431,28.288,9.606,24.485,2z";

	var qua = "M25.979,12.896 19.312,12.896 19.312,6.229 12.647,6.229 12.647,12.896 5.979,12.896 5.979,19.562 12.647,19.562 12.647,26.229 19.312,26.229 19.312,19.562 25.979,19.562z";

	var mes = "M16,5.333c-7.732,0-14,4.701-14,10.5c0,1.982,0.741,3.833,2.016,5.414L2,25.667l5.613-1.441c2.339,1.317,5.237,2.107,8.387,2.107c7.732,0,14-4.701,14-10.5C30,10.034,23.732,5.333,16,5.333z";

	var fam_icon = Raphael('fam', 40, 40);
	fam_icon.path(fam).attr({"fill": "#333"});

	var res_icon = Raphael('res', 40, 40);
	res_icon.path(res).attr({"fill": "#333"});

	var qua_icon = Raphael('qua', 40, 40);
	qua_icon.path(qua).attr({"fill": "#333"});

	var mes_icon = Raphael('mes', 40, 40);
	mes_icon.path(mes).attr({"fill": "#333"});

</script>
