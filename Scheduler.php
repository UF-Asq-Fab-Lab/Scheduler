<?php

// reservation form
$message = '';

$data = wire('modules')->getModuleConfigData('ProcessScheduler');

// the actual reservation function, called when the user clicks "Reserve" in the overlay/

function reserve($equipment, $owner, $color, $start, $end){
  $eventsPage = wire("pages")->get("name=event");
  $startdate = date_create($start);
  $enddate = date_create($end);

  if(!validateFormat($startdate, $enddate)) return;

  $startTS = date_timestamp_get($startdate);
  $endTS = date_timestamp_get($enddate);      

  // Reservation Rules

  if(!validateAdvanceTime($startTS)) return;

  if(!validateDuration($start, $end)) return;

  if(!validateEventOverlap($equipment, $start, $end)) return;

  if(!validateAccumulatedTime($startTS, $endTS)) return;
  
  // All rules passed, make event
  $newevent = new Page();
  $newevent->username = $owner;
  $newevent->equipmentName = $equipment;
  $newevent->color = $color;
  $newevent->start = $start;
  $newevent->end = $end;
  $newevent->parent = $eventsPage;
  $newevent->save();

  
  $message .= "<p class='message'>Reservation Scheduled</p>";
  wire("session")->redirect($page->path); //reload page
  return;
}

function validateAdvanceTime ($startTS){
  $thresholdH = $data['reservationBuffer'];
  $threshold = $thresholdH*60*60; //convert from hours to seconds
  $t = $startTS - $threshold;
  if($t < date_timestamp_get(date_create("now"))){
    $message .= "<p>Reservations must be made at least {$thresholdH} hours in advance.</p>";
    echo "<em class='error'>" . $message . "</em>";
    return false;
  } else {
    return true;
  }
}

function validateFormat ($start, $end){
  // Check for invalid formatting on input strings //
  if (!$start || !$end) {
      $message .= "<p>Invalid format.</p>";
    echo "<em class='error'>" . $message . "</em>";
      return false;
  } else {
    return true;
  }
}

function validateDuration ($start, $end) {
  $dur = $end - $start;
  $minDurH = $data['minReservationTime'];
  $maxDurH = $data['maxReservationTime'];
  $minDur = $minDurH*60*60;
  $maxDur = $maxDurH*60*60;
  if(!($dur >= $minDur) && ($dur <= $maxDur)){
    $message .= "<p>Reservations must be at least {$minDurH} hour(s) and no greater than {$maxDurH} hours in length.</p>";
    echo "<em class='error'>" . $message . "</em>";
    return false;
  } else {
    return true;
  }
}

function validateAccumulatedTime ($startTS, $endTS) {
  $schedulerPage = wire("pages")->get("name=".$data['scheduler_page_name']);
  $user_accumulated_time = 0;
  $events = $schedulerPage->children;
  foreach ($events as $event) {
    if($event->start){
      $EstartTS = date_timestamp_get(date_create($event->start));
      $EendTS = date_timestamp_get(date_create($event->end));

      if($event->username == wire("user")->name && 
        (strtotime("last Sunday", $startTS) < $EstartTS) && 
        ($EstartTS < strtotime("next Sunday", $startTS))) {
        //if the event being considered matches the current user AND
        //that event is in the same week as the new event
        $user_accumulated_time += ($EendTS - $EstartTS); //add duration to accumulated time
      }
    }
  }
  $h = $data['scheduler_allowed_hours_per_week'];
  $hpw = $h * 60 * 60; //time per week in seconds
  if($user_accumulated_time + ($endTS - $startTS) > $hpw){
    $message .= "<p>You may only reserve up to {$h} hours per week.</p>";
    echo "<em class='error'>" . $message . "</em>";
    return false;
  }
  return true;
}

function validateEventOverlap ($equipment, $start, $end) {
  $schedulerPage = wire("pages")->get("name=".$data['scheduler_page_name']);
  $user_accumulated_time = 0;
  $events = $schedulerPage->children;
  foreach ($events as $event) {
    if($event->start){
      $EstartTS = date_timestamp_get(date_create($event->start));
      $EendTS = date_timestamp_get(date_create($event->end));

      if($event->equipment_name == $equipment){
        
        if($startTS >= $EstartTS && $startTS <= $EendTS){
          $message .= "<p>Time overlaps with existing reservation for that machine.</p>";
          echo "<em class='error'>" . $message . "</em>";
          return false;
        } else if($endTS >= $EstartTS && $endTS <= $EendTS){
          $message .= "<p>Time overlaps with existing reservation for that machine.</p>";
          echo "<em class='error'>" . $message . "</em>";
          return false;
        } else if($startTS <= $EstartTS && $endTS >= $EendTS){
          $message .= "<p>Time overlaps with existing reservation for that machine.</p>";
          echo "<em class='error'>" . $message . "</em>";
          return false;
        }
      }
    }
    
  }
  return true;
}

  // Construct reservation parameters on click 
if($input->post->submit){
  $equipment = $input->post->equipment;
  $owner = $sanitizer->pageName($user->name);
  $color = "#AAAAAA";
  $schedulerPage = wire("pages")->get("name=".$data['scheduler_page_name']);
  foreach ($schedulerPage->children as $eq) {
    if($equipment == $eq->title){
      $color = $eq->color;
      break;
    }
  }

  $start = $input->post->start;
  $end = $input->post->end;

  reserve($equipment, $owner, $color, $start, $end);
}



?>


<h1 class="pageheader"><?php echo $page->title;?></h1>

<?php
echo $page->body;
echo $message;
echo '<p><br></p>';
?>

<div id='calendar'></div>

<div id="overlay">
     <div>
        <p id="form-message"></p>
          <form method="post" action="./" enctype="multipart/form-data">
            <p><label for="start">Start Time:</label></p>
            <p><input type="text" name="start" required></p>
            <p><label for="end">End Time:</label></p>
            <p><input type="text" name="end" required></p>
        <p><label for="machine">Equipment to Reserve:</label></p>
        <p><select name="equipment" id="equipmentdropdown">
      <option selected="selected">Choose Equipment</option>
      
      </select></p>
        <p><input type="submit" name="submit" id="overlaysubmit" value="Reserve"/>
        <input type="button" name="cancel" id="overlaycancel" value="Cancel"/></p>
    </form>
     </div>
</div>

<script type="text/javascript">

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

</script>