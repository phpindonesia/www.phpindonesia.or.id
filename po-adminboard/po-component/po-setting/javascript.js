$("#setting1").click(function(){
	$('#settinginput1').show();
	$('#settinginput2').hide();
	$('#settinginput3').hide();
	$('#settinginput4').hide();
	$('#settinginput5').hide();
	$('#settinginput6').hide();
	$('#settinginput7').hide();
	$('#settinginput8').hide();
	$('#settinginput9').hide();
	$('#setting1').hide();
	$('#setting2').show();
	$('#setting3').show();
	$('#setting4').show();
	$('#setting5').show();
	$('#setting6').show();
	$('#setting7').show();
	$('#setting8').show();
	$('#setting9').show();
});
$("#settingbtn1").click(function(){
	var post = $('#settingtext1').val();
	var mod = 'setting';
	var act =  'website_name';
	var dataString = 'post='+ post + '&mod='+ mod + '&act='+ act;
	$.ajax({
		type: "POST",
		url: "po-component/po-setting/proses.php",
		data: dataString,
		cache: false,
		success: function(html){
			$('#settingtext1').val(html);
			$('#setting1').html(html);
			$('#settinginput1').hide();
			$('#setting1').show();
		}
	});
	return false;
});
$("#setting2").click(function(){
	$('#settinginput1').hide();
	$('#settinginput2').show();
	$('#settinginput3').hide();
	$('#settinginput4').hide();
	$('#settinginput5').hide();
	$('#settinginput6').hide();
	$('#settinginput7').hide();
	$('#settinginput8').hide();
	$('#settinginput9').hide();
	$('#setting1').show();
	$('#setting2').hide();
	$('#setting3').show();
	$('#setting4').show();
	$('#setting5').show();
	$('#setting6').show();
	$('#setting7').show();
	$('#setting8').show();
	$('#setting9').show();
});
$("#settingbtn2").click(function(){
	var post = $('#settingtext2').val();
	var mod = 'setting';
	var act =  'website_url';
	var dataString = 'post='+ post + '&mod='+ mod + '&act='+ act;
	$.ajax({
		type: "POST",
		url: "po-component/po-setting/proses.php",
		data: dataString,
		cache: false,
		success: function(html){
			$('#settingtext2').val(html);
			$('#setting2').html(html);
			$('#settinginput2').hide();
			$('#setting2').show();
		}
	});
	return false;
});
$("#setting3").click(function(){
	$('#settinginput1').hide();
	$('#settinginput2').hide();
	$('#settinginput3').show();
	$('#settinginput4').hide();
	$('#settinginput5').hide();
	$('#settinginput6').hide();
	$('#settinginput7').hide();
	$('#settinginput8').hide();
	$('#settinginput9').hide();
	$('#setting1').show();
	$('#setting2').show();
	$('#setting3').hide();
	$('#setting4').show();
	$('#setting5').show();
	$('#setting6').show();
	$('#setting7').show();
	$('#setting8').show();
	$('#setting9').show();
});
$("#settingbtn3").click(function(){
	var post = $('#settingtext3').val();
	var mod = 'setting';
	var act =  'meta_description';
	var dataString = 'post='+ post + '&mod='+ mod + '&act='+ act;
	$.ajax({
		type: "POST",
		url: "po-component/po-setting/proses.php",
		data: dataString,
		cache: false,
		success: function(html){
			$('#settingtext3').val(html);
			$('#setting3').html(html);
			$('#settinginput3').hide();
			$('#setting3').show();
		}
	});
	return false;
});
$("#setting4").click(function(){
	$('#settinginput1').hide();
	$('#settinginput2').hide();
	$('#settinginput3').hide();
	$('#settinginput4').show();
	$('#settinginput5').hide();
	$('#settinginput6').hide();
	$('#settinginput7').hide();
	$('#settinginput8').hide();
	$('#settinginput9').hide();
	$('#setting1').show();
	$('#setting2').show();
	$('#setting3').show();
	$('#setting4').hide();
	$('#setting5').show();
	$('#setting6').show();
	$('#setting7').show();
	$('#setting8').show();
	$('#setting9').show();
});
$("#settingbtn4").click(function(){
	var post = $('#settingtext4').val();
	var mod = 'setting';
	var act =  'meta_keyword';
	var dataString = 'post='+ post + '&mod='+ mod + '&act='+ act;
	$.ajax({
		type: "POST",
		url: "po-component/po-setting/proses.php",
		data: dataString,
		cache: false,
		success: function(html){
			$('#settingtext4').val(html);
			$('#setting4').html(html);
			$('#settinginput4').hide();
			$('#setting4').show();
		}
	});
	return false;
});
$("#setting5").click(function(){
	$('#settinginput1').hide();
	$('#settinginput2').hide();
	$('#settinginput3').hide();
	$('#settinginput4').hide();
	$('#settinginput5').show();
	$('#settinginput6').hide();
	$('#settinginput7').hide();
	$('#settinginput8').hide();
	$('#settinginput9').hide();
	$('#setting1').show();
	$('#setting2').show();
	$('#setting3').show();
	$('#setting4').show();
	$('#setting5').hide();
	$('#setting6').show();
	$('#setting7').show();
	$('#setting8').show();
	$('#setting9').show();
});
$("#setting6").click(function(){
	$('#settinginput1').hide();
	$('#settinginput2').hide();
	$('#settinginput3').hide();
	$('#settinginput4').hide();
	$('#settinginput5').hide();
	$('#settinginput6').show();
	$('#settinginput7').hide();
	$('#settinginput8').hide();
	$('#settinginput9').hide();
	$('#setting1').show();
	$('#setting2').show();
	$('#setting3').show();
	$('#setting4').show();
	$('#setting5').show();
	$('#setting6').hide();
	$('#setting7').show();
	$('#setting8').show();
	$('#setting9').show();
});
$("#settingbtn6").click(function(){
	var post = $('#settingtext6').val();
	var mod = 'setting';
	var act =  'email';
	var dataString = 'post='+ post + '&mod='+ mod + '&act='+ act;
	$.ajax({
		type: "POST",
		url: "po-component/po-setting/proses.php",
		data: dataString,
		cache: false,
		success: function(html){
			$('#settingtext6').val(html);
			$('#setting6').html(html);
			$('#settinginput6').hide();
			$('#setting6').show();
		}
	});
	return false;
});
$("#setting7").click(function(){
	$('#settinginput1').hide();
	$('#settinginput2').hide();
	$('#settinginput3').hide();
	$('#settinginput4').hide();
	$('#settinginput5').hide();
	$('#settinginput6').hide();
	$('#settinginput7').show();
	$('#settinginput8').hide();
	$('#settinginput9').hide();
	$('#setting1').show();
	$('#setting2').show();
	$('#setting3').show();
	$('#setting4').show();
	$('#setting5').show();
	$('#setting6').show();
	$('#setting7').hide();
	$('#setting8').show();
	$('#setting9').show();
});
$("#settingbtn7").click(function(){
	var post = $('#settingtext7').val();
	var status = $('#select7').val();
	var statustext = $('#select7 option[value='+status+']').text();
	var mod = 'setting';
	var act =  'maintenance';
	var dataString = 'post='+ post + '&status='+ status + '&mod='+ mod + '&act='+ act;
	$.ajax({
		type: "POST",
		url: "po-component/po-setting/proses.php",
		data: dataString,
		cache: false,
		success: function(html){
			$('#settingtext7').val(html);
			$('#setting7').html(statustext);
			$('#settinginput7').hide();
			$('#setting7').show();
		}
	});
	return false;
});
$("#setting8").click(function(){
	$('#settinginput1').hide();
	$('#settinginput2').hide();
	$('#settinginput3').hide();
	$('#settinginput4').hide();
	$('#settinginput5').hide();
	$('#settinginput6').hide();
	$('#settinginput7').hide();
	$('#settinginput8').show();
	$('#settinginput9').hide();
	$('#setting1').show();
	$('#setting2').show();
	$('#setting3').show();
	$('#setting4').show();
	$('#setting5').show();
	$('#setting6').show();
	$('#setting7').show();
	$('#setting8').hide();
	$('#setting9').show();
});
$("#settingbtn8").click(function(){
	var post = $('#settingtext8').val();
	var status = $('#select8').val();
	var statustext = $('#select8 option[value='+status+']').text();
	var mod = 'setting';
	var act =  'cache';
	var dataString = 'post='+ post + '&status='+ status + '&mod='+ mod + '&act='+ act;
	$.ajax({
		type: "POST",
		url: "po-component/po-setting/proses.php",
		data: dataString,
		cache: false,
		success: function(){
			$('#setting8').html(statustext);
			$('#settinginput8').hide();
			$('#setting8').show();
		}
	});
	return false;
});
$("#setting9").click(function(){
	$('#settinginput1').hide();
	$('#settinginput2').hide();
	$('#settinginput3').hide();
	$('#settinginput4').hide();
	$('#settinginput5').hide();
	$('#settinginput6').hide();
	$('#settinginput7').hide();
	$('#settinginput8').hide();
	$('#settinginput9').show();
	$('#setting1').show();
	$('#setting2').show();
	$('#setting3').show();
	$('#setting4').show();
	$('#setting5').show();
	$('#setting6').show();
	$('#setting7').show();
	$('#setting8').show();
	$('#setting9').hide();
});
$("#settingbtn9").click(function(){
	var status = $('#select9').val();
	var statustext = $('#select9 option[value='+status+']').text();
	var mod = 'setting';
	var act =  'memberregister';
	var dataString = 'status='+ status + '&mod='+ mod + '&act='+ act;
	$.ajax({
		type: "POST",
		url: "po-component/po-setting/proses.php",
		data: dataString,
		cache: false,
		success: function(){
			$('#setting9').html(statustext);
			$('#settinginput9').hide();
			$('#setting9').show();
		}
	});
	return false;
});
var editor = CodeMirror.fromTextArea(document.getElementById("pocodemirror"), {
	lineNumbers: true,
    mode: "php",
	extraKeys: {
		"Ctrl-J": "toMatchingTag",
		"F11": function(cm) {
			cm.setOption("fullScreen", !cm.getOption("fullScreen"));
		},
		"Esc": function(cm) {
			if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
		},
		"Ctrl-Space": "autocomplete"
	},
	gutters: ["CodeMirror-linenumbers", "breakpoints"],
	styleActiveLine: true,
	autoCloseBrackets: true,
	autoCloseTags: true,
    theme: "github"
});
editor.on("gutterClick", function(cm, n) {
  var info = cm.lineInfo(n);
  cm.setGutterMarker(n, "breakpoints", info.gutterMarkers ? null : makeMarker());
});
function makeMarker() {
  var marker = document.createElement("div");
  marker.style.color = "#ff0000";
  marker.innerHTML = "●";
  return marker;
}