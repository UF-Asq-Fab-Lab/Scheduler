var config = {scheduler_format: "M-D-YYYY h:mm a"};

function toggleModal (target) {
  $(target).toggle();
  $("#modal-bg").toggle();
};

function readyReserveModal(start, end){
  $("#start_time").val(moment(start).format(config.scheduler_format));
  $("#end_time").val(moment(end).format(config.scheduler_format));
}

function readyEventModal(event){
  console.log(event.title);
  $("#event-title-data").html(event.title);
  $("#event-start-data").html(event.start.format(config.scheduler_format));
  $("#event-end-data").html(event.end.format(config.scheduler_format));
  $("#event-id-data").html(event.id);
  $("#cancel_id").val(event.id);
}

function reserveEvent() {
  $("#start_time_unix").val(moment($("#start_time").val(), config.scheduler_format).unix());
  $("#end_time_unix").val(moment($("#end_time").val(), config.scheduler_format).unix());
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

    $("#reserve-form").submit(function(){
      reserveEvent();
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
      timeFormat : config.scheduler_format
    });
    // referesh background mesh now that the main div has content
    $("#main-mesh").remove();
    mainMesh = MeshGen("#main", 20);
    mainMesh.meshify();
});
