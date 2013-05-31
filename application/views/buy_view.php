<form id="buy_form" class="horizontal" action="<?php echo site_url();?>/store/buy" method="POST"> 

	<div class="control-group">
		<select id="buyItemSelect" name="buyItem">
			<?php foreach($buy_inventory->result() as $buy_item){ ?> 
				<option value="<?php echo $buy_item->id; ?>" data-quantity="<?php echo $buy_item->quantity;?>" data-price="<?php echo $buy_item->buyPrice;?>">
					<?php echo $buy_item->name."&nbsp;";?>
					<?php echo "&nbsp;$".$buy_item->buyPrice; ?>
				</option>
			<?php } ?>
		</select>
	</div>

	<div id="quantity_box" class="control-group">
		<input id="buyQuantitySelectBox" name="buyQuantity" type="number" name="buyQuantity" min="1" max="<?=$buy_inventory->row()->quantity;?>" step='1' value="1"/>
	</div>

	<div class="control-group">
		<a class="btn btn-primary" href="javascript: checkCash()">Buy</a>
	</div>

	<div class="control-group">
		<input type="text" id="buyCost" value="Price: $0" disabled/>
	</div>

	<div class="control-group">
		<input type="text" id="buyAvailable" value="Updated Cash: $<?php echo $cash; ?>" disabled/>
	</div>

</form>

<div id="error" class="alert alert-blocki alert-error" style="display:none;">  
  <a class="close" onclick="$('#error').hide()">X</a>  
  <h4 class="alert-heading">Error!</h4>  
	<p id="error_message"></p>
</div> 

<script>
var price = $('#buyItemSelect option:selected').data('price');
var quantity = 1;
buyCal();

//Set up the on-click for the buttons that select the items
$('#buyItemSelect').change(function () {
	$('#buyQuantitySelectBox').val(1);
	$('#buyQuantitySelectBox').attr("max", $('option:selected', this).data('quantity'));
	price = $('option:selected', this).data('price'); 
	quantity = 1;

	if(price == null) price = 0;

	buyCal();
});

//Set up the on-click for the buttons that select the items
$('#buyQuantitySelectBox').change(function () {
	quantity = $(this).val();
	buyCal();
});

function buyCal(){
	var cash = <?php echo $cash; ?>;
	var buyAvailable = document.getElementById("buyAvailable");
	var buyCost = document.getElementById("buyCost");

	buyCost.value =  "Price: $" + (price * quantity);
	buyAvailable.value = cash - (price * quantity);
	buyAvailable.value = "Updated Cash: $" + buyAvailable.value;

	if(cash - (price * quantity) > 0){
		$('#quantity_box').removeClass("error");
		return(true);
	}
	else{
		$('#quantity_box').addClass("error");
		return(false);
	}
}

function checkCash(){
	if(buyCal())	$('#buy_form').submit();
	else{
		$('#error_message').text("You do not have the funds to buy this.");
		$('#error').show();
		return(false);
	}
}


</script>
