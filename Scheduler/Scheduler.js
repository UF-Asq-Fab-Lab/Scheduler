function overlay (start, end) {
  el = $("#overlay");
  el.css("visibility", function(){return (el.css("visibility") == "visible") ? "hidden" : "visible"});
  el = $("#overlay-bg");
  el.css("visibility", function(){return (el.css("visibility") == "visible") ? "hidden" : "visible"});
  $('[name=start]').val(start.format(config.scheduler_format));
  $('[name=end]').val(end.format(config.scheduler_format));
};

function reserve (event) {
  $("#start").val(moment($("#start").val(), config.scheduler_format).unix());
  $("#end").val(moment($("#end").val(), config.scheduler_format).unix());
  //event.preventDefault();
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
    events = events.map(function (cv, i) {
      cv.start = moment.unix(parseInt(cv.start)).format();
      cv.end = moment.unix(parseInt(cv.end)).format();
      cv = {
        title : cv.title,
        start : cv.start,
        end : cv.end
      };
      console.log(cv);
      return cv;
    });
     // page is now ready, initialize the calendar...
    $("#overlaycancel").click(overlaycancel);

    $("#form-reserve").submit(reserve);

    equipment.forEach(function(eq){
      $('#equipmentdropdown').append("<option>"+eq.equipment_name+"</option>");
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
      timeFormat : config.scheduler_format
    });

});
