The Alarm plugin allows Jeedom to have a real alarm system for
home automation, very simple to use and configure.

Plugin configuration
=======================

After downloading the plugin, you just need to activate it,
there is no additional configuration at this level.

Immediate concept
================

This is a very important concept of the Alarm plugin and it is
very important to understand it well. To simplify it is as if
you had 2 alarms, the first one : the immediate alarm that does take into
account of the triggering times (warning it takes into account
activation times) and a second alarm which takes into account
trigger times.

**Why this immediate notion ?**

This immediate notion makes it possible to trigger actions well
specific. for example : you go home and you don't have
deactivated the alarm, before triggering the siren it may be good to
broadcast a message reminding you to deactivate the alarm and if this
is not done 1 minute later (activation time of 1 minute therefore)
activate the siren.

This notion is found in different types of actions, each time
its principle will be detailed.

Equipements
===========

The configuration of the Alarm equipment is accessible from the menu
Plugin &gt; Sécurité.

Once an alarm is added you end up with :

-   **Name of the alarm equipment** : name of your alarm,

-   **Parent object** : indicates the parent object to which belongs
    equipment,

-   **Category** : the category of the equipment (safety in general
    for an alarm),

-   **Activer** : makes your equipment active,

-   **Visible** : makes your equipment visible on the dashboard,

-   **Active all the time** : indicates that the alarm will be permanently
    active (for example for a fire detection alarm),

-   **Arming Visible** : allows to make visible or not the arming command
    of the alarm on the widget,

-   **Immediate Status Visible** : allows to make the immediate status of
    the alarm visible  (see below for the explanation),

-   **Historize alarm status and status** : allows to historize or
    not alarm status and state.

-   **Separate zones** : makes the zones independent in terms of alerts. Normally if a Zone is on alert the plugin will ignore the other zones. By separating the zones it will repeat the actions for the other zones which would enter in alert

-   **Automatic reset** : when triggered, the full alarm is rearmed to prevent subsequent triggers (in normal times it will not rearm until there has been a scenario / human action to do so)

-   **Do not take immediate actions if the sensor has no delay** : tells the alarm not to do immediate actions if the sensor does not have a trigger delay, the alarm will therefore only do the actions

> **Tip**
>
> For each action it is possible to specify the mode in which
> it must run or in all modes

Zones
=====

Main part of the alarm. This is where you configure the
different zones and actions (immediate and deferred by zone, do
note that it is also possible to configure them globally)
in case of a trigger. A Zone may as well be volumetric (for
during the day for example) but also be perimeter (for the night) or also
areas of the house (garage, bedroom, outbuildings, etc.).

A button at the top right allows you to add as many as you
voulez.

> **Tip**
>
> It is possible to edit the name of the Zone by clicking on the name of
> it (in front of the label "Name of the zone").

A Zone is made up of different elements : - trigger, - action
immediate, - action.

Trigger
-----------

A trigger is a binary command, which when it is 1 will
trigger the alarm. It is possible to reverse the trigger, so that
it is the state 0 of the sensor which triggers the alarm, by putting
"reverse "to YES. Once you've chosen your trigger, you can
specify an activation delay in minutes (it is not possible to
go below the minute). This delay allows for example, if you
activate the alarm before leaving your home, not to trigger
the alarm before a minute (time to let you out). Other case,
some motion detectors remain in triggered mode (value 1)
for a while even if there is no detection, for example
4 minutes, it is therefore good to delay the activation of these sensors by 4
or 5 min so that the alarm does not go on immediately after
the activation. Then you have the trigger delay, at the
difference with activation time which occurs only once during
the activation of the alarm, it is used after each
triggering of a sensor. The kinematics is as follows during the
triggering of the sensor (door opening, presence detection), if
the activation times have passed, the alarm will trigger the immediate actions
but will wait until the activation delay is over before
triggering actions. Finally you have the "reverse" button which allows
to invert the triggering state of the sensor (0 instead of 1).

