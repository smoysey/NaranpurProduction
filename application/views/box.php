<div class="container-fluid">
	<h1><?php echo ucwords($box);?></h1>
	<?php $this->load->helper('url'); ?> 

	<form class="form" action="<?php echo site_url();?>/messages/delete_messages" method="POST">
		<input type="hidden" name="box" value="<?php $box; ?>" />
		<input type="hidden" name="seg" value="<?php echo uri_string(); ?>" />
	<div class="container-fluid">
		<table class="table table-hover table-boredered table-striped">
			<thead>
				<tr class="info">
					<th class="span1"></th>
					<?php foreach($fields as $field_name => $field_display):?>
						<th <?php if($sort_by == $field_name) echo "class=\"sort_$sort_order\""; ?>>
							<?php echo anchor("messages/$box/$field_name/" . 
															(($sort_order == 'asc' && $sort_by == $field_name) ? 'desc' : 'asc'),
															$field_display); ?> 
							<?php if($sort_by == $field_name){ ?>&nbsp;
								<i class="<?=($sort_order == 'desc') ? 'icon-chevron-up' : 'icon-chevron-down';?>"></i>
							<?php } ?>
						</th>
					<?php endforeach;?>
				</tr>
			</thead>

			<tbody>
			<?php foreach($messages->result() as $message):?>
			<tr style="cursor:pointer"; onclick="document.location = '<?php echo site_url("/messages/view_message/$message->id");?>';">
					<td><input type="checkbox" name="msg[]" value="<?php echo $message->id; ?>" /></td>	
					<?php foreach($fields as $field_name => $field_display):?>
						<td><?=$message->$field_name;?></td>
					<?php endforeach;?>
			</tr>
			<?php endforeach;?>
			</tbody>
	
		</table>

	<?php echo $pagination; ?>	

<hr></hr>

		<div class="control-group">
			<!-- Button -->
			<div class="controls">
				<button type="submit" class="btn btn-danger"><i class="icon-trash"></i> Delete</button>
			</div>
		</div>

	</div>
	</form>
</div>
