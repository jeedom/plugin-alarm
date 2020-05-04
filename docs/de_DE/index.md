Das Alarm-Plugin ermöglicht Jeedom ein echtes Alarmsystem für
Hausautomation, sehr einfach zu bedienen und zu konfigurieren.

Plugin Konfiguration
=======================

Nach dem Herunterladen des Plugins müssen Sie es nur noch aktivieren,
Auf dieser Ebene gibt es keine zusätzliche Konfiguration.

Sofortiges Konzept
================

Dies ist ein sehr wichtiger Begriff des Alarm-Plugins
sehr wichtig, um es gut zu verstehen. Zur Vereinfachung ist es so, als ob
Sie hatten 2 Alarme, den ersten : der sofortige Alarm, der nicht hält
Berücksichtigung der Auslösezeiten (Aufmerksamkeit berücksichtigt
Aktivierungszeiten) und einen zweiten Alarm, der berücksichtigt
Auslösezeiten.

**Warum diese unmittelbare Vorstellung ?**

Diese unmittelbare Vorstellung ermöglicht es, Aktionen gut auszulösen
spezifisch. Zum Beispiel : du gehst nach Hause und hast nicht
Deaktivieren Sie den Alarm, bevor Sie die Sirene auslösen
Senden Sie eine Nachricht, die Sie daran erinnert, den Alarm zu deaktivieren, und falls dies der Fall ist
wird nicht 1 Minute später durchgeführt (Aktivierungszeit von 1 Minute daher)
Aktivieren Sie die Sirene.

Dieser Begriff findet sich jedes Mal in verschiedenen Arten von Aktionen
sein Prinzip wird detailliert beschrieben.

Equipements
===========

Die Konfiguration der Alarmausrüstung ist über das Menü zugänglich
Plugin &gt; Sécurité.

Sobald ein Alarm hinzugefügt wurde, erhalten Sie :

-   **Name der Alarmausrüstung** : Name Ihres Alarms,

-   **Übergeordnetes Objekt** : gibt das übergeordnete Objekt an, zu dem es gehört
    Ausrüstung,

-   **Kategorie** : die Kategorie der Ausrüstung (Sicherheit im Allgemeinen
    für einen Alarm),

-   **Activer** : macht Ihre Ausrüstung aktiv,

-   **Visible** : macht Ihre Ausrüstung auf dem Armaturenbrett sichtbar,

-   **Immer aktiv** : zeigt an, dass der Alarm dauerhaft ist
    aktiv (zum Beispiel für einen Branderkennungsalarm),

-   **Sichtbare Waffen** : ermöglicht es, den Befehl sichtbar zu machen oder nicht
    den Alarm auf dem Widget zu aktivieren,

-   **Sofort sichtbarer Status** : ermöglicht den sofortigen Status von
    der sichtbare Alarm (Erklärung siehe unten),

-   **Alarmstatus und -status protokollieren** : erlaubt zu historisieren oder
    kein Alarmstatus und Status.

-   **Separate Zonen** : macht die Zonen in Bezug auf Warnungen unabhängig. Normalerweise ignoriert das Plugin die anderen Zonen, wenn eine Zone in Alarmbereitschaft ist. Durch Trennen der Zonen werden die Aktionen für die anderen Zonen wiederholt, die in Alarmbereitschaft eintreten würden

-   **Automatischer Reset** : Bei Auslösung wird der vollständige Alarm erneut aktiviert, um nachfolgende Auslöser zu verhindern (in normalen Zeiten wird er erst wieder aktiviert, wenn ein Szenario / eine menschliche Aktion dazu durchgeführt wurde).

-   **Ergreifen Sie keine sofortigen Maßnahmen, wenn der Sensor keine Verzögerung aufweist** : Weist den Alarm an, keine sofortigen Maßnahmen zu ergreifen, wenn der Sensor keine Auslöseverzögerung hat. Der Alarm führt daher nur die Aktionen aus

> **Tip**
>
> Für jede Aktion kann der Modus angegeben werden, in dem
> es muss laufen oder in allen Modi

Zones
=====

