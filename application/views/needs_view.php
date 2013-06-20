<div id="needsModal" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Family Needs</h3>
  </div>

  <div class="modal-body">
		<table class="table table-condensed table-striped">
			<thead>
				<tr>
					<th></th>
					<th>Available</th>
					<th>Required</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th>Labor</th>
					<td id="la" class="text-success"></td>
					<td id="lu" class="text-error"></td>
				</tr>
				<tr>
					<th>Water</th>
					<td id="wa" class="text-success"></td>
					<td id="wu" class="text-error"></td>
				</tr>
				<tr>
					<th>Grain</th>
					<td></td>
					<td id="gr" class="text-error"></td>
				</tr>
				<tr>
					<th>Milk</th>
					<td></td>
					<td id="mr" class="text-error"></td>
				</tr>
			</tbody>
		</table>

  </div>
</div>


<script>

  $('#needsLink').click(function () 
  {
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
