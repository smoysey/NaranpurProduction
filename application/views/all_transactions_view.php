<div class="container-fluid">

<div class="row-fluid">
<ul class="nav nav-pills">
	<li class="dropdown">
  	<a class="dropdown-toggle"
       data-toggle="dropdown"
       href="#">
        Resource Filter
        <b class="caret"></b>
      </a>
    <ul class="dropdown-menu">
			<li><a href="<?=site_url()?>/transaction/view_all_transactions/-1">All</a></li>
			<?php foreach($resources->result() as $res){ ?>
				<li><a href="<?=site_url()?>/transaction/view_all_transactions/<?=$res->id;?>"><?=$res->name;?></a></li>
			<?php } ?>
    </ul>
  </li>
	<?php if(count($trans) > 0){ ?>
		<?php foreach($resources->result() as $res){ ?>
			<?php if($res->id == $this->uri->segment(3)){ ?>
					<li class="active"><a><strong><?=$res->name;?></strong></a></li>
			<?php } ?>
		<?php } ?>
		<?php if("" == $this->uri->segment(3) || $this->uri->segment(3) == -1){ ?>
			<li class="active"><a><strong>All</strong></a></li>
		<?php } ?>
	<?php } ?>
	</ul>
</div>



<div class="row-fluid">
<table class="table">
	<thead>
		<tr>
			<th></th>
			<th></th>
			<th>Family</th>
			<th>Resource</th>
			<th>Quantity</th>
			<th>Message</th>
		</tr>
	</thead>
	<tbody>
		<?php for($i = 0; $i < count($trans); $i++){?>
			<?php $listing = $trans[$i]['listing']->row_array(); ?>
			<?php $bid = $trans[$i]['bid']->row_array(); ?>
			<tr <?php if($i % 2) echo 'class="well"'?>>
				<td rowspan="2"><h3>Transaction:</h3><strong><?=$trans[$i]['time'];?></strong></td>
				<td>
					<h4>Lister</h4>
				</td>
				<td>
					<?php echo $listing['family_name'];?>
				</td>
				<td>
					<?php echo $listing['resource_name'];?>
				</td>
				<td>
					<?php echo $listing['quantity'];?>
				</td>
				<td class="span9">
					<textarea rows="1" class="span12" placeholder="<?php echo $listing['message']?>" disabled></textarea>
				</td>
			</tr>
			<tr <?php if($i % 2) echo 'class="well"'?>>
				<td>
					<h4>Winning Bidder</h4>
				</td>
				<td>
					<?php echo $bid['family_name'];?>
				</td>
				<td>
					<?php echo $bid['resource_name'];?>
				</td>
				<td>
					<?php echo $bid['quantity'];?>
				</td>
				<td class="span9">
					<textarea rows="1" class="span12" placeholder="<?php echo $bid['message']?>" disabled></textarea>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>
</div>

	<ul class="pager">
  	<li class="previous" style="<?php if($prev < 0) echo "display:none;";?>">
    	<a href="<?=site_url("transaction/view_all_transactions/$res_id/$prev")?>">
				<i class="icon-chevron-left"></i>
			</a>
  	</li>
  	<li class="next" style="<?php if($total <= $next) echo "display:none;";?>">
    	<a href="<?=site_url("transaction/view_all_transactions/$res_id/$next")?>">
				<i class="icon-chevron-right"></i>
			</a>
  	</li>
	</ul>

</div>
