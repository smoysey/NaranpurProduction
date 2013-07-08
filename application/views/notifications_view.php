<div id="notsModal" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Notifications</h3>
  </div>

  <div class="modal-body">

		<table class="table table-condensed table-striped">
			<thead>
				<tr>
					<th></th>
					<th>Message</th>
					<th>Date</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="nots">
			</tbody>
		</table>
  </div>
</div>


<script>

  $('#notsLink').click(function () 
  {
    $.ajax({
      url: "<?=site_url('/family/get_notifications')?>", 
			dataType: 'json',
      success: function(data)
      {
				$('#nots').empty();
				for(var i = 0; i < data.length; i++){
						var notification = "";
						if(data[i].seen == 1) notification += '<tr>';
						else notification += '<tr class="info">';
						if(data[i].urgent == 1)	notification += '<td><i class="icon-warning-sign"></i></td>';
						else notification += '<td></td>';
						notification += '<td>' + data[i].content + '</td>';
						notification += '<td>' + data[i].timestamp + '</td>';
						notification += '<td><i id="' + data[i].id + '" class="icon-trash" style="cursor:pointer" data-id="' + data[i].id + '"></i></td>';
						notification += '</tr>';
						$('#nots').append(notification);
						$('#'+data[i].id).click(function () {
							$(this).closest('tr').remove();
    					$.ajax({
							type: "POST",
      				url: "<?=site_url('family/delete_notification')?>", 
							data: "id=" + $(this).data('id'),
							dataType: 'json',
      				success: function(data){}
						});
					});
				}
      } 
    });
  }); 

</script>
