El plug-in de alarma permite Jeedom que tiene un sistema de alarma reales
su automatización, fácil de utilizar y configurar.

Configuration du plugin
=======================

Après téléchargement du plugin, il vous suffit juste d’activer celui-ci,
il n’y a aucune configuration supplémentaire à ce niveau.

Notion immédiate
================

C’est une notion très importante du plugin Alarme et il est
très important de bien la comprendre. Pour schématiser c’est comme si
vous aviez 2 alarmes, la première : l’alarme immédiate qui ne tient pas
compte des délais de déclenchement (attention elle prend bien en compte
les délais d’activation) et une 2ème alarme qui elle, prend en compte
les délais de déclenchement.

**¿Por qué esta noción inmediata?**

Cette notion immédiate permet de déclencher des actions bien
spécifiques. Par exemple : vous rentrez chez vous et vous n’avez pas
désactivé l’alarme, avant de déclencher la sirène il peut être bon de
diffuser un message rappellant de bien désactiver l’alarme et si ce
n’est pas fait 1 minute plus tard (délai d’activation de 1 minute donc)
d’activer la sirène.

Este concepto se encuentra en diferentes tipos de acciones, cada vez
principio se detallará.

Equipements
===========

configuración de un sistema de alarma está disponible en el menú
Plugin de Seguridad &gt;.

Una vez añadido alarma se termina con:

-   **Nombre del equipo de alarma** Nombre de la alarma,

-   **Objeto padre** : especifica el objeto padre al que pertenece
    equipos,

-   ** ** Categoría: la categoría del equipo (seguridad en general
    para una alarma)

-   ** ** Activar: para que su equipo activo,

-   ** ** visible hace que su equipo visible en el salpicadero,

-   Permanentemente activa ** ** Indica que la alarma estará permanentemente
    activo (por ejemplo una alarma de detección de incendios)

-   ** ** Arma visibles: permite hacer visible o no el comando
    Conectar la alarma en el widget,

-   **Estado** inmediata visible: hacer que la situación inmediata
    la alarma visible (ver más abajo para una explicación),

-   **estado historizar y estado de alarma** se utiliza para generar o
    no el estado y el estado de la alarma.

-   **Séparer les zones** : permet de rendre les zones indépendantes en terme d'alerte. En temps normal si une zone est en alerte le plugin va ignorer les autres zones. En séparant les zones il répetera les actions pour les autres zones qui entreraient en alerte

-   **Réarmement automatique** : lors d'un déclenchement l'alarme complète se réarme pour prévenir des déclenchements suivants (en temps normal elle ne se réarme pas tant qu'il n'y a pas eu une action scénario/humaine pour le faire)

-   **Ne pas faire les actions immédiates si le capteur n'a pas de délai** : indique à l'alarme de ne pas faire les actions immédiates si le capteur n'a pas de délai de déclenchement, l'alarme ne fera donc que les actions

> **Tip**
>
> Pour chaque action il est possible de spécifier le mode dans lequel
> elle doit s’exécuter ou dans tous les modes

Zones
=====

parte principal de la alarma. Aquí es donde se configura
diferentes zonas y acciones inmediatas y diferidas (por área,
Tenga en cuenta que también es posible configurar a nivel mundial) para hacer
cuando se activa. Una zona puede ser o bien volumétrico (por
día, por ejemplo) que el perímetro (por la noche) o también
áreas de la casa (garaje, dormitorio, dependencias ....).

Un botón de arriba a la derecha le permite añadir todas las que
desee.

> **Tip**
>
> Puede editar el nombre de la zona haciendo clic en el nombre de
> Es (frente a la etiqueta de "zona de nombres").

Una zona consiste en diferentes elementos: - gatillo, - Acción
inmediata - acción.

Déclencheur
-----------

Un déclencheur est une commande binaire, qui lorsqu’elle vaut 1 va
déclencher l’alarme. Il est possible d’inverser le déclencheur, pour que
ça soit l’état 0 du capteur qui déclenche l’alarme, en mettant
"inverser" sur OUI. Une fois votre déclencheur choisi, vous pouvez
spécifier un délai d’activiation en minute (il n’est pas possible de
descendre en-dessous de la minute). Ce délai permet par exemple, si vous
activez l’alarme avant de sortir de chez vous, de ne pas déclencher
l’alarme avant une minute (le temps de vous laisser sortir). Autre cas,
certains détecteurs de mouvement restent en mode déclenché (valeur 1)
pendant un certain temps même si il n’y a aucune détection, par exemple
4 minutes, il est donc bon de décaler l’activation de ces capteurs de 4
ou 5 min pour que l’alarme ne se déclenche pas immédiatement après
l’activation. Ensuite vous avez le délai de déclenchement, à la
différence du délai d’activation qui n’a lieu que une fois lors de
l’activation de l’alarme, celui-ci est mis en place après chaque
déclenchement d’un capteur. La cinématique est la suivante lors du
déclenchement du capteur (ouverture de porte, détection de présence), si
les délais d’activation sont passés, l’alarme va déclencher les actions
immédiates mais va attendre que le délai d’activation soit fini avant de
déchencher les actions. Enfin vous avez le bouton "inverser" qui permet
d’inverser l’état déclencheur du capteur (0 au lieu de 1).

