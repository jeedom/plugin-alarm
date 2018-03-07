<?php
if (!isConnect('admin')) {
	throw new Exception('{{Error 401 Unauthorized}}');
}
$plugin = plugin::byId('alarm');
sendVarToJS('eqType', $plugin->getId());
$eqLogics = eqLogic::byType($plugin->getId());
?>
<div class="row row-overflow">
  <div class="col-lg-2 col-md-3 col-sm-4">
    <div class="bs-sidebar">
      <ul id="ul_eqLogic" class="nav nav-list bs-sidenav">
        <a class="btn btn-default eqLogicAction" style="width : 100%;margin-top : 5px;margin-bottom: 5px;" data-action="add"><i class="fa fa-plus-circle"></i> {{Ajouter une alarme}}</a>
        <li class="filter" style="margin-bottom: 5px;"><input class="filter form-control input-sm" placeholder="{{Rechercher}}" style="width: 100%"/></li>
        <?php
foreach ($eqLogics as $eqLogic) {
	$opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
	echo '<li class="cursor li_eqLogic" data-eqLogic_id="' . $eqLogic->getId() . '" style="' . $opacity . '"><a>' . $eqLogic->getHumanName(true) . '</a></li>';
}
?>
     </ul>
   </div>
 </div>

 <div class="col-lg-10 col-md-9 col-sm-8 eqLogicThumbnailDisplay" style="border-left: solid 1px #EEE; padding-left: 25px;">
  <legend><i class="fa fa-cog"></i>  {{Gestion}}</legend>

  <div class="eqLogicThumbnailContainer">
    <div class="cursor eqLogicAction" data-action="add" style="background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >
     <center>
      <i class="fa fa-plus-circle" style="font-size : 5em;color:#94ca02;"></i>
    </center>
    <span style="font-size : 1.1em;position:relative; top : 23px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#94ca02"><center>Ajouter</center></span>
  </div>
</div>

<legend><i class="icon jeedom-alerte"></i>  {{Mes Alarmes}}</legend>
<input class="form-control" placeholder="{{Rechercher}}" style="margin-bottom:4px;" id="in_searchEqlogic" />
<div class="eqLogicThumbnailContainer">
  <?php
foreach ($eqLogics as $eqLogic) {
	$opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
	echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;' . $opacity . '" >';
	echo "<center>";
	echo '<img src="' . $plugin->getPathImgIcon() . '" height="105" width="95" />';
	echo "</center>";
	echo '<span class="name" style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;"><center>' . $eqLogic->getHumanName(true, true) . '</center></span>';
	echo '</div>';
}
?>
</div>

</div>

