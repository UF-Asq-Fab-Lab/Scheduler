<?php
$user = $this->wire('user');
$allowed = ['laser-user', 'admin', 'superuser'];
$isAllowed = false;
foreach ($allowed as $role) {
  $isAllowed = $user->hasRole($role);
  if($isAllowed){break;}
}
if($user->isLoggedIn() && $isAllowed){
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
<?php } //end if isLoggedIn?>
