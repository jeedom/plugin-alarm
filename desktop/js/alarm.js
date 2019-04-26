
/* This file is part of Jeedom.
*
* Jeedom is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* Jeedom is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
*/
$("#div_raz").sortable({axis: "y", cursor: "move", items: ".raz", placeholder: "ui-state-highlight", tolerance: "intersect", forcePlaceholderSize: true});
$("#div_razImmediate").sortable({axis: "y", cursor: "move", items: ".razImmediate", placeholder: "ui-state-highlight", tolerance: "intersect", forcePlaceholderSize: true});
$("#div_release").sortable({axis: "y", cursor: "move", items: ".release", placeholder: "ui-state-highlight", tolerance: "intersect", forcePlaceholderSize: true});
$("#div_activationOk").sortable({axis: "y", cursor: "move", items: ".activationOk", placeholder: "ui-state-highlight", tolerance: "intersect", forcePlaceholderSize: true});
$("#div_activationKo").sortable({axis: "y", cursor: "move", items: ".activationKo", placeholder: "ui-state-highlight", tolerance: "intersect", forcePlaceholderSize: true});
$("#div_activationImmediateOk").sortable({axis: "y", cursor: "move", items: ".activationImmediateOk", placeholder: "ui-state-highlight", tolerance: "intersect", forcePlaceholderSize: true});
$("#div_releaseImmediate").sortable({axis: "y", cursor: "move", items: ".activationKo", placeholder: "ui-state-highlight", tolerance: "intersect", forcePlaceholderSize: true});
$("#div_release").sortable({axis: "y", cursor: "move", items: ".release", placeholder: "ui-state-highlight", tolerance: "intersect", forcePlaceholderSize: true});
$("#div_outbreakImmediate").sortable({axis: "y", cursor: "move", items: ".outbreakImmediate", placeholder: "ui-state-highlight", tolerance: "intersect", forcePlaceholderSize: true});
$("#div_outbreak").sortable({axis: "y", cursor: "move", items: ".outbreak", placeholder: "ui-state-highlight", tolerance: "intersect", forcePlaceholderSize: true});
$("#div_reenableTrigger").sortable({axis: "y", cursor: "move", items: ".reenableTrigger", placeholder: "ui-state-highlight", tolerance: "intersect", forcePlaceholderSize: true});

