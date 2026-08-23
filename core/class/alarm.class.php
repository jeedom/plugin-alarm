<?php

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

/* * ***************************Includes********************************* */
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

class alarm extends eqLogic {
	/*     * *************************Attributs****************************** */

	/*     * ***********************Methode static*************************** */

	public static function pull($_option) {
		$alarm = alarm::byId($_option['alarm_id']);
		if (is_object($alarm) && $alarm->getIsEnable() == 1) {
			$cmd_armed = $alarm->getCmd(null, 'enable');
			if (is_object($cmd_armed) && $cmd_armed->execCmd() == 1) {
				$alarm->execute($_option['event_id'], $_option['value']);
			}
		}
	}

	public static function checkDetector($_params) {
		$eqLogic = eqLogic::byId($_params['alarm_id']);
		if (!is_object($eqLogic)) {
			return;
		}
		log::add('alarm', 'debug',$eqLogic->getHumanName(). __('Lancement de la vérification des detecteurs post activation', __FILE__));
		$cmd_armed = $eqLogic->getCmd(null, 'enable');
		$cmd_state = $eqLogic->getCmd(null, 'state');
		if (!is_object($cmd_armed) || !is_object($cmd_state) || $cmd_armed->execCmd() != 1 || ($cmd_state->execCmd() != 0 && $eqLogic->getConfiguration('autorearm', 0) != 1)) {
			return;
		}
		$cmd = cmd::byId($_params['cmd_id']);
		if (!is_object($cmd)) {
			return;
		}
		if (isset($_params['delay']) && $_params['delay'] > 0) {
			sleep($_params['delay']);
		}
		$cmd_mode = $eqLogic->getCmd(null, 'mode');
		$select_mode = $cmd_mode->execCmd();
		$zones = $eqLogic->getZoneOfMode($select_mode);
		$disable_trigger = array();
		$disable_zone_trigger = array();
		foreach ($zones as $zone) {
			log::add('alarm', 'debug',$eqLogic->getHumanName(). __('[checkDetector] Vérification de la zone : ', __FILE__) . $zone['name']);
			foreach ($zone['triggers'] as $trigger) {
				if ($trigger['cmd'] != '#' . $cmd->getId() . '#') {
					continue;
				}
				if (isset($trigger['enable']) && $trigger['enable'] == 0) {
					continue;
				}
				log::add('alarm', 'debug',$eqLogic->getHumanName(). __('[checkDetector] Verification de ', __FILE__) . $cmd->getHumanName());
				$result = $cmd->execCmd();
				if (isset($trigger['invert']) && $trigger['invert'] == 1) {
					$result = ($result == 1 || $result) ? 0 : 1;
				}
				log::add('alarm', 'debug', $eqLogic->getHumanName().__('[checkDetector] Valeur ', __FILE__) . $result);
				if ($result != 1) {
					log::add('alarm', 'debug',$eqLogic->getHumanName(). __('[checkDetector] Aucune alerte, rien à faire', __FILE__));
					continue;
				}
				if (isset($trigger['armedDelay'])) {
					$armedDelay = jeedom::evaluateExpression($trigger['armedDelay']);
				}
				if (!isset($trigger['armedDelay']) || $trigger['armedDelay'] === '' || !is_numeric(intval($armedDelay)) || $armedDelay == 0) {
					log::add('alarm', 'debug',$eqLogic->getHumanName(). __('[checkDetector] Delai vide ou non valide, rien à faire', __FILE__));
					continue;
				}
				if (strtotime('now') > (strtotime($cmd_armed->getCollectDate()) + $armedDelay * 60 + 60)) {
					log::add('alarm', 'debug',$eqLogic->getHumanName(). __('[checkDetector] Delai depassé, rien à faire', __FILE__));
					continue;
				}
				if ((strtotime($cmd_armed->getCollectDate()) + $armedDelay * 60) - strtotime('now') > 0) {
					sleep((strtotime($cmd_armed->getCollectDate()) + $armedDelay * 60) - strtotime('now'));
				}
				$result = $cmd->execCmd();
				if (isset($trigger['invert']) && $trigger['invert'] == 1) {
					$result = ($result == 1 || $result) ? 0 : 1;
				}
				log::add('alarm', 'debug',$eqLogic->getHumanName(). __('[checkDetector] Valeur ', __FILE__) . $result);
				if ($result == 0) {
					log::add('alarm', 'debug',$eqLogic->getHumanName(). __('[checkDetector] Plus d\'alerte, rien à faire', __FILE__));
					continue;
				}
				$disable_trigger[$cmd->getId()] = $cmd->getHumanName();
				$disable_zone_trigger[$zone['name']] = $zone['name'];
				log::add('alarm', 'debug',$eqLogic->getHumanName(). __('[checkDetector] Commande active, j\'ai du boulot', __FILE__));
			}
		}
		$eqLogic->setCache('disable_trigger', $eqLogic->getCache('disable_trigger', array()) + $disable_trigger);
		if (count($disable_trigger) > 0) {
			log::add('alarm', 'debug',$eqLogic->getHumanName(). __('Déclencheur désactivé : ', __FILE__) . print_r($disable_trigger, true));
			log::add('alarm', 'debug',$eqLogic->getHumanName(). __('Lancement des actions d\'activation ko', __FILE__));
			$eqLogic->doAction('activationKo', array('#mode#' => $select_mode, '#alarm_trigger#' => implode(',', $disable_trigger), '#zone#' => implode(',', $disable_zone_trigger)));
		}
	}

