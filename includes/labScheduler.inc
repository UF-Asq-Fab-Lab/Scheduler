<?php
// check permission to view/edit the schedule
$data = wire('modules')->getModuleConfigData('LabScheduler');
 ?>
<div class="row">
  <div id='calendar'></div>
</div>

<form id="reservation-form" method="post" action="./">
<div class="row">
  <div class="four columns">
     <label for="reservation-tool">Tool to reserve</label>
     <input class="u-full-width" type="text" name="reservation-tool" id="reservation-tool">
  </div>
</div>
<div class="row">

  <div class="six columns">
    <label for="reservation-start-section">Reservation start</label>
    <div class="row" id="reservation-start-section">
      <div class="six columns">
        <label for="reservation-start-date">Date</label>
        <input class="u-full-width" type="date" name="reservation-start-date" id="reservation-start-date">
      </div>
      <div class="six columns">
        <label for="reservation-start-time">Time</label>
        <input class="u-full-width" type="time" name="reservation-start-time" id="reservation-start-time">
      </div>
    </div>
  </div>

  <div class="six columns">
    <label for="reservation-end-section">Reservation end</label>
    <div class="row" id="reservation-end-section">
      <div class="six columns">
        <label for="reservation-end-date">Date</label>
        <input class="u-full-width" type="date" name="reservation-end-date" id="reservation-end-date">
      </div>
      <div class="six columns">
        <label for="reservation-end-time">Time</label>
        <input class="u-full-width" type="time" name="reservation-end-time" id="reservation-end-time">
      </div>
    </div>
  </div>

  <input id="reservation-user-name" type="hidden" name="reservation-user-name" value="<?php echo wire('user')->name ?>"
  <input id="reservation-format" type="hidden" name="reservation-user-name" value="<?php echo $data['lab_scheduler_frontend_datetime_format'] ?>"

</div>

<div class="row">
  <span>
    <input id="reservation-submit" name="reservation-submit" class="button-primary" type="submit" value="Make Reservation">
    <p><?php echo $response; ?></p>
  </span>
</div>
</form>
