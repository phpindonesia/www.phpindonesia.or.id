$(function(){
	$.contextMenu({
		selector: '.CodeMirror.cm-s-github',
		zIndex: 0,
		callback: function(key, options) {
			var mod = 'theme';
			var act = 'helper';
			var post = key;
			var dataString = 'post='+ post + '&mod='+ mod + '&act='+ act;
			$.ajax({
				type: "POST",
				url: "po-component/po-theme/proses.php",
				data: dataString,
				cache: false,
				success: function(data){
					$('#helper-box .modal-body').html(data);
					$('#helper-box').modal('show');
				}
			});
		},
		items: {
			"mainelement": {
				"name": "Main Element Helper",
				"icon": "show_big_thumbnails",
				"items": {
					"headerhelper": {"name": "Header Element Helper", "icon": "tag"},
					"sep1": "---------",
					"footerhelper": {"name": "Footer Element Helper", "icon": "tag"},
					"sep2": "---------",
					"sidebarhelper": {"name": "Sidebar Element Helper", "icon": "tag"}
				}
			},
			"sep3": "---------",
			"contentelement": {
				"name": "Content Element Helper",
				"icon": "show_thumbnails",
				"items": {
					"homehelper": {"name": "Home Element Helper", "icon": "tag"},
					"sep4": "---------",
					"pageshelper": {"name": "Pages Element Helper", "icon": "tag"},
					"sep5": "---------",
					"categoryhelper": {"name": "Category Element Helper", "icon": "tag"},
					"sep6": "---------",
					"detailposthelper": {"name": "Detail Post Element Helper", "icon": "tag"},
					"sep7": "---------",
					"galleryhelper": {"name": "Gallery Element Helper", "icon": "tag"},
					"sep8": "---------",
					"contacthelper": {"name": "Contact Element Helper", "icon": "tag"},
					"sep9": "---------",
					"searchresulthelper": {"name": "Search Result Element Helper", "icon": "tag"}
				}
			},
			"sep10": "---------",
			"loginhelper": {"name": "Login Element Helper", "icon": "ok"},
			"sep11": "---------",
			"registerhelper": {"name": "Register Element Helper", "icon": "upload"},
			"sep12": "---------",
			"quit": {"name": "Quit Helper", "icon": "remove_2", callback: function(){ return true; }},
		}
	});
});