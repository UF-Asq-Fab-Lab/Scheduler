var config = {scheduler_format: "M-D-YYYY h:mm a"};

function overlay (start, end) {
  el = $("#overlay");
  el.css("visibility", function(){
    return (el.css("visibility") == "visible") ? "hidden" : "visible"
    });
  el = $("#overlay-bg");
  el.css("visibility", function(){
    return (el.css("visibility") == "visible") ? "hidden" : "visible"
    });
  $("#start_time").val(start.format(config.scheduler_format));
  $("#end_time").val(end.format(config.scheduler_format));
};

function reserve (event) {
  $("#start_time_unix").val(moment($("#start_time").val(), config.scheduler_format).unix());
  $("#end_time_unix").val(moment($("#end_time").val(), config.scheduler_format).unix());
}

function overlaycancel () {
  el = $("#overlay");
  el.css("visibility", function(){return (el.css("visibility") == "visible") ? "hidden" : "visible"});
  el = $("#overlay-bg");
  el.css("visibility", function(){return (el.css("visibility") == "visible") ? "hidden" : "visible"});
};

function reloadCalendar () {
    var interval = document.setInterval($('#calendar').fullCalendar('refetchEvents'), 5000);
};

$(document).ready(function() {
  $.getJSON("./", {config: 1}, function(data){
    config = data;
  });
     // page is now ready, initialize the calendar...
    $("#overlay-cancel").click(overlaycancel);

    $("#reserve-form").submit(reserve);

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
      eventClick : function(calEvent, jsEvent, view){
          eventOverlay(calEvent);
      }
      editable: false,
      events: {
        url: './',
        type: 'GET',
        data: {
            events: 1,
        },
        error: function(d, e) {
            alert('there was an error while fetching events!');
            console.dir(e);
        },
      }, //events source
      timeFormat : config.scheduler_format
    });
    $("#main-mesh").remove();
    mainMesh = MeshGen("#main", 20);
    mainMesh.meshify();
});
