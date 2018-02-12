
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
