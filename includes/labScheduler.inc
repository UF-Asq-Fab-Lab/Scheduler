<?php
// check permission to view/edit the schedule
$data = wire('modules')->getModuleConfigData('LabScheduler');
 ?>
<div class="row">
  <div id='calendar'></div>
  <p><strong>Please use the scheduler interface above to select a time and tool to reserve.</strong></p>
</div>
<div id="reservation-form-container">
  <form id="reservation-form" method="post" action="./">
  <div class="row">
    <div class="four columns">
       <label for="reservation-tool">Tool to reserve</label>
       <input readonly class="u-full-width" type="text" name="reservation-tool" id="reservation-tool">
    </div>
  </div>
  <div class="row">

    <div class="six columns">
      <label for="reservation-start-section">Reservation start</label>
      <div class="row" id="reservation-start-section">
        <div class="six columns">
          <label for="reservation-start-date">Date</label>
          <input readonly class="u-full-width" type="text" name="reservation-start-date" id="reservation-start-date">
        </div>
        <div class="six columns">
          <label for="reservation-start-time">Time</label>
          <input readonly class="u-full-width" type="text" name="reservation-start-time" id="reservation-start-time">
        </div>
      </div>
    </div>

    <div class="six columns">
      <label for="reservation-end-section">Reservation end</label>
      <div class="row" id="reservation-end-section">
        <div class="six columns">
          <label for="reservation-end-date">Date</label>
          <input readonly class="u-full-width" type="text" name="reservation-end-date" id="reservation-end-date">
        </div>
        <div class="six columns">
          <label for="reservation-end-time">Time</label>
          <input readonly class="u-full-width" type="text" name="reservation-end-time" id="reservation-end-time">
        </div>
      </div>
    </div>

    <input id="reservation-user-name" type="hidden" name="reservation-user-name" value="<?php echo wire('user')->name ?>">
    <input id="reservation-format" type="hidden" name="reservation-user-name" value="<?php echo $data['lab_scheduler_frontend_datetime_format'] ?>">
    <input id="reservation-tool-id" type="hidden" name="reservation-tool-id" value="">
  </div>

  <div class="row">
    <span>
      <input id="reservation-submit" name="reservation-submit" class="button-primary" type="submit" value="Make Reservation">
    </span>
  </div>
  </form>
</div>

<div id="cancellation-form-container">
<form id="cancellation-form" method="post" action="./">
  <div class="row">
    <div class="three columns">
      <input id="reservation-cancel-id" type="hidden" name="reservation-cancel-id" value="">
      <input id="cancellation-submit" name="cancellation-submit" class="button-primary" type="submit" value="Cancel Reservation">
    </div>
    <div id="reservation-info" class="nine columns">
      <p><strong id="reservation-info-title"></strong></p>
      <p><strong>Day: </strong><span id="reservation-info-date"></span></p>
      <p><strong>Time: </strong><span id="reservation-info-time"></span></p>
      <p><strong>Tool: </strong><span id="reservation-info-tool"></span></p>
      <p><strong>User: </strong><span id="reservation-info-user"></span></p>
    </div>
  </div>
</form>
</div>
