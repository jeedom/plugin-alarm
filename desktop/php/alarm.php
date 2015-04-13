<?php
if (!isConnect('admin')) {
	throw new Exception('{{Error 401 Unauthorized}}');
}
sendVarToJS('eqType', 'alarm');
$eqLogics = eqLogic::byType('alarm');
?>
<div class="row row-overflow">
    <div class="col-lg-2 col-md-3 col-sm-4">
        <div class="bs-sidebar">
            <ul id="ul_eqLogic" class="nav nav-list bs-sidenav">
                <a class="btn btn-default eqLogicAction" style="width : 100%;margin-top : 5px;margin-bottom: 5px;" data-action="add"><i class="fa fa-plus-circle"></i> {{Ajouter une alarme}}</a>
                <li class="filter" style="margin-bottom: 5px;"><input class="filter form-control input-sm" placeholder="{{Rechercher}}" style="width: 100%"/></li>
                <?php
foreach ($eqLogics as $eqLogic) {
	echo '<li class="cursor li_eqLogic" data-eqLogic_id="' . $eqLogic->getId() . '"><a>' . $eqLogic->getHumanName(true) . '</a></li>';
}
?>
           </ul>
       </div>
   </div>

   <div class="col-lg-10 col-md-9 col-sm-8 eqLogicThumbnailDisplay" style="border-left: solid 1px #EEE; padding-left: 25px;">
    <legend>{{Mes équipements alarmes}}
    </legend>
    <div class="eqLogicThumbnailContainer">
      <div class="cursor eqLogicAction" data-action="add" style="background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >
         <center>
            <i class="fa fa-plus-circle" style="font-size : 7em;color:#94ca02;"></i>
        </center>
        <span style="font-size : 1.1em;position:relative; top : 23px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#94ca02"><center>Ajouter</center></span>
    </div>
    <?php
foreach ($eqLogics as $eqLogic) {
	echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >';
	echo "<center>";
	echo '<img src="plugins/alarm/doc/images/alarm_icon.png" height="105" width="95" />';
	echo "</center>";
	echo '<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;"><center>' . $eqLogic->getHumanName(true, true) . '</center></span>';
	echo '</div>';
}
?>
</div>

</div>

<div class="col-lg-10 col-md-9 col-sm-8 eqLogic" style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
    <form class="form-horizontal">
        <fieldset>
            <legend><i class="fa fa-arrow-circle-left eqLogicAction cursor" data-action="returnToThumbnailDisplay"></i> {{Général}}<i class='fa fa-cogs eqLogicAction pull-right cursor expertModeVisible' data-action='configure'></i></legend>
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
        <label class="col-sm-2 control-label">{{Activer}}</label>
        <div class="col-sm-1">
            <input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked/>
        </div>
        <label class="col-sm-2 control-label">{{Visible}}</label>
        <div class="col-sm-1">
            <input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked/>
        </div>
    </div>

    <div class="form-group expertModeVisible">
        <label class="col-sm-2 control-label">{{Actif en permanence}}</label>
        <div class="col-sm-1">
            <input type="checkbox" class="eqLogicAttr" data-l1key="configuration" data-l2key="always_active"/>
        </div>
        <label class="col-sm-2 control-label">{{Armement visible}}</label>
        <div class="col-sm-1">
            <input type="checkbox" class="eqLogicAttr" data-l1key="configuration" data-l2key="armed_visible" checked/>
        </div>
        <label class="col-sm-2 control-label">{{Status immédiat visible}}</label>
        <div class="col-sm-1">
            <input type="checkbox" class="eqLogicAttr" data-l1key="configuration" data-l2key="immediateState_visible"/>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">{{Historiser état et status de l'alarme}}</label>
        <div class="col-sm-1">
            <input type="checkbox" class="eqLogicAttr" data-l1key="configuration" data-l2key="historizedState"/>
        </div>
    </div>
</fieldset>
</form>

