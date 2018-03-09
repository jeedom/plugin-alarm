- Ajout d'une option pour un déclenchement multi-zone (si une autre zone rentre en alert alors l'alarme se declenche)
- Ajout d'action lors de la reprise de surveillance d'un capteur
- Ajout du tag #zone#


# 06/03/2018

- Ajout de la gestion des commandes orphelines
- Si des capteurs sont désactiver alors les actions d'activation ok ne sont plus déclenchées
- Correction de bugs
- Les detecteurs ayant des délais d'activation et étant toujours actif après ce délai ne déclenche plus l'alarme, mais lance une activation KO, avec surveillance de ce detecteur exclu jusqu'à un retour à la normal

# 12/02/2018

- Correction d'un bug sur le déplacement des actions dans déclenchement

- Ability to add a trigger hold delay before activating the alarm

# 01/12/2017

-   Fixed a bug on disabling detectors

-   Management of seconds on the activation delay (JEED-63)

-   Back on the non triggering of immediate actions if
    the activation time is empty or null

-   If during activation a sensor is on alert and has no delay
    activation then the alarm goes off even when ignoring this sensor
    (unless he comes back to rest)

-   Added global trigger action (plus filtered by zone, it
    is advisable to use this one rather than the actions of
    zone triggering)

-   Code optimization

-   ATTENTION: the alarm no longer executes immediate actions if there is no
    has no trigger time !!!!!! ⇒ Canceled

-   Possibility of filtering the achievement of actions in relation to
    alarm mode

-   Add pause / resume command

-   Improved configuration interface
