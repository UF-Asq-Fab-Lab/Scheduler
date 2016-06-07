<?php
class LabSchedulerConfig extends ModuleConfig {
  public function __construct() {
    $this->add(
    array(
      'lab_reservations_id' => array(
        'type' => 'InputfieldInteger',
        'value' => 0,
        'label' => 'ID of parent page for all Lab Reservation pages.'
      ),
      'lab_tools_id' => array(
        'type' => 'InputfieldInteger',
        'value' => 0,
        'label' => 'ID of parent page for all Lab Tool pages.'
      ),
      'lab_rulesets_id' => array(
        'type' => 'InputfieldInteger',
        'value' => 0,
        'label' => 'ID of parent page for all Lab Ruleset pages.'
      ),
      'lab_scheduler_root_id' => array(
        'type' => 'InputfieldInteger',
        'value' => 0,
        'label' => 'ID of the Lab Scheduler page, the root for Scheduler-related pages.'
      ),
      'lab_schedule_id' => array(
        'type' => 'InputfieldInteger',
        'value' => 0,
        'label' => 'ID of the frontend schedule page.'
      ),
      'lab_scheduler_frontend_datetime_format' => array(
        'type' => 'InputfieldText',
        'value' => 'M/D/YYYY h:mm a',
        'label' => 'How should dates and times be displayed to users in the frontend interface? See: http://momentjs.com/docs/#/displaying/'
      ),
      'lab_scheduler_require_role' => array(
        'type' => 'InputfieldText',
        'value' => 'superuser,intern,assistant,admin,user',
        'label' => 'Comma separated list of roles which are allowed to use the scheduler frontend interface.'
      ),
      "max_hours_per_week" => array(
        'type' => 'InputfieldInteger',
        'value' => 6,
        'label' => 'Max Hours per Week - How many hours are users allowed to reserve equipment for per week?'
      )
    ));
  }
}
?>
