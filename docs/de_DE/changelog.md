- Si l'alarme est déjà active l'armement ne la réactive pas
- Ajout d'une option pour un déclenchement multi-zone (si une autre zone rentre en alert alors l'alarme se declenche)
- Ajout d'action lors de la reprise de surveillance d'un capteur
- Ajout du tag #zone#


# 06/03/2018

- Ajout de la gestion des commandes orphelines
- Si des capteurs sont désactiver alors les actions d'activation ok ne sont plus déclenchées
- Correction de bugs
- Les detecteurs ayant des délais d'activation et étant toujours actif après ce délai ne déclenche plus l'alarme, mais lance une activation KO, avec surveillance de ce detecteur exclu jusqu'à un retour à la normal

# 12/02/2018

- Es wurde ein Fehler beim Verschieben von Aktionen beim Auslösen behoben

- Die Möglichkeit, eine Verzögerung hinzuzufügen, führt einen Alarmaktivierungsauslöser vor

# 2017.01.12

-   Fehler behoben, zum Deaktivieren von Detektoren

-   Management Sekunden auf die Verzögerung von activatio (Jeed-63)

-   Zurück auf den Nicht-Trigger sofortigen Maßnahmen zu unterstützen, wenn
    die Aktivierungszeit ist leer oder null

-   Wenn, wenn ein Sensor aktiviert ist ansprechbar und hat keine Zeit
    Aktivierung dann der Alarm scharf geschaltet ist, wenn auch dieser Sensor ignoriert
    (Es sei denn, es erreicht den Idle)

-   Hinzufügen globale Trigger-Aktion (mehr gefilterten Bereich,
    ratsam ist es als Aktionen eher zu verwenden
    Auslösung durch Fläche)

-   Code-Optimierung

-   ACHTUNG: Der Alarm mehr Aktien ausgeführt werden, wenn immediates
    keine Triggerverzögerung !!!!!! ⇒ Abbrechen

-   Die Fähigkeit zu filtern, um die Maßnahmen in Bezug auf die Durchführung
    Alarmmodus

-   Hinzufügen Pause Befehl / Erholung

-   Verbesserte Konfigurationsschnittstelle