	public static function armedComplete($_params) {
		$eqLogic = eqLogic::byId($_params['alarm_id']);
		if (is_object($eqLogic)) {
			$cmd_armed = $eqLogic->getCmd(null, 'enable');
			$cmd_state = $eqLogic->getCmd(null, 'state');
			if (!is_object($cmd_armed) || !is_object($cmd_state) || $cmd_armed->execCmd() != 1 || $cmd_state->execCmd() != 0) {
				return;
			}
			if (isset($_params['delay']) && $_params['delay'] > 0) {
				sleep($_params['delay']);
			}
			$disable_trigger = $eqLogic->getCache('disable_trigger', array());
			if (count($disable_trigger) > 0) {
				return;
			}
			log::add('alarm', 'debug',$eqLogic->getHumanName(). __('Activation OK éxécution des actions', __FILE__));
			$eqLogic->doAction('activationOk');
		}
	}

	public static function deadCmd() {
		$return = array();
		foreach (eqLogic::byType('alarm') as $alarm) {
			foreach ($alarm->getConfiguration('zones', array()) as $zone) {
				$name = isset($zone['name']) ? $zone['name'] : '';
				foreach ($zone['actions'] as $action) {
					if (isset($action['cmd'])) {
						preg_match_all("/#([0-9]*)#/", $action['cmd'], $matches);
						foreach ($matches[1] as $cmd_id) {
							if (is_numeric($cmd_id)) {
								if (!cmd::byId(str_replace('#', '', $cmd_id))) {
									$return[] = array('detail' => 'Alarme ' . $alarm->getHumanName(), 'help' => 'Zone ' . $name . ' - Action', 'who' => '#' . $cmd_id . '#');
								}
							}
						}
					}
				}
				foreach ($zone['actionsImmediate'] as $action) {
					if (isset($action['cmd'])) {
						preg_match_all("/#([0-9]*)#/", $action['cmd'], $matches);
						foreach ($matches[1] as $cmd_id) {
							if (is_numeric($cmd_id)) {
								if (!cmd::byId(str_replace('#', '', $cmd_id))) {
									$return[] = array('detail' => 'Alarme ' . $alarm->getHumanName(), 'help' => 'Zone ' . $name . ' - Action Immédiate', 'who' => '#' . $cmd_id . '#');
								}
							}
						}
					}
				}
				foreach ($zone['triggers'] as $trigger) {
					if (isset($trigger['cmd'])) {
						preg_match_all("/#([0-9]*)#/", $trigger['cmd'], $matches);
						foreach ($matches[1] as $cmd_id) {
							if (is_numeric($cmd_id)) {
								if (!cmd::byId(str_replace('#', '', $cmd_id))) {
									$return[] = array('detail' => 'Alarme ' . $alarm->getHumanName(), 'help' => 'Zone ' . $name . ' - Déclencheur', 'who' => '#' . $cmd_id . '#');
								}
							}
						}
					}
				}
			}
		}
		return $return;
	}

	/*     * *********************Methode d'instance************************* */

	public function preInsert() {
		$this->setCategory('security', 1);
	}