$('#tab_alarm a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})

$('#bt_addZone').off('click').on('click', function () {
  bootbox.prompt("{{Nom de la zone ?}}", function (result) {
    if (result !== null && result != '') {
      addZone({name: result});
    }
  });
});

$('body').off('click','.rename').on('click','.rename',  function () {
  var el = $(this);
  bootbox.prompt("{{Nouveau nom ?}}", function (result) {
    if (result !== null && result != '') {
      var previousName = el.text();
      el.text(result);
      el.closest('.panel.panel-default').find('span.name').text(result);
      if (el.hasClass('zoneAttr')) {
        $('.modeAttr[data-l1key=zone]').each(function () {
          if ($(this).text() == previousName) {
            $(this).text(result);
          }
        });
      }
    }
  });
});

$("#div_zones").off('click','.bt_removeZone').on('click','.bt_removeZone', function () {
  $(this).closest('.zone').remove();
});

$('#bt_addMode').off('click').on('click', function () {
  bootbox.prompt("{{Nom du mode ?}}", function (result) {
    if (result !== null && result != '') {
      addMode({name: result});
    }
  });
});

$("#div_modes").off('click','.bt_removeZoneMode').on('click','.bt_removeZoneMode',  function () {
  $(this).closest('.zoneMode').remove();
});

$("#div_modes").off('click','.bt_addZoneMode').on('click','.bt_addZoneMode',  function () {
  var el = $(this);
  var select = '<select class="form-control">';
  $('#div_zones .zone').each(function () {
    var zone = $(this).getValues('.zoneAttr');
    zone = zone[0];
    select += '<option>' + zone.name + '</option>';
  });
  select += '</select>';
  $('#md_addZoneModeSelect').empty().append(select);
  $("#md_addZoneMode").modal('show');
  $('#bt_addZoneModeOk').off();
  $('#bt_addZoneModeOk').on('click', function () {
    $("#md_addZoneMode").modal('hide');
    addZoneMode(el.closest('.mode'), {zone: $('#md_addZoneModeSelect').find('select').value()});
  });
});


$("#div_modes").off('click','.bt_removeMode').on('click','.bt_removeMode',  function () {
  $(this).closest('.mode').remove();
});

$("#div_zones").off('click','.bt_addAction').on('click','.bt_addAction',  function () {
  addAction({}, 'action', '{{Action}}', $(this).closest('.zone'));
});

$("#div_zones").off('click','.bt_addActionImmediate').on('click','.bt_addActionImmediate',  function () {
  addAction({}, 'actionImmediate', '{{Action immédiate}}', $(this).closest('.zone'));
});

$("#div_zones").off('click','.bt_addTrigger').on('click','.bt_addTrigger',  function () {
  addTrigger($(this).closest('.zone'), '');
});

$("#div_zones").off('click','.bt_removeTrigger').on('click','.bt_removeTrigger',  function () {
  $(this).closest('.trigger').remove();
});

$("#div_zones").off('click','.listCmdInfo').on('click','.listCmdInfo',  function () {
  var el = $(this).closest('.trigger').find('.triggerAttr[data-l1key=cmd]');
  jeedom.cmd.getSelectModal({cmd: {type: 'info', subType: 'binary'}}, function (result) {
    el.value(result.human);
  });
});

$('#div_zones').off('click','.bt_duplicateZone').on('click','.bt_duplicateZone',  function () {
  var zone = $(this).closest('.zone').clone();
  bootbox.prompt("{{Nom de la zone ?}}", function (result) {
    if (result !== null) {
      var random = Math.floor((Math.random() * 1000000) + 1);
      zone.find('a[data-toggle=collapse]').attr('href', '#collapse' + random);
      zone.find('.panel-collapse.collapse').attr('id', 'collapse' + random);
      zone.find('.zoneAttr[data-l1key=name]').html(result);
      zone.find('.name').html(result);
      $('#div_zones').append(zone);
      $('.collapse').collapse();
    }
  });
});

/**************** RAZ Alarm ***********/

$('#btn_addRazAlarm').off('click').on('click', function () {
  addAction({}, 'raz', '{{Réinitialisation}}');
});

$('#btn_addRazImmediateAlarm').off('click').on('click', function () {
  addAction({}, 'razImmediate', '{{Réinitialisation immédiate}}');
});

/**************** Release Alarm ***********/
$('#btn_addReleaseAlarm').off('click').on('click', function () {
  addAction({}, 'release', '{{Libération}}');
});


/**************Activation OK/KO**********************/

$('#btn_addActionActivationOk').off('click').on('click', function () {
  addAction({}, 'activationOk', '{{Action}}');
});

$('#btn_addActionActivationKo').off('click').on('click', function () {
  addAction({}, 'activationKo', '{{Action}}');
});


$('#btn_addActionReenableTrigger').off('click').on('click', function () {
  addAction({}, 'reenableTrigger', '{{Action}}');
});

$('#btn_addActionActivationImmediateOk').off('click').on('click', function () {
  addAction({}, 'activationImmediateOk', '{{Action Immediate}}');
});

/**************outbreak**********************/

$('#btn_addActionOutbreak').off('click').on('click', function () {
  addAction({}, 'outbreak', '{{Action}}');
});

$('#btn_addActionOutbreakImmediate').off('click').on('click', function () {
  addAction({}, 'outbreakImmediate', '{{Action}}');
});

/**************** Commun ***********/
$("body").off('click', '.listCmdAction').on('click', '.listCmdAction', function () {
  var type = $(this).attr('data-type');
  var el = $(this).closest('.' + type).find('.expressionAttr[data-l1key=cmd]');
  jeedom.cmd.getSelectModal({cmd: {type: 'action'}}, function (result) {
    el.value(result.human);
    jeedom.cmd.displayActionOption(el.value(), '', function (html) {
      el.closest('.' + type).find('.actionOptions').html(html);
      taAutosize();
    });
  });
});

$("body").off('click','.listAction').on('click','.listAction',  function () {
  var type = $(this).attr('data-type');
  var el = $(this).closest('.' + type).find('.expressionAttr[data-l1key=cmd]');
  jeedom.getSelectActionModal({}, function (result) {
    el.value(result.human);
    jeedom.cmd.displayActionOption(el.value(), '', function (html) {
      el.closest('.' + type).find('.actionOptions').html(html);
      taAutosize();
    });
  });
});

$("body").off('click', '.bt_removeAction').on('click', '.bt_removeAction', function () {
  var type = $(this).attr('data-type');
  $(this).closest('.' + type).remove();
});

$('body').off('focusout','.cmdAction.expressionAttr[data-l1key=cmd]').on('focusout','.cmdAction.expressionAttr[data-l1key=cmd]',  function (event) {
  var type = $(this).attr('data-type')
  var expression = $(this).closest('.' + type).getValues('.expressionAttr');
  var el = $(this);
  jeedom.cmd.displayActionOption($(this).value(), init(expression[0].options), function (html) {
    el.closest('.' + type).find('.actionOptions').html(html);
    taAutosize();
  })
});

$('.nav-tabs li a').off('click').on('click',function(){
  setTimeout(function(){
    taAutosize();
  }, 50);
})

function saveEqLogic(_eqLogic) {
  if (!isset(_eqLogic.configuration)) {
    _eqLogic.configuration = {};
  }
  _eqLogic.configuration.zones = [];
  $('#div_zones .zone').each(function () {
    var zone = $(this).getValues('.zoneAttr')[0];
    zone.actions = $(this).find('.action').getValues('.expressionAttr');
    zone.actionsImmediate = $(this).find('.actionImmediate').getValues('.expressionAttr');
    zone.triggers = $(this).find('.trigger').getValues('.triggerAttr');
    _eqLogic.configuration.zones.push(zone);
  });
  
  _eqLogic.configuration.modes = [];
  $('#div_modes .mode').each(function () {
    var mode = $(this).getValues('.modeAttr')[0];
    _eqLogic.configuration.modes.push(mode);
  });
  
  _eqLogic.configuration.release = $('#div_release .release').getValues('.expressionAttr');
  _eqLogic.configuration.raz = $('#div_raz .raz').getValues('.expressionAttr');
  _eqLogic.configuration.razImmediate = $('#div_razImmediate .razImmediate').getValues('.expressionAttr');
  _eqLogic.configuration.activationOk = $('#div_activationOk .activationOk').getValues('.expressionAttr');
  _eqLogic.configuration.activationKo = $('#div_activationKo .activationKo').getValues('.expressionAttr');
  _eqLogic.configuration.activationImmediateOk = $('#div_activationImmediateOk .activationImmediateOk').getValues('.expressionAttr');
  _eqLogic.configuration.outbreak = $('#div_outbreak .outbreak').getValues('.expressionAttr');
  _eqLogic.configuration.outbreakImmediate = $('#div_outbreakImmediate .outbreakImmediate').getValues('.expressionAttr');
  _eqLogic.configuration.reenableTrigger = $('#div_reenableTrigger .reenableTrigger').getValues('.expressionAttr');
  
  return _eqLogic;
}

function printEqLogic(_eqLogic) {
  actionOptions = []
  $('#div_zones').empty();
  $('#div_modes').empty();
  $('#div_raz').empty();
  $('#div_release').empty();
  $('#div_razImmediate').empty();
  $('#div_activationOk').empty();
  $('#div_activationImmediateOk').empty();
  $('#div_activationKo').empty();
  $('#div_outbreak').empty();
  $('#div_outbreakImmediate').empty();
  $('#div_reenableTrigger').empty();
  if (isset(_eqLogic.configuration)) {
    if (isset(_eqLogic.configuration.modes)) {
      for (var i in _eqLogic.configuration.modes) {
        addMode(_eqLogic.configuration.modes[i]);
      }
    }
    if (isset(_eqLogic.configuration.zones)) {
      for (var i in _eqLogic.configuration.zones) {
        addZone(_eqLogic.configuration.zones[i]);
      }
    }
    if (isset(_eqLogic.configuration.release)) {
      for (var i in _eqLogic.configuration.release) {
        addAction(_eqLogic.configuration.release[i], 'release', '{{Libération}}');
      }
    }
    if (isset(_eqLogic.configuration.raz)) {
      for (var i in _eqLogic.configuration.raz) {
        addAction(_eqLogic.configuration.raz[i], 'raz', '{{Réinitialisation}}');
      }
    }
    if (isset(_eqLogic.configuration.razImmediate)) {
      for (var i in _eqLogic.configuration.razImmediate) {
        addAction(_eqLogic.configuration.razImmediate[i], 'razImmediate', '{{Réinitialisation immédiate}}');
      }
    }
    if (isset(_eqLogic.configuration.activationOk)) {
      for (var i in _eqLogic.configuration.activationOk) {
        addAction(_eqLogic.configuration.activationOk[i], 'activationOk', '{{Action}}');
      }
    }
    if (isset(_eqLogic.configuration.activationImmediateOk)) {
      for (var i in _eqLogic.configuration.activationImmediateOk) {
        addAction(_eqLogic.configuration.activationImmediateOk[i], 'activationImmediateOk', '{{Action Immediate}}');
      }
    }
    if (isset(_eqLogic.configuration.activationKo)) {
      for (var i in _eqLogic.configuration.activationKo) {
        addAction(_eqLogic.configuration.activationKo[i], 'activationKo', '{{Action}}');
      }
    }
    if (isset(_eqLogic.configuration.reenableTrigger)) {
      for (var i in _eqLogic.configuration.reenableTrigger) {
        addAction(_eqLogic.configuration.reenableTrigger[i], 'reenableTrigger', '{{Action}}');
      }
    }
    if (isset(_eqLogic.configuration.outbreak)) {
      for (var i in _eqLogic.configuration.outbreak) {
        addAction(_eqLogic.configuration.outbreak[i], 'outbreak', '{{Action}}');
      }
    }
    if (isset(_eqLogic.configuration.outbreakImmediate)) {
      for (var i in _eqLogic.configuration.outbreakImmediate) {
        addAction(_eqLogic.configuration.outbreakImmediate[i], 'outbreakImmediate', '{{Action}}');
      }
    }
  }
  jeedom.cmd.displayActionsOption({
    params : actionOptions,
    async : false,
    error: function (error) {
      $('#div_alert').showAlert({message: error.message, level: 'danger'});
    },
    success : function(data){
      for(var i in data){
        $('#'+data[i].id).append(data[i].html.html);
      }
      taAutosize();
    }
  });
}

function addAction(_action, _type, _name, _el) {
  if (!isset(_action)) {
    _action = {};
  }
  if (!isset(_action.options)) {
    _action.options = {};
  }
  var input = '';
  var button = 'btn-default';
  if (_type == 'action') {
    input = 'has-error';
    button = 'btn-danger';
  }else if (_type == 'actionImmediate') {
    input = 'has-warning';
    button = 'btn-warning';
  }else if (_type == 'raz') {
    input = 'has-success';
    button = 'btn-success';
  }else if (_type == 'razImmediate') {
    input = 'has-warning';
    button = 'btn-warning';
  }else if (_type == 'activationOk') {
    input = 'has-success';
    button = 'btn-success';
  }else if (_type == 'activationKo') {
    input = 'has-warning';
    button = 'btn-warning';
  }else if (_type == 'activationImmediateOk') {
    input = 'has-warning';
    button = 'btn-warning';
  }else if (_type == 'outbreak') {
    input = 'has-error';
    button = 'btn-danger';
  }else if (_type == 'outbreakImmediate') {
    input = 'has-warning';
    button = 'btn-warning';
  }else if (_type == 'release') {
    input = 'has-success';
    button = 'btn-success';
  }else if (_type == 'reenableTrigger') {
    input = 'has-success';
    button = 'btn-success';
  }
  var div = '<div class="' + _type + '">';
  div += '<div class="form-group ">';
  div += '<label class="col-sm-1 control-label">' + _name + '</label>';
  div += '<div class="col-sm-2">';
  div += '<input type="checkbox" class="expressionAttr" data-l1key="options" data-l2key="enable" checked title="{{Décocher pour desactiver l\'action}}" />';
  div += '<input type="checkbox" class="expressionAttr" data-l1key="options" data-l2key="background" title="{{Cocher pour que la commande s\'éxecute en parrallele des autres actions}}" />';
  div += '<select class="expressionAttr form-control input-sm selectMode" data-l1key="onMode" style="width:calc(100% - 50px);display:inline-block">';
  div += '<option value="all">{{Tous les modes}}</option>';
  $('#div_modes .mode').each(function () {
    var mode = $(this).getValues('.modeAttr')[0];
    div += '<option value="'+mode.name+'">'+mode.name+'</option>';
  });
  
  div += '</select>';
  div += '</div>';
  div += '<div class="col-sm-4 ' + input + '">';
  div += '<div class="input-group">';
  div += '<span class="input-group-btn">';
  
  div += '<a class="btn btn-default bt_removeAction btn-sm roundedLeft" data-type="' + _type + '"><i class="fa fa-minus-circle"></i></a>';
  div += '</span>';
  div += '<input class="expressionAttr form-control input-sm cmdAction" data-l1key="cmd" data-type="' + _type + '" />';
  div += '<span class="input-group-btn">';
  div += '<a class="btn ' + button + ' btn-sm listAction" data-type="' + _type + '" title="{{Sélectionner un mot-clé}}"><i class="fa fa-tasks"></i></a>';
  div += '<a class="btn ' + button + ' btn-sm listCmdAction roundedRight" data-type="' + _type + '"><i class="fa fa-list-alt"></i></a>';
  div += '</span>';
  div += '</div>';
  div += '</div>';
  var actionOption_id = uniqId();
  div += '<div class="col-sm-5 actionOptions" id="'+actionOption_id+'">';
  div += '</div>';
  div += '</div>';
  if (isset(_el)) {
    _el.find('.div_' + _type).append(div);
    _el.find('.' + _type + ':last').setValues(_action, '.expressionAttr');
  } else {
    $('#div_' + _type).append(div);
    $('#div_' + _type + ' .' + _type + ':last').setValues(_action, '.expressionAttr');
  }
  actionOptions.push({
    expression : init(_action.cmd, ''),
    options : _action.options,
    id : actionOption_id
  });
}

function updateSelectMode(){
  $('select.selectMode').each(function () {
    var value = $(this).val();
    $(this).empty();
    var options = '<option value="all">{{Tous les modes}}</option>';
    $('#div_modes .mode').each(function () {
      var mode = $(this).getValues('.modeAttr')[0];
      options += '<option value="'+mode.name+'">'+mode.name+'</option>';
    });
    $(this).append(options);
    $(this).val(value);
  });
}

function addTrigger(_el, _trigger) {
  if (!isset(_trigger)) {
    _trigger = {};
  }
  var div = '<div class="trigger">';
  div += '<div class="form-group">';
  div += '<label class="col-sm-1 control-label">{{Déclencheur}}</label>';
  div += '<div class="col-sm-3 has-success">';
  div += '<div class="input-group">';
  div += '<span class="input-group-btn">';
  div += '<input type="checkbox" class="triggerAttr" data-l1key="enable" checked />';
  div += '<a class="btn btn-default bt_removeTrigger btn-sm roundedLeft"><i class="fa fa-minus-circle"></i></a>';
  div += '</span>';
  div += '<input class="triggerAttr form-control input-sm" data-l1key="cmd" />';
  div += '<span class="input-group-btn">';
  div += '<a class="btn btn-sm listCmdInfo btn-success roundedRight"><i class="fa fa-list-alt"></i></a>';
  div += '</span>';
  div += '</div>';
  div += '</div>';
  div += '<div class="col-sm-1 has-success">';
  div += '<label><input type="checkbox" class="triggerAttr checkbox-inline" data-l1key="invert" />{{Inverser}}</label>';
  div += '</div>';
  div += '<label class="col-sm-1 control-label">{{Maintient (s)}}</label>';
  div += '<div class="col-sm-1 has-success">';
  div += '<input class="triggerAttr form-control input-sm" data-l1key="triggerHold" value="0" />';
  div += '</div>';
  div += '<label class="col-sm-1 control-label">{{Activation (min pleine)}}</label>';
  div += '<div class="col-sm-1 has-success">';
  div += '<input class="triggerAttr form-control input-sm" data-l1key="armedDelay" />';
  div += '</div>';
  div += '<label class="col-sm-1 control-label">{{Déclenchement (min, décimal possible)}}</label>';
  div += '<div class="col-sm-1 has-success">';
  div += '<input class="triggerAttr form-control input-sm" data-l1key="waitDelay" />';
  div += '</div>';
  
  div += '</div>';
  _el.find('.div_triggers').append(div);
  _el.find('.trigger:last').setValues(_trigger, '.triggerAttr');
}

function addZone(_zone) {
  if (init(_zone.name) == '') {
    return;
  }
  var random = Math.floor((Math.random() * 1000000) + 1);
  var div = '<div class="zone panel panel-default">';
  div += '<div class="panel-heading">';
  div += '<h4 class="panel-title">';
  div += '<a data-toggle="collapse" data-parent="#div_zones" href="#collapse' + random + '">';
  div += '<span class="name">' + _zone.name + '</span>';
  div += '</a>';
  div += '</h4>';
  div += '</div>';
  div += '<div id="collapse' + random + '" class="panel-collapse collapse in">';
  div += '<div class="panel-body">';
  
  div += '<div class="well">';
  div += '<form class="form-horizontal" role="form">';
  div += '<div class="form-group">';
  div += '<label class="col-sm-1 control-label">{{Nom de la zone}}</label>';
  div += '<div class="col-sm-2">';
  div += '<span class="zoneAttr label label-info rename cursor" data-l1key="name" style="font-size : 1em;" ></span>';
  div += '</div>';
  div += '<div class="col-sm-9">';
  div += '<div class="btn-group pull-right" role="group">';
  div += '<a class="btn btn-sm bt_removeZone btn-primary"><i class="fa fa-minus-circle"></i> {{Supprimer}}</a>';
  div += '<a class="btn btn-sm bt_addAction btn-danger"><i class="fa fa-plus-circle"></i> {{Action}}</a>';
  div += '<a class="btn btn-warning btn-sm bt_addActionImmediate"><i class="fa fa-plus-circle"></i> {{Action immédiate}}</a>';
  div += '<a class="btn btn-sm bt_addTrigger btn-success"><i class="fa fa-plus-circle"></i> {{Déclencheur}}</a>';
  div += '<a class="btn btn-sm bt_duplicateZone btn-default"><i class="fa fa-files-o"></i> {{Dupliquer}}</a>';
  div += '</div>';
  div += '</div>';
  div += '</div>';
  div += '<div class="div_triggers"></div>';
  div += '<hr/>';
  div += '<div class="div_actionImmediate"></div>';
  div += '<hr/>';
  div += '<div class="div_action"></div>';
  div += '</form>';
  div += '</div>';
  
  div += '</div>';
  div += '</div>';
  div += '</div>';
  
  $('#div_zones').append(div);
  $('#div_zones .zone:last').setValues(_zone, '.zoneAttr');
  if (is_array(_zone.actions)) {
    for (var i in _zone.actions) {
      addAction(_zone.actions[i], 'action', '{{Action}}', $('#div_zones .zone:last'));
    }
  } else {
    if ($.trim(_zone.actions) != '') {
      addAction(_zone.actions[i], 'action', '{{Action}}', $('#div_zones .zone:last'));
    }
  }
  
  if (is_array(_zone.actionsImmediate)) {
    for (var i in _zone.actionsImmediate) {
      addAction(_zone.actionsImmediate[i], 'actionImmediate', '{{Action immédiate}}', $('#div_zones .zone:last'));
    }
  } else {
    if ($.trim(_zone.actionsImmediate) != '') {
      addAction(_zone.actionsImmediate, 'actionImmediate', '{{Action immédiate}}', $('#div_zones .zone:last'));
    }
  }
  
  if (is_array(_zone.triggers)) {
    for (var i in _zone.triggers) {
      addTrigger($('#div_zones .zone:last'), _zone.triggers[i]);
    }
  } else {
    if ($.trim(_zone.triggers) != '') {
      addTrigger($('#div_zones .zone:last'), _zone.triggers);
    }
  }
  
  $('.collapse').collapse();
  $("#div_zones .zone:last .div_action").sortable({axis: "y", cursor: "move", items: ".action", placeholder: "ui-state-highlight", tolerance: "intersect", forcePlaceholderSize: true});
  $("#div_zones .zone:last .div_actionImmediate").sortable({axis: "y", cursor: "move", items: ".actionImmediate", placeholder: "ui-state-highlight", tolerance: "intersect", forcePlaceholderSize: true});
}

function addMode(_mode) {
  var div = '<div class="mode well">';
  div += '<form class="form-horizontal" role="form">';
  div += '<div class="form-group">';
  div += '<label class="col-sm-1 control-label">{{Nom du mode}}</label>';
  div += '<div class="col-sm-2">';
  div += '<span class="modeAttr label label-info rename cursor" data-l1key="name" style="font-size : 1em;"></span>';
  div += '</div>';
  div += '<div class="col-sm-2 col-sm-offset-7">';
  div += '<i class="fa fa-minus-circle pull-right cursor bt_removeMode"></i>';
  div += '<a class="btn btn-default btn-sm bt_addZoneMode pull-right"><i class="fa fa-plus-circle"></i> {{Zone}}</a>';
  
  div += '</div>';
  div += '</div>';
  div += '<div class="div_zonesMode">';
  div += '</div>';
  div += '</form>';
  div += '</div>';
  $('#div_modes').append(div);
  $('#div_modes .mode:last').setValues(_mode, '.modeAttr');
  
  if (is_array(_mode.zone)) {
    for (var i in _mode.zone) {
      if (_mode.zone[i] != '') {
        addZoneMode($('#div_modes .mode:last'), {zone: _mode.zone[i]});
      }
    }
  } else {
    if ($.trim(_mode.zone) != '') {
      addZoneMode($('#div_modes .mode:last'), {zone: _mode.zone});
    }
  }
  updateSelectMode();
}

function addZoneMode(_el, _mode) {
  if (!isset(_mode)) {
    _mode = {};
  }
  var div = '<div class="zoneMode">';
  div += '<div class="form-group">';
  div += '<label class="col-sm-1 control-label">{{Zone}}</label>';
  div += '<div class="col-sm-3">';
  div += '<span class="modeAttr label label-primary" data-l1key="zone" style="font-size : 1em;"></span>';
  div += '</div>';
  div += '<div class="col-sm-1 col-sm-offset-7">';
  div += '<i class="fa fa-minus-circle pull-right cursor bt_removeZoneMode"></i>';
  div += '</div>';
  div += '</div>';
  
  _el.find('.div_zonesMode').append(div);
  _el.find('.zoneMode:last').setValues(_mode, '.modeAttr');
}
