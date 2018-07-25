El plug-in de alarma permite Jeedom que tiene un sistema de alarma reales
su automatización, fácil de utilizar y configurar.

configuración del plugin
=======================

Después de descargar el plugin, sólo hay que activarlo,
no hay ninguna configuración adicional a este nivel.

concepto inmediata
================

C’est une notion très importante sur le plugin alarme et il est
important de très bien la comprendre. Pour schématiser c’est comme si
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

comodidades
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

> **Tip**
>
> Para cada acción, es posible especificar el modo de
> Se debe ejecutar o en todos los modos

áreas
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

gatillo
-----------

Un disparador es un comando binario, que es 1 cuando está
activar la alarma. Es posible revertir el detonante de
es el estado 0 del sensor que activa una alarma, con
"Invertir" SÍ. Una vez que el gatillo escogido, podrá
especificar un período de activiation en minutos (no es posible
por debajo de un minuto). Esto da tiempo, por ejemplo, si
activar la alarma antes de salir de casa, no para disparar
la alarma antes de un minuto (tiempo para dejar salir). otros casos
algunos detectores de movimiento permanecen modo activan (valor 1)
durante algún tiempo, incluso si no hay detección, por ejemplo
4 minutos, lo que es bueno para escalonar la activación de estos sensores 4
o 5 min antes de la alarma no se activa inmediatamente después de
activación. Entonces usted tiene el retardo de disparo, la
diferencia del retardo de activación que se produce sólo una vez en
activación de la alarma, se estableció después de cada
activación de un sensor. La cinemática es como sigue cuando
activando el sensor (abertura de la puerta, de detección de presencia), si
tiempo de activación pasado, la alarma se disparará acciones
inmediata sino que esperar a que el tiempo de activación es más antes
déchencher acciones. Finalmente usted tiene el botón "atrás" que
para revertir la condición de activación del sensor (0 en vez de 1).

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

acción inmediata
----------------

Como se describió anteriormente, se trata de acciones que se desencadenan a partir de la
activación ignorando el retardo de disparo (pero
aun teniendo en cuenta el tiempo de activación). Sólo tienes que
seleccione el control de la acción deseada y función de la misma
Parámetros de ejecución completos.

> **Nota**
>
> Cuando varias zonas se activan sucesivamente, sólo se
> Las acciones inmediatas de la primera zona desencadenado se ejecutan.

modos
=====

Los modos son bastante fácil de configurar, sólo hay que indicar
las áreas activas en función del modo.

> **Tip**
>
> Es posible cambiar el nombre del modo haciendo clic en el nombre de ella
> (Frente a la etiqueta "Nombre del modo").

> **Nota**
>
> Al cambiar el nombre de una manera deben en el widget de alarma
> Haga clic de nuevo en el modo de pregunta para tener plenamente en cuenta
> (Si jeedom permanece en la vieja manera)

> **Importante**
>
> Asegúrese de crear al menos un modo y asignar áreas
> Si la alarma no funciona.

Aceptar la activación
=============

Esta sección define las acciones a seguir una
activación de la alarma. Una vez más, se encuentra el plazo inmediato
representativos de las acciones a Inmediatamente después de armar
alarma, seguido por la activación acciones son
ejecutado después de que el retardo de disparo.

En el ejemplo, me vuelvo aquí, por ejemplo, una lámpara roja
informan que el armado se ha tenido en cuenta y que un éteinds
Una vez que el armamento completo (ya que normalmente no hay nadie en el
alarma de perímetro, de lo contrario se dispara).

> **Importante**
>
> Las acciones de activación OK no tienen en cuenta el tiempo
> Activación. Si usted tiene un retraso en la activación de un sensor
> de apertura, incluso si su puerta está abierta medidas de activación
> Será ejecutado.

la activación KO
=============

Ces actions sont exécutées si un capteur est déclenché suite à l'activation de l'alarme ou après le delai d'activation d'un capteur si celui-ci est en alerte

Vous pouvez aussi ici ajouter des action lors de la reprise de surveillance d'un capteur

liberación
=============

Configurar las acciones globals que hacer cuando se activa
alarma. Usted no está obligado a añadir si tiene
configurar una acción específica por área.

Aceptar la desactivación
================

Estas acciones se ejecutan cuando se desactiva la alarma y ella
no se activa. Ejemplo llegue a casa, abriendo la
puerta que activa la alarma, pero se puso una vez
activando el sensor y apagar la alarma antes de que el
plazo, se ejecutará acciones de desactivación OK. Si por contra
de detener la alarma después del final de este retardo de ida
no habría sido el caso.

reajustar
================

Esta sección le permite definir acciones para hacer cuando la alarma
se activa y desactiva. Aquí también hay acciones inmediatas
y diferida. He aquí un ejemplo: si se va a casa, el tiempo
La activación pasó, pero abriendo la puerta esto desencadena
la alarma. Si la deshabilita (antes de la hora de activación)
a continuación, restablecer inmediatamente las acciones serán ejecutadas, pero
no los de restablecimiento normal. Si lo apaga después
retardo de disparo, entonces las acciones de restablecimiento inmediato
normal y será ejecutado.

Preguntas frecuentes
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


