<?php
$scheduleId = wire('modules')->getModuleConfigData('LabScheduler')['lab_schedule_id'];
$scheduleHref = wire('pages')->get($scheduleId)->httpUrl;
?>
<div class="row">
  <a href="<?php echo $scheduleHref ?>">
    <button class="button-primary u-full-width">
      Schedule <i class="fa fa-calendar-o" aria-hidden="true"></i>
    </button>
  </a>
</div>
