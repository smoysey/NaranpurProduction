<table class="table table-striped">
	<thead>
    <tr>
    	<th>Member</th>
      <th>Age</th>
      <th>Sex</th>
      <th>Health</th>
		</tr>
	</thead>
	<tbody>
		<?php $i = 1;?>
		<?php foreach($family->result() as $member){ ?>
			<tr>
				<td><?=$i;?></td>
				<td><?=$member->age;?></td>
				<td><?=$member->sex;?></td>
				<td><?=$member->health;?></td>
			</tr>
		<?php $i++;  } ?>
	</tbody>
</table>

