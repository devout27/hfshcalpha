
<table class="table table-sm table-hover no-wrap" id="dt-admin-amenities">
  <thead>
    <tr>
      <th scope="col">Sr No.</th>
      <th scope="col">Picture</th>
      <th scope="col">Details</th>
      <th scope="col">Type</th>
      <th scope="col">Stalls</th>
      <th scope="col">Acres</th>
    </tr>
  </thead>
  <tbody>
  	<? foreach((array)$amenities AS $k=>$a): ?>
    <tr>
        <td><?=++$k?></td>
    	<? if($a['amenities_picture']): ?>
      		<td><img src="<?= $a['amenities_picture'] ?>" height="50"></td>
    	<? else: ?>
      		<td class="text-center font-weight-bold">N/A</td>
      	<? endif; ?>
      <td><b><?= $a['amenities_name'] ?></b><br/><p><small><?= $a['amenities_description'] ?></td>
      <td><?= $a['amenities_type'] ?></td>
      <td><?= $a['amenities_stalls'] ?></td>
      <td><?= $a['amenities_acres'] ?></td>
    </tr>
	<? endforeach; ?>
	<? if(!count($amenities)): ?>
		<tr><td colspan=100%>No Amenities</td></tr>
	<? endif; ?>
  </tbody>
</table>
