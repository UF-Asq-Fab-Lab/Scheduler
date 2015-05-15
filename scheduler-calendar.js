
//var events = [....];
//var equipment = [....];
//var config = {....};

function overlay (start, end) {
	el = $("#overlay");
	el.css("visibility", function(){return (el.css("visibility") == "visible") ? "hidden" : "visible"});
	$('[name=start]').val(start.format(config.datetime_format));
	$('[name=end]').val(end.format(config.datetime_format));
};

function overlaycancel () {
	el = $("#overlay");
	el.css("visibility", function(){return (el.css("visibility") == "visible") ? "hidden" : "visible"});
};

function reloadCalendar () {
		var interval = document.setInterval($('#calendar').fullCalendar('refetchEvents'), 5000);	
};

$(document).ready(function() {

     // page is now ready, initialize the calendar...
    $("#overlaycancel").click(overlaycancel);

    equipment.forEach(function(eq){
    	$('#equipmentdropdown').append("<option>"+eq.name+"</option>");
    });

    $('#calendar').fullCalendar({
        // put options and callbacks here
        header:{ 
        	left: 'prev,next today',
        	center: 'title',
        	right: 'agendaWeek,agendaDay'
   		},
   		defaultView: 'agendaWeek', 
   		selectable: true,
   		select: function(start, end){
   				overlay(start, end.add(30, 'm'));
   		},
   		editable: false,
   		events: events, //events source
   		timeFormat : config.calendarFormat
    });
    
});