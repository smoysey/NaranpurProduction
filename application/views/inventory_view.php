<div id="inventoryModal" class="modal hide fade">
  <div class="modal-body">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Inventory</h3>
		<table class="table table-condensed">
			<tbody id="inventory"></tbody>
		</table>
  </div>
</div>


<script>

  $('#inventoryLink').click(function () 
  {
    $.ajax({
      url: "<?=site_url()?>/family/get_inventory", 
      data: "",
			dataType: 'json',
      success: function(data)
      {
				var cat = "";
				var color = 0;
				$('#inventory').empty();
				for(var i = 0; i < data.length; i++){
					if(data[i].category != cat){
						$('#inventory').append('<tr><th>' + data[i].category + '<i class="icon-leaf pull-right"></i></th><th></th><th><i class="icon-plus-sign pull-left"></i></th></tr>');
						cat = data[i].category;
					}

        	var resource = $('<tr><td style="text-align:right;">' + data[i].name + '</td><td style="text-align:center">-</td><td style="text-align:left;">' + data[i].quantity + '</td></tr>');
					$('#inventory').append(resource);
				}
      } 
    });

  }); 

</script>
