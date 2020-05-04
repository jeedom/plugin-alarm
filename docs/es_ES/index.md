El complemento de alarma le permite a Jeedom tener un sistema de alarma real para
domótica, muy simple de usar y configurar.

Configuración del plugin
=======================

Después de descargar el complemento, solo necesita activarlo,
no hay configuración adicional a este nivel.

Concepto inmediato
================

Esta es una noción muy importante del complemento de alarma y es
muy importante entenderlo bien. Para simplificar es como si
tenías 2 alarmas, la primera : la alarma inmediata que no se sostiene
cuenta de los tiempos de activación (atención que tiene en cuenta
tiempos de activación) y una segunda alarma que tiene en cuenta
tiempos de activación.

**¿Por qué esta noción inmediata? ?**

Esta noción inmediata hace posible activar acciones bien
específico Por ejemplo : te vas a casa y no tienes
desactivar la alarma, antes de activar la sirena puede ser bueno
transmitir un mensaje recordándole que desactive la alarma y si esto
no se realiza 1 minuto después (tiempo de activación de 1 minuto por lo tanto)
activar la sirena.

Esta noción se encuentra en diferentes tipos de acciones, cada vez
se detallará su principio.

Equipements
===========

Se puede acceder a la configuración del equipo de alarma desde el menú
Plugin &gt; Sécurité.

Una vez que se agrega una alarma, terminas con :

-   **Nombre del equipo de alarma.** : nombre de tu alarma,

-   **Objeto padre** : indica el objeto padre al que pertenece
    equipo,

-   **Categoría** : la categoría del equipo (seguridad en general
    para una alarma),

-   **Activer** : activa su equipo,

-   **Visible** : hace que su equipo sea visible en el tablero,

-   **Activo todo el tiempo** : indica que la alarma será permanente
    activo (por ejemplo, para una alarma de detección de incendios),

-   **Armamento visible** : permite hacer visible o no el comando
    de armar la alarma en el widget,

-   **Estado visible inmediato** : permite hacer el estado inmediato de
    la alarma visible (ver más abajo para la explicación),

-   **Registrar estado de alarma y estado** : permite historizar o
    sin estado de alarma y estado.

-   **Zonas separadas** : hace que las zonas sean independientes en términos de alertas. Normalmente, si una zona está en alerta, el complemento ignorará las otras zonas. Al separar las zonas, repetirá las acciones para las otras zonas que entrarían en alerta

-   **Reinicio automático** : cuando se activa, la alarma completa se rearma para evitar disparadores posteriores (en tiempos normales no se rearmará hasta que haya habido un escenario / acción humana para hacerlo)

-   **No tome medidas inmediatas si el sensor no tiene retraso** : le dice a la alarma que no tome acciones inmediatas si el sensor no tiene un retraso de activación, por lo tanto, la alarma solo realizará las acciones

> **Tip**
>
> Para cada acción es posible especificar el modo en que
> debe ejecutarse o en todos los modos

Zones
=====

Parte principal de la alarma. Aquí es donde configuras el
diferentes zonas y acciones (inmediatas y diferidas por zona, para
tenga en cuenta que también es posible configurarlos globalmente)
caso de gatillo. Un área también puede ser volumétrica (para
durante el día, por ejemplo) que el perímetro (por la noche) o también
áreas de la casa (garaje, dormitorio, dependencias, etc.).

Un botón en la parte superior derecha le permite agregar tantos como desee
voulez.

> **Tip**
>
> Es posible editar el nombre de la zona haciendo clic en el nombre de
> este (delante de la etiqueta "Nombre de la zona").

Un área está compuesta de diferentes elementos. : - disparador, - acción
inmediata, - acción.

Disparador
-----------

Un disparador es un comando binario, que cuando vale 1 va
hacer sonar la alarma. Es posible invertir el gatillo, de modo que
Es el estado 0 del sensor el que activa la alarma, al poner
"revertir "a SÍ. Una vez que haya elegido su disparador, puede
especificar un retraso de activación en minutos (no es posible
ir debajo del minuto). Este retraso permite, por ejemplo, si usted
active la alarma antes de salir de su casa, para no activar
la alarma antes de un minuto (hora de dejarte salir). Otro caso,
algunos detectores de movimiento permanecen en modo activado (valor 1)
por un tiempo, incluso si no hay detección, por ejemplo
4 minutos, por lo tanto, es bueno retrasar la activación de estos sensores por 4
o 5 minutos para que la alarma no suene inmediatamente después
activación Entonces tienes el retraso del disparador, en el
diferencia en el tiempo de activación que ocurre solo una vez durante
la activación de la alarma, se configura después de cada
disparo de un sensor. La cinemática es la siguiente durante el
activación del sensor (apertura de puerta, detección de presencia), si
los tiempos de activación han pasado, la alarma activará las acciones
pero esperará hasta que termine el retraso de activación antes de
desencadenar acciones. Finalmente tienes el botón "revertir" que permite
para invertir el estado de activación del sensor (0 en lugar de 1).

