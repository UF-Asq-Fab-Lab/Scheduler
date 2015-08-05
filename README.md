# Scheduler
Frontend scheduler/calendar interface connects to an events manager handled as a Processwire module.

Version 1

Thomas R Storey

---

##Installation

---

1. Place Scheduler folder, ProcessEquipment.module, an ProcessEvent.module inside the sites/modules directory of the site.
2. Navigate to http://yoururl.edu/processwire
3. Sign in as an account with admin privileges
4. Navigate to the Modules admin page
5. Install "A² Fab Lab Scheduler System"
6. Edit the "Schedule" page to set it to "hidden" if you don't want it to show up in the navigation bar of your site.


##Usage

---

###Admin

####Configuration

All configuration settings can be found by navigating through the admin interface to Modules > Site > A² Fab Lab Scheduler System > Settings.

#####Scheduler Page ID

This configuration specifies the id of the page that will display the schedule to a front end user. It should be an id of a page that is accessible to an end user. This setting should get set automatically, and only needs to be changed if you want to change the page that scheduler appears in. As long as a page has a Body field, and that field has the [scheduler] tag written somewhere in it, and that page's id is stored in this setting, the Scheduler module will insert the schedule interface there.

#####User date-time display

This configuration determines the format of dates and times as displayed in the calendar interface (specifically in the reservation form). It uses JavaScript datetime syntax. For more information on how to write date formats in this syntax, see http://momentjs.com/docs/#/displaying/format/

#####Admin date-time display

This configuration determines the format of dates and times as displayed in the admin interface for the Event pages. (Scheduler > Events > Event Page Name). It uses php datetime syntax. For more information on how to format dates using this syntax, see http://php.net/manual/en/datetime.formats.php

#####Hours per week

Use this setting to specify how many hours per week a user is allowed to reserve equipment. Pretty straightforward

#####Advance hours - reserve

Use this setting to specify how many hours in advance a user must reserve a time slot.

#####Advance hours - cancel

Use this setting to specify how many hours in advance a user must cancel a time slot.

#####Minimum reservation duration

Set the minimum number of hours a reservation can last. Can be a decimal number. (i.e. 0.5 = 30 minutes).

#####Maximum reservation duration

Set the maximum number of hours a reservation can last. Can be a decimal number. (i.e. 3.5 = 3 hours and 30 minutes).

#####Roles setting

This setting determines what roles a user must have in order to view the scheduler calendar interface. It must be a comma-delimited list of role names (see: Access > Roles)

#####Unauthorized message.

This setting allows you to configure the message that will be presented to the user upon trying to view the upload page while not logged or not in possession of one or more of the roles present in the Roles setting detailed above.

####Workflow

#####Events

This module generally runs itself, from an admin point of view. Configure the settings as shown above.

To delete an event, navigate to Scheduler > Events > Event Name, click on the Delete tab, click the checkbox and click save.

To delete all expired events (events whose duration has passed), click on the Clean Events button in the Scheduler > Events dropdown menu.

#####Equipment

The scheduler module automatically populates the reservation interface with a list of equipment that is available to be reserved. This list is generated from all the pages on the site that use the equipment template.

You can add, update or remove equipment pages at Scheduler > Equipment. Click the Add button to add an Equipment page. Give it a name, title, color and description. The color is specified as a hex value (see: http://www.color-hex.com/) and is used to visually differentiate reservations from each other in the calendar interface.

You can specify an existing piece of equipment as available or unavailable using the checkbox in the edit interface for an equipment page. If for instance a piece of equipment is broken and you don't want users reserving time on it until it is fixed, uncheck the checkbox and hit save. Equipment not marked as available will not show up in the list of equipment to reserve in the calendar.

---

###User

To use the scheduler interface, a user must be logged in and have at least one role listed in the Roles setting (see above).

To reserve a time for any piece of equipment, first click a time slot on the calendar. In the reservation form that pops up, specify the date and time for the start and end of your reservation, and pick the equipment you want to use from the dropdown menu. Then click the reserve button.

The page will refresh, you will get a message saying your time was reserved successfully, and your event will show up in the calendar.
