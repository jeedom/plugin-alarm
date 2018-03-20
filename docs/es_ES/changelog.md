- Si l'alarme est déjà active l'armement ne la réactive pas
- Ajout d'une option pour un déclenchement multi-zones (si une autre zone rentre en alerte alors l'alarme se déclenche)
- Ajout d'action lors de la reprise de surveillance d'un capteur
- Ajout du tag #zone#


# 06/03/2018

- Ajout de la gestion des commandes orphelines
- Si des capteurs sont désactivés alors les actions d'activation ok ne sont plus déclenchées
- Correction de bugs
- Les détecteurs ayant des délais d'activation et étant toujours actif après ce délai ne déclenchent plus l'alarme, mais lancent une activation KO, avec surveillance de ce détecteur exclu jusqu'à un retour à la normale

# 12/02/2018

- Correction d'un bug sur le déplacement des actions dans déclenchement

- Posibilidad de añadir una demora mantiene un disparador de activación de alarma antes

# 01/12/2017

-   Corregido un fallo sobre detectores incapacitantes

-   Gestion des secondes sur le delai d’activation (JEED-63)

-   Retour en arrière sur le non déclenchement des actions immédiates si
    el tiempo de activación está vacía o nula

-   Si al activar un sensor está alerta y no tiene tiempo
    d’activation alors l’alarme s’arme quand même en ignorant ce capteur
    (à moins qu’il revienne au repos)

-   Adición de una acción global gatillo (área más filtrada,
    es recomendable utilizarlo en lugar de acciones
    activación por área)

-   optimización de código

-   ADVERTENCIA: la alarma ejecutar más acciones si hay immediates
    sin retardo de disparo !!!!!! ⇒ Cancelar

-   Filtrar la realización de las acciones con respecto a la
    modo de alarma

-   Adición de pausa comando / recuperación

-   interfaz de configuración mejorada