	public function postSave() {
		$cmdArmed = $this->getCmd(null, 'enable');
		if (!is_object($cmdArmed)) {
			$cmdArmed = new alarmCmd();
			$cmdArmed->setOrder(1);
			$cmdArmed->setTemplate('dashboard', 'lock');
			$cmdArmed->setTemplate('mobile', 'lock');
		}
		$cmdArmed->setName(__('Actif', __FILE__));
		$cmdArmed->setEqLogic_id($this->getId());
		$cmdArmed->setLogicalId('enable');
		$cmdArmed->setType('info');
		$cmdArmed->setSubType('binary');
		$cmdArmed->setIsVisible(1 - $this->getConfiguration('armed_visible',0));
		$cmdArmed->setIsHistorized($this->getConfiguration('historizedState'));
		$cmdArmed->setDisplay('generic_type', 'ALARM_ENABLE_STATE');
		$cmdArmed->save();

		$statePause = $this->getCmd(null, 'statePause');
		if (!is_object($statePause)) {
			$statePause = new alarmCmd();
			$statePause->setOrder(2);
			$statePause->setIsVisible(0);
			$statePause->setLogicalId('statePause');
		}
		$statePause->setName(__('Statut pause', __FILE__));
		$statePause->setEqLogic_id($this->getId());
		$statePause->setType('info');
		$statePause->setSubType('binary');
		$statePause->setIsHistorized($this->getConfiguration('historizedState'));
		$statePause->save();

		$cmdPauseOn = $this->getCmd(null, 'pauseOn');
		if (!is_object($cmdPauseOn)) {
			$cmdPauseOn = new alarmCmd();
			$cmdPauseOn->setOrder(5);
			$cmdPauseOn->setLogicalId('pauseOn');
			$cmdPauseOn->setIsVisible(0);
		}
		$cmdPauseOn->setName(__('Pause', __FILE__));
		$cmdPauseOn->setEqLogic_id($this->getId());
		$cmdPauseOn->setType('action');
		$cmdPauseOn->setSubType('other');
		$cmdPauseOn->setValue($statePause->getId());
		$cmdPauseOn->save();

		$cmdPauseOff = $this->getCmd(null, 'pauseOff');
		if (!is_object($cmdPauseOff)) {
			$cmdPauseOff = new alarmCmd();
			$cmdPauseOff->setOrder(5);
			$cmdPauseOff->setLogicalId('pauseOff');
			$cmdPauseOff->setIsVisible(0);
		}
		$cmdPauseOff->setName(__('Reprise', __FILE__));
		$cmdPauseOff->setEqLogic_id($this->getId());
		$cmdPauseOff->setType('action');
		$cmdPauseOff->setSubType('other');
		$cmdPauseOff->setValue($statePause->getId());
		$cmdPauseOff->save();

		$cmdState = $this->getCmd(null, 'state');
		if (!is_object($cmdState)) {
			$cmdState = new alarmCmd();
			$cmdState->setTemplate('dashboard', 'alert');
			$cmdState->setTemplate('mobile', 'alert');
			$cmdState->setOrder(2);
		}
		$cmdState->setDisplay('invertBinary', 1);
		$cmdState->setName(__('Statut', __FILE__));
		$cmdState->setEqLogic_id($this->getId());
		$cmdState->setLogicalId('state');
		$cmdState->setType('info');
		$cmdState->setSubType('binary');
		$cmdState->setDisplay('generic_type', 'ALARM_STATE');
		$cmdState->setIsHistorized($this->getConfiguration('historizedState'));
		$cmdState->save();

		$cmdImmediatState = $this->getCmd(null, 'immediatState');
		if (!is_object($cmdImmediatState)) {
			$cmdImmediatState = new alarmCmd();
			$cmdImmediatState->setTemplate('dashboard', 'alert');
			$cmdImmediatState->setTemplate('mobile', 'alert');
			$cmdImmediatState->setorder(2);
		}
		$cmdImmediatState->setDisplay('invertBinary', 1);
		$cmdImmediatState->setName(__('Immédiat', __FILE__));
		$cmdImmediatState->setLogicalId('immediatState');
		$cmdImmediatState->setEqLogic_id($this->getId());
		$cmdImmediatState->setType('info');
		$cmdImmediatState->setSubType('binary');
		$cmdImmediatState->setIsVisible($this->getConfiguration('immediateState_visible',1));
		$cmdImmediatState->setIsHistorized($this->getConfiguration('historizedState'));
		$cmdImmediatState->save();

		$mode = $this->getCmd(null, 'mode');
		if (!is_object($mode)) {
			$mode = new alarmCmd();
			$mode->setTemplate('dashboard', 'lock');
			$mode->setTemplate('mobile', 'lock');
			$mode->setName(__('Mode', __FILE__));
			$mode->setorder(3);
		}
		$mode->setConfiguration('repeatEventManagement', 'always');
		$mode->setEqLogic_id($this->getId());
		$mode->setType('info');
		$mode->setDisplay('generic_type', 'ALARM_MODE');
		$mode->setLogicalId('mode');
		$mode->setSubType('string');
		$mode->save();

		$existing_mode = array();
		if (is_array($this->getConfiguration('modes'))) {
			foreach ($this->getConfiguration('modes') as $key => $value) {
				if(in_array($value['name'],array(__('Actif', __FILE__),__('Statut pause', __FILE__),__('Pause', __FILE__),__('Reprise', __FILE__),__('Statut', __FILE__),__('Immédiat', __FILE__),__('Mode', __FILE__),__('Activer', __FILE__),__('Désactiver', __FILE__)))){
					throw new \Exception(__('Vous ne pouvez avoir un mode avec le nom : ',__FILE__).$value['name']);
				}
				$existing_mode[] = $value['name'];
				$cmd = null;
				foreach ($this->getCmd() as $cmd_list) {
					if ($cmd_list->getName() == $value['name']) {
						$cmd = $cmd_list;
						break;
					}
				}
				if ($cmd == null) {
					$cmd = new alarmCmd();
					$cmd->setorder(4);
				}
				$cmd->setName($value['name']);
				$cmd->setEqLogic_id($this->getId());
				$cmd->setType('action');
				$cmd->setSubType('other');
				$cmd->setConfiguration('mode', '1');
				$cmd->setConfiguration('state', $value['name']);
				$cmd->setDisplay('generic_type', 'ALARM_SET_MODE');
				if (is_object($mode)) {
					$cmd->setValue($mode->getId());
				}
				$cmd->save();
			}
		}
		if ($this->getIsEnable() == 1) {
			if (is_object($mode) && ($mode->execCmd() == '' || !in_array($mode->execCmd(),$existing_mode)) && isset($value)) {
				$mode->event($value['name']);
			}
		}

		$armed = $this->getCmd(null, 'armed');
		if (!is_object($armed)) {
			$armed = new alarmCmd();
			$armed->setTemplate('dashboard', 'lock');
			$armed->setTemplate('mobile', 'lock');
			$armed->setorder(0);
		}
		$armed->setName(__('Activer', __FILE__));
		$armed->setEqLogic_id($this->getId());
		$armed->setType('action');
		$armed->setLogicalId('armed');
		$armed->setSubType('other');
		$armed->setConfiguration('state', '1');
		$armed->setConfiguration('armed', '1');
		$armed->setValue($this->getCmd(null, 'enable')->getId());
		$armed->setDisplay('generic_type', 'ALARM_ARMED');
		if ($this->getConfiguration('always_active') == 1) {
			$armed->setIsVisible(0);
		} else {
			$armed->setIsVisible($this->getConfiguration('armed_visible', 1));
		}
		$armed->save();

		$released = $this->getCmd(null, 'released');
		if (!is_object($released)) {
			$released = new alarmCmd();
			$released->setTemplate('dashboard', 'lock');
			$released->setTemplate('mobile', 'lock');
			$released->setorder(0);
		}
		$released->setName(__('Désactiver', __FILE__));
		$released->setEqLogic_id($this->getId());
		$released->setType('action');
		$released->setLogicalId('released');
		$released->setSubType('other');
		$released->setConfiguration('state', '0');
		$released->setConfiguration('armed', '1');
		$released->setValue($this->getCmd(null, 'enable')->getId());
		$released->setDisplay('generic_type', 'ALARM_RELEASED');
		if ($this->getConfiguration('always_active') == 1) {
			$released->setIsVisible(0);
		} else {
			$released->setIsVisible($this->getConfiguration('armed_visible', 1));
		}
		$released->save();

		foreach ($this->getCmd() as $cmd) {
			if ($cmd->getType() == 'action' && !in_array($cmd->getName(), $existing_mode) &&
			$cmd->getLogicalId() != 'mode' && $cmd->getLogicalId() != 'released' && $cmd->getLogicalId() != 'armed' && $cmd->getLogicalId() != 'pauseOn' && $cmd->getLogicalId() != 'pauseOff') {
				$cmd->remove();
			}
		}

		if ($this->getConfiguration('always_active') == 1) {
			$this->getCmd(null, 'enable')->event(1);
		}

		if ($this->getIsEnable() == 1) {
			$listener = listener::byClassAndFunction('alarm', 'pull', array('alarm_id' => intval($this->getId())));
			if (!is_object($listener)) {
				$listener = new listener();
			}
			$listener->setClass('alarm');
			$listener->setFunction('pull');
			$listener->setOption(array('alarm_id' => intval($this->getId())));
			$listener->emptyEvent();
			$zones = $this->getConfiguration('zones');
			foreach ($zones as $zone) {
				foreach ($zone['triggers'] as $trigger) {
					if (isset($trigger['enable']) && $trigger['enable'] == 0) {
						continue;
					}
					$cmd = cmd::byId(str_replace('#', '', $trigger['cmd']));
					if (!is_object($cmd)) {
						continue;
					}
					$listener->addEvent($trigger['cmd']);
				}
			}
			$listener->save();
		} else {
			$listener = listener::byClassAndFunction('alarm', 'pull', array('alarm_id' => intval($this->getId())));
			if (is_object($listener)) {
				$listener->remove();
			}
		}
	}

