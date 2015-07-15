var config = {frontend_format: "M/D/YYYY h:mm a"};

function toggleModal (target) {
  $(target).toggle();
  $("#modal-bg").toggle();
};

function readyReserveModal(start, end){
  var formatArray = config.frontend_format.split(' ');
  var format_time = [formatArray[1], formatArray[2]].join(' ');
  var format_date = formatArray[0];
  $("#start_time").val(moment(start).format(format_time));
  $("#start_date").val(moment(start).format(format_date));
  $("#end_time").val(moment(end).format(format_time));
  $("#end_date").val(moment(end).format(format_date));
}

function readyEventModal(event){
  console.log(event.title);
  $("#event-title-data").html(event.title);
  $("#event-start-data").html(event.start.format(config.frontend_format));
  $("#event-end-data").html(event.end.format(config.frontend_format));
  $("#event-id-data").html(event.id);
  $("#cancel_id").val(event.id);
}

function reserveEvent(event) {
  // event.preventDefault();
  var start_datetime = [$("#start_date").val(), $("#start_time").val()].join(' ');
  console.log(start_datetime);
  var end_datetime = [$("#end_date").val(), $("#end_time").val()].join(' ');
  console.log(end_datetime);
  $("#start_time_unix").val(moment(start_datetime, config.frontend_format).unix());
  $("#end_time_unix").val(moment(end_datetime, config.frontend_format).unix());
}

function reloadCalendar () {
    $('#calendar').fullCalendar('refetchEvents');
};

$(document).ready(function() {
  $.getJSON("./", {config: 1}, function(data){
    config = data;
  });
     // page is now ready, initialize the calendar...
    $("#reserve-cancel").click(function(){
      toggleModal("#reserve-modal");
    });

    $("#event-back").click(function(){
      toggleModal("#event-modal");
    });

    $("#reserve-form").submit(function(event){
      reserveEvent(event);
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
          toggleModal("#reserve-modal");
          readyReserveModal(start, end.add(30, 'm'));
      },
      eventClick : function(calEvent, jsEvent, view){
          toggleModal("#event-modal");
          readyEventModal(calEvent);
      },
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
      timeFormat : config.frontend_format
    });
    // attach timepickers
    var options = {
      disableTextInput : true,
    };
    $('#start_time').timepicker(options);
    $('#end_time').timepicker(options);
    // referesh background mesh now that the main div has content
    $("#main-mesh").remove();
    mainMesh = MeshGen("#main", 20);
    mainMesh.meshify();
});
