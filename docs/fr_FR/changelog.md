- Correction de bug sur le renommage des modes
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

- Correction d'un bug sur le déplacement des actions dans déclenchement

- Possibilité d'ajouter un délai de maintient d'un déclencheur avant activation de l'alarme

# 01/12/2017

-   Correction d’un bug sur la désactivation des détecteurs

-   Gestion des secondes sur le delai d’activatio (JEED-63)

-   Retour en arriere sur le non déclenchement des actions immédiates si
    le délai d’activation est vide ou nul

-   Si lors de l’activation un capteur est en alerte et n’a pas de délai
    d’activation alors l’alarme s’arme quand meme en ignorant ce capteur
    (a moins qu’il revienne au repos)

-   Ajout d’action de déclenchement globale (plus filtrée par zone, il
    est conseillé d’utiliser celle-ci plutot que les actions de
    déclenchement par zone)

-   Optimisation du code

-   ATTENTION : l’alarme n’execute plus les actions immediates si il n’y
    a pas de délai de déclenchement !!!!!! ⇒ Annulé

-   Possibilité de filtrer la réalisation des actions par rapport au
    mode de l’alarme

-   Ajout commande pause/reprise

-   Amélioration de l’interface de configuration
