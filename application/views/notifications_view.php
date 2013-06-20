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
      url: "<?=site_url()?>/family/get_notifications", 
      data: "",
			dataType: 'json',
      success: function(data)
      {
				$('#nots').empty();
				for(var i = 0; i < data['nots'].length; i++){
						var notification = "";
						if(data['nots'][i].read == 1) notification += '<tr id="' + data['nots'][i].id + '">';
						else notification += '<tr class="info" id="' + data['nots'][i].id + '">';
						if(data['nots'][i].urgent == 1)	notification += '<td><i class="icon-warning-sign"></i></td>';
						else notification += '<td></td>';
						notification += '<td>' + data['nots'][i].content + '</td>';
						notification += '<td>' + data['nots'][i].timestamp + '</td>';
						notification += '<td><i class="icon-trash" style="cursor:pointer" data-id="' + data['nots'][i].id + '"></i></td>';
						notification += '</tr>';
						$('#nots').append(notification);
				}
				
				var icon = (data['prefs'].win == 1) ? 'icon-ok' : 'icon-remove';
				$('#win').addClass(icon);
				$('#win').data('bool', data['prefs'].win);
				icon = (data['prefs'].bid == 1) ? 'icon-ok' : 'icon-remove';
				$('#bid').addClass(icon);
				$('#bid').data('bool', data['prefs'].bid);
				icon = (data['prefs'].message == 1) ? 'icon-ok' : 'icon-remove';
				$('#message').addClass(icon);
				$('#message').data('bool', data['prefs'].message);

      } 
    });
  }); 

</script>
