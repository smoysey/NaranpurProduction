<div class="navbar">
	<div class="navbar-inner">
		<div class="container-fluid">
			<a class="brand" href="<?php echo site_url();?>" name="top">Naranpur</i></a>
			<div class="nav-collapse collapse">
				<ul class="nav">
						<li class="divider-vertical"></li>

      		<li><a href="<?php echo site_url("/world");?>"><i class="icon-globe"></i> World</a></li>
						<li class="divider-vertical"></li>

     			<li class="dropdown">
						<a class="dropdown-toggle text-error" data-toggle="dropdown" href=""><i class="icon-home"></i> Family <b class="caret"></b></a>
							<ul class="dropdown-menu span3">
      						<li id="inventoryLink"><a href="#inventoryModal" role="button"  data-toggle="modal"><i class="icon-tasks"></i> Inventory</a></li>
									<li class="divider"></li>
      						<li id="needsLink"><a href="#needsModal" role="button"  data-toggle="modal"><i class="icon-tint"></i> Needs</a></li>
									<li class="divider"></li>
      						<li id="notsLink">
										<a href="#notsModal" role="button"  data-toggle="modal">
											<i class="icon-bullhorn"></i> Alerts <span id='notif' class="badge badge-info pull-right" style="display:none;">
										</a>
									</li>
									<li class="divider"></li>
									<li>
				     				<a href="<?php echo site_url("/family/logout");?>"><i class="icon-share"></i> Logout</a>
									</li>
							</ul>
					</li>
						<li class="divider-vertical"></li>

      		<li><a href="<?php echo site_url("/store");?>"><i class="icon-leaf"></i> Store</a></li>
						<li class="divider-vertical"></li>

     			<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href=""><i class="icon-th"></i> Market <b class="caret"></b></a>
							<ul class="dropdown-menu span3">
								<li>
									<a href="<?php echo site_url("/listing/view_all_listings");?>">
										<i class="icon-search"></i> View Listings <span id='bid' class="badge badge-info pull-right" style="display:none;">
									</a>
								</li>
									<li class="divider"></li>
								<li>
									<a href="<?php echo site_url("/transaction/view_all_transactions");?>">
										<i class="icon-barcode"></i> View Transactions <span id='win' class="badge badge-info pull-right" style="display:none;">
									</a>
								</li>
							</ul>
					</li>
						<li class="divider-vertical"></li>

     			<li><a href="<?php echo site_url();?>/discussion"><i class="icon-comment"></i> Forum</a></li>
						<li class="divider-vertical"></li>

     			<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href=""><i class="icon-envelope"></i> Messages <b class="caret"></b></a>
							<ul class="dropdown-menu span3">
								<li><a href="<?php echo site_url("/messages/compose");?>"><i class="icon-pencil"></i> Compose</a></li>
									<li class="divider"></li>
								<li>
									<a href="<?php echo site_url("/messages/inbox");?>">
										<i class="icon-inbox"></i> Inbox <span id='mess' class="badge badge-info pull-right" style="display:none;"></span>
									</a>
								</li>
									<li class="divider"></li>
								<li><a href="<?php echo site_url("/messages/outbox");?>"><i class="icon-share"></i> Outbox</a></li>
							</ul>
					</li>

						<li class="divider-vertical"></li>

          <li>
						<p class="navbar-text">
							<strong id="year"></strong>
							<strong id="month"></strong>
							<strong id="week"></strong>
							<strong id="day"></strong>
						</p>
          </li>

				</ul>


				</div>
			</div>
			<!--/.nav-collapse -->
		</div>
		<!--/.container-fluid -->
	</div>
	<!--/.navbar-inner -->
</div>
<!--/.navbar -->

<span class="label label-info"></span>

<div id="alert_popup" class="alert alert-info" onclick="$(this).hide();" style="position:fixed; bottom:2%; right:5%; display:none; cursor:pointer;">
</div>

<script>
	var win = 0;
	var bid = 0;
	var notif = 0;
	var mess = 0;

	$(document).ready(function() {
		updates();
	});


	function new_alert(message){
		$('#alert_popup').hide();
		$('#alert_popup').fadeIn(1000);
		$('#alert_popup').text(message);
	}

	$.ajax({
  	url: "<?=site_url()?>/family/get_date", 
		dataType: 'json',
    success: function(data)
    {
			$('#year').text("Year: " + data[0].year);
			$('#month').text("Month: " + data[0].month);
			$('#week').text("Week: " + data[0].week);
			$('#day').text("Day: " + data[0].day);
    } 
  });

	function updates(){
		$.ajax({
    	url: "<?=site_url()?>/family/get_updates", 
			dataType: 'json',
    	success: function(data)
    	{
				if(data.mess > 0){
					$('#mess').text(data.mess);
					$('#mess').show();
				}
				else $('#mess').hide()

				if(data.win > 0){
					$('#win').text(data.win);
					$('#win').show();
				}
				else $('#win').hide()

				if(data.bid > 0){
					$('#bid').text(data.bid);
					$('#bid').show(); 
				}
				else $('#bid').hide()

				if(data.notif > 0){
					$('#notif').text(data.notif);
					$('#notif').show();
				}
				else $('#notif').hide()
   		} 
		});
	}

	setInterval(updates, 3000);

</script>
