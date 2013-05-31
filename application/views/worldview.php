<div class="container-fluid">
	<div class="row-fluid">
		<div class="span6">
			<?php $this->load->view("map"); ?>

			<form class="form-inline" action="<?php echo site_url("lmu/view");?>" method="POST">
				<select name="lmu_id">
					<?php foreach($lmu_list->result() as $row){ ?>
 			 			<option value="<?=$row->id?>"><?=$row->family_name?> - <?=$row->id?></option>
					<?php } ?>
				</select>
				<button class="btn btn-primary">Go to LMU</button>
			</form>
		</div>

		<div class="span6">
			<?php $this->load->view("chart"); ?>
		</div>

	</div>
</div>