	public function preRemove() {
		$listener = listener::byClassAndFunction('alarm', 'pull', array('alarm_id' => intval($this->getId())));
		if (is_object($listener)) {
			$listener->remove();
		}
	}

	public function postUpdate() {
		if ($this->getIsEnable() == 1) {
			$cmd_state = $this->getCmd(null, 'state');
			if (is_object($cmd_state) && $cmd_state->execCmd() == '') {
				$cmd_state->event(0);
			}
			$cmd_immediatState = $this->getCmd(null, 'immediatState');
			if (is_object($cmd_immediatState) && $cmd_immediatState->execCmd() == '') {
				$cmd_immediatState->event(0);
			}
			$cmd_armed = $this->getCmd(null, 'enable');
			if (is_object($cmd_armed) && $cmd_armed->execCmd() == '') {
				$cmd_armed->event(0);
			}
		}
	}

	public function getZoneOfMode($_select_mode) {
		$modes = $this->getConfiguration('modes');
		$zones = $this->getConfiguration('zones');
		$return = array();
		foreach ($modes as $mode) {
			if ($mode['name'] == $_select_mode) {
				if(!isset($mode['zone'])){
					return $return;
				}
				foreach ($zones as $zone) {
					if (!is_array($mode['zone'])) {
						if (trim($zone['name']) == trim($mode['zone'])) {
							$return[] = $zone;
						}
					} else {
						foreach ($mode['zone'] as $mzone) {
							if (trim($zone['name']) == trim($mzone)) {
								$return[] = $zone;
							}
						}
					}
				}
			}
		}
		return $return;
	}

