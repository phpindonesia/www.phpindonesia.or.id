$(".alertdel").click(function(){
	var id = $(this).attr("id");
	$('#alertdel').modal('show');
	$('#delid').val(id);
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