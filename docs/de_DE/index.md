Die Alarm-Plugin ermöglicht es Jeedom ein echtes Alarmsystem zu haben,
seine Automatisierung, einfach zu bedienen und zu konfigurieren.

Plugin-Konfiguration
=======================

Nachdem das Plugin herunterzuladen, müssen Sie nur um es zu aktivieren,
gibt es keine zusätzliche Konfiguration auf dieser Ebene.

sofort Konzept
================

C’est une notion très importante sur le plugin alarme et il est
important de très bien la comprendre. Pour schématiser c’est comme si
vous aviez 2 alarmes, la première : l’alarme immédiate qui ne tient pas
compte des délais de déclenchement (attention elle prend bien en compte
les délais d’activation) et une 2ème alarme qui elle, prend en compte
les délais de déclenchement.

**Warum diese unmittelbare Vorstellung?**

Cette notion immédiate permet de déclencher des actions bien
spécifiques. Par exemple : vous rentrez chez vous et vous n’avez pas
désactivé l’alarme, avant de déclencher la sirène il peut être bon de
diffuser un message rappellant de bien désactiver l’alarme et si ce
n’est pas fait 1 minute plus tard (délai d’activation de 1 minute donc)
d’activer la sirène.

Dieses Konzept in verschiedenen Arten von Maßnahmen gefunden wird, jedes Mal,
Prinzip wird ausführlich beschrieben.

Einrichtungen
===========

Alarmanlagen-Konfiguration aus dem Menü verfügbar
Plugin &gt; Sicherheit.

Nach dem Hinzufügen Alarm Sie am Ende mit:

-   **Name der Alarmanlage** Name Ihres Alarmes

-   **Übergeordnete Objekt** zeigt das übergeordnete Objekt gehört
    Ausrüstung,

-   ** ** Kategorie: die Kategorie der Ausrüstung (Sicherheit im Allgemeinen
    für einen Alarm)

-   **Aktivieren**: auf Ihre aktive Ausrüstung zu machen,

-   Visible ** ** macht Ihr Gerät sichtbar auf dem Armaturenbrett,

-   Dauerhaft aktiv ** ** Zeigt an, dass der Alarm dauerhaft sein
    aktiv ist (zum Beispiel Alarm einer Brandmelde)

-   ** ** sichtbar Waffe: Damit kann sichtbar oder nicht den Befehl machen
    Aktivierung der Alarmfunktion auf das Widget,

-   **Der Status** sofort sichtbar: auf den sofortigen Status machen
    der sichtbare Alarm (unten, um Erläuterungen sehen),

-   **historisieren Status- und Alarmstatus** wird verwendet, um zu generieren oder
    nicht der Staat und der Status des Alarms.

> **Tipp**
>
> Für jede Aktion ist es möglich, die Betriebsart angeben
> Es muss allen Modi ausführen oder in

Bereiche
=====

Hauptteil des Alarms. Hier können Sie konfigurieren
verschiedene Zonen und Aktionen (sofortige und Bereich verschoben,
Beachten Sie, dass es auch möglich ist, global zu konfigurieren) zu machen
wenn sie ausgelöst wird. Eine Zone kann entweder volumetrisch sein (für
Tag, zum Beispiel), dass Umfang (für die Nacht) oder auch
Bereiche des Hauses (Garage, Schlafzimmer, Nebengebäude ....).

Eine obere rechte Taste ermöglicht es Ihnen, so viele, wie Sie hinzufügen
möchten.

> **Tipp**
>
> Sie können mit einem Klick auf den Namen, den Namen des Bereichs bearbeiten
> Es (gegenüber der Bezeichnung "Zone Name").

Eine Zone besteht aus verschiedenen Elementen: - Auslöser, - Aktion
sofort - Aktion.

Auslöser
-----------