	public function listCmdTrigger($_trigger_id = null) {
		$result = array();
		if ($_trigger_id !== null) {
			$cmd = cmd::byId(str_replace('#', '', $_trigger_id));
			if (is_object($cmd)) {
				$result[$cmd->getId()] = str_replace('#', '', $cmd->getHumanName());
			}
		}
		$zones = $this->getZoneOfMode($this->getCmd(null, 'mode')->execCmd());
		foreach ($zones as $zone) {
			foreach ($zone['triggers'] as $trigger) {
				if (isset($trigger['enable']) && $trigger['enable'] == 0) {
					continue;
				}
				$cmd = cmd::byId(str_replace('#', '', $trigger['cmd']));
				if (is_object($cmd)) {
					$value = $cmd->execCmd();
					if (isset($trigger['invert']) && $trigger['invert'] == 1) {
						$value = ($value == 1 || $value) ? 0 : 1;
					}
					if ($value == 1 || $value) {
						$result[$cmd->getId()] = str_replace('#', '', $cmd->getHumanName());
					}
				}
			}
		}
		return $result;
	}

	public function execute($_trigger_id, $_value) {
		log::add('alarm', 'debug',$this->getHumanName().' '. __('Lancement de l\'alarme : ', __FILE__) . $this->getHumanName());
		$cmd_state_pause = $this->getCmd(null, 'statePause');
		if ($cmd_state_pause->execCmd() == 1) {
			log::add('alarm', 'debug',$this->getHumanName().' '. __('L\'alarme est en pause', __FILE__) . $this->getHumanName());
			return;
		}
		$cmd_armed = $this->getCmd(null, 'enable');
		$cmd_state = $this->getCmd(null, 'state');
		log::add('alarm', 'debug',$this->getHumanName().' '. __('Status de l\'alarme : ', __FILE__) . $cmd_state->execCmd() . __(' , armement : ', __FILE__) . $cmd_armed->execCmd());
		$cmd_immediatState = $this->getCmd(null, 'immediatState');
		$cmd_trigger = cmd::byId($_trigger_id);
		if (!is_object($cmd_trigger)) {
			log::add('alarm', 'error',$this->getHumanName().' '. __('Commande déclencheur de l\'alarme non trouvé : ', __FILE__) . $_trigger_id);
			return;
		}
		log::add('alarm', 'debug',$this->getHumanName().' '. __('Déclenchement de l\'alarme sur évenement : ', __FILE__) . $cmd_trigger->getHumanName() . __(' valeur : ', __FILE__) . $_value);
		$select_mode = $this->getCmd(null, 'mode')->execCmd();
		log::add('alarm', 'debug',$this->getHumanName().' '. __('Mode actif : ', __FILE__) . $select_mode);
		$zones = $this->getZoneOfMode($select_mode);
		if(!is_array($zones) || count($zones) == 0){
			log::add('alarm', 'debug',$this->getHumanName().' '. __('Aucune zone trouvée pour le mode actif', __FILE__));
			return;
		}
		$disable_trigger = $this->getCache('disable_trigger', array());
		foreach ($zones as $zone) {
			log::add('alarm', 'debug',$this->getHumanName().' '. __('Vérification de la zone : ', __FILE__) . $zone['name']);
			foreach ($zone['triggers'] as $trigger) {
				if (isset($trigger['enable']) && $trigger['enable'] == 0) {
					continue;
				}
				if ($trigger['cmd'] != '#' . $_trigger_id . '#') {
					continue;
				}
				log::add('alarm', 'debug',$this->getHumanName().' '. __('Déclencheur id : ', __FILE__) . $_trigger_id);
				if (isset($trigger['invert']) && $trigger['invert'] == 1) {
					$_value = ($_value == 1 || $_value) ? 0 : 1;
				}
				log::add('alarm', 'debug',$this->getHumanName().' '. __('Déclencheur inactif : ', __FILE__) . print_r($disable_trigger, true));
				if (isset($disable_trigger[$_trigger_id])) {
					log::add('alarm', 'debug',$this->getHumanName().' '. __('Non déclenchement car le capteur est inactif (car il était en alerte à l\'activation) : ', __FILE__) . print_r($disable_trigger, true));
					if ($_value != 1 && !$_value) {
						unset($disable_trigger[$_trigger_id]);
						$this->setCache('disable_trigger', $disable_trigger);
						log::add('alarm', 'debug',$this->getHumanName().' '. __('Supression du capteur de la liste de capteur inactif à l\'activation', __FILE__));
						$this->doAction('reenableTrigger', array('#mode#' => $select_mode, '#alarm_trigger#' => $cmd_trigger->getHumanName(), '#zone#' => $zone['name']));
					}
					continue;
				}
				if (isset($trigger['triggerHold'])) {
					$triggerHold = jeedom::evaluateExpression($trigger['triggerHold']);
					if ($triggerHold != '' && is_numeric(intval($triggerHold)) && $triggerHold > 0) {
						sleep($triggerHold);
						$_value = $cmd_trigger->execCmd();
						if (isset($trigger['invert']) && $trigger['invert'] == 1) {
							$_value = ($_value == 1 || $_value) ? 0 : 1;
						}
					}
				}
				if ($_value != 1 && !$_value) {
					log::add('alarm', 'debug',$this->getHumanName().' '. __('Non déclenchement car la valeur n\'est pas une alerte : ', __FILE__) . print_r($_value, true));
					continue;
				}
				$triggerStr = $cmd_trigger->getHumanName();
				log::add('alarm', 'debug',$this->getHumanName().' '. __('Evenement valide, mise en alerte de l\'alarme sur declencheur : ', __FILE__) . $cmd_trigger->getHumanName() . __(' valeur : ', __FILE__) . $_value);
				if (isset($trigger['armedDelay'])) {
					$armedDelay = jeedom::evaluateExpression($trigger['armedDelay']);
					if ($armedDelay !== '' && is_numeric(intval($armedDelay)) && $armedDelay > 0) {
						if (strtotime('now') < (strtotime($cmd_armed->getCollectDate()) + $armedDelay * 60)) {
							log::add('alarm', 'debug',$this->getHumanName().' '. __('Non déclenchement de l\'alarme car hors delai d\'armement : ', __FILE__) . $cmd_armed->getCollectDate() . ' +' . $armedDelay . 'min');
							return;
						}
					}
				}
				$this->cleanArmedCompleted();
				$trigger_zone_immediate = $this->getCache('trigger_zone_immediate', array());
				if ($this->getConfiguration('autorearm', 0) == 1 || $cmd_immediatState->execCmd() != 1 || ($this->getConfiguration('splitZone', 0) == 1 && !isset($trigger_zone_immediate[$zone['name']]))) {
					$this->setCache('trigger_zone_immediate', $trigger_zone_immediate + array($zone['name'] => $zone['name']));
					log::add('alarm', 'debug',$this->getHumanName().' '. __('Exécution des actions immédiates', __FILE__));
					$cmd_immediatState->event(1);
					if ($this->getConfiguration('ignoreImmediatIfNoDelay', 0) == 0 || (isset($trigger['waitDelay']) && $trigger['waitDelay'] !== '')) {
						$this->doAction('outbreakImmediate', array('#mode#' => $select_mode, '#alarm_trigger#' => $triggerStr, '#zone#' => $zone['name']));
						$this->doZoneAction($zone['actionsImmediate'], array('#mode#' => $select_mode, '#alarm_trigger#' => $triggerStr, '#zone#' => $zone['name']));
					}
				}

				if (isset($trigger['waitDelay'])) {
					$waitDelay = jeedom::evaluateExpression(str_replace(',','.',$trigger['waitDelay']));
					if ($waitDelay !== '' && is_numeric(intval($waitDelay)) && $waitDelay > 0) {
						log::add('alarm', 'debug',$this->getHumanName().' '. __('Attente de ' . $waitDelay . ' min avant déclenchement', __FILE__));
						sleep($waitDelay * 60);
						if ($cmd_armed->execCmd() == 0 || $cmd_immediatState->execCmd() == 0) {
							log::add('alarm', 'debug',$this->getHumanName().' '. __('L\'alarme a été désarmé avant déclenchement', __FILE__));
							return;
						}
					}
				}
				log::add('alarm', 'debug',$this->getHumanName().' '. __('Status de l\'alarme (2) : ', __FILE__) . $cmd_state->execCmd() . __(' , armement : ', __FILE__) . $cmd_armed->execCmd());
				$trigger_zone = $this->getCache('trigger_zone', array());
				if ($this->getConfiguration('autorearm', 0) == 1 || $cmd_state->execCmd() != 1 || ($this->getConfiguration('splitZone', 0) == 1 && !isset($trigger_zone[$zone['name']]))) {
					$this->setCache('trigger_zone', $trigger_zone + array($zone['name'] => $zone['name']));
					log::add('alarm', 'debug',$this->getHumanName().' '. __('Déclenchement de l\'alarme', __FILE__));
					$cmd_state->event(1);
					$this->doAction('outbreak', array('#mode#' => $select_mode, '#alarm_trigger#' => $triggerStr, '#zone#' => $zone['name']));
					$this->doZoneAction($zone['actions'], array('#mode#' => $select_mode, '#alarm_trigger#' => $triggerStr, '#zone#' => $zone['name']));
				}
				return;
			}
		}
	}

