$(document).ready(function(){
  var user = $("#reservation-user-name").val();
  // get format strings
  var format = $("#reservation-format").val();
  var formatArray = format.split(" ");
  var dateFormat = formatArray[0];
  var timeFormat = formatArray[1]+" "+formatArray[2];
  // get interface elements
  var reserveFormContainer = $("#reservation-form-container");
  var cancelFormContainer = $("#cancellation-form-container");
  var reserveForm = $("#reservation-form");
  var cancelForm = $("#cancellation-form");

  var resStartDateInput = $("#reservation-start-date");
  var resStartTimeInput = $("#reservation-start-time");
  var resEndDateInput = $("#reservation-end-date");
  var resEndTimeInput = $("#reservation-end-time");
  var resToolInput = $("#reservation-tool");
  var resToolIDInput = $("#reservation-tool-id");

  var resDateInfo = $("#reservation-info-date");
  var resTimeInfo = $("#reservation-info-time");
  var resToolInfo = $("#reservation-info-tool");
  var resUserInfo = $("#reservation-info-user");

  $('#calendar').fullCalendar({
    schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
    defaultView: 'timelineDay',
    selectable: true,
    eventOverlap: false,
    selectOverlap: false,
    events: {
      url: './',
      type: 'GET',
      data : {
        'reservations' : 1
      }
    },
    resourceAreaWidth: '25%',
		resourceColumns: [
			{
				labelText: 'Tool',
				field: 'title'
			},
			{
				labelText: 'Status',
				field: 'status'
			}
		],
    resources: {
      url: './',
      type: 'GET',
      data : {
        'tools' : 1
      }
    },
    aspectRatio: 2,
    select: function select (start, end, event, view, tool){
      $('#calendar').fullCalendar('removeEvents', 'new-reservation');
      var title = user+" "+tool.title+" "+start.format(format);
      var data = {
        title: title,
        start: start,
        end: end,
        id: "new-reservation",
        resourceId: tool.id
      }
      $('#calendar').fullCalendar('renderEvent', data, false);
      reserveFormContainer.toggle(true);
      cancelFormContainer.toggle(false);
      resStartDateInput.val(start.format(dateFormat));
      resStartTimeInput.val(start.format(timeFormat));
      resEndDateInput.val(end.format(dateFormat));
      resEndTimeInput.val(end.format(timeFormat));
      resToolInput.val(tool.title);
      resToolIDInput.val(tool.id);
    },
    eventClick: function eventClick(reservation, event, view){
      $('#calendar').fullCalendar('removeEvents', 'new-reservation');
      reserveFormContainer.toggle(false);
      cancelFormContainer.toggle(true);
      if(reservation.user === user){
        $("#cancellation-submit").removeAttr("disabled");
        $("#reservation-cancel-id").val(reservation.id);
        resDateInfo.html(reservation.start.format(dateFormat));
        resTimeInfo.html(reservation.start.format(timeFormat)+" - "+reservation.end.format(timeFormat));
        resToolInfo.html($('#calendar').fullCalendar('getResourceById', reservation.resourceId).title);
        resUserInfo.html(reservation.user);
      } else {
        $("#cancellation-submit").attr("disabled", true);
        // $("#cancellation-submit").attr("disabled", true);
      }
    }
  });
});
