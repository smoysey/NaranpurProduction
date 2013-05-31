<div class="container-fluid">

	<div class="row-fluid">
			<h1>Welcome to the Store</h1?>
			</br>
			<h3 style="color:#006600">Family Cash: $<?php echo $cash; ?></h3>
			</br>
	</div>

	<div class="row-fluid">

		<div class="span3 offset2 well" style="text-align:center">
			<h3>Buy</h3>
			<?php $this->load->view('buy_view'); ?>
		</div>

		<div class="span3 offset2 well" style="text-align:center">
			<h3>Sell</h3>
			<?php $this->load->view('sell_view'); ?>
		</div>

	</div>

	<div class="row-fluid">

		<div class="span6 offset3">
		<div class="span6 offset3">
		</div>
		</div>

	</div>

</div>
