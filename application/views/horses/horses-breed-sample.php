
<div class="row">
	<div class="col-sm-12">
<div class="container-fluid">
    <div class="table-responsive">
<table class="table table-sm table-hover" id="dt-breeding-sample">
  <thead>
    <tr>
      <th scope="col"></th>
      <th scope="col"><?= $horse1['horses_name'] ?></th>
      <th scope="col"><?= $horse2['horses_name'] ?></th>
      <th scope="col">Dominant</th>
      <th scope="col">Heterozygous</th>
      <th scope="col">Recessive</th>
  </tr>
  </thead>
  <tbody>
  	<? foreach((array)$genes AS $i => $g): ?>
  		<? if(!$g['genes_name']){continue;} ?>

<tr>
	<td><b><?= $g['genes_name'] ?></b></td>
	<td scope="col"><?= $genes['horse1']['genes'][$i]['horses_x_genes_value'] ?: '<span class="text-muted">N/A</span>' ?></td>
	<td scope="col"><?= $genes['horse2']['genes'][$i]['horses_x_genes_value'] ?: '<span class="text-muted">N/A</span>' ?></td>
	<td scope="col"><?= $genes['foal']['genes'][$i]['possibility1'] ?> <?= $genes['foal']['genes'][$i]['possibility1_percent'] ?>%</td>
	<td scope="col"><?= $genes['foal']['genes'][$i]['possibility2'] ?> <?= $genes['foal']['genes'][$i]['possibility2_percent'] ?>%</td>
	<td scope="col"><?= $genes['foal']['genes'][$i]['possibility3'] ?> <?= $genes['foal']['genes'][$i]['possibility3_percent'] ?>%</td>
</tr>
	<? endforeach; ?>
  </tbody>
</table>
</div>
</div>

	</div>
</div>

<? //pre($genes); ?>