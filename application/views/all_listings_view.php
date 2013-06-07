<div class="container-fluid">

<div class="row-fluid">
<ul class="nav nav-pills">
	<li <?php if($this->uri->segment(2) == "view_all_listings") echo 'class="active"'?>>
		<a href="<?=site_url()?>/listing/view_all_listings">All Listings</a>
	</li>
	<li <?php if($this->uri->segment(2) == "my_listings") echo 'class="active"'?>>
		<a href="<?=site_url()?>/listing/my_listings">My Listings</a>
	</li>
  <li class="dropdown">
    <a class="dropdown-toggle"
       data-toggle="dropdown"
       href="#">
        Resource Filter
        <b class="caret"></b>
      </a>
    <ul class="dropdown-menu">
			<li><a href="<?=site_url()?>/listing/<?=$this->uri->segment(2)?>/">All</a></li>
			<?php foreach($resources->result() as $res){ ?>
				<li><a href="<?=site_url()?>/listing/<?=$this->uri->segment(2)?>/<?=$res->id;?>"><?=$res->name;?></a></li>
			<?php } ?>
    </ul>
  </li>
	<?php foreach($resources->result() as $res){ ?>
		<?php if($res->id == $this->uri->segment(3)){ ?>
				<li class="active"><a><strong><?=$res->name;?></strong></a></li>
		<?php } ?>
	<?php } ?>
	<?php if("" == $this->uri->segment(3)){ ?>
		<li class="active"><a><strong>All</strong></a></li>
	<?php } ?>

	<li class="pull-right">
		<a href="#create_listing_modal" role="button" class="btn" data-toggle="modal">
			Create a Listing
		</a>
	</li>

</ul>
</div>

<div class="row-fluid">
<div class="span12">
<table class="table table-striped">
	<thead>
		<tr>
			<th>Family</th>
			<th>Resource</th>
			<th>Quantity</th>
			<th>Bids</th>
			<th>Message</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($listings->result() as $row){ ?>
			<tr style="cursor:pointer"; onclick="document.location = '<?php echo site_url("/listing/view_listing/$row->id");?>';">
				<td>
					<?php echo $row->family_name;?>
				</td>
				<td class="span3">
					<?php echo $row->resource_name;?>
				</td>
				<td>
					<?php echo $row->quantity;?>
				</td>
				<td>
					<?php echo $row->bids;?>
				</td>
				<td class="span9">
					<textarea rows="1" class="span12" placeholder="<?php echo $row->message;?>" disabled></textarea>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>


</div>

	<ul class="pager">
  	<li class="previous" style="<?php if($prev < 0) echo "display:none;";?>">
    	<a href="<?=site_url("listing/".$this->uri->segment(2)."/$res_id/$prev")?>">
				<i class="icon-chevron-left"></i>
			</a>
  	</li>
  	<li class="next" style="<?php if($total <= $next) echo "display:none;";?>">
    	<a href="<?=site_url("listing/".$this->uri->segment(2)."/$res_id/$next")?>">
				<i class="icon-chevron-right"></i>
			</a>
  	</li>
	</ul>

</div>
</div>
</div>
</div>

<?php $this->load->view('create_listing_view'); ?>