You also have a parameter **Maintient** which allows you to specify a trigger hold time before triggering the alarm. Ex if you have a smoke detector which sometimes raises false alarms you can specify a delay of 2s. When the alarm is triggered Jeedom will wait 2s and check that the smoke detector is still on alert if it is not the case it will not trigger the alarm.  

Little example to understand : on the first trigger
(*\[Salon\]\[Oeil\]\[Présence\]*) I have here an activation delay of 5
minutes and 1 minute trigger. This means that when
I activate the alarm, during the first 5 minutes no trigger
of the alarm can occur due to this sensor. After this time
of 5 minutes, if movement is detected by the sensor, the alarm will
wait 1 minute (long enough for me to deactivate the alarm) before
triggering actions. If I had had immediate actions these
would have triggered immediately without waiting for the end of the activation delay
, non-immediate actions would have taken place after (1
minute after immediate actions).

Immediate action
----------------

As described above, these are actions that are triggered from the
trigger not taking into account the trigger delay (but
taking into account the activation delay anyway). You just have to
select the desired action command and then according to it
fill the execution parameters.

> **Note**
>
> When several zones are triggered successively, only the
> immediate actions of the 1st triggered Zone are executed.

Modes
=====

The modes are quite simple to configure, just indicate
the active zones according to the mode.

> **Tip**
>
> It is possible to rename the mode by clicking on its name
> (besides the label "Name of the mode"). Attention during the renaming of a mode it is absolutely necessary to review the scenarios / equipment which use the old name to pass them on the new

> **Note**
>
> When renaming a mode, you must on the alarm widget
> reclick on the concerned mode for complete consideration
> (otherwise Jeedom remains on the old mode)

> **Important**
>
> It is absolutely necessary to create at least one mode and assign it zones
> otherwise your alarm will not work.

Activation OK
=============

This part is used to define the actions to be taken following an
alarm activation. Here again, you will find the immediate concept
which represents the actions to be taken immediately after arming
the alarm, then come the activation actions which are
executed after trigger times.

In the example, here I turn on for example a red lamp to
signal that the arming has been taken into account and I turn it off 
once the complete arming (because normally there is no one left in the
perimeter of the alarm, otherwise it triggers it).

> **Important**
>
> OK activation actions do not take into account delays of
> activation. If you have a delay on a sensor activation
> even if your door is open, activation actions
> will be triggered.

Acitvation KO
=============

These actions are executed if a sensor is triggered following the activation of the alarm or after the activation delay of a sensor if it is in alert

Here you can also add actions when resuming a sensor monitoring

Trigger
=============

Allows you to configure the global actions to be taken during a trigger
of the alarm. You don't have to add some if you have
configured specific actions by Zone.

Deactivation OK
================

These actions are executed when the alarm is deactivated and
not triggered. Example you go home, by opening the
door this triggers the alarm but you have set a delay of
trigger on the sensor and you cut the alarm before the end of this
delay, Deactivation OK actions will be triggered. If on the other hand
you had stopped the alarm after the end of the trigger delay this
would not have been the case.

Reset
================

This part allows you to define the actions to be done when the alarm
is triggered and then disabled. Here too there are immediate actions
and delayed ones. Here is an example : you get home, the activation delays
have passed, but opening the door triggers
the alarm. If you deactivate it (before trigger times)
then the immediate reset actions will be executed, but
not normal reset ones. If you deactivate it after
trigger times, then immediate reset actions
and normal ones will be executed.

FAQ
===

>**What are the possible tags ?**
>
> 
Possible tags are
 :
>
> - #mode# : name of the current mode
> - #trigger# : name of the command that triggered the alert
> - #zone# : name of the Zone of ​​the command that triggered the alert


>**How to rearm a permanent alarm ?**
>
>Just click on one of the alarm modes (even
>the active one).

>**Can we put the delays in seconds ?**
>
>It is possible for the "Trigger delay" (you must put
>floating point numbers, ex : 0.5 for 30 seconds) but not for the
>"Activation delay "(do not put decimal points for
>this setting).

>**I don't understand my alarm does nothing**
>
>Check that the alarm has an active mode