Vous avez aussi un paramètre **Maintient** qui permet de spécifier un délai de maintient du déclencheur avant de déclencher l'alarme. Ex si vous avez un détecteur de fumée qui remonte parfois de fausses alarmes vous pouvez spécifier un délai de 2s. Lors du déclenchement de l'alarme Jeedom va attendre 2s et vérifier que le détecteur de fumée est toujours en alerte si ce n'est pas le cas il ne déclenchera pas l'alarme.  

Pequeño ejemplo para comprender: el primer disparo
(* \ [Salón \] \ [Eye \] \ [Presencia \] *) He aquí un periodo de activación de 5
minuto y el gatillo 1 minuto. Esto significa que cuando
Cómo activo la alarma, durante los primeros 5 minutos sin gatillo
La alarma no puede tener lugar debido a este sensor. Después de este tiempo
5 minutos, si el movimiento es detectado por el sensor, la alarma se
espere 1 minuto (el tiempo para dejar fuera de la alarma) antes
desencadenar acciones. Si tuviera que acciones inmediatas
comenzaría inmediatamente sin esperar a la fecha límite
activación, acciones inmediatas no han tenido lugar después de (1
minutos después de que las acciones inmediatas).

Action immédiate
----------------

Como se describió anteriormente, se trata de acciones que se desencadenan a partir de la
activación ignorando el retardo de disparo (pero
aun teniendo en cuenta el tiempo de activación). Sólo tienes que
seleccione el control de la acción deseada y función de la misma
Parámetros de ejecución completos.

> **Note**
>
> Lorsque plusieurs zones sont déclenchées successivement, seules les
> actions immédiates de la 1ere zone déclenchée sont exécutées.

Modes
=====

Los modos son bastante fácil de configurar, sólo hay que indicar
las áreas activas en función del modo.

> **Tip**
>
> Il est possible de renommer le mode en cliquant sur le nom de celui-ci
> (en face du label "Nom du mode").

> **Note**
>
> Lors du renommage d’un mode, il faut sur le widget de l’alarme
> recliquer sur le mode en question pour une prise en compte complète
> (sinon Jeedom reste sur l’ancien mode)

> **Important**
>
> Il faut absolument créer au moins un mode et lui affecter des zones
> sinon votre alarme ne marchera pas.

Activation OK
=============

Cette partie permet de définir les actions à faire suite à une
activation de l’alarme. Ici encore, vous retrouverez la notion immédiate
qui représente les actions à faire tout de suite après armement de
l’alarme, ensuite viennent les actions d’activation qui elles sont
exécutées après les délais de déclenchement.

Dans l’exemple, ici j’allume par exemple une lampe en rouge pour
signaler que l’armement a bien été pris en compte et je l’éteins une
fois l’armement complet (car normalement il n’y a plus personne dans le
périmètre de l’alarme, sinon ça la déclenche).

> **Importante**
>
> Las acciones de activación OK no tienen en cuenta el tiempo
> Activación. Si usted tiene un retraso en la activación de un sensor
> de apertura, incluso si su puerta está abierta medidas de activación
> Será ejecutado.

Activation KO
=============

Ces actions sont exécutées si un capteur est déclenché suite à l'activation de l'alarme ou après le delai d'activation d'un capteur si celui-ci est en alerte

Vous pouvez aussi ici ajouter des actions lors de la reprise de surveillance d'un capteur

Déclenchement
=============

Permet de configurer les actions globales à faire lors d’un déclenchement
de l’alarme. Vous n’êtes pas obligé d’en ajouter si vous avez
configuré des actions spécifiques par zone.

Désactivation OK
================

Estas acciones se ejecutan cuando se desactiva la alarma y ella
no se activa. Ejemplo llegue a casa, abriendo la
puerta que activa la alarma, pero se puso una vez
activando el sensor y apagar la alarma antes de que el
plazo, se ejecutará acciones de desactivación OK. Si por contra
de detener la alarma después del final de este retardo de ida
no habría sido el caso.

Réinitialisation
================

Cette partie vous permet de définir les actions à faire lorsque l’alarme
est déclenchée puis désactivée. Ici aussi il y a des actions immédiates
et différées. Voici un exemple : vous rentrez chez vous, les délais
d’activation sont passés, mais en ouvrant la porte cela déclenche
l’alarme. Si vous la désactivez (avant les délais de déclenchement)
alors les actions de réinitialisation immédiate seront exécutées, mais
pas celles de réinitialisation normale. Si vous la désactivez après les
délais de déclenchement, alors les actions de réinitialisation immédiate
et normale seront exécutées.

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
