//                                              Don't delete this comments
// =======================================================================
// CoGen a.k.a Component Generator
// =======================================================================
// Creator : Dwira Survivor
// Version : 1.0.0
// About :
// CoGen is tool for PopojiCMS for generate some component without
// coding, so user can create new component in PopojiCMS with easy steps.
// =======================================================================
//                                              Don't delete this comments
$("#compogen-wizard").formwizard({
	disableUIStyles: !0,
	validationEnabled: !0,
	validationOptions: {
		errorClass: "help-block animation-slideDown",
		errorElement: "span",
		errorPlacement: function (e, a) {
			a.parents(".form-group > div").append(e)
		},
		highlight: function (e) {
			$(e).closest(".form-group").removeClass("has-success has-error").addClass("has-error"), $(e).closest(".help-block").remove()
		},
		success: function (e) {
			e.closest(".form-group").removeClass("has-success has-error"), e.closest(".help-block").remove()
		},
		rules: {
			compo_name: {
				required: !0,
				minlength: 3
			},
			compo_table: {
				required: !0,
				minlength: 5
			},
			compo_accept: {
				required: !0
			}
		},
		messages: {
			compo_name: {
				required: "Please enter a component name",
				minlength: "Your component name must consist of at least 3 characters"
			},
			compo_table: {
				required: "Please enter a component table",
				minlength: "Your component table must consist of at least 5 characters"
			},
			compo_accept: "Please accept the terms and conditions to continue"
		}
	},
	inDuration: 0,
	outDuration: 0,
	textSubmit: "Create Component",
	textNext: "Next Step",
	textBack: "Prev Step"
});

$(document).on('change','#compo_name',function(e){
	var compo_name = $(this).val();
    var mod = 'cogen';
	var act =  'compogenexists';
	var dataString = 'compo_name='+ compo_name + '&mod='+ mod + '&act='+ act;
	$.ajax({
		type: "POST",
		url: "po-component/po-cogen/proses.php",
		data: dataString,
		cache: false,
		success: function(data){
			if (data == "true") {
				$('#label-check').html('<span class="label label-danger">Component already exists. If you continue this component will be remove before and create new. Be carefully!</span>');
			} else {
				$('#label-check').html('');
			}
		}
	});
	return false;
});

$(document).on('change','#compo_table',function(e){
	var compo_table = $(this).val();
    var mod = 'cogen';
	var act =  'compogentblexist';
	var dataString = 'compo_table='+ compo_table + '&mod='+ mod + '&act='+ act;
	$.ajax({
		type: "POST",
		url: "po-component/po-cogen/proses.php",
		data: dataString,
		cache: false,
		success: function(data){
			if (data == "true") {
				$('#label-check-table').html('<span class="label label-danger">Table already exists in database. If you continue this table will be remove before and create new. Be carefully!</span>');
			} else {
				$('#label-check-table').html('');
			}
		}
	});
	return false;
});

$(document).on('click','.btn-add-field',function(e){
    e.preventDefault();
	var id = $(this).attr("id");
	var newid = parseInt(id) + 1;
	var idtot = $('#totalfield').val();
	var newidtot = parseInt(idtot) + 1;
    var mod = 'cogen';
	var act =  'compogenaddfield';
	var dataString = 'id='+ id + '&mod='+ mod + '&act='+ act;
	$.ajax({
		type: "POST",
		url: "po-component/po-cogen/proses.php",
		data: dataString,
		cache: false,
		success: function(html){
			$('#append-add-field').append(html);
			$('.btn-add-field').attr("id", ""+newid+"");
			$('#totalfield').val(newidtot);
		}
	});
	return false;
});