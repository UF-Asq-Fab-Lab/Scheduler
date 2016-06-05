$(document).ready(function(){
  var user = $("#reservation-user-name").value();
  var format = $("#reservation-format").value();
  // TODO: GET FORM ELEMENTS
  var formatArray = format.split(" ", format);
  var dateFormat = formatArray[0];
  var timeFormat = formatArray[1]+" "+formatArray[2];
  $('#calendar').fullCalendar({
    schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
    defaultView: 'timelineDay',
    selectable: true,
    events: {
      url: '/schedule',
      type: 'GET',
      data : {
        'reservations' : 1
      }
    },
    resources: {
      url: '/schedule'
      type: 'GET',
      data : {
        'tools' : 1
      }
    },
    aspectRatio: 2,
    select: function select (start, end, event, view, tool){
      // TODO: REMOVE PREVIOUS SELECTION
      var title = user+" "+tool.name+" "+start.format(format);
      var data = {
        title: title,
        start: start,
        end: end
      }
      $('#calendar').fullCalendar('renderEvent', data, false);
      // TODO: POPULATE FORM ELEMENTS

    },
  });
});
