<div id="inventoryModal" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Inventory</h3>
  </div>

  <div class="modal-body">
		<ul class="unstyled">
			<ul class="unstyled inline text-center">
				<li><strong>Labor:</strong></li>
				<li id="lu" class="text-error"></li>
				<li><strong>/</strong></li>
				<li id="la" class="text-success"></li>
				<li><strong>Water:</strong></li>
				<li id="wu" class="text-error"></li>
				<li><strong>/</strong></li>
				<li id="wa" class="text-success"></li>
			</ul>
			<ul class="unstyled inline text-center">
				<li><strong>Grain Required:</strong></li>
				<li id="gr" class="text-error"></li>
				<li><strong>Milk Required:</strong></li>
				<li id="mr" class="text-error"></li>
			</ul>
		</ul>

		<table class="table table-striped">
			<thead>
				<tr>
					<th>Resource</th>
					<th>Category</th>
					<th>Quantity</th>
				</tr>
			</thead>
			<tbody id="inventory">
			</tbody>
		</table>
  </div>
</div>


<script>

  $('#modalLink').click(function () 
  {
    $.ajax({
      url: "<?=site_url()?>/family/get_inventory", 
      data: "",
			dataType: 'json',
      success: function(data)
      {
				$('#inventory').empty();
				for(var i = 0; i < data.length; i++){
        	var resource = $('<tr><td>' + data[i].name + '</td><td>' + data[i].category + '</td><td>' + data[i].quantity + '</td></tr>');
					$('#inventory').append(resource);
				}
      } 
    });

    $.ajax({
      url: "<?=site_url()?>/family/get_status", 
      data: "",
			dataType: 'json',
      success: function(data)
      {
				$('#gr').text(data.grain);
				$('#mr').text(data.milk);
				$('#wu').text(data.used_water);
				$('#wa').text(data.available_water);
				$('#lu').text(data.used_labor);
				$('#la').text(data.available_labor);
      } 
    });

  }); 

</script>
