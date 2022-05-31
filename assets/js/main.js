
$(function() {
var url = window.location.href;
var activeTab = url.substring(url.indexOf("#") + 1);
$('a[href="#'+ activeTab +'"]').tab('show');

$.extend( $.fn.dataTable.defaults, {
		"pageLength": 25
} );



$('#dt-logs').DataTable({

	/*"aaSorting": []*/
	"pageLength": 100,
	"order": [[ 3, "desc" ]],

});

$('#dt-inbox').DataTable({

	/*"aaSorting": []*/
	"order": [[ 0, "desc" ]],
	"columnDefs": [
		{
			"targets": [ 0 ],
			"visible": false,
			"searchable": false
		}
		]

});
$('#dt-sent').DataTable({
	"order": [[ 0, "desc" ]],
	"columnDefs": [
		{
			"targets": [ 0 ],
			"visible": false,
			"searchable": false
		}
		]
});

$('#dt-notices').DataTable({
	"aaSorting": [],
	"pageLength": 100
});


$('#dt-horses-enter-class').DataTable({
	"order": [[ 1, "desc" ]],
});

$('#dt-appts-search').DataTable({
	"order": [[ 0, "desc" ]],
	"columnDefs": [
		{
			"targets": [ 0 ],
			"visible": false,
			"searchable": false
		}
		]});

$('#dt-horses').DataTable({
});
$('#dt-horses-search').DataTable({"autoWidth": true});
$('#dt-events-search').DataTable({
	"autoWidth": true,
	"aaSorting": [],
	"pageLength": 10,
});
$('#dt-events-admin-classes').DataTable({
	"autoWidth": true,
	"aaSorting": [],
	"pageLength": 50,
});
$('#dt-horses-progeny').DataTable({});
$('#dt-horses-siblings-sire').DataTable({});
$('#dt-horses-siblings-dam').DataTable({});
$('#dt-cabs').DataTable({});


$('#dt-admin-genes').DataTable({});
$('#dt-admin-classlists').DataTable({});
$('#dt-admin-amenities').DataTable({
	"order": [[ 1, "asc" ]],
});
$('#dt-admin-divisions').DataTable({});
$('#dt-admin-classes').DataTable({});
$('#dt-admin-blueprints').DataTable({});
$('#dt-admin-blueprints-genes').DataTable({
	"paging": false,
});
$('#dt-admin-stables-packages-amenities').DataTable({
	"paging": false,
});



$('#dt-bank-loans').DataTable({
	"order": [[ 3, "asc" ]],
});
$('#dt-bank-loans-search').DataTable({});

$('#dt-bank-ledger').DataTable({
	"order": [[ 0, "desc" ]],
	"columnDefs": [
		{
			"targets": [ 0 ],
			"visible": false,
			"searchable": false
		}
		]
});
$('#dt-bank-incoming').DataTable({
	"order": [[ 0, "desc" ]],
	"columnDefs": [
		{
			"targets": [ 0 ],
			"visible": false,
			"searchable": false
		}
		]
});
$('#dt-bank-outgoing').DataTable({
	"order": [[ 0, "desc" ]],
	"columnDefs": [
		{
			"targets": [ 0 ],
			"visible": false,
			"searchable": false
		}
		]
});


$("#dt-inbox").css("width","100%");
$("#dt-sent").css("width","100%");
$("#dt-horses").css("width","100%");
$("#dt-cabs").css("width","100%");
$("#dt-bank-ledger").css("width","100%");
$('#dt-horses-search').css("width", "100%");




$('#terms_agree').click(function(){
	if(this.checked){
		$('#terms_disagree').prop('checked', false);
	}
});

$('#terms_disagree').click(function(){
	if(this.checked){
		$('#terms_agree').prop('checked', false);
	}
});

$('#transfer_type').on('change', function(){
	if(this.value == "Internal"){
		$('#transfer_id').parent().parent().hide();
		$('#transfer_to').parent().parent().show();
	}else if(this.value == "External"){
		$('#transfer_id').parent().parent().show();
		$('#transfer_to').parent().parent().hide();
	}
	$('#transfer_amount').parent().parent().show();
	$('#transfer_memo').parent().parent().show();
	$('#transfer_from').parent().parent().show();
	$('#transfer_recurring').parent().parent().show();
});


$('#events_type').on('change', function(){
	if(this.value == "0"){
		$('.racedates').hide();
		$('.showdates').show();
	}else if(this.value == "1"){
		$('.racedates').show();
		$('.showdates').hide();
	}
});



$('#transfer_recurring').on('change', function(){
	if(this.value == "Yes"){
		$('#transfer_frequency').parent().parent().parent().parent().show();
		$('#transfer_months').parent().parent().hide();
		$('#transfer_days').parent().parent().hide();
		$('#transfer_start').parent().parent().show();
	}else if(this.value == "No"){
		$('#transfer_start').parent().parent().hide();
		$('#transfer_days').parent().parent().hide();
		$('#transfer_months').parent().parent().hide();
		$('#transfer_frequency').parent().parent().parent().parent().hide();
	}
});



$('#transfer_frequency').on('change', function(){
	if(this.value == "Days"){
		$('#transfer_months').parent().parent().hide();
		$('#transfer_days').parent().parent().show();
	}else if(this.value == "Months"){
		$('#transfer_days').parent().parent().hide();
		$('#transfer_months').parent().parent().show();
	}
});


$('input[name="genes_code[0]"]').keyup(function(){
	var str = $(this).val();
	var value = $('input[name="genes_code[0]"]').val().toLowerCase();
	var value2 = str.charAt(0).toUpperCase() + str.substr(1).toLowerCase();
	$('input[name="genes_code[1]"]').val(value2);
	$('input[name="genes_code[2]"]').val(value);
});


$('#transfer_id').parent().parent().hide();
$('#transfer_to').parent().parent().hide();
$('#transfer_amount').parent().parent().hide();
$('#transfer_memo').parent().parent().hide();
$('#transfer_from').parent().parent().hide();
$('#transfer_frequency').parent().parent().parent().parent().hide();
$('#transfer_months').parent().parent().hide();
$('#transfer_days').parent().parent().hide();
$('#transfer_recurring').parent().parent().hide();
$('#transfer_start').parent().parent().hide();
$('#email_body_div').hide();



$('#send_email_checkbox').click(function(){
	if(this.checked){
		$('#email_body_div').show();
	}else{
		$('#email_body_div').hide();
	}
});

$('.datepicker_shows').datepicker({
    beforeShowDay: function(date) {
    	var days = [6, 10, 13, 16, 20, 23, 26, 30];
    	if(days.includes(date.getDate())){
    		return [true];
    	}
        return [false];
    },
    minDate: 0,
    maxDate: "+3M",
    dateFormat: 'yy-mm-dd',
});

$('.datepicker_races').datepicker({
    beforeShowDay: function(date) {
    	if(date.getDay() == 5 || date.getDay() == 6){
    		return [true];
    	}
        return [false];
    },
    minDate: 0,
    maxDate: "+3M",
    dateFormat: 'yy-mm-dd',
});



$('#events_type').change();

/*
$("#admin-sortable-blueprint1, #admin-sortable-blueprint2" ).sortable({
	connectWith: ".connectedSortable"
}).disableSelection();
*/











/* SHOWS/EVENTS */
$(".enterhorse").on( "click", function() {
	var class_id = $(this).data('classid');
	var horse_id = $(this).data('horseid');
	var button = $(this);
	var curRow = button.closest('tr');
	var rowSpan = button.parent().attr('rowspan');
	console.log($(this).data('classid'));
	$.ajax({
		url: "/city/ajax/enter-class",
		cache: false,
		method: "POST",
		data: {
			classes_id: class_id,
			join_horses_id: horse_id,
		}
	})
	.done(function( response ) {
		if(response == 1){
			button.attr('disabled', true);
			button.attr('value', 'Entered');
			button.html("Success");
			button.removeClass('btn-success');
			button.addClass('btn-info');
		}else{
			button.removeClass('btn-success');
			button.addClass('btn-warning');
			button.html('Failed');
			button.parent().attr('rowspan', parseInt(rowSpan) + parseInt(1));
			curRow.after('<tr><td colspan=5><i>' + response + "</i></td></tr>");
		}
	});

});











/* DIALOGS */
$(".admin-new-class").on( "click", function() {
	$('#classlists_classes_id').val('0');
	$('#join_classlists_id').val($(this).data("classlistsid"));
	$('#save-events-class').html("Create Class");
});


$(".admin-edit-class").on( "click", function() {
	$('#classlists_classes_id').val($(this).data("id"));
	$('#join_classlists_id').val($(this).data("classlistsid"));
	$('#join_divisions_id').val($(this).data("divisionsid"));
	$('#classlists_classes_name').val($(this).data("name"));
	$('#classlists_classes_min_age').val($(this).data("minage"));
	$('#classlists_classes_max_age').val($(this).data("maxage"));
	$('#classlists_classes_fee').val($(this).data("fee"));
	$('#classlists_classes_strenuous').val($(this).data("strenuous"));
	$('#classlists_classes_description').val($(this).data("desc"));
	$('#classlists_classes_disciplines').val($(this).data("disciplines").split('|'));
	$('#classlists_classes_breeds_types').val($(this).data("types").split('|'));
	$('#classlists_classes_breeds').val($(this).data("breeds").split('|'));

	$('#save-events-class').html("Save Changes");
});



$("#admin-save-events-class").on("click", function(){
	var class_id = $('#classlists_classes_id').val();
	if(!class_id){class_id = 0;}
	var save_button = $(".admin-edit-class[data-id="+ class_id +"]");
	$.ajax({
		url: "/admin/ajax/update-class",
		cache: false,
		method: "POST",
		data: {
			classlists_classes_id: $('#classlists_classes_id').val(),
			join_classlists_id: $('#join_classlists_id').val(),
			classlists_classes_name: $('#classlists_classes_name').val(),
			classlists_classes_min_age: $('#classlists_classes_min_age').val(),
			classlists_classes_max_age: $('#classlists_classes_max_age').val(),
			classlists_classes_fee: $('#classlists_classes_fee').val(),
			classlists_classes_strenuous: $('#classlists_classes_strenuous').val(),
			classlists_classes_description: $('#classlists_classes_description').val(),
			join_divisions_id: $('#join_divisions_id').val(),
			classlists_classes_disciplines: $('#classlists_classes_disciplines').val(),
			classlists_classes_breeds_types: $('#classlists_classes_breeds_types').val(),
			classlists_classes_breeds: $('#classlists_classes_breeds').val(),
		}
	})
	.done(function( response ) {
		//$( "#results" ).append( html );
		//console.log(JSON.parse(response));
		response = JSON.parse(response);
		if(response.success == 1){
			if($('#classlists_classes_id').val() == 0){
				//this is a new class, so let's add a row to the table.
				var strenuous = "";
				if(response.classlists_classes_strenuous == 1){
					strenuous = "*";
				}
				$('#dt-events-admin-classes tr:last').after('<tr id="class-id-' + response.classlists_classes_id +'"><td id="e-name-' + response.classlists_classes_id +'">' + strenuous + response.classlists_classes_name +'</td><td id="e-age-' + response.classlists_classes_id +'">' + response.classlists_classes_min_age + ' - ' + response.classlists_classes_max_age + '</td><td id="e-fee-' + response.classlists_classes_id +'">$' + response.classlists_classes_fee + '</td><td id="e-divisionsid-' + response.join_divisions_id +'">'+ $('#classlists_divisions_id :selected').text() +'</td><td><button type="button" class="btn btn-primary admin-edit-class" data-toggle="modal" data-target="#dialog-events-classes-edit" data-id="' + response.classlists_classes_id +'" data-name="' + response.classlists_classes_name +'" data-minage="' + response.classlists_classes_min_age +'" data-maxage="' + response.classlists_classes_max_age +'" data-fee="' + response.classlists_classes_fee +'" data-desc="' + response.classlists_classes_description +'" data-strenuous="' + response.classlists_classes_strenuous +'">Edit Class</button><div class="save_status float-right" data-id="' + response.classlists_classes_id +'"></div><div class=""></div></td></tr>');
			}else{
				var strenuous;
				var row = $('#class-id-' + class_id);
				$('.save_status[data-id="' + class_id + '"]').html('<p class="text-success"><span class="fas fa-check"></span></p>');
				$('.save_status[data-id="0"]').html(' ');
				if($('#classlists_classes_strenuous').val() == "1"){
					$('#e-name-' + class_id).html('*' + $('#classlists_classes_name').val());
				}else{
					$('#e-name-' + class_id).html($('#classlists_classes_name').val());
				}
				$('#e-age-' + class_id).html($('#classlists_classes_min_age').val() +'-'+ $('#classlists_classes_max_age').val());
				$('#e-fee-' + class_id).html('$' + $('#classlists_classes_fee').val());
				$('#e-division-' + class_id).html(response.classlists_divisions_name);

				save_button.data('disciplines', $('#classlists_classes_disciplines').val().join('|'));
				save_button.data('breeds', $('#classlists_classes_breeds').val().join('|'));
				save_button.data('types', $('#classlists_classes_breeds_types').val().join('|'));
				save_button.data('name', $('#classlists_classes_name').val());
				save_button.data('minage', $('#classlists_classes_min_age').val());
				save_button.data('maxage', $('#classlists_classes_max_age').val());
				save_button.data('fee', $('#classlists_classes_fee').val());
				save_button.data('strenuous', $('#classlists_classes_strenuous').val());
				save_button.data('desc', $('#classlists_classes_description').val());
				save_button.data('divisionsid', $('#join_divisions_id').val());
			}
		}else{
			$('.save_status[data-id="0"]').html('<p class="text-danger"><span class="fas fa-check"></span><br/>' + response + '</p>');
		}
		$('#dialog-events-classes-edit').modal('hide');
	});
});













$(".edit-class").on( "click", function() {
	$('#events_x_classes_id').val($(this).data("id"));
	$('#events_x_classes_name').val($(this).data("name"));
	$('#events_x_classes_min_age').val($(this).data("minage"));
	$('#events_x_classes_max_age').val($(this).data("maxage"));
	$('#events_x_classes_fee').val($(this).data("fee"));
	$('#events_x_classes_prize01').val($(this).data("prize01"));
	$('#events_x_classes_prize02').val($(this).data("prize02"));
	$('#events_x_classes_prize03').val($(this).data("prize03"));
	$('#events_x_classes_prize04').val($(this).data("prize04"));
	$('#events_x_classes_prize05').val($(this).data("prize05"));
	$('#events_x_classes_prize06').val($(this).data("prize06"));
	$('#events_x_classes_prize07').val($(this).data("prize07"));
	$('#events_x_classes_prize08').val($(this).data("prize08"));
	$('#events_x_classes_prize09').val($(this).data("prize09"));
	$('#events_x_classes_prize10').val($(this).data("prize10"));
	$('#events_x_classes_prize11').val($(this).data("prize11"));
	$('#events_x_classes_prize12').val($(this).data("prize12"));
	$('#events_x_classes_strenuous').val($(this).data("strenuous"));
	$('#events_x_classes_description').val($(this).data("desc"));
	//$('#classlists_divisions_id').val($(this).data("divisionsid"));
	$('#join_classlists_id').val($(this).data("classlistsid"));
	console.log($(this).data("divisionsid"));
	if($(this).data("divisionsid") == 0){
		$('#events-prizes').show();
	}else{
		$('#events-prizes').hide();
	}
	$('#save-events-class').html("Save Changes");
});



$("#save-events-class").on("click", function(){
	var class_id = $('#events_x_classes_id').val();
	var save_button = $(".edit-class[data-id="+ class_id +"]");
	$.ajax({
		url: "/city/ajax/update-class",
		cache: false,
		method: "POST",
		data: {
			events_x_classes_id: $('#events_x_classes_id').val(),
			events_x_classes_name: $('#events_x_classes_name').val(),
			events_x_classes_min_age: $('#events_x_classes_min_age').val(),
			events_x_classes_max_age: $('#events_x_classes_max_age').val(),
			events_x_classes_fee: $('#events_x_classes_fee').val(),
			events_x_classes_prize01: $('#events_x_classes_prize01').val(),
			events_x_classes_prize02: $('#events_x_classes_prize02').val(),
			events_x_classes_prize03: $('#events_x_classes_prize03').val(),
			events_x_classes_prize04: $('#events_x_classes_prize04').val(),
			events_x_classes_prize05: $('#events_x_classes_prize05').val(),
			events_x_classes_prize06: $('#events_x_classes_prize06').val(),
			events_x_classes_prize07: $('#events_x_classes_prize07').val(),
			events_x_classes_prize08: $('#events_x_classes_prize08').val(),
			events_x_classes_prize09: $('#events_x_classes_prize09').val(),
			events_x_classes_prize10: $('#events_x_classes_prize10').val(),
			events_x_classes_prize11: $('#events_x_classes_prize11').val(),
			events_x_classes_prize12: $('#events_x_classes_prize12').val(),
			events_x_classes_strenuous: $('#events_x_classes_strenuous').val(),
			events_x_classes_description: $('#events_x_classes_description').val(),
			join_classlists_id: $('#join_classlists_id').val(),
		}
	})
	.done(function( response ) {
		//$( "#results" ).append( html );
		//console.log(response);
		if(response == 1){
			var strenuous;
			var row = $('#class-id-' + class_id);
			$('.save_status[data-id="' + class_id + '"]').html('<p class="text-success"><span class="fas fa-check"></span></p>');
			$('.save_status[data-id="0"]').html(' ');
			if($('#events_x_classes_strenuous').val() == "1"){
				$('#e-name-' + class_id).html('*<a href="/city/events/classes/' + class_id + '">' + $('#events_x_classes_name').val() + '</a>');
			}else{
				$('#e-name-' + class_id).html('<a href="/city/events/classes/' + class_id + '">' + $('#events_x_classes_name').val() + '</a>');
			}
			$('#e-age-' + class_id).html($('#events_x_classes_min_age').val() +'-'+ $('#events_x_classes_max_age').val());
			$('#e-fee-' + class_id).html('$' + $('#events_x_classes_fee').val());

			save_button.data('name', $('#events_x_classes_name').val());
			save_button.data('minage', $('#events_x_classes_min_age').val());
			save_button.data('maxage', $('#events_x_classes_max_age').val());
			save_button.data('fee', $('#events_x_classes_fee').val());
			save_button.data('prize01', $('#events_x_classes_prize01').val());
			save_button.data('prize02', $('#events_x_classes_prize02').val());
			save_button.data('prize03', $('#events_x_classes_prize03').val());
			save_button.data('prize04', $('#events_x_classes_prize04').val());
			save_button.data('prize05', $('#events_x_classes_prize05').val());
			save_button.data('prize06', $('#events_x_classes_prize06').val());
			save_button.data('prize07', $('#events_x_classes_prize07').val());
			save_button.data('prize08', $('#events_x_classes_prize08').val());
			save_button.data('prize09', $('#events_x_classes_prize09').val());
			save_button.data('prize10', $('#events_x_classes_prize10').val());
			save_button.data('prize11', $('#events_x_classes_prize11').val());
			save_button.data('prize12', $('#events_x_classes_prize12').val());
			save_button.data('strenuous', $('#events_x_classes_strenuous').val());
			save_button.data('desc', $('#events_x_classes_description').val());
			save_button.data('divisionsid', $('#classlists_divisions_id').val());
			save_button.data('divisionsname', $('#classlists_divisions_name').val());

		}else{
			$('.save_status[data-id="0"]').html('<p class="text-danger"><span class="fas fa-check"></span><br/>' + response + '</p>');
		}
		$('#dialog-events-classes-edit').modal('hide');
	});
});



$("#new-classlist").on("click", function(){
	$.ajax({
		url: "/admin/ajax/create-classlist",
		cache: false,
		method: "POST",
		data: {
			classlists_name: $('#classlists_name').val(),
			join_cabs_id: $('#join_cabs_id').val(),
			classlists_special: $('#classlists_special').val(),

		}
	})
	.done(function( response ) {
		//$( "#results" ).append( html );
		console.log(response);
		if(response){
			document.location.href = "/admin/events/classlists/view/" + response;
		}else{
			$('.save_status[data-id="0"]').html('<p class="text-danger"><span class="fas fa-check"></span><br/>' + response + '</p>');
		}
		$('#dialog-events-classes-edit').modal('hide');
	});
});

$(".admin-delete-class").on("click", function(){
	$('#dialog-admin-confirm-delete').modal('show');
	$('#admin-delete-class-confirm').data('id', $(this).data("id"));
	//console.log($('#admin-delete-class-confirm').data('id'));
});

$('#admin-delete-class-confirm').on("click", function(){
	var class_id = $('#admin-delete-class-confirm').data('id');
	$.ajax({
		url: "/admin/ajax/delete-class",
		cache: false,
		method: "POST",
		data: {
			classlists_classes_id: class_id,

		}
	})
	.done(function( response ) {
		//$( "#results" ).append( html );
		response = JSON.parse(response);
		if(response == "1"){
			$('#class-id-' + class_id).slideUp('slow');
		}else{
			$('.save_status[data-id="'+class_id+'"]').html('<p class="text-danger"><span class="fas fa-check"></span><br/>' + response + '</p>');
		}
		$('#dialog-admin-confirm-delete').modal('hide');
	});
});



//delete classlist
$('#delete-classlist').on("click", function(){
	$('#dialog-admin-confirm-delete-classlist').modal('show');
	$('#admin-delete-classlist-confirm').data('id', $(this).data('id'));
});
$('#admin-delete-classlist-confirm').on("click", function(){
	document.location.href = "/admin/events/classlists/delete/" + $(this).data('id');
});

//cancel event
$('#btn-cancel-event').on("click", function(e){
	e.preventDefault();
	$('#dialog-cancel-event').modal('show');
});
$('#cancel-event').on("click", function(){
	document.location.href = "/city/events/cancel/" + $(this).data('id');
});





//divisions

$(".admin-edit-division").on( "click", function() {
	$('#classlists_divisions_id').val($(this).data("id"));
	$('#classlists_divisions_name').val($(this).data("name"));
	$('#join_classlists_id').val($(this).data("classlistsid"));
	$('#admin-save-division').html("Save Changes");
});

$(".admin-new-division").on( "click", function() {
	$('#classlists_divisions_id').val('0');
	$('#join_classlists_id').val($(this).data("classlistsid"));
	$('#classlists_divisions_name').val('');
	$('#admin-save-division').html("Create");
});


$("#admin-save-division").on("click", function(){
	var division_id = $('#classlists_divisions_id').val();
	var classlists_id = $('#join_classlists_id').val();
	var save_button = $(".edit-division[data-id="+ division_id +"]");
	$.ajax({
		url: "/admin/ajax/update-division",
		cache: false,
		method: "POST",
		data: {
			classlists_divisions_id: division_id,
			join_classlists_id: classlists_id,
			classlists_divisions_name: $('#classlists_divisions_name').val(),
		}
	})
	.done(function( response ) {
		response = JSON.parse(response);
		//$( "#results" ).append( html );
		console.log(classlists_id);
		if(response.success == 1){
			if(division_id == 0){
				//this is a new division, so let's add a row to the table.
				$('#dt-events-admin-divisions tr:last').after('<tr id="divisions-id-' + response.classlists_divisions_id +'"><td id="e-name-' + response.classlists_divisions_id +'">' + response.classlists_divisions_name +'</td><td><button type="button" class="btn btn-primary admin-edit-division" data-toggle="modal" data-target="#dialog-events-divisions-edit" data-id="' + response.classlists_divisions_id +'" data-name="' + response.classlists_divisions_name +'" data-classlists_id="' + response.join_classlists_id +'">Edit Division</button></td><td><button type="button" class="btn btn-danger admin-delete-division float-right" data-id="' + response.classlists_divisions_id +'">X</button><div class="save_status_division float-right" data-id="' + response.classlists_divisions_id +'"></td></tr>');
				$('#admin-save-division').html("Save Changes");
			}else{
				$('#e-name-' + division_id).html(response.classlists_divisions_name);
				save_button.data('name', $('#classlists_divisions_name').val());
			}

		}else{
			$('.save_status_division[data-id="0"]').html('<p class="text-danger"><span class="fas fa-check"></span><br/>' + response + '</p>');
		}
		$('#dialog-events-divisions-edit').modal('hide');
	});
});


$(".admin-delete-division").on("click", function(){
	$('#dialog-admin-confirm-delete-division').modal('show');
	$('#admin-delete-division-confirm').data('id', $(this).data("id"));
	//console.log($('#admin-delete-class-confirm').data('id'));
});

$('#admin-delete-division-confirm').on("click", function(){
	var divisions_id = $('#admin-delete-division-confirm').data('id');
	$.ajax({
		url: "/admin/ajax/delete-division",
		cache: false,
		method: "POST",
		data: {
			classlists_divisions_id: divisions_id,

		}
	})
	.done(function( response ) {
		//$( "#results" ).append( html );
		response = JSON.parse(response);
		if(response == "1"){
			$('#divisions-id-' + divisions_id).slideUp('slow');
		}else{
			$('.save_status[data-id="'+divisions_id+'"]').html('<p class="text-danger"><span class="fas fa-check"></span><br/>' + response + '</p>');
		}
		$('#dialog-admin-confirm-delete-division').modal('hide');
	});
});



//confirmation dialog to follow a link
$('.confirm-link').on("click", function(e){
	var link = this;
	e.preventDefault();
	$('#dialog-confirm-general').modal('show');
	$('#div-confirm-general-link').html(link.href);
	$('#div-confirm-custom').html($(this).data('custom'));
});

$('#button-confirm-general').on("click", function(){
	window.location = $('#div-confirm-general-link').html();
});






// turn on tooltips
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
});