Hauptteil des Alarms. Hier konfigurieren Sie die
verschiedene Zonen und Aktionen (unmittelbar und verzögert nach Zonen, bis
Beachten Sie, dass es auch möglich ist, sie global zu konfigurieren.
Triggerfall. Ein Bereich kann auch volumetrisch sein (z
tagsüber zum Beispiel) als Umfang (für die Nacht) oder auch
Bereiche des Hauses (Garage, Schlafzimmer, Nebengebäude usw.).

Über eine Schaltfläche oben rechts können Sie so viele hinzufügen, wie Sie möchten
voulez.

> **Tip**
>
> Sie können den Namen der Zone bearbeiten, indem Sie auf den Namen von klicken
> dieses (vor dem Etikett "Name der Zone").

Ein Bereich besteht aus verschiedenen Elementen : - auslösen, - Aktion
sofortige Aktion.

Auslöser
-----------

Ein Trigger ist ein binärer Befehl, der ausgeführt wird, wenn er 1 wert ist
Alarm auslösen. Es ist möglich, den Auslöser umzukehren, so dass
Es ist der Zustand 0 des Sensors, der den Alarm durch Setzen auslöst
"rückwärts "auf JA. Sobald Sie Ihren Auslöser ausgewählt haben, können Sie
Geben Sie eine Aktivierungsverzögerung in Minuten an (dies ist nicht möglich
unter die Minute gehen). Diese Verzögerung ermöglicht zum Beispiel, wenn Sie
Aktivieren Sie den Alarm, bevor Sie Ihr Zuhause verlassen, um ihn nicht auszulösen
der Alarm vor einer Minute (Zeit, Sie rauszulassen). Anderer Fall,
Einige Bewegungsmelder bleiben im ausgelösten Modus (Wert 1).
für eine Weile, auch wenn es zum Beispiel keine Erkennung gibt
4 Minuten ist es daher gut, die Aktivierung dieser Sensoren um 4 zu verzögern
oder 5 min, damit der Alarm nicht sofort danach losgeht
Aktivierung. Dann haben Sie die Triggerverzögerung am
Unterschied in der Aktivierungszeit, der nur einmal während auftritt
Nach Aktivierung des Alarms wird dieser nach jedem eingerichtet
Auslösen eines Sensors. Die Kinematik ist während des
Auslösen des Sensors (Türöffnung, Anwesenheitserkennung), wenn
Wenn die Aktivierungszeiten abgelaufen sind, löst der Alarm die Aktionen aus
wird aber warten, bis die Aktivierungsverzögerung vorbei ist
Aktionen auslösen. Schließlich haben Sie die "Rückwärts" -Taste, die erlaubt
um den Auslösezustand des Sensors zu invertieren (0 statt 1).

Sie haben auch einen Parameter **Maintient** Hier können Sie eine Trigger-Haltezeit festlegen, bevor Sie den Alarm auslösen. Wenn Sie beispielsweise einen Rauchmelder haben, der manchmal Fehlalarme auslöst, können Sie eine Verzögerung von 2 Sekunden angeben. Wenn der Alarm ausgelöst wird, wartet Jeedom 2 Sekunden und überprüft, ob der Rauchmelder immer noch in Alarmbereitschaft ist, wenn dies nicht der Fall ist, löst er den Alarm nicht aus.  

Kleines Beispiel zu verstehen : beim ersten Auslöser
(* \ [Salon \] \ [Auge \] \ [Präsenz \] *) Ich habe hier eine Aktivierungsverzögerung von 5
Minuten und 1 Minute Auslöser. Dies bedeutet, dass wenn
Ich aktiviere den Alarm, während der ersten 5 Minuten kein Auslöser
Aufgrund dieses Sensors kann kein Alarm auftreten. Nach dieser Zeit
5 Minuten, wenn der Sensor eine Bewegung erkennt, wird der Alarm ausgelöst
Warten Sie 1 Minute (lange genug, bis ich den Alarm deaktiviere)
Aktionen auslösen. Wenn ich sofort Maßnahmen ergriffen hätte
hätte sofort ausgelöst, ohne auf das Ende der Verzögerung zu warten
Aktivierung, nicht unmittelbare Aktionen hätten nach (1
Minute nach sofortigen Maßnahmen).

Sofortige Aktion
----------------

Wie oben beschrieben, sind dies Aktionen, die von der ausgelöst werden
Trigger ohne Berücksichtigung der Triggerverzögerung (aber in
unter Berücksichtigung der Aktivierungsverzögerung trotzdem). Du musst nur
Wählen Sie den gewünschten Aktionsbefehl und dann entsprechend
Füllen Sie die Ausführungsparameter.

> **Note**
>
> Wenn mehrere Zonen nacheinander ausgelöst werden, wird nur die
> Sofortaktionen der 1. ausgelösten Zone werden ausgeführt.

Modes
=====

Die Modi sind recht einfach zu konfigurieren, geben Sie einfach an
die aktiven Zonen entsprechend dem Modus.

> **Tip**
>
> Sie können den Modus umbenennen, indem Sie auf seinen Namen klicken
> (gegenüber der Bezeichnung "Name des Modus"). Achtung beim Umbenennen eines Modus ist es unbedingt erforderlich, die Szenarien / Geräte zu überprüfen, die den alten Namen verwenden, um sie an den neuen weiterzugeben

> **Note**
>
> Wenn Sie einen Modus umbenennen, müssen Sie das Alarm-Widget aktivieren
> Klicken Sie erneut auf den betreffenden Modus, um eine vollständige Prüfung zu erhalten
> (ansonsten bleibt Jeedom im alten Modus)

> **Important**
>
> Es ist unbedingt erforderlich, mindestens einen Modus zu erstellen und ihm Zonen zuzuweisen
> Andernfalls funktioniert Ihr Alarm nicht.

Aktivierung OK
=============

In diesem Teil werden die Aktionen definiert, die nach a ausgeführt werden sollen
Alarmaktivierung. Auch hier finden Sie den unmittelbaren Begriff
Dies stellt die Maßnahmen dar, die unmittelbar nach der Scharfschaltung zu ergreifen sind
der Alarm, dann kommen die Aktivierungsaktionen, die sie sind
nach Triggerzeiten ausgeführt.

Im Beispiel schalte ich hier zum Beispiel eine rote Lampe ein
signalisieren, dass die Waffe berücksichtigt wurde und ich schalte eine aus
einmal die komplette Scharfschaltung (weil normalerweise niemand mehr in der ist
Umfang des Alarms, sonst wird er ausgelöst).

> **Important**
>
> OK Aktivierungsaktionen berücksichtigen keine Fristen
> Aktivierung. Wenn Sie eine Verzögerung beim Aktivieren eines Sensors haben
> Auch wenn Ihre Tür offen ist, Aktivierungsaktionen
> wird ausgeführt.

KO-Aktivierung
=============

Diese Aktionen werden ausgeführt, wenn ein Sensor nach der Aktivierung des Alarms ausgelöst wird oder nach der Aktivierungsverzögerung eines Sensors, wenn dieser in Alarmbereitschaft ist

Hier können Sie auch Aktionen hinzufügen, wenn Sie die Überwachung eines Sensors fortsetzen

Veröffentlichung
=============

Hier können Sie die globalen Aktionen konfigurieren, die während eines Triggers ausgeführt werden sollen
des Alarms. Sie müssen nicht mehr hinzufügen, wenn Sie haben
bestimmte Aktionen nach Zone konfiguriert.

Deaktivierung OK
================

Diese Aktionen werden ausgeführt, wenn der Alarm deaktiviert ist und
wird nicht ausgelöst. Beispiel Sie gehen nach Hause, indem Sie die öffnen
Tür dies löst den Alarm aus, aber Sie stellen eine Verzögerung von ein
Trigger am Sensor und Sie unterbrechen den Alarm vor dem Ende des
Verzögerung, OK Deaktivierungsaktionen werden ausgeführt. Wenn auf der anderen Seite
Sie hatten den Alarm nach dem Ende der Triggerverzögerung gestoppt
wäre nicht der Fall gewesen.

Zurücksetzen
================

In diesem Teil können Sie die Aktionen definieren, die beim Alarm ausgeführt werden sollen
wird ausgelöst und dann deaktiviert. Auch hier gibt es Sofortmaßnahmen
und aufgeschoben. Hier ist ein Beispiel : Du kommst nach Hause, die Fristen
vorbei sind, aber das Öffnen der Tür löst aus
der Alarm. Wenn Sie es deaktivieren (vor den Auslösezeiten)
dann werden die sofortigen Rücksetzaktionen ausgeführt, aber
nicht normal zurückgesetzt. Wenn Sie es danach deaktivieren
Auslösezeiten, dann sofortiges Zurücksetzen
und normal wird ausgeführt.

FAQ
===

>**Was sind die möglichen Tags ?**
>
> Mögliche Tags sind :
>
> - #mode# : Name des aktuellen Modus
> - #trigger# : Name des Befehls, der die Warnung ausgelöst hat
> - #zone# : Name des Bereichs des Befehls, der die Warnung ausgelöst hat

>**So setzen Sie einen permanenten Alarm zurück ?**
>
>Klicken Sie einfach auf einen der Alarmmodi (gerade)
>der aktive).

>**Können wir die Verzögerungen in Sekunden setzen? ?**
>
>Es ist möglich für die "Trigger Delay" (müssen Sie setzen
>Gleitkommazahlen, z : 0.5 für 30 Sekunden), aber nicht für die
>"Aktivierungsverzögerung "(keine Dezimalstellen für setzen
>diese Einstellung).

>**Ich verstehe nicht, dass mein Alarm nichts bewirkt**
>
>Überprüfen Sie, ob der Alarm aktiv ist
