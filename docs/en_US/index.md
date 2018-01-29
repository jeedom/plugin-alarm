The Alarm plugin allows Jeedom to have a real alarm system for its automation, easy to use and configure.

== Plugin configuration

After downloading the plugin, you just have to activate it, there is no additional configuration at this level.

Immediate concept
================

This is a very important notion about the alarm plugin and it is
important to understand it well. To schematize it is as if
you had 2 alarms, the first one: the immediate alarm that does not fit
account of the triggering delays (be careful it takes into account
activation times) and a second alarm which, in turn, takes into account
the trigger times.

**Why this immediate notion?**

This immediate notion allows triggering actions well
specific. For example: you go home and you do not have
disable the alarm, before triggering the siren it can be good to
broadcast a message reminding of well disable the alarm and if this
is not done 1 minute later (activation time of 1 minute therefore)
activate the siren.

This notion is found in different types of actions, each time
its principle will be detailed.

Facilities
===========

The alarm equipment configuration is accessible from the menu
Plugin &gt; Security.

Once an alarm is added you are left with:

-   **Alarm Name** : Choose a name for your alarm

-   **Parent Object** : means the parent object the equipment depend
    equipment,

-   **Category** : This is the category of the equipment (generally "security" for alarms
    for an alarm),

-   **Enable**: to make your equipment active,

-   **Visible**: makes your equipment visible on the dashboard,

-   **Always active**: indicates that the alarm will be permanently
    active (for example for a fire alarm),

-   **Arming visible**: makes it possible to make visible or not the order
    arming the alarm on the widget,

-   **Immediate status visible**: allows to make the immediate status of
    the visible alarm (see below for the explanation),

-   **History and status of the alarm**: allows you to log or
    not the state and status of the alarm.

> **Tip**
>
> For each action it is possible to specify the mode in which
> it must be executed or in all modes

Areas
=====

Main part of the alarm. This is where you set up
different zones and actions (immediate and delayed by zone,
note that it is also possible to configure them globally) to do
triggering case. An area may be volumetric (for
the day for example) that perimetric (for the night) or also
areas of the house (garage, bedroom, outbuildings ....).

A button at the top right allows you to add as many as you
want.

> **Tip**
>
> It is possible to edit the name of the zone by clicking on the name of the
> this one (in front of the label "Name of the zone").

A zone consists of different elements: - trigger, - action
immediate, - action.

Trigger
-----------

A trigger is a binary command, which when it is worth 1 will
trigger the alarm. It is possible to invert the trigger, so that
this is the state 0 of the sensor that triggers the alarm, putting
"reverse" to YES. Once your trigger is chosen, you can
specify an activation time in minutes (it is not possible to
go below the minute). This delay allows for example, if you
activate the alarm before leaving your home, not to trigger
the alarm before one minute (the time to let you out). Other case,
some motion detectors remain in triggered mode (value 1)
for a while although there is no detection for example
4 minutes, so it's good to shift the activation of these sensors 4
or 5 min so that the alarm does not sound immediately after
activation. Then you have the trigger time, at the
difference in the activation delay which occurs only once
activation of the alarm, it is set up after each
triggering a sensor. The kinematics is the following during the
triggering of the sensor (door opening, presence detection), if
the activation times are passed, the alarm will trigger the actions
immediately but will wait until the activation delay is over before
to unearth the actions. Finally you have the "invert" button that allows
reverse the trigger state of the sensor (0 instead of 1).

Small example to understand: on the first trigger
(* \ [Salon \] \ [Eye \] \ [Presence \] *) Here I have an activation time of 5
minutes and 1 minute trigger. It means that when
I activate the alarm, during the first 5 minutes no triggering
the alarm can not take place because of this sensor. After this time
5 minutes, if motion is detected by the sensor, the alarm will
wait 1 minute (the time to let me turn off the alarm) before
trigger the actions. If I had immediate actions these
would have started immediately without waiting for the end of
activation, non-immediate actions would have taken place after (1
minute after the immediate actions).

Immediate action
----------------

As described above, these are actions that are triggered as soon as
triggering by not taking into account the triggering delay (but in
taking into account any activation delay). You just have to
select the desired action command and then according to it
fill in the execution parameters.

> **Note**
>
> When more than one zone is triggered successively, only the
> immediate actions of the 1st triggered zone are executed.

Modes
=====

The modes are simple enough to configure, just indicate
active zones according to the mode.

> **Tip**
>
> It is possible to rename the mode by clicking on the name of it
> (opposite the "Mode name" label).

> **Note**
>
> When renaming a mode, you need the alarm widget
> recliquer on the mode in question for a complete account
> (otherwise jeedom stays on the old mode)

> **Important**
>
> You must create at least one mode and assign zones
> otherwise your alarm will not work.

OK activation
=============

This part defines the actions to be taken following a
activation of the alarm. Here again, you will find the immediate notion
which represents the actions to be done immediately after arming of
the alarm, then come the activation actions that they are
executed after the trigger times.

In the example, here I turn on for example a lamp in red for
signal that the armament has been taken into account and I turn it off a
times the complete armament (because normally there is no one in the
perimeter of the alarm, otherwise it triggers it).

> **Important**
>
> OK activation actions do not take into account deadlines
> activation. If you have a delay on activating a sensor
> opening, even if your door is open activation actions
> will be executed.

KO activation
=============

These actions are executed if a sensor is triggered and this one is triggered
has no activation time.

Release
=============

Allows you to configure the global actions to be performed during a trigger
of the alarm. You do not have to add any if you have
configure specific actions by zone.

Disabling OK
================

These actions are executed when the alarm is disabled and
is not triggered. Example you go home, opening the
door that sounds the alarm, but you put a delay of
trigger on the sensor and you turn off the alarm before the end of the
delay, the OK deactivation actions will be executed. If however
you had stopped the alarm after the end of the triggering time this
would not have been the case.

Reset
================

This part allows you to define the actions to be done when the alarm
is triggered and deactivated. Here too there are immediate actions
and deferred. Here is an example: you go home, the deadlines
activations are passed, but by opening the door it triggers
the alarm. If you disable it (before the trigger times)
then the immediate reset actions will be executed but
not normal reset ones. If you disable it after
trigger times, then immediate reset actions
and normal will be executed.

FAQ
===

How to reset a permanent alarm?

: Just click on one of the alarm modes (even
    the active one).

<! - ->

Can we put deadlines in seconds?

: It is possible for the "Trigger delay" (it is necessary to put
    decimal numbers, eg 0.5 for 30 seconds) but not for the
    "Activation timeout" (do not put any decimal digits for
    this parameter).

I do not understand my alarm does not do anything

: Check that the alarm has an active mode


