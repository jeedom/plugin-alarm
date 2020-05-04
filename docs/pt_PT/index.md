O plugin Alarme permite que o Jeedom tenha um sistema de alarme real para
automação residencial, muito simples de usar e configurar.

Configuração do plugin
=======================

Depois de baixar o plugin, você só precisa ativá-lo,
não há configuração adicional nesse nível.

Conceito imediato
================

Esta é uma noção muito importante do plugin Alarme e é
muito importante entendê-lo bem. Simplificar é como se
você teve 2 alarmes, o primeiro : o alarme imediato que não detém
conta os tempos de disparo (atenção que leva em consideração
tempos de ativação) e um segundo alarme que leva em consideração
tempos de disparo.

**Por que essa noção imediata ?**

Essa noção imediata possibilita desencadear ações bem
específico. Por exemplo : você vai para casa e você não tem
desativar o alarme, antes de acionar a sirene, pode ser bom
transmita uma mensagem lembrando-o de desativar o alarme e se isso
não é feito 1 minuto depois (tempo de ativação de 1 minuto)
ativar a sirene.

Essa noção é encontrada em diferentes tipos de ações, a cada vez
seu princípio será detalhado.

Equipements
===========

A configuração do equipamento de alarme pode ser acessada no menu
Plugin &gt; Sécurité.

Depois que um alarme é adicionado, você acaba com :

-   **Nome do equipamento de alarme** : nome do seu alarme,

-   **Objeto pai** : indica o objeto pai ao qual pertence
    o equipamento,

-   **Categoria** : a categoria do equipamento (segurança em geral
    para um alarme),

-   **Activer** : torna seu equipamento ativo,

-   **Visible** : torna seu equipamento visível no painel,

-   **Ativo o tempo todo** : indica que o alarme será permanentemente
    ativo (por exemplo, para um alarme de detecção de incêndio),

-   **Armamento visível** : permite tornar visível ou não o comando
    de armar o alarme no widget,

-   **Status visível imediato** : permite fazer o status imediato de
    o alarme visível (veja abaixo a explicação),

-   **Status e status do alarme de log** : permite historiar ou
    nenhum status de alarme e status.

-   **Zonas separadas** : torna as zonas independentes em termos de alertas. Normalmente, se uma zona estiver em alerta, o plug-in ignorará as outras zonas.. Ao separar as zonas, ele repetirá as ações para as outras zonas que entrariam em alerta

-   **Reset automático** : Quando acionado, o alarme completo é rearmado para evitar disparos subseqüentes (em tempos normais, ele não será rearmado até que exista um cenário / ação humana para fazer isso)

-   **Não tome medidas imediatas se o sensor não tiver atraso** : diz ao alarme para não executar ações imediatas se o sensor não tiver um atraso no gatilho, o alarme executará apenas as ações

> **Tip**
>
> Para cada ação, é possível especificar o modo em que
> deve ser executado ou em todos os modos

Zones
=====

Parte principal do alarme. É aqui que você configura o
diferentes zonas e ações (imediatas e diferidas por zona, para
note que também é possível configurá-los globalmente)
caso de gatilho. Uma área também pode ser volumétrica (por
durante o dia, por exemplo) do que perímetro (para a noite) ou também
áreas da casa (garagem, quarto, dependências, etc.).

Um botão no canto superior direito permite adicionar quantos você quiser
voulez.

> **Tip**
>
> É possível editar o nome da zona clicando no nome da zona.
> este (em frente ao rótulo "Nome da zona").

Uma área é composta de diferentes elementos : - gatilho, - ação
imediato, - ação.

Gatilho
-----------

Um gatilho é um comando binário, que quando vale 1 vai
disparar o alarme. É possível inverter o gatilho, para que
é o estado 0 do sensor que aciona o alarme, colocando
"reverter "para SIM. Depois de escolher seu gatilho, você pode
especificar um atraso de ativação em minutos (não é possível
vá abaixo do minuto). Esse atraso permite, por exemplo, se você
ative o alarme antes de sair de casa, para não acionar
o alarme antes de um minuto (hora de deixar você sair). Outro caso,
alguns detectores de movimento permanecem no modo acionado (valor 1)
por um tempo, mesmo se não houver detecção, por exemplo
4 minutos, é bom adiar a ativação desses sensores por 4
ou 5 min para que o alarme não dispare imediatamente após
ativação. Então você tem o atraso do gatilho, no
diferença no tempo de ativação que ocorre apenas uma vez durante
a ativação do alarme, ele é configurado após cada
disparo de um sensor. A cinemática é a seguinte durante o
acionamento do sensor (abertura da porta, detecção de presença), se
os tempos de ativação passaram, o alarme acionará as ações
mas esperará até que o atraso da ativação termine antes
acionar ações. Finalmente, você tem o botão "reverso", que permite
para inverter o estado de disparo do sensor (0 em vez de 1).

