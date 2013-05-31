<div class="navbar">
	<div class="navbar-inner">
		<div class="container-fluid">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<a class="brand" href="<?php echo site_url();?>" name="top">Naranpur</i></a>
			<div class="nav-collapse collapse">
				<ul class="nav">
						<li class="divider-vertical"></li>

      		<li><a href="<?php echo site_url();?>/world"><i class="icon-globe"></i> World</a></li>
						<li class="divider-vertical"></li>

      		<li id="modalLink"><a href="#inventoryModal" role="button"  data-toggle="modal"><i class="icon-tasks"></i> Inventory</a></li>
						<li class="divider-vertical"></li>

      		<li><a href="<?php echo site_url();?>/store"><i class="icon-leaf"></i> Store</a></li>
						<li class="divider-vertical"></li>

     			<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href=""><i class="icon-th"></i> Market <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo site_url();?>/listing/view_all_listings"><i class="icon-search"></i> View Listings</a></li>
									<li class="divider"></li>
								<li><a href="<?php echo site_url();?>/transaction/view_all_transactions"><i class="icon-barcode"></i> View Transactions</a></li>
							</ul>
					</li>
						<li class="divider-vertical"></li>

     			<li><a href="<?php echo site_url();?>/discussion"><i class="icon-comment"></i> Forum</a></li>
						<li class="divider-vertical"></li>

     			<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href=""><i class="icon-envelope"></i> Messages <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo site_url();?>/messages/compose"><i class="icon-pencil"></i> Compose</a></li>
									<li class="divider"></li>
								<li><a href="<?php echo site_url();?>/messages/inbox"><i class="icon-inbox"></i> Inbox</a></li>
									<li class="divider"></li>
								<li><a href="<?php echo site_url();?>/messages/outbox"><i class="icon-share"></i> Outbox</a></li>
							</ul>
					</li>

						<li class="divider-vertical"></li>

          <li>
     				<a href="<?php echo site_url();?>/family/logout"><i class="icon-share"></i> Logout</a>
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


<script>
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
</script>