	public function doZoneAction($_actions, $_replace = array()) {
		if (!isset($_replace['#mode#'])) {
			$_replace['#mode#'] = $this->getCmd(null, 'mode')->execCmd();
		}
		if (!isset($_replace['#alarm_trigger#'])) {
			$_replace['#alarm_trigger#'] = implode(" , ", $this->listCmdTrigger());
		}
		foreach ($_actions as $action) {
			try {
				if (isset($action['onMode']) && $action['onMode'] != 'all' && $action['onMode'] != $_replace['#mode#']) {
					continue;
				}
				if (isset($action['options'])) {
					$options = $action['options'];
					foreach ($options as $key => $value) {
						$options[$key] = str_replace(array_keys($_replace), $_replace, $value);
					}
				}
				log::add('alarm', 'debug',$this->getHumanName().' '. __('Execution de ', __FILE__) . $action['cmd'] . ' => ' . print_r($options, true));
				scenarioExpression::createAndExec('action', $action['cmd'], $options);
			} catch (Exception $e) {
				log::add('alarm', 'error',$this->getHumanName().' '. __('Erreur lors de l\'éxecution de ', __FILE__) . $action['cmd'] . __('. Détails : ', __FILE__) . $e->getMessage());
			}
		}
	}

	public function doAction($_action, $_replace = array()) {
		if (!isset($_replace['#mode#'])) {
			$_replace['#mode#'] = $this->getCmd(null, 'mode')->execCmd();
		}
		if (!isset($_replace['#alarm_trigger#'])) {
			$_replace['#alarm_trigger#'] = implode(" , ", $this->listCmdTrigger());
		}
		$actions = $this->getConfiguration($_action);
		if(!is_array($actions) || count($actions) == 0){
			return;
		}
		foreach ($actions as $action) {
			if (isset($action['onMode']) && $action['onMode'] != 'all' && $action['onMode'] != $_replace['#mode#']) {
				continue;
			}
			try {
				$cmd = cmd::byId(str_replace('#', '', $action['cmd']));
				if (is_object($cmd) && $this->getId() == $cmd->getEqLogic_id()) {
					continue;
				}
				$options = array();
				if (isset($action['options'])) {
					$options = $action['options'];
					foreach ($options as $key => $value) {
						$options[$key] = str_replace(array_keys($_replace), $_replace, $value);
					}
				}
				scenarioExpression::createAndExec('action', $action['cmd'], $options);
			} catch (Exception $e) {
				log::add('alarm', 'error',$this->getHumanName().' '. __('Erreur lors de l\'éxecution de ', __FILE__) . $action['cmd'] . __('. Détails : ', __FILE__) . $e->getMessage());
			}
		}
	}

