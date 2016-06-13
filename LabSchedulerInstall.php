<?php

/**
 * Installer and uninstaller for LabScheduler module
 *
 * Thomas R Storey, 2015
 * Licensed under MIT License, see LICENSE.TXT
 *
 * http://fablab.arts.ufl.edu
 * https://github.com/UF-Asq-Fab-Lab
 */

 class LabSchedulerInstall extends Wire {
    public function ___install () {
      $adminPage = $this->pages->get($this->config->adminRootPageID);
      $helper = $this->modules->get('FabLabModuleHelpers');

      // create ProcessList page
      $schedulerPage = $helper->getAdminPage('lab_scheduler', 'ProcessList', null, null);

      // create ProcessLabReservation page
      $labReservationsPage = $helper->getAdminPage('lab_reservations',
                                              'ProcessLabReservation',
                                              $schedulerPage->id, null);
      // create ProcessLabTool page
      $labToolsPage = $helper->getAdminPage('lab_tools',
                                              'ProcessLabTool',
                                              $schedulerPage->id, null);
      // create ProcessLabRuleset page
      $labRulesetsPage = $helper->getAdminPage('lab_rulesets',
                                              'ProcessLabRuleset',
                                              $schedulerPage->id, null);

      // create Schedule frontend page
      $schedulePage = $helper->getFrontendPage("schedule", null, null, "one-column-page");
      $schedulePage->of(false);
      $schedulePage->body = "[scheduler]";
      $schedulePage->save();
      $schedulePage->of(true);

      // create scheduler role and permission
      $schedulerPermission = $this->wire('permissions')->add('scheduler-edit');
      $schedulerRole = $this->wire('roles')->add('scheduler-admin');
      $schedulerRole->addPermission($schedulerPermission);
      $schedulerRole->save();

      $templateOptions = array('noChildren' => 1, 'noSettings' => 1, 'noUnpublished' => 1);
      // create LabReservation page template
      $tool_opt = array(
        'tags'=>'Scheduler',
        'parent_id' => $labToolsPage->id,
        'inputfield' => 'InputfieldSelect',
        'required' => 1
      );
      $datetime_opt = array(
        'tags'=>'Scheduler',
        'required' => 1,
        'datetimeFormat' => 'm/d/Y H:i:s',
      );
      $user_opt = array(
        'tags'=>'Scheduler',
        'parent_id' => $this->wire('config')->usersPageID,
        'inputfield' => 'InputfieldSelect',
        'required' => 1
      );
      $lrf = array(
        'title'=> array('type'=>'FieldtypeTitle', 'options'=>array()),
        'lab_reservation_tool' => array('type'=>'FieldtypePage', 'options'=>$tool_opt),
        'lab_reservation_start' => array('type'=>'FieldtypeDatetime', 'options'=>$datetime_opt),
        'lab_reservation_end' => array('type'=>'FieldtypeDatetime', 'options'=>$datetime_opt),
        'lab_reservation_user' => array('type'=>'FieldtypePage', 'options'=>$user_opt)
      );
      $labReservationTemplate = $helper->getTemplate(
      LabScheduler::LabReservationTemplateName, $lrf, 'Scheduler', $templateOptions);

      // create LabTool page template
      $ruleset_opt = array(
        'tags'=>'Scheduler',
        'parent_id' => $labRulesetsPage->id,
        'inputfield' => 'InputfieldRadios',
        'required' => 1
      );
      $color_opt = array(
        'tags'=>'Scheduler',
        'required' => 1
      );
      $active_opt = array(
        'tags'=>'Scheduler',
        'description'=>'Check this on if the tool is currently operational and available.'
      );
      $status_opt = array(
        'tags'=>'Scheduler',
        'description'=>'A short explanatory note describing the tool\'s current status.'
      );
      $ltf = array(
        'title'=> array('type'=>'FieldtypeTitle', 'options'=>array()),
        'lab_tool_color' => array('type'=>'FieldtypeText', 'options'=>$color_opt),
        'lab_tool_available' => array('type'=>'FieldtypeCheckbox', 'options'=>$active_opt),
        'lab_tool_status' => array('type'=>'FieldtypeText', 'options'=>$status_opt),
        'lab_tool_ruleset' => array('type'=>'FieldtypePage', 'options'=>$ruleset_opt)
      );
      $labToolTemplate = $helper->getTemplate(
      LabScheduler::LabToolTemplateName, $ltf, 'Scheduler', $templateOptions);

    // create LabRuleset page template
    $roles_opt = array(
      'tags'=>'Scheduler',
      'parent_id' => $this->wire('config')->rolesPageID,
      'inputfield' => 'InputfieldAsmSelect',
      'derefAsPage' => 1,
      'description' => 'To users with which roles should this ruleset apply?'
    );
    $int_opt = array(
      'tags'=>'Scheduler',
      'description' => 'Leave this field blank to disable this rule.'
    );
    $days_opt = array(
      'tags'=>'Scheduler',
      'description'=>'Comma separated list of days of the week during which the tool can be reserved. Leave this field blank to disable this rule.'
    );
    $hours_opt = array(
      'tags'=>'Scheduler',
      'description'=>'Comma separated list of hours of the day during which the tool can be reserved. Leave this field blank to disable this rule.'
    );
    $text_opt = array( 'tags'=>'Scheduler');
    $lrsf = array(
      'title'=> array('type'=>'FieldtypeTitle', 'options'=>array()),
      'lab_ruleset_roles' => array('type'=>'FieldtypePage', 'options'=>$roles_opt),
      'lab_ruleset_hours_per_week' => array('type'=>'FieldtypeInteger', 'options'=>$int_opt),
      'lab_ruleset_hours_per_day' => array('type'=>'FieldtypeInteger', 'options'=>$int_opt),
      'lab_ruleset_reservation_buffer_hours' => array('type'=>'FieldtypeInteger', 'options'=>$int_opt),
      'lab_ruleset_cancellation_buffer_hours' => array('type'=>'FieldtypeInteger', 'options'=>$int_opt),
      'lab_ruleset_minimum_reservation_hours' => array('type'=>'FieldtypeInteger', 'options'=>$int_opt),
      'lab_ruleset_maximum_reservation_hours' => array('type'=>'FieldtypeInteger', 'options'=>$int_opt),
      'lab_ruleset_reservable_days' => array('type'=>'FieldtypeText', 'options'=>$text_opt),
      'lab_ruleset_reservable_hours' => array('type'=>'FieldtypeText', 'options'=>$text_opt),
      'lab_ruleset_allow_simultaneous_reservations' => array('type'=>'FieldtypeCheckbox', 'options'=>$text_opt)
    );
    $labRulesetTemplate = $helper->getTemplate(
    LabScheduler::LabRulesetTemplateName, $lrsf, 'Scheduler', $templateOptions);

    // save config data
    $configData = array(
      'lab_reservations_id'=>$labReservationsPage->id,
      'lab_tools_id'=>$labToolsPage->id,
      'lab_rulesets_id'=>$labRulesetsPage->id,
      'lab_scheduler_root_id'=>$schedulerPage->id,
      'lab_schedule_id'=>$schedulePage->id
    );
    $this->wire('modules')->saveModuleConfigData('LabScheduler', $configData);

    $this->message("Lab Scheduler installed!");
  }

  public function ___uninstall() {
    $data = $this->wire('modules')->getModuleConfigData($this);
    $helper = $this->wire('modules')->get('FabLabModuleHelpers');

    $helper->deletePagesByTemplate('lab_reservation');
    $helper->deletePagesByTemplate('lab_ruleset');
    $helper->deletePagesByTemplate('lab_tool');
    $helper->deleteTemplateByName('lab_reservation');
    $helper->deleteTemplateByName('lab_ruleset');
    $helper->deleteTemplateByName('lab_tool');
    $helper->deletePageByName('lab_reservations');
    $helper->deletePageByName('lab_rulesets');
    $helper->deletePageByName('lab_tools');
    $helper->deletePageByName('lab_scheduler');
    $helper->deletePageByName('schedule');

    $labSchedulerFields = $this->fields->find('name*=lab_reservation|lab_ruleset|lab_tool');
    foreach ($labSchedulerFields as $lsf) {
      if(!$lsf->numFieldgroups()){
        $this->message("Removing field: {$lcf->name}");
  			$this->fields->delete($lsf);
      }
    }

    Wire::setFuel('lab_reservations', null);
    Wire::setFuel('lab_rulesets', null);
    Wire::setFuel('lab_tools', null);

    $uninstallModules = array(
      'ProcessLabReservation',
      'ProcessLabRuleset',
      'ProcessLabTool'
    );
		foreach($uninstallModules as $name) {
			$this->modules->uninstall($name);
			$this->message("Uninstalled Module: $name");
		}
  }

 }

 ?>