Você também tem um parâmetro **Maintient** que permite especificar um tempo de espera do gatilho antes de disparar o alarme. Por exemplo, se você possui um detector de fumaça que, às vezes, gera alarmes falsos, pode especificar um atraso de 2s. Quando o alarme é acionado, o Jeedom espera 2s e verifica se o detector de fumaça ainda está em alerta, se não for o caso, não acionará o alarme..  

Pequeno exemplo para entender : no primeiro gatilho
(* \ [Salon \] \ [Eye \] \ [Presence \] *) Tenho aqui um atraso de ativação de 5
minutos e gatilho de 1 minuto. Isso significa que quando
Ativei o alarme, durante os primeiros 5 minutos sem gatilho
alarme não pode ocorrer devido a este sensor. Após esse tempo
5 minutos, se for detectado movimento pelo sensor, o alarme será acionado
aguarde 1 minuto (tempo suficiente para eu desativar o alarme) antes de
acionar ações. Se eu tivesse ações imediatas, essas
teria desencadeado imediatamente sem esperar pelo final do atraso
ativação, ações não imediatas teriam ocorrido após (1
minuto após ações imediatas).

Ação imediata
----------------

Conforme descrito acima, são ações que são acionadas a partir do
gatilho não levando em consideração o atraso do gatilho (mas em
levando em consideração o atraso da ativação). Você apenas tem que
selecione o comando de ação desejado e, em seguida, de acordo com ele
preencha os parâmetros de execução.

> **Note**
>
> Quando várias zonas são acionadas sucessivamente, apenas o
> ações imediatas da 1ª zona acionada são executadas.

Modes
=====

Os modos são bem simples de configurar, basta indicar
as zonas ativas de acordo com o modo.

> **Tip**
>
> É possível renomear o modo clicando em seu nome
> (ao lado do rótulo "Nome do modo"). Atenção durante a renomeação de um modo, é absolutamente necessário revisar os cenários / equipamentos que usam o nome antigo para transmiti-los aos novos

> **Note**
>
> Ao renomear um modo, você deve no widget de alarme
> clique novamente no modo em questão para uma consideração completa
> (caso contrário, o Jeedom permanece no modo antigo)

> **Important**
>
> É absolutamente necessário criar pelo menos um modo e atribuir zonas a ele
> caso contrário, seu alarme não funcionará.

Ativação OK
=============

Esta parte é usada para definir as ações a serem executadas após um
ativação de alarme. Aqui, novamente, você encontrará a noção imediata
que representa as ações a serem tomadas imediatamente após o armamento
o alarme, então vêm as ações de ativação que eles são
executado após os tempos de disparo.

No exemplo, aqui acendo, por exemplo, uma lâmpada vermelha para
sinal de que o armamento foi levado em consideração e eu o desligo
uma vez que o armamento completo (porque normalmente não há mais ninguém no
perímetro do alarme, caso contrário ele o aciona).

> **Important**
>
> As ações de ativação OK não levam em consideração os prazos
> ativação. Se você tiver um atraso na ativação de um sensor
> mesmo que sua porta esteja aberta, ações de ativação
> será executado.

Ativação de KO
=============

Essas ações são executadas se um sensor for acionado após a ativação do alarme ou após o atraso de ativação de um sensor se estiver em alerta

Aqui você também pode adicionar ações ao retomar o monitoramento de um sensor

Trigger
=============

Permite configurar as ações globais a serem executadas durante um acionador
do alarme. Você não precisa adicionar mais se tiver
ações específicas configuradas por zona.

Desativação OK
================

Essas ações são executadas quando o alarme é desativado e
não é acionado. Exemplo, você vai para casa, abrindo o
porta isso dispara o alarme, mas você define um atraso de
disparar no sensor e você cortará o alarme antes do final do
atraso, ações de desativação OK serão executadas. Se por outro lado
você tinha parado o alarme após o final do gatilho atrasar este
não teria sido o caso.

Reset
================

Esta parte permite definir as ações a serem executadas quando o alarme
é acionado e desativado. Aqui também existem ações imediatas
e diferido. Aqui está um exemplo : você chega em casa, os prazos
já passaram, mas abrir a porta dispara
o alarme. Se você desativá-lo (antes dos tempos de disparo)
as ações de redefinição imediata serão executadas, mas
não redefinir normais. Se você desativá-lo após
tempos de disparo e ações de redefinição imediata
e normal será executado.

FAQ
===

>**Quais são as possíveis tags ?**
>
> As tags possíveis são :
>
> - #mode# : nome do modo atual
> - #trigger# : nome do comando que acionou o alerta
> - #zone# : nome da área do comando que acionou o alerta

>**Como redefinir um alarme permanente ?**
>
>Basta clicar em um dos modos de alarme (mesmo
>o ativo).

>**Podemos colocar os atrasos em segundos ?**
>
>É possível para o "atraso de disparo" (você deve colocar
>números de ponto flutuante, ex : 0.5 por 30 segundos), mas não para o
>"Atraso de ativação "(não coloque casas decimais para
>essa configuração).

>**Eu não entendo meu alarme não faz nada**
>
>Verifique se o alarme está no modo ativo
