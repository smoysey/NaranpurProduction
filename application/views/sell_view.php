<form class="horizontal" action="<?php echo site_url();?>/store/sell" method="POST"> 

	<div class="control-group">
		<select id="sellItemSelect" name="sellItem">
			<?php foreach($sell_inventory->result() as $sell_item){ ?> 
				<option value="<?php echo $sell_item->id; ?>" data-quantity="<?php echo $sell_item->quantity?>" data-price="<?php echo $sell_item->sellPrice?>">
					<?php echo $sell_item->name."&nbsp;";?>
					<?php echo "&nbsp;$".$sell_item->sellPrice; ?>
				</option>
			<?php } ?>
		</select>
	</div>

	<div class="control-group">
		<input id="sellQuantitySelectBox" name="sellQuantity" type="number" min="1" max="<?=$sell_inventory->row()->quantity;?>" step='1' value="1"/>
	</div>

	<div class="control-group">
		<button id="sellButton" class="btn btn-primary" type="submit">Sell</button>
	</div>

	<div class="control-group">
			<input type="text" id="sellCost" value="Price: $0" disabled/>
	</div>

	<div class="control-group">
			<input type="text" id="sellAvailable" value="Updated Cash: $<?php echo $cash; ?>" disabled/>
	</div>

	<div id="sell_error" class="alert alert-block alert-error" style="display:none;">  
  	<a class="close" onclick="$('#sell_error').hide()">X</a>  
		<h4 class="alert-heading">Error!</h4>  
		<p id="sell_error_message"></p>
	</div> 

</form>


<script>
var price = <?=$sell_inventory->row()->sellPrice;?>;
var quantity = 1;
sellCal();

$(document).ready(function() {
	$('#sellQuantitySelectBox').val(1);
	quantity = 1;
	$('#sellButton').removeAttr("disabled");
});

//Set up the on-click for the buttons that select the items
$('#sellItemSelect').change(function () {
	$('#sellQuantitySelectBox').val(1);
	$('#sellQuantitySelectBox').attr("max", $('option:selected', this).data('quantity'));
		price = $('option:selected', this).data('price'); 
		quantity = 1;

		if(price == null) price = 0;

		sellCal();
});

$('#sellQuantitySelectBox').change(function () {
	quantity = $(this).val();

	sellCal();
});

function sellCal(){
	var cash = <?php echo $cash; ?>;
	var sellAvailable = document.getElementById("sellAvailable");
	var sellCost = document.getElementById("sellCost");

	if(isNaN(quantity) == true || quantity == "" || quantity < 1){
		$('#sellButton').attr("disabled", "disabled");
		$('#sell_error_message').text("You must enter a valid number.");
		$('#sell_error').show();
	}
	else if(quantity > $('#sellItemSelect option:selected').data('quantity')){
		$('#sellButton').attr("disabled", "disabled");
		$('#sell_error_message').text("You do not have sufficent inventory for this transaction.");
		$('#sell_error').show();
	}
	else{
		$('#sellButton').removeAttr("disabled");
	}

	sellCost.value = "Price: " + price * quantity;
	sellAvailable.value = "Updated Cash: $" + (cash + (price * quantity));
}

</script>
