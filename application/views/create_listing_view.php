<h3>Create a Listing</h3>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Resource</th>
			<th>Quantity</th>
			<th>Message</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($listing_inventory->result() as $row){ ?>
			<tr>
				<form class="form" action="<?php echo site_url();?>/listing/create_listing" method="POST">
					<td>
						<input type="hidden" name="resource_id" value="<?php echo $row->id;?>"/>
						<?php echo $row->name;?>
					</td>
					<td>
						<select name="quantity">
							<?php for($i = 1; $i <= $row->quantity; $i++){ ?>
								<option><?php echo $i; ?></option>
							<?php } ?>
						</select>
					</td>
					<td class="span9">
						<textarea rows="1" class="span6" name="message" placeholder="What are you looking for in return..."></textarea>
					</td>
					<td>
						<button type="submit" class="btn btn-primary"><i class="icon-list"></i> Create Listing</button>
					</td>
				</form>
			</tr>
		<?php } ?>
	</tbody>
</table>