Ein Auslöser ist ein binärer Befehl, der 1 ist, wenn es
den Alarm auslösen. Es ist möglich, den Auslöser zu umkehren für
es ist der Zustand 0 des Sensors, der einen Alarm auslöst, mit
"Invertieren" YES. Sobald Ihre gewählte Trigger, können Sie
Geben Sie einen Zeitraum von activiation in Minuten (es nicht möglich ist,
unterhalb einer Minute nach unten). Dies ermöglicht es Zeit zum Beispiel, wenn Sie
den Alarm aktivieren, bevor das Haus zu verlassen, nicht zu triggern
der Alarm vor 1 Minute (Zeit, Sie zu lassen). andere Fälle
einige Bewegungsmelder-Modus (Wert 1) bleiben ausgelöst
seit einiger Zeit, auch wenn kein Nachweis ist beispiel
4 Minuten, so ist es gut, die Aktivierung dieser Sensoren staffeln 4
oder 5 Minuten vor dem Alarm nicht sofort ausgelöst, nachdem
Aktivierung. Dann haben Sie die Trigger-Verzögerung, die
Differenz der Aktivierungsverzögerung, die nur einmal auftritt, in
Aktivierung des Alarms wird nach jedem Set up
Auslösen eines Sensors. Die Kinematik ist wie folgt, wenn
Auslösen des Sensors (Toröffnung, Anwesenheitserfassung), wenn
Aktivierungszeit vergangen, wird der Alarm ausgelöst Aktionen
sofort, sondern wird für die Aktivierungszeit warten ist vorbei, bevor
déchencher Aktionen. Schließlich haben Sie die „reverse“ Knopf,
umzukehren, die Sensor Triggerbedingung (0 statt 1).

Vous avez aussi un paramètre **Maintient** qui permet de spécifier un délai de maintient du déclencheur avant de déclencher l'alarme. Ex si vous avez un détecteur de fumée qui remonte parfois de fausses alarmes vous pouvez spécifier un délai de 2s. Lors du déclenchement de l'alarme Jeedom va attendre 2s et vérifier que le détecteur de fumée est toujours en alerte si ce n'est pas le cas il ne déclenchera pas l'alarme.  

Kleines Beispiel zu verstehen: der ersten Trigger
(* \ [Salon \] \ [Eye \] \ [Presence \] *) Ich habe hier eine Aktivierungsperiode von 5
Minuten und Abzug 1 Minute. Dies bedeutet, dass, wenn
Aktiviere ich den Alarm während der ersten 5 Minuten kein Trigger
Der Alarm kann nicht stattfinden, weil dieser Sensor. Nach dieser Zeit
5 Minuten, wenn die Bewegung durch den Sensor erfasst wird, wird der Alarm
1 Minute warten (die Zeit, mich vom Alarm zu lassen), bevor
Aktionen auslösen. Wenn ich hatte unmittelbare Aktionen, die sie
beginnen würde sofort für die Frist, ohne warten
Aktivierung, nicht sofortige Maßnahmen stattgefunden haben, nach (1
Minute nach den unmittelbaren Aktionen).

sofortiges Handeln
----------------

Wie oben beschrieben, sind diese Aktionen, die von der ausgelöst werden
Triggern der Triggerverzögerung ignoriert (aber
selbst wenn unter Berücksichtigung der Aktivierungszeit). Sie müssen nur
wählen die gewünschte Aktionssteuer dann davon funktionieren
komplette Ausführungsparameter.

> **Hinweis**
>
> Wenn mehrere Zonen nacheinander ausgelöst, nur
> Sofortige Aktionen werden zuerst ausgelöst Zone ausgeführt.

Modi
=====

Die Modi sind recht einfach einzurichten, müssen Sie nur angeben,
die aktiven Bereiche in Abhängigkeit von der Betriebsart.

> **Tipp**
>
> Es ist möglich, den Modus, indem Sie auf den Namen es umbenennen
> (Gegenüber der Bezeichnung „Modellname“).

> **Hinweis**
>
> Beim Umbenennen eine Art und Weise in dem Alarm Widget muss
> Klicken Sie erneut auf die Frage Modus für die vollständige Berücksichtigung
> (Wenn jeedom auf dem alten Weg bleibt)

