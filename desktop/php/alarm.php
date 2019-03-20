<?php
if (!isConnect('admin')) {
	throw new Exception('{{Error 401 Unauthorized}}');
}
$plugin = plugin::byId('alarm');
sendVarToJS('eqType', $plugin->getId());
$eqLogics = eqLogic::byType($plugin->getId());
?>
<div class="row row-overflow">
	<div class="col-xs-12 eqLogicThumbnailDisplay">
		<legend><i class="fas fa-cog"></i> {{Gestion}}</legend>
		<div class="eqLogicThumbnailContainer">
			<div class="cursor eqLogicAction logoPrimary" data-action="add"  >
				<i class="fas fa-plus-circle"></i>
				<br/>
				<span ><center>Ajouter</center></span>
			</div>
		</div>
		<legend><i class="icon jeedom-alerte"></i> {{Mes Alarmes}}</legend>
		<input class="form-control" placeholder="{{Rechercher}}" id="in_searchEqlogic" />
		<div class="eqLogicThumbnailContainer">
			<?php
			foreach ($eqLogics as $eqLogic) {
				$opacity = ($eqLogic->getIsEnable()) ? '' : 'disableCard';
				echo '<div class="eqLogicDisplayCard cursor '.$opacity.'" data-eqLogic_id="' . $eqLogic->getId() . '">';
				echo '<img src="' . $plugin->getPathImgIcon() . '"/>';
				echo "<br/>";
				echo '<span class="name">' . $eqLogic->getHumanName(true, true) . '</span>';
				echo '</div>';
			}
			?>
		</div>
	</div>
	
	<div class="col-xs-12 eqLogic" style="display: none;">
		<div class="input-group pull-right" style="display:inline-flex">
			<span class="input-group-btn">
				<a class="btn btn-default btn-sm eqLogicAction roundedLeft" data-action="configure"><i class="fas fa-cogs"></i> {{Configuration avancée}}</a><a class="btn btn-default btn-sm eqLogicAction" data-action="copy"><i class="fas fa-copy"></i> {{Dupliquer}}</a><a class="btn btn-sm btn-success eqLogicAction" data-action="save"><i class="fas fa-check-circle"></i> {{Sauvegarder}}</a><a class="btn btn-danger btn-sm eqLogicAction roundedRight" data-action="remove"><i class="fas fa-minus-circle"></i> {{Supprimer}}</a>
			</span>
		</div>
		<ul class="nav nav-tabs" id="tab_alarm">
			<li role="presentation"><a class="eqLogicAction cursor" aria-controls="home" role="tab" data-action="returnToThumbnailDisplay"><i class="fas fa-arrow-circle-left"></i></a></li>
			<li class="active"><a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab" style="padding:10px 5px !important"><i class="fas fa-tachometer-alt"></i> {{Equipement}}</a></li>
			<li><a href="#tab_zones" aria-controls="home" role="tab" data-toggle="tab" style="padding:10px 5px !important"><i class="fas fa-th-list"></i> {{Zones}}</a></li>
			<li><a href="#tab_modes" aria-controls="home" role="tab" data-toggle="tab" style="padding:10px 5px !important"><i class="fab fa-modx"></i> {{Modes}}</a></li>
			<li><a href="#tab_activeOk" aria-controls="home" role="tab" data-toggle="tab" style="padding:10px 5px !important"><i class="fas fa-check"></i> {{Activation OK}}</a></li>
			<li><a href="#tab_activeKo" aria-controls="home" role="tab" data-toggle="tab" style="padding:10px 5px !important"><i class="fas fa-exclamation"></i> {{Activation KO}}</a></li>
			<li><a href="#tab_outbreak" aria-controls="home" role="tab" data-toggle="tab" style="padding:10px 5px !important"><i class="fas fa-bell"></i> {{Déclenchement}}</a></li>
			<li><a href="#tab_release" aria-controls="home" role="tab" data-toggle="tab" style="padding:10px 5px !important"><i class="fas fa-times"></i> {{Désactivation OK}}</a></li>
			<li><a href="#tab_raz" aria-controls="home" role="tab" data-toggle="tab" style="padding:10px 5px !important"><i class="fas fa-sync-alt"></i> {{Réinitialisation}}</a></li>
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
								<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="configuration" data-l2key="ignoreImmediatIfNoDelay"/>{{Ne pas faire les actions immédiates si le capteur n'a pas de délai}}</label>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
			
			<div class="tab-pane" id="tab_zones">
				<br/>
				<div class="alert alert-info">{{Une zone décrit les capteurs que l'alarme doit surveiller ainsi que les actions à faire en cas de déclenchement.}}
					<a class="btn btn-success btn-xs pull-right" id="bt_addZone"><i class="fas fa-plus-circle"></i> {{Ajouter zone}}</a>
					<br/>
				</div>
				<div class="panel-group" id="div_zones"></div>
			</div>
			
			<div class="tab-pane" id="tab_modes">
				<br/>
				<div class="alert alert-info">{{Les modes permettent d'activer les zones. Il vous en faut absolument un.}}
					<a class="btn btn-success btn-xs pull-right" id="bt_addMode"><i class="fas fa-plus-circle"></i> {{Ajouter mode}}</a>
				</div>
				<div id="div_modes"></div>
			</div>
			
			<div class="tab-pane" id="tab_raz">
				<br/>
				<div class="alert alert-info">{{C'est ici que vous devez mettre les actions à faire lorsque l’alarme est déclenchée puis désactivée}}
					<div class="input-group pull-right" style="display:inline-flex">
						<span class="input-group-btn">
							<a class='btn btn-warning btn-xs roundedLeft' id="btn_addRazImmediateAlarm"><i class="fas fa-plus-circle"></i> {{Ajouter réinitialisation immédiate}}</a><a class='btn btn-success btn-xs roundedRight' id="btn_addRazAlarm"><i class="fas fa-plus-circle"></i> {{Ajouter réinitialisation}}</a>
						</span>
					</div>
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
					<a class='btn btn-success btn-xs pull-right' id="btn_addReleaseAlarm"><i class="fas fa-plus-circle"></i> {{Ajouter action de désactivation OK}}</a>
				</div>
				<form class="form-horizontal">
					<div id="div_release"></div>
				</form>
			</div>
			
			<div class="tab-pane" id="tab_activeOk">
				<br/>
				<div class="alert alert-info">{{C'est ici que vous devez mettre les actions à faire lors d'une activation réussie de l'alarme}}
					<div class="input-group pull-right" style="display:inline-flex">
						<span class="input-group-btn">
							<a class='btn btn-warning btn-xs roundedLeft' id="btn_addActionActivationImmediateOk"><i class="fas fa-plus-circle"></i> {{Ajouter action immediate lors de l'activation}}</a><a class='btn btn-success btn-xs roundedRight' id="btn_addActionActivationOk"><i class="fas fa-plus-circle"></i> {{Ajouter action lors de l'activation}}</a>
						</span>
					</div>
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
					<div class="input-group pull-right" style="display:inline-flex">
						<span class="input-group-btn">
							<a class='btn btn-warning btn-xs roundedLeft' id="btn_addActionOutbreakImmediate"><i class="fas fa-plus-circle"></i> {{Ajouter action immediate de déclenchement}}</a><a class='btn btn-danger btn-xs roundedRight' id="btn_addActionOutbreak"><i class="fas fa-plus-circle"></i> {{Ajouter action de déclenchement}}</a>
						</span>
					</div>
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
				<div class="alert alert-info">{{Ici que vous devez mettre les actions à faire lorsque l'activation de l'alarme a échoué ou est partielle}}
					<div class="input-group pull-right" style="display:inline-flex">
						<span class="input-group-btn">
							<a class='btn btn-success btn-xs roundedLeft' id="btn_addActionReenableTrigger"><i class="fas fa-plus-circle"></i> {{Ajouter action lors de la reprise de la surveillance}}</a><a class='btn btn-warning btn-xs roundedRight' id="btn_addActionActivationKo"><i class="fas fa-plus-circle"></i> {{Ajouter action lors de l'echec d'activation}}</a>
						</span>
					</div>
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
				<button type="button" class="close" data-dismiss="modal">&times;</button>
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
				<a class="btn btn-danger" data-dismiss="modal"><i class="fas fa-minus-circle"></i> {{Annuler}}</a>
				<a class="btn btn-success" id="bt_addZoneModeOk"><i class="fas fa-check-circle"></i> {{Valider}}</a>
			</div>
		</div>
	</div>
</div>

<?php include_file('desktop', 'alarm', 'js', 'alarm');?>
<?php include_file('core', 'plugin.template', 'js');?>
