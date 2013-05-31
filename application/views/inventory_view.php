<div id="inventoryModal" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Inventory</h3>
  </div>

  <div class="modal-body well">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Resource</th>
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
        	var resource = $('<tr><td>' + data[i].name + '</td><td>' + data[i].quantity + '</td></tr>');
					$('#inventory').append(resource);
				}
      } 
    });
  }); 

</script>