<ul class="nav nav-tabs" id="tab_alarm">
    <li class="active"><a href="#tab_zones">{{Zones}}</a></li>
    <li><a href="#tab_modes">{{Modes}}</a></li>
    <li><a href="#tab_raz">{{Réinitialisation}}</a></li>
    <li><a href="#tab_ping">{{Pertes de communication}}</a></li>
    <li><a href="#tab_activeOk">{{Activation OK}}</a></li>
    <li><a href="#tab_activeKo">{{Activation KO}}</a></li>
    <li><a href="#tab_release">{{Désactivation OK}}</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="tab_zones">
        <a class="btn btn-success btn-xs pull-right" id="bt_addZone" style="margin-top: 5px;"><i class="fa fa-plus-circle"></i> {{Ajouter zone}}</a>
        <br/><br/>
        <div class="panel-group" id="div_zones"></div>
    </div>

    <div class="tab-pane" id="tab_modes">
        <a class="btn btn-success btn-xs pull-right" id="bt_addMode" style="margin-top: 5px;"><i class="fa fa-plus-circle"></i> {{Ajouter mode}}</a>
        <br/><br/>
        <div id="div_modes"></div>
    </div>

    <div class="tab-pane" id="tab_raz">
        <a class='btn btn-success btn-xs pull-right' id="btn_addRazAlarm" style="margin-top: 5px;"><i class="fa fa-plus-circle"></i> {{Ajouter réinitialisation}}</a>
        <a class='btn btn-warning btn-xs pull-right' id="btn_addRazImmediateAlarm" style="margin-top: 5px;"><i class="fa fa-plus-circle"></i> {{Ajouter réinitialisation immédiate}}</a>
        <br/><br/>
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
        <a class='btn btn-success btn-xs pull-right' id="btn_addReleaseAlarm" style="margin-top: 5px;"><i class="fa fa-plus-circle"></i> {{Ajouter action de désactivation OK}}</a>
        <br/><br/>
        <form class="form-horizontal">
            <div id="div_release"></div>
        </form>
    </div>

    <div class="tab-pane" id="tab_ping">
        <a class='btn btn-warning btn-xs pull-right' id="btn_addPingAction" style="margin-top: 5px;"><i class="fa fa-plus-circle"></i> {{Ajouter action perte de communication}}</a>
        <a class='btn btn-success btn-xs pull-right' id="btn_addPingTest" style="margin-top: 5px;"><i class="fa fa-plus-circle"></i> {{Ajouter équipement à tester}}</a>
        <br/><br/>
        <form class="form-horizontal">
            <div id="div_pingTest"></div>
            <div id="div_ping"></div>
        </form>
    </div>

    <div class="tab-pane" id="tab_activeOk">
        <a class='btn btn-success btn-xs pull-right' id="btn_addActionActivationOk" style="margin-top: 5px;"><i class="fa fa-plus-circle"></i> {{Ajouter action lors de l'activation}}</a>
        <a class='btn btn-warning btn-xs pull-right' id="btn_addActionActivationImmediateOk" style="margin-top: 5px;"><i class="fa fa-plus-circle"></i> {{Ajouter action immediate lors de l'activation}}</a>
        <br/><br/>
        <form class="form-horizontal">
            <div id="div_activationImmediateOk"></div>
        </form>
        <hr/>
        <br/>
        <form class="form-horizontal">
            <div id="div_activationOk"></div>
        </form>
    </div>
    <div class="tab-pane" id="tab_activeKo">
        <a class='btn btn-success btn-xs pull-right' id="btn_addActionActivationKo" style="margin-top: 5px;"><i class="fa fa-plus-circle"></i> {{Ajouter action lors de l'echec d'activation}}</a>
        <br/><br/>
        <form class="form-horizontal">
            <div id="div_activationKo"></div>
        </form>
    </div>
</div>

<br/><br/>
<hr/>
<form class="form-horizontal">
    <fieldset>
        <div class="form-actions">
            <a class="btn btn-danger eqLogicAction" data-action="remove"><i class="fa fa-minus-circle"></i> {{Supprimer}}</a>
            <a class="btn btn-success eqLogicAction" data-action="save"><i class="fa fa-check-circle"></i> {{Sauvegarder}}</a>
        </div>
    </fieldset>
</form>

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