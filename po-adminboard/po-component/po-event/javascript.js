var date = new Date();
var d = date.getDate();
var m = date.getMonth();
var y = date.getFullYear();
var calendar = $("#calendar").fullCalendar({
	header: {
		left: "prev,next",
		center: "title",
		right: "month,agendaWeek,agendaDay"
	},
	firstDay: 1,
	editable: true,
	events: 'po-component/po-event/datatable.php',
	eventRender: function(event, element, view) {
		if (event.allDay === 'true') {
			event.allDay = true;
		} else {
			event.allDay = false;
		}
	},
	selectable: true,
	selectHelper: true,
	select: function(start, end, allDay) {
		var start = $.fullCalendar.formatDate(start, "yyyy-MM-dd HH:mm:ss");
		var end = $.fullCalendar.formatDate(end, "yyyy-MM-dd HH:mm:ss");
		window.location = "admin.php?mod=event&act=addnew&start="+start+"&end="+end+"&allday="+allDay;
	},
	eventDrop: function(event, delta) {
		var start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
		var end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
		$.ajax({
			url: 'po-component/po-event/proses.php',
			data: 'mod=event&act=updatedrag&start='+ start +'&end='+ end +'&id='+ event.id ,
			type: "POST",
			success: function(json) {}
		});
	},
	eventClick: function(event) {
		window.location = "admin.php?mod=event&act=edit&id="+event.id;
	},
	eventResize: function(event) {
		var start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
		var end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
		$.ajax({
			url: 'po-component/po-event/proses.php',
			data: 'mod=event&act=updatedrag&start='+ start +'&end='+ end +'&id='+ event.id ,
			type: "POST",
			success: function(json) {}
		});
	}
});