<div class="col-lg-10 col-md-9 col-sm-8 eqLogic" style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
  <a class="btn btn-success eqLogicAction pull-right" data-action="save"><i class="fa fa-check-circle"></i> {{Sauvegarder}}</a>
  <a class="btn btn-danger eqLogicAction pull-right" data-action="remove"><i class="fa fa-minus-circle"></i> {{Supprimer}}</a>
  <a class="btn btn-default eqLogicAction pull-right" data-action="configure"><i class="fa fa-cogs"></i> {{Configuration avancée}}</a>
  <ul class="nav nav-tabs" id="tab_alarm">
   <li role="presentation"><a class="eqLogicAction cursor" aria-controls="home" role="tab" data-action="returnToThumbnailDisplay"><i class="fa fa-arrow-circle-left"></i></a></li>
   <li class="active"><a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab" style="padding:10px 5px !important"><i class="fa fa-tachometer"></i> {{Equipement}}</a></li>
   <li><a href="#tab_zones" aria-controls="home" role="tab" data-toggle="tab" style="padding:10px 5px !important"><i class="fa fa-th-list" aria-hidden="true"></i> {{Zones}}</a></li>
   <li><a href="#tab_modes" aria-controls="home" role="tab" data-toggle="tab" style="padding:10px 5px !important"><i class="fa fa-modx" aria-hidden="true"></i> {{Modes}}</a></li>
   <li><a href="#tab_activeOk" aria-controls="home" role="tab" data-toggle="tab" style="padding:10px 5px !important"><i class="fa fa-check" aria-hidden="true"></i> {{Activation OK}}</a></li>
   <li><a href="#tab_activeKo" aria-controls="home" role="tab" data-toggle="tab" style="padding:10px 5px !important"><i class="fa fa-exclamation" aria-hidden="true"></i> {{Activation KO}}</a></li>
   <li><a href="#tab_outbreak" aria-controls="home" role="tab" data-toggle="tab" style="padding:10px 5px !important"><i class="fa fa-bell" aria-hidden="true"></i> {{Déclenchement}}</a></li>
   <li><a href="#tab_release" aria-controls="home" role="tab" data-toggle="tab" style="padding:10px 5px !important"><i class="fa fa-times" aria-hidden="true"></i> {{Désactivation OK}}</a></li>
   <li><a href="#tab_raz" aria-controls="home" role="tab" data-toggle="tab" style="padding:10px 5px !important"><i class="fa fa-refresh" aria-hidden="true"></i> {{Réinitialisation}}</a></li>
 </ul>
 <div class="tab-content">
  <div role="tabpanel" class="tab-pane active" id="eqlogictab">
    <br/>
    <form class="form-horizontal">
      <fieldset>
        <div class="form-group">
          <label class="col-sm-2 control-label">{{Nom de l'alarme}}</label>
          <div class="col-sm-3">
            <input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
            <input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="Nom de la zone"/>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" >{{Objet parent}}</label>
          <div class="col-sm-3">
            <select id="sel_object" class="eqLogicAttr form-control" data-l1key="object_id">
              <option value="">{{Aucun}}</option>
              <?php
foreach (object::all() as $object) {
	echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
}
?>
           </select>
         </div>
       </div>
       <div class="form-group">
        <label class="col-sm-2 control-label">{{Catégorie}}</label>
        <div class="col-sm-10">
          <?php
foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
	echo '<label class="checkbox-inline">';
	echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
	echo '</label>';
}
?>

       </div>
     </div>
     <div class="form-group">
      <label class="col-sm-2 control-label"></label>
      <div class="col-sm-10">
        <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked/>{{Activer}}</label>
        <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked/>{{Visible}}</label>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2 control-label"></label>
      <div class="col-sm-10">
        <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="configuration" data-l2key="always_active"/>{{Actif en permanence}}</label><br/>
        <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="configuration" data-l2key="armed_visible" checked/>{{Armement visible}} </label><br/>
        <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="configuration" data-l2key="immediateState_visible"/>{{Status immédiat visible}}</label><br/>
        <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="configuration" data-l2key="autorearm"/>{{Réarmement automatique}}</label><br/>
        <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="configuration" data-l2key="historizedState"/>{{Historiser état et status de l'alarme}}</label><br/>
        <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="configuration" data-l2key="splitZone"/>{{Séparer les zones}}</label><br/>
        <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="configuration" data-l2key="ignoreImmediatIfNoDelay"/>{{Ne pas faire les actions immediate si le capteur n'a pas de délai}}</label>
      </div>
    </div>
  </fieldset>
</form>
</div>

<div class="tab-pane" id="tab_zones">
  <br/>
  <div class="alert alert-info">{{Une zone décrit les capteurs que l'alarme doit surveiller ainsi que les actions à faire en cas de déclenchement.}} <a class="btn btn-success btn-xs pull-right" id="bt_addZone"><i class="fa fa-plus-circle"></i> {{Ajouter zone}}</a></div>
  <div class="panel-group" id="div_zones"></div>
</div>

<div class="tab-pane" id="tab_modes">
 <br/>
 <div class="alert alert-info">{{Les modes permettent d'activer les zones. Il vous en faut absolument un.}} <a class="btn btn-success btn-xs pull-right" id="bt_addMode"><i class="fa fa-plus-circle"></i> {{Ajouter mode}}</a></div>
 <div id="div_modes"></div>
</div>

<div class="tab-pane" id="tab_raz">
 <br/>
 <div class="alert alert-info">{{C'est ici que vous devez mettre les actions à faire lorsque l’alarme est déclenchée puis désactivée}}
   <a class='btn btn-success btn-xs pull-right' id="btn_addRazAlarm"><i class="fa fa-plus-circle"></i> {{Ajouter réinitialisation}}</a>
   <a class='btn btn-warning btn-xs pull-right' id="btn_addRazImmediateAlarm"><i class="fa fa-plus-circle"></i> {{Ajouter réinitialisation immédiate}}</a>
 </div>
 <form class="form-horizontal">
  <div id="div_razImmediate"></div>
</form>
<hr/>
<br/>
<form class="form-horizontal">
  <div id="div_raz"></div>
</form>
</div>

<div class="tab-pane" id="tab_release">
  <br/>
  <div class="alert alert-info">{{C'est ici que vous devez mettre les actions à faire lorsque l’alarme est désactivée et qu’elle n’est pas déclenchée}}
    <a class='btn btn-success btn-xs pull-right' id="btn_addReleaseAlarm"><i class="fa fa-plus-circle"></i> {{Ajouter action de désactivation OK}}</a>
  </div>
  <form class="form-horizontal">
    <div id="div_release"></div>
  </form>
</div>

<div class="tab-pane" id="tab_activeOk">
  <br/>
  <div class="alert alert-info">{{C'est ici que vous devez mettre les actions à faire lors d'une activation réussie de l'alarme}}
    <a class='btn btn-success btn-xs pull-right' id="btn_addActionActivationOk"><i class="fa fa-plus-circle"></i> {{Ajouter action lors de l'activation}}</a>
    <a class='btn btn-warning btn-xs pull-right' id="btn_addActionActivationImmediateOk"><i class="fa fa-plus-circle"></i> {{Ajouter action immediate lors de l'activation}}</a>
  </div>
  <form class="form-horizontal">
    <div id="div_activationImmediateOk"></div>
  </form>
  <hr/>
  <br/>
  <form class="form-horizontal">
    <div id="div_activationOk"></div>
  </form>
</div>
<div class="tab-pane" id="tab_outbreak">
  <br/>
  <div class="alert alert-info">{{C'est ici que vous devez mettre les actions à faire lorsque l'alarme se déclenche (à noter que vous pouvez aussi le faire par zone)}}
    <a class='btn btn-danger btn-xs pull-right' id="btn_addActionOutbreak"><i class="fa fa-plus-circle"></i> {{Ajouter action de déclechement}}</a>
    <a class='btn btn-warning btn-xs pull-right' id="btn_addActionOutbreakImmediate"><i class="fa fa-plus-circle"></i> {{Ajouter action immediate de déclenchement}}</a>
  </div>
  <form class="form-horizontal">
    <div id="div_outbreakImmediate"></div>
  </form>
  <hr/>
  <br/>
  <form class="form-horizontal">
    <div id="div_outbreak"></div>
  </form>
</div>
<div class="tab-pane" id="tab_activeKo">
  <br/>
  <div class="alert alert-info">{{C'est ici que vous devez mettre les actions à faire lorsque l'activation de l'alarme à échouée ou est partielle ainsi que celle lors de la reprise de surveillance d'un capteur}}
    <a class='btn btn-warning btn-xs pull-right' id="btn_addActionActivationKo"><i class="fa fa-plus-circle"></i> {{Ajouter action lors de l'echec d'activation}}</a>
    <a class='btn btn-success btn-xs pull-right' id="btn_addActionReenableTrigger"><i class="fa fa-plus-circle"></i> {{Ajouter action lors de la reprise de la surveillance}}</a>
  </div>
  <form class="form-horizontal">
    <div id="div_activationKo"></div>
  </form>
  <hr/>
  <br/>
  <form class="form-horizontal">
    <div id="div_reenableTrigger"></div>
  </form>
</div>
</div>
</div>
</div>

<div class="modal fade" id="md_addZoneMode">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">{{Ajouter zone}}</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-4 control-label" >{{Zone}}</label>
            <div class="col-sm-8" id="md_addZoneModeSelect">

            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <a class="btn btn-danger" data-dismiss="modal"><i class="fa fa-minus-circle"></i> {{Annuler}}</a>
        <a class="btn btn-success" id="bt_addZoneModeOk"><i class="fa fa-check-circle"></i> {{Valider}}</a>
      </div>
    </div>
  </div>
</div>

<?php include_file('desktop', 'alarm', 'js', 'alarm');?>
<?php include_file('core', 'plugin.template', 'js');?>