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
					<th>Food</th>
					<td id="ga" class="text-success"></td>
					<td id="gu" class="text-error"></td>
				</tr>
				<tr>
					<th>Milk</th>
					<td id="ma" class="text-success"></td>
					<td id="mu" class="text-error"></td>
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
				$('#ga').text(data.available_grain);
				$('#gu').text(data.used_grain);
				$('#ma').text(data.available_milk);
				$('#mu').text(data.used_milk);
				$('#wa').text(data.available_water);
				$('#wu').text(data.used_water);
				$('#la').text(data.available_labor);
				$('#lu').text(data.used_labor);
      } 
    });
  }); 

</script>
