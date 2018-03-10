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

- Posibilidad de añadir una demora mantiene un disparador de activación de alarma antes

# 01/12/2017

-   Corregido un fallo sobre detectores incapacitantes

-   segundos de gestión sobre el retraso de activatio (JEED-63)

-   Espalda con espalda en la no-disparador de la acción inmediata si
    el tiempo de activación está vacía o nula

-   Si al activar un sensor está alerta y no tiene tiempo
    activación entonces la alarma está armado cuando incluso ignorando este sensor
    (A menos que llegue al ralentí)

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
