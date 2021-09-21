
 <div class="row">
    <div class="col-md-6 col-xl-4">
        <div class="card mb-4">
          	<h4 class="card-header">Breeds</h4>
            <div class="card-body">
				<div class="row">
					<div class="col-sm-12">
						<b>Add Breed</b>
						<form method="post" action="/admin/horses/breeds">
							<?= hf_input('breed', 'Breed', $_POST, array(), $errors) ?>
							<?= hf_submit('a_breed', 'Add Breed', array('class' => 'btn btn-primary col-sm-12')) ?>
						</form>
						<hr>
						<b>Remove Breed</b>
						<form method="post" action="/admin/horses/breeds">
							<?= hf_dropdown('remove_breed', 'Breed', $_POST, $breeds, array(), $errors, 1) ?>
							<?= hf_dropdown('horses_breed2', 'What breed should these horses become?', $_POST, $breeds, array(), $errors, 1) ?>
							<?= hf_submit('r_breed', 'Remove Breed', array('class' => 'btn btn-primary col-sm-12')) ?>
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>


    <div class="col-md-6 col-xl-4">
        <div class="card mb-4">
          	<h4 class="card-header">Disciplines</h4>
            <div class="card-body">
				<div class="row">
					<div class="col-sm-12">
						<b>Add Discipline</b>
						<form method="post" action="/admin/horses/breeds">
							<?= hf_input('horses_discipline', 'Discipline', $_POST, array(), $errors) ?>
							<?= hf_submit('a_discipline', 'Add Discipline', array('class' => 'btn btn-primary col-sm-12')) ?>
						</form>
						<hr>
						<b>Remove Discipline</b>
						<form method="post" action="/admin/horses/breeds">
							<?= hf_dropdown('remove_discipline', 'Discipline', $_POST, $disciplines, array(), $errors, 1) ?>
							<?= hf_dropdown('horses_discipline2', 'What should horses with this discipline be changed to?', $_POST, $disciplines, array(), $errors, 1) ?>
							<?= hf_submit('r_discipline', 'Remove Discipline', array('class' => 'btn btn-primary col-sm-12')) ?>
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>

    <div class="col-md-6 col-xl-4">
        <div class="card mb-4">
          	<h4 class="card-header">Base Colors</h4>
            <div class="card-body">
				<div class="row">
					<div class="col-sm-12">
						<b>Add Base Color</b>
						<form method="post" action="/admin/horses/breeds">
							<?= hf_input('horses_color', 'Base Color', $_POST, array(), $errors) ?>
							<?= hf_submit('a_base', 'Add Base Color', array('class' => 'btn btn-primary col-sm-12')) ?>
						</form>
						<hr>
						<b>Remove Base Color</b>
						<form method="post" action="/admin/horses/breeds">
							<?= hf_dropdown('remove_color', 'Base Color', $_POST, $base_colors, array(), $errors, 1) ?>
							<?= hf_dropdown('horses_color2', 'What should horses with this base color be changed to?', $_POST, $base_colors, array(), $errors, 1) ?>
							<?= hf_submit('r_base', 'Remove Base Color', array('class' => 'btn btn-primary col-sm-12')) ?>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>



    <div class="col-md-6 col-xl-4">
        <div class="card mb-4">
          	<h4 class="card-header">Patterns</h4>
            <div class="card-body">
				<div class="row">
					<div class="col-sm-12">
						<b>Add Pattern</b>
						<form method="post" action="/admin/horses/breeds">
							<?= hf_input('horses_pattern', 'Pattern Color', $_POST, array(), $errors) ?>
							<?= hf_submit('a_pattern', 'Add Pattern', array('class' => 'btn btn-primary col-sm-12')) ?>
						</form>
						<hr>
						<b>Remove Pattern</b>
						<form method="post" action="/admin/horses/breeds">
							<?= hf_dropdown('remove_pattern', 'Pattern Color', $_POST, $base_patterns, array(), $errors, 1) ?>
							<?= hf_dropdown('horses_pattern2', 'What should horses with this pattern color be changed to?', $_POST, $base_patterns, array(), $errors, 1) ?>
							<?= hf_submit('r_pattern', 'Remove Pattern', array('class' => 'btn btn-primary col-sm-12')) ?>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

    <div class="col-md-6 col-xl-4">
        <div class="card mb-4">
          	<h4 class="card-header">Lines</h4>
            <div class="card-body">
				<div class="row">
					<div class="col-sm-12">
						<b>Add Line</b>
						<form method="post" action="/admin/horses/breeds">
							<?= hf_input('horses_line', 'Line', $_POST, array(), $errors) ?>
							<?= hf_submit('a_line', 'Add Line', array('class' => 'btn btn-primary col-sm-12')) ?>
						</form>
						<hr>
						<b>Remove Line</b>
						<form method="post" action="/admin/horses/breeds">
							<?= hf_dropdown('remove_line', 'Line', $_POST, $lines, array(), $errors, 1) ?>
							<?= hf_dropdown('horses_line2', 'What should horses with this line be changed to?', $_POST, $lines, array(), $errors, 1) ?>
							<?= hf_submit('r_line', 'Remove Line', array('class' => 'btn btn-primary col-sm-12')) ?>
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>



    <div class="col-md-6 col-xl-4">
        <div class="card mb-4">
          	<h4 class="card-header">Restricted Names</h4>
            <div class="card-body">
				<div class="row">
					<div class="col-sm-12">
						<b>Add Restricted Name</b>
						<form method="post" action="/admin/horses/breeds">
							<?= hf_input('restricted_name', 'Name', $_POST, array(), $errors) ?>
							<?= hf_submit('a_restricted_name', 'Add Restriction', array('class' => 'btn btn-primary col-sm-12')) ?>
						</form>
						<hr>
						<b>Remove Restricted Name</b>
						<form method="post" action="/admin/horses/breeds">
							<?= hf_dropdown('remove_name', 'Name', $_POST, $restricted_names, array(), $errors, 1) ?>
							<?= hf_submit('r_restricted_name', 'Remove Restriction', array('class' => 'btn btn-primary col-sm-12')) ?>
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