	public function cleanArmedCompleted() {
		$crons = cron::searchClassAndFunction('alarm', 'armedComplete', '"alarm_id":' . $this->getId());
		if (is_array($crons) && count($crons) > 0) {
			foreach ($crons as $cron) {
				if ($cron->getState() != 'run') {
					$cron->remove();
				}
			}
		}
	}

}

class alarmCmd extends cmd {
	/*     * *************************Attributs****************************** */

	public function dontRemoveCmd() {
		return true;
	}

	public function execute($_options = array()) {
		$eqLogic = $this->getEqLogic();
		$cmd_armed = $eqLogic->getCmd('info', 'enable');
		$cmd_state = $eqLogic->getCmd('info', 'state');
		$cmd_state_pause = $eqLogic->getCmd('info', 'statePause');
		$cmd_immediateState = $eqLogic->getCmd('info', 'immediatState');
		$cmd_mode = $eqLogic->getCmd('info', 'mode');
		if ($this->getLogicalId() == 'released') {
			if ($cmd_armed->execCmd() == 0) {
				log::add('alarm', 'debug',$eqLogic->getHumanName(). __(' Alarme déjà désactivée', __FILE__));
				return;
			}
			$cmd_armed->event(0);
			$cmd_mode->event($cmd_mode->execCmd());
			$eqLogic->doAction('release', array('#mode#' => $cmd_mode->execCmd()));
			if ($cmd_immediateState->execCmd() == 1) {
				$cmd_immediateState->event(0);
				log::add('alarm', 'debug',$eqLogic->getHumanName(). __(' Remise à zero immédiate de l\'alarme', __FILE__));
				$eqLogic->doAction('razImmediate', array('#mode#' => $cmd_mode->execCmd()));
			}
			if ($cmd_state->execCmd() == 1) {
				$cmd_state->event(0);
				log::add('alarm', 'debug',$eqLogic->getHumanName(). __(' Remise à zero de l\'alarme', __FILE__));
				$eqLogic->doAction('raz', array('#mode#' => $cmd_mode->execCmd()));
			}
			$eqLogic->setCache('trigger_zone', array());
			$eqLogic->setCache('trigger_zone_immediate', array());
			$eqLogic->cleanArmedCompleted();
			return;
		}
		if ($this->getLogicalId() == 'pauseOn') {
			$cmd_state_pause->event(1);
			return;
		}
		if ($this->getLogicalId() == 'pauseOff') {
			$cmd_state_pause->event(0);
			return;
		}
		if ($this->getLogicalId() == 'armed') {
			$cmd_state_pause->event(0);
			if ($cmd_armed->execCmd() == 1) {
				log::add('alarm', 'debug',$eqLogic->getHumanName(). __(' Alarme déjà active', __FILE__));
				return;
			}
			$cmd_armed->event(1);
			$select_mode = $cmd_mode->execCmd();
			if ($select_mode == '') {
				throw new Exception(__('Aucun mode sélectionné', __FILE__));
			}
			$cmd_mode->event($select_mode);
			$armedCompleteDatetime = -1;
			$eqLogic->cleanArmedCompleted();
			$zones = $eqLogic->getZoneOfMode($select_mode);
			log::add('alarm', 'debug',$eqLogic->getHumanName(). __(' Activation de l\'alarme réussie dans le mode : ', __FILE__).$select_mode);
			$eqLogic->doAction('activationImmediateOk', array('#mode#' => $select_mode));

			$disable_trigger = array();
			$disable_zone_trigger = array();
			if(count($zones) == 0){
				log::add('alarm', 'debug',$eqLogic->getHumanName(). __(' Attention je ne trouve aucune zone pour le mode sélectionnée', __FILE__));
			}
			foreach ($zones as $zone) {
				log::add('alarm', 'debug',$eqLogic->getHumanName(). __(' Vérification de la zone : ', __FILE__) . $zone['name']);
				foreach ($zone['triggers'] as $trigger) {
					if (isset($trigger['enable']) && $trigger['enable'] == 0) {
						continue;
					}
					$cmd = cmd::byId(str_replace('#', '', $trigger['cmd']));
					if (!is_object($cmd)) {
						continue;
					}
					log::add('alarm', 'debug',$eqLogic->getHumanName(). __(' Vérification de la commande : ', __FILE__) . $cmd->getHumanName());
					if (isset($trigger['armedDelay'])) {
						$armedDelay = jeedom::evaluateExpression($trigger['armedDelay']);
						if (is_numeric(intval($armedDelay)) && $armedDelay > 0) {
							$armedCompleteDatetimeTemp = strtotime('now') + $armedDelay * 60;
							if ($armedCompleteDatetime < $armedCompleteDatetimeTemp) {
								$armedCompleteDatetime = $armedCompleteDatetimeTemp;
							}
							$cron = new cron();
							$cron->setClass('alarm');
							$cron->setFunction('checkDetector');
							$cron->setOption(array('alarm_id' => intval($eqLogic->getId()), 'cmd_id' => intval($cmd->getId()), 'delay' => date('s', $armedCompleteDatetime)));
							$cron->setLastRun(date('Y-m-d H:i:s'));
							$cron->setOnce(1);
							$cron->setSchedule(cron::convertDateToCron($armedCompleteDatetimeTemp));
							$cron->save();
							continue;
						}
					}
					$result = $cmd->execCmd();
					if (isset($trigger['invert']) && $trigger['invert'] == 1) {
						$result = ($result == 1 || $result) ? 0 : 1;
					}
					if ($result == 1) {
						log::add('alarm', 'debug',$eqLogic->getHumanName(). __(' La commande est active : ', __FILE__) . $cmd->getHumanName());
						$disable_trigger[$cmd->getId()] = $cmd->getHumanName();
						$disable_zone_trigger[$zone['name']] = $zone['name'];
					}
				}
			}
			$eqLogic->setCache('disable_trigger', $disable_trigger);
			if (count($disable_trigger) > 0) {
				log::add('alarm', 'debug', $eqLogic->getHumanName(). __(' Déclencheur désactivé : ', __FILE__) . print_r($disable_trigger, true));
				log::add('alarm', 'debug',$eqLogic->getHumanName(). __(' Lancement des actions d\'activation ko', __FILE__));
				$eqLogic->doAction('activationKo', array('#mode#' => $select_mode, '#alarm_trigger#' => implode(',', $disable_trigger), '#zone#' => implode(',', $disable_zone_trigger)));
			}

			/*             * *****************Activation reussi***************** */
			if ($armedCompleteDatetime > 0) {
				$cron = new cron();
				$cron->setClass('alarm');
				$cron->setFunction('armedComplete');
				$cron->setOption(array('alarm_id' => intval($eqLogic->getId()), 'delay' => date('s', $armedCompleteDatetime + 5)));
				$cron->setLastRun(date('Y-m-d H:i:s'));
				$cron->setOnce(1);
				$cron->setSchedule(cron::convertDateToCron($armedCompleteDatetime));
				$cron->save();
			} else if (count($disable_trigger) == 0) {
				log::add('alarm', 'debug',$eqLogic->getHumanName(). __(' Activation OK éxécution des actions', __FILE__));
				$eqLogic->doAction('activationOk', array('#mode#' => $select_mode));
			}
			return;
		}
		if ($this->getConfiguration('mode') == '1') {
			$select_mode = $cmd_mode->execCmd();
			$cmd_mode->event($this->getConfiguration('state'));
			if ($cmd_immediateState->execCmd() == 1) {
				log::add('alarm', 'debug',$eqLogic->getHumanName(). __(' Remise à zero immédiate de l\'alarme', __FILE__));
				$eqLogic->doAction('razImmediate');
			}
			if ($cmd_state->execCmd() == 1) {
				log::add('alarm', 'debug',$eqLogic->getHumanName(). __(' Remise à zero de l\'alarme', __FILE__));
				$eqLogic->doAction('raz');
			}
			log::add('alarm', 'debug',$eqLogic->getHumanName(). __(' Envoi etat alarm ok', __FILE__));
			$cmd_state->event(0);
			$cmd_immediateState->event(0);
			if($select_mode != $this->getConfiguration('state') || $cmd_armed->execCmd() == 0){
				$eqLogic->setCache('trigger_zone', array());
				$eqLogic->setCache('trigger_zone_immediate', array());
				$eqLogic->cleanArmedCompleted();
				$eqLogic->getCmd(null, 'armed')->execCmd();
			}
		}
	}

	/*     * ***********************Methode static*************************** */

	/*     * *********************Methode d'instance************************* */
}

?>