> **Wichtig**
>
> Achten Sie darauf, mindestens einen Modus und weisen Bereiche zu schaffen
> Wenn Ihr Alarm nicht funktioniert.

OK Aktivierung
=============

In diesem Abschnitt werden die Aktionen a folgen
Alarmaktivierung. Auch hier werden Sie den sofortigen Begriff finden
die Aktien vertreten zu Unmittelbar nach Bewaffnung
Alarm, gefolgt von der Aktivierung Aktionen
nach der Triggerverzögerung ausgeführt.

Im Beispiel drehe ich hier zum Beispiel eine rote Lampe
berichten, dass Bewaffnung berücksichtigt wurde und ich éteinds ein
Sobald die volle Bewaffnung (denn normalerweise gibt es niemand in der
Perimeter-Alarm, sonst löst sie).

> **Wichtig**
>
> Die OK Aktivierungsmaßnahmen berücksichtigen nicht in die Zeit
> Aktivierung. Wenn Sie eine Verzögerung auf die Aktivierung eines Sensors
> Öffnen, auch wenn Ihre Tür ist offen Aktivierungsmaßnahmen
> Wird ausgeführt werden.

KO-Aktivierung
=============

Ces actions sont exécutées si un capteur est déclenché suite à l'activation de l'alarme ou après le delai d'activation d'un capteur si celui-ci est en alerte

Vous pouvez aussi ici ajouter des action lors de la reprise de surveillance d'un capteur

Veröffentlichung
=============

Konfigurieren Sie die Globals Aktionen zu tun, wenn sie ausgelöst
Alarm. Sie sind nicht hinzuzufügen gezwungen, wenn Sie
konfigurieren, dass bestimmte Maßnahmen Bereich.

OK Deaktivierung
================

Diese Aktionen werden ausgeführt, wenn der Alarm deaktiviert und sie
nicht ausgelöst. Beispiel Sie nach Hause kommen, die Öffnung
Tür, die den Alarm auslöst, aber Sie setzen eine Zeit
Auslösen des Sensors und den Alarm ausschalten, bevor die
Frist, OK Deaktivierung Aktionen werden ausgeführt. Wenn durch Nachteile
Sie stoppte den Alarm nach dem Ende dieser Reise Verzögerung
wäre nicht der Fall gewesen.

rücksetzen
================

In diesem Abschnitt können Sie Aktionen definieren, wenn der Alarm zu tun
aktiviert und deaktiviert wird. Auch hier gibt es Sofortmaßnahmen
und abgegrenzt. Hier ein Beispiel: Sie gehen nach Hause, Zeit
Die Aktivierung vergangen, aber das Öffnen der Tür löst dies
der Alarm. Wenn Sie deaktivieren (vor dem Triggerzeitpunkt)
dann sofort zurückgesetzt Aktionen ausgeführt wird, aber
diejenigen, die nicht von normalen zurückgesetzt. Wenn Sie sie ausschalten nach
Trigger-Verzögerung, dann die Aktionen der sofortigen Reset
normal und wird ausgeführt.

FAQ
===

>**Quels sont les tags possible ?**
>
> Les tags possible sont : 
>
> - #mode# : nom du mode en cours
> - #trigger# : nom de la commande qui a déclenché l'alerte
> - #zone# : nom de la zone de la commande qui a déclenché l'alerte

>**Comment réarmer une alarme permanente ?**
>
>Il suffit de cliquer sur un des modes de l’alarme (même
>celui actif).

>**Peut-on mettre les délais en secondes ?**
>
>C’est possible pour le "Délai de déclenchement" (il faut mettre des
>nombres à virgule, ex : 0.5 pour 30 secondes) mais pas pour le
>"Délai d’activation" (ne pas mettre de chiffres à virgule pour
>ce paramètre).

>**Je ne comprends pas mon alarme ne fait rien**
>
>Vérifiez que l’alarme a bien un mode d’actif