También tienes un parámetro **Maintient** que le permite especificar un tiempo de espera de activación antes de activar la alarma. Por ejemplo, si tiene un detector de humo que a veces genera falsas alarmas, puede especificar un retraso de 2 segundos. Cuando se activa la alarma, Jeedom esperará 2 segundos y comprobará que el detector de humo todavía está alerta si no es el caso, no activará la alarma..  

Pequeño ejemplo para entender : en el primer disparador
(* \ [Salon \] \ [Eye \] \ [Presence \] *) Tengo aquí un retraso de activación de 5
minutos y 1 minuto de activación. Esto significa que cuando
Activo la alarma, durante los primeros 5 minutos no se activa
la alarma no puede ocurrir debido a este sensor. Despues de este tiempo
5 minutos, si el sensor detecta movimiento, la alarma sonará
espere 1 minuto (el tiempo suficiente para que desactive la alarma) antes
desencadenar acciones. Si hubiera tenido acciones inmediatas estas
se habría disparado inmediatamente sin esperar el final del retraso
activación, las acciones no inmediatas habrían tenido lugar después de (1
minuto después de acciones inmediatas).

Acción inmediata
----------------

Como se describió anteriormente, estas son acciones que se activan desde
el disparador no tiene en cuenta el retraso del disparador (pero en
teniendo en cuenta el retraso de activación de todos modos). Solo tienes que
seleccione el comando de acción deseado y luego de acuerdo con él
llenar los parámetros de ejecución.

> **Note**
>
> Cuando se activan varias zonas sucesivamente, solo el
> se ejecutan acciones inmediatas de la primera zona activada.

Modes
=====

Los modos son bastante simples de configurar, solo indique
las zonas activas según el modo.

> **Tip**
>
> Es posible cambiar el nombre del modo haciendo clic en su nombre
> (opuesto a la etiqueta "Nombre del modo"). Atención durante el cambio de nombre de un modo es absolutamente necesario revisar los escenarios / equipos que usan el nombre antiguo para pasarlos al nuevo

> **Note**
>
> Al cambiar el nombre de un modo, debe hacerlo en el widget de alarma
> haga clic nuevamente en el modo en cuestión para una consideración completa
> (de lo contrario, Jeedom permanece en el modo antiguo)

> **Important**
>
> Es absolutamente necesario crear al menos un modo y asignarle zonas
> de lo contrario su alarma no funcionará.

Activación OK
=============

Esta parte se utiliza para definir las acciones que se tomarán después de un
activación de alarma. Aquí nuevamente, encontrarás la noción inmediata
que representa las acciones a tomar inmediatamente después de armar
la alarma, luego vienen las acciones de activación que son
ejecutado después de los tiempos de activación.

En el ejemplo, aquí enciendo, por ejemplo, una lámpara roja para
señalo que el armamento ha sido tomado en cuenta y lo apago
una vez que el armado completo (porque normalmente no queda nadie en el
perímetro de la alarma, de lo contrario lo activa).

> **Important**
>
> Las acciones de activación OK no tienen en cuenta los plazos
> activación. Si tiene un retraso en la activación de un sensor
> incluso si tu puerta está abierta, acciones de activación
> será ejecutado.

Activación KO
=============

Estas acciones se ejecutan si se activa un sensor después de la activación de la alarma o después del retraso de activación de un sensor si está en alerta

Aquí también puede agregar acciones al reanudar la supervisión de un sensor

Liberación
=============

Le permite configurar las acciones globales que se tomarán durante un desencadenante
de la alarma. No tiene que agregar más si tiene
acciones específicas configuradas por zona.

Desactivación OK
================

Estas acciones se ejecutan cuando la alarma se desactiva y
no se activa. Ejemplo, vas a casa abriendo el
puerta esto activa la alarma pero establece un retraso de
activa el sensor y corta la alarma antes del final de la
retraso, se ejecutarán acciones de desactivación OK. Si por otro lado
habías detenido la alarma después de que el final del gatillo retrasara esto
no hubiera sido el caso.

Restablecer
================

Esta parte le permite definir las acciones a realizar cuando la alarma
se activa y luego se desactiva. Aquí también hay acciones inmediatas.
y diferido. Aquí un ejemplo : llegas a casa, los plazos
han pasado, pero al abrir la puerta se dispara
la alarma Si lo desactiva (antes de los tiempos de activación)
entonces se ejecutarán las acciones de reinicio inmediatas, pero
los restablecimientos no normales. Si lo desactiva después de
tiempos de activación, luego acciones de reinicio inmediatas
y normal se ejecutará.

FAQ
===

>**¿Cuáles son las posibles etiquetas? ?**
>
> Las posibles etiquetas son :
>
> - #mode# : nombre del modo actual
> - #trigger# : nombre del comando que activó la alerta
> - #zone# : nombre del área del comando que activó la alerta

>**Cómo restablecer una alarma permanente ?**
>
>Simplemente haga clic en uno de los modos de alarma (incluso
>el activo).

>**¿Podemos poner los retrasos en segundos? ?**
>
>Es posible el "retraso de activación" (debe poner
>números de coma flotante, ex : 0.5 por 30 segundos) pero no por el
>"Retraso de activación "(no ponga puntos decimales para
>esta configuración).

>**No entiendo mi alarma no hace nada**
>
>Verifique que la alarma tenga un modo activo
