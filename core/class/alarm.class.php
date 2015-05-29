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

	public static function cron() {
		foreach (eqLogic::byType('alarm') as $eqLogic) {
			$cmd_armed = $eqLogic->getCmd(null, 'enable');
			if (is_object($cmd_armed) && $cmd_armed->execCmd() == 1) {
				$eqLogic->ping();
				$eqLogic->checkActivationOk();
			}
		}
	}

	/*     * *********************Methode d'instance************************* */

	public function launch($_trigger_id, $_value) {
		$cmd = 'nohup php ' . dirname(__FILE__) . '/../../core/php/jeeAlarm.php ';
		$cmd .= ' eqLogic_id=' . $this->getId() . ' trigger_id=' . $_trigger_id . ' value=' . $_value;
		$cmd .= ' >> ' . log::getPathToLog('alarm') . ' 2>&1 &';
		shell_exec($cmd);
		return true;
	}

	public function preInsert() {
		$this->setCategory('security', 1);
	}

	public function postSave() {

		$cmdArmed = $this->getCmd(null, 'enable');
		if (!is_object($cmdArmed)) {
			$cmdArmed = new alarmCmd();
		}
		$cmdArmed->setName(__('Actif', __FILE__));
		$cmdArmed->setEqLogic_id($this->id);
		$cmdArmed->setLogicalId('enable');
		$cmdArmed->setType('info');
		$cmdArmed->setTemplate('dashboard', 'lock');
		$cmdArmed->setTemplate('mobile', 'lock');
		$cmdArmed->setOrder(1);
		$cmdArmed->setSubType('binary');
		$cmdArmed->setEventOnly(1);
		$cmdArmed->setIsVisible(1 - $this->getConfiguration('armed_visible'));
		$cmdArmed->setIsHistorized($this->getConfiguration('historizedState'));
		$cmdArmed->save();

		$cmdState = $this->getCmd(null, 'state');
		if (!is_object($cmdState)) {
			$cmdState = new alarmCmd();
			$cmdState->setTemplate('dashboard', 'alert');
			$cmdState->setTemplate('mobile', 'alert');
		}
		$cmdState->setName(__('Statut', __FILE__));
		$cmdState->setEqLogic_id($this->id);
		$cmdState->setLogicalId('state');
		$cmdState->setType('info');
		$cmdState->setOrder(2);
		$cmdState->setSubType('binary');
		$cmdState->setEventOnly(1);
		$cmdState->setDisplay('invertBinary', 1);

		$cmdState->setIsHistorized($this->getConfiguration('historizedState'));
		$cmdState->save();

		$cmdImmediatState = $this->getCmd(null, 'immediatState');
		if (!is_object($cmdImmediatState)) {
			$cmdImmediatState = new alarmCmd();
			$cmdImmediatState->setTemplate('dashboard', 'alert');
			$cmdImmediatState->setTemplate('mobile', 'alert');
		}
		$cmdImmediatState->setName(__('Immédiat', __FILE__));
		$cmdImmediatState->setLogicalId('immediatState');
		$cmdImmediatState->setEqLogic_id($this->id);
		$cmdImmediatState->setType('info');
		$cmdImmediatState->setorder(2);
		$cmdImmediatState->setSubType('binary');
		$cmdImmediatState->setIsVisible($this->getConfiguration('immediateState_visible'));
		$cmdImmediatState->setEventOnly(1);
		$cmdImmediatState->setDisplay('invertBinary', 1);

		$cmdImmediatState->setIsHistorized($this->getConfiguration('historizedState'));
		$cmdImmediatState->save();

		$existing_mode = array();
		if (is_array($this->getConfiguration('modes'))) {
			foreach ($this->getConfiguration('modes') as $key => $value) {
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
				}
				$cmd->setName($value['name']);
				$cmd->setEqLogic_id($this->id);
				$cmd->setType('action');
				$cmd->setSubType('other');
				$cmd->setorder(4);
				$cmd->setConfiguration('mode', '1');
				$cmd->setConfiguration('state', $value['name']);
				$cmd->save();
			}
		}
		if ($this->getIsEnable() == 1) {
			$cmd_zone = $this->getCmd(null, 'mode');
			if (is_object($cmd_zone) && $cmd_zone->execCmd() == '' && isset($value)) {
				$cmd_zone->setCollectDate('');
				$cmd_zone->event($value['name']);
			}
		}

		$cmd_find = array(
			'armed' => false,
			'released' => false,
			'mode' => false,
		);
		foreach ($this->getCmd() as $cmd) {
			if ($cmd->getName() == __('Mode', __FILE__)) {
				$cmd->setLogicalId('mode');
				$cmd->save();
				$cmd_find['mode'] = true;
			}
		}

		$armed = $this->getCmd(null, 'armed');
		if (!is_object($armed)) {
			$armed = new alarmCmd();
			$armed->setTemplate('dashboard', 'lock');
			$armed->setTemplate('mobile', 'lock');
		}
		$armed->setName('lock');
		$armed->setEqLogic_id($this->id);
		$armed->setType('action');
		$armed->setLogicalId('armed');
		$armed->setSubType('other');
		$armed->setorder(0);
		$armed->setConfiguration('state', '1');
		$armed->setConfiguration('armed', '1');
		$armed->setValue($this->getCmd(null, 'enable')->getId());
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
		}
		$released->setName('unlock');
		$released->setEqLogic_id($this->id);
		$released->setType('action');
		$released->setLogicalId('released');
		$released->setorder(0);
		$released->setSubType('other');
		$released->setConfiguration('state', '0');
		$released->setConfiguration('armed', '1');
		$released->setValue($this->getCmd(null, 'enable')->getId());
		if ($this->getConfiguration('always_active') == 1) {
			$released->setIsVisible(0);
		} else {
			$released->setIsVisible($this->getConfiguration('armed_visible', 1));
		}
		$released->save();

		if (!$cmd_find['mode']) {
			$cmd = new alarmCmd();
			$cmd->setName(__('Mode', __FILE__));
			$cmd->setEqLogic_id($this->id);
			$cmd->setType('info');
			$cmd->setLogicalId('mode');
			$cmd->setSubType('string');
			$cmd->setEventOnly(1);
			$cmd->setorder(3);
			$cmd->save();
		}

		foreach ($this->getCmd() as $cmd) {
			if ($cmd->getType() == 'action' && !in_array($cmd->getName(), $existing_mode) &&
				$cmd->getLogicalId() != 'mode' && $cmd->getLogicalId() != 'released' && $cmd->getLogicalId() != 'armed') {
				$cmd->remove();
			}
		}

		if ($this->getConfiguration('always_active') == 1) {
			$cmd_armed = $this->getCmd(null, 'enable');
			$cmd_armed->event(1);
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
					$cmd = cmd::byId(str_replace('#', '', $trigger['cmd']));
					if (!is_object($cmd)) {
						throw new Exception(__('Commande déclencheur inconnue : ' . $trigger['cmd'], __FILE__));
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

	public function preSave() {
		$zones = $this->getConfiguration('zones');
		if (is_array($zones)) {
			foreach ($zones as $zone) {
				if (is_array($zone['triggers'])) {
					foreach ($zone['triggers'] as $trigger) {
						if (isset($trigger['armedDelay']) && $trigger['armedDelay'] !== '' && (!is_numeric(intval($trigger['armedDelay'])) || $trigger['armedDelay'] < 0)) {
							throw new Exception('Le délai d\'armement doit etre un entier supérieur à 0  : ' . $trigger['armedDelay']);
						}
						if (isset($trigger['waitDelay']) && $trigger['armedDelay'] !== '' && (!is_numeric(intval($trigger['waitDelay'])) || $trigger['waitDelay'] < 0)) {
							throw new Exception('Le délai d\'activation doit etre un entier supérieur à 0 : ' . $trigger['waitDelay']);
						}
					}
				}
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
				$cmd_state->setCollectDate('');
				$cmd_state->event(0);
			}
			$cmd_immediatState = $this->getCmd(null, 'immediatState');
			if (is_object($cmd_immediatState) && $cmd_immediatState->execCmd() == '') {
				$cmd_immediatState->setCollectDate('');
				$cmd_immediatState->event(0);
			}
			$cmd_armed = $this->getCmd(null, 'enable');
			if (is_object($cmd_armed) && $cmd_armed->execCmd() == '') {
				$cmd_armed->setCollectDate('');
				$cmd_armed->event(0);
			}
		}
	}

	public function ping() {
		if ($this->getConfiguration('pingState', 1) != 1) {
			return true;
		}
		log::add('alarm', 'debug', __('Lancement du ping de l\'alarme : ', __FILE__) . $this->getHumanName());
		foreach ($this->getConfiguration('pingTest') as $pingTest) {
			$eqLogic = eqLogic::byId(str_replace(array('#', 'eqLogic'), '', $pingTest['eqLogic']));
			if (!is_object($eqLogic)) {
				continue;
			}
			log::add('alarm', 'debug', __('Test ping pour : ', __FILE__) . $eqLogic->getHumanName());
			if ($eqLogic->getIsEnable() == 1 && method_exists($eqLogic, 'ping')) {
				try {
					$ping = $eqLogic->ping();
				} catch (Exception $e) {
					$ping = true;
				}
				if (!$ping) {
					log::add('alarm', 'debug', __('Ping NOK sur : ', __FILE__) . $eqLogic->getHumanName());
					$this->setConfiguration('pingState', 0);
					$this->save();
					log::add('alarm', 'debug', __('Alert perte ping éxecution des actions', __FILE__));
					$eqLogic->doAction('ping');
					break;
				} else {
					log::add('alarm', 'debug', __('Ping OK sur : ', __FILE__) . $eqLogic->getHumanName());
				}
			} else {
				log::add('alarm', 'debug', __('Aucune méthode de ping pour : ', __FILE__) . $eqLogic->getHumanName());
			}
		}
	}

	public function checkActivationOk() {
		$armed = $this->getCmd(null, 'armed');
		if (!is_object($armed)) {
			return;
		}
		if ($armed->getConfiguration('armedComplete') == 1) {
			return;
		}
		$cmd_mode = $this->getCmd(null, 'mode');
		$select_mode = $cmd_mode->execCmd();
		$modes = $this->getConfiguration('modes');
		$armedComplete = true;
		foreach ($modes as $mode) {
			if ($mode['name'] == $select_mode) {
				$zones = $this->getConfiguration('zones');
				foreach ($zones as $zone) {
					if ((!is_array($mode['zone']) && $zone['name'] == $mode['zone']) || (is_array($mode['zone']) && in_array($zone['name'], $mode['zone']))) {
						foreach ($zone['triggers'] as $trigger) {
							if (isset($trigger['armedDelay']) && is_numeric(intval($trigger['armedDelay'])) && $trigger['armedDelay'] > 0) {
								if (strtotime('now') < ($armed->getConfiguration('armedDatetime') + ($trigger['armedDelay'] * 60))) {
									return;
								}
							}
						}
					}
				}
			}
		}
		log::add('alarm', 'debug', __('Activation OK éxécution des actions', __FILE__));
		$this->doAction('activationOk');
		$armed->setConfiguration('armedComplete', 1);
		$armed->save();
	}

	public function listCmdTrigger() {
		$result = array();
		$modes = $this->getConfiguration('modes');
		$cmd_mode = $this->getCmd(null, 'mode');
		$select_mode = $cmd_mode->execCmd();
		foreach ($modes as $mode) {
			if ($mode['name'] == $select_mode) {
				$zones = $this->getConfiguration('zones');
				foreach ($zones as $zone) {
					if ((!is_array($mode['zone']) && $zone['name'] == $mode['zone']) || (is_array($mode['zone']) && in_array($zone['name'], $mode['zone']))) {
						foreach ($zone['triggers'] as $trigger) {
							$cmd = cmd::byId(str_replace('#', '', $trigger['cmd']));
							if (is_object($cmd)) {
								$value = $cmd->execCmd();
								if (isset($trigger['invert']) && $trigger['invert'] == 1) {
									$value = ($value == 1 || $value) ? 0 : 1;
								}
								if ($value == 1 || $value) {
									$result[] = $cmd->getHumanName();
								}
							}
						}
					}
				}
			}
		}
		return $result;
	}

	public function execute($_trigger_id, $_value) {
		log::add('alarm', 'debug', __('Lancement de l\'alarme : ', __FILE__) . $this->getHumanName());
		$cmd_armed = $this->getCmd(null, 'enable');
		$cmd_state = $this->getCmd(null, 'state');
		log::add('alarm', 'debug', __('Status de l\'alarme : ', __FILE__) . $cmd_state->execCmd());
		if ($cmd_armed->execCmd() == 1 && $cmd_state->execCmd() != 1) {
			$cmd_immediatState = $this->getCmd(null, 'immediatState');
			$cmd_trigger = cmd::byId($_trigger_id);
			if (!is_object($cmd_trigger)) {
				log::add('alarm', 'error', __('Commande déclencheur de l\'alarme non trouvé : ', __FILE__) . $_trigger_id);
				return;
			}
			log::add('alarm', 'debug', __('Déclenchement de l\'alarme sur évenement : ', __FILE__) . $cmd_trigger->getHumanName() . __(' valeur : ', __FILE__) . $_value);
			$cmd_mode = $this->getCmd(null, 'mode');
			$select_mode = $cmd_mode->execCmd();
			$modes = $this->getConfiguration('modes');
			foreach ($modes as $mode) {
				if ($mode['name'] == $select_mode) {
					log::add('alarm', 'debug', __('Mode actif : ', __FILE__) . $select_mode);
					$zones = $this->getConfiguration('zones');
					foreach ($zones as $zone) {
						if ((!is_array($mode['zone']) && $zone['name'] == $mode['zone']) || (is_array($mode['zone']) && in_array($zone['name'], $mode['zone']))) {
							log::add('alarm', 'debug', __('Vérification de la zone : ', __FILE__) . $zone['name']);
							foreach ($zone['triggers'] as $trigger) {
								if ($trigger['cmd'] == '#' . $_trigger_id . '#') {
									if (isset($trigger['invert']) && $trigger['invert'] == 1) {
										$_value = ($_value == 1 || $_value) ? 0 : 1;
									}
									if ($_value == 1 || $_value) {
										log::add('alarm', 'debug', __('Evenement valide, mise en alerte de l\'alarme sur declencheur : ', __FILE__) . $cmd_trigger->getHumanName() . __(' valeur : ', __FILE__) . $_value);
										if (isset($trigger['armedDelay']) && $trigger['armedDelay'] !== '' && is_numeric(intval($trigger['armedDelay'])) && $trigger['armedDelay'] > 0) {
											if (strtotime('now') < (strtotime($cmd_armed->getCollectDate()) + $trigger['armedDelay'] * 60)) {
												log::add('alarm', 'debug', __('Non déclenchement de l\'alarme car hors delai d\'armement : ', __FILE__) . $cmd_armed->getCollectDate() . ' +' . $trigger['armedDelay'] . 'min');
												return;
											}
										}
										if ($cmd_immediatState->execCmd() != 1) {
											$cmd_immediatState->setCollectDate('');
											$cmd_immediatState->event(1);
											foreach ($zone['actionsImmediate'] as $action) {
												try {
													$options = array();
													if (isset($action['options'])) {
														$options = $action['options'];
														foreach ($options as $key => $value) {
															$options[$key] = str_replace('#trigger#', implode(" , ", $this->listCmdTrigger()), $value);
														}
													}
													scenarioExpression::createAndExec('action', $action['cmd'], $options);
												} catch (Exception $e) {
													log::add('alarm', 'error', __('Erreur lors de l\'éxecution de ', __FILE__) . $action['cmd'] . __('. Détails : ', __FILE__) . $e->getMessage());
												}
											}
										}
										if (isset($trigger['waitDelay']) && $trigger['waitDelay'] !== '' && is_numeric(intval($trigger['waitDelay'])) && $trigger['waitDelay'] > 0) {
											log::add('alarm', 'debug', __('Attente de ' . $trigger['waitDelay'] . ' min avant déclenchement', __FILE__));
											sleep($trigger['waitDelay'] * 60);
											if ($cmd_armed->execCmd() == 0) {
												log::add('alarm', 'debug', __('L\'alarme a été désarmé avant déclenchement', __FILE__));
												return;
											}
										}
										log::add('alarm', 'debug', __('Status de l\'alarme : ', __FILE__) . $cmd_state->execCmd());
										if ($cmd_state->execCmd() == 1) {
											log::add('alarm', 'debug', __('L\'alarme est deja en cours', __FILE__));
											return;
										}
										log::add('alarm', 'debug', __('Déclenchement de l\'alarme', __FILE__));
										$cmd_state->setCollectDate('');
										$cmd_state->event(1);
										foreach ($zone['actions'] as $action) {
											try {
												if (isset($action['options'])) {
													$options = $action['options'];
													foreach ($options as $key => $value) {
														$options[$key] = str_replace('#trigger#', implode(" , ", $this->listCmdTrigger()), $value);
													}
												}
												scenarioExpression::createAndExec('action', $action['cmd'], $options);
											} catch (Exception $e) {
												log::add('alarm', 'error', __('Erreur lors de l\'éxecution de ', __FILE__) . $action['cmd'] . __('. Détails : ', __FILE__) . $e->getMessage());
											}
										}
										return;
									}
								}
							}
						}
					}
				}
			}
		}
	}

	public function doAction($_action) {
		$trigger = '';
		$trigger = implode(" , ", $this->listCmdTrigger());
		foreach ($this->getConfiguration($_action) as $action) {
			try {
				$options = array();
				if (isset($action['options'])) {
					$options = $action['options'];
					foreach ($options as $key => $value) {
						$options[$key] = str_replace('#trigger#', $trigger, $value);
					}
				}
				scenarioExpression::createAndExec('action', $action['cmd'], $options);
			} catch (Exception $e) {
				log::add('alarm', 'error', __('Erreur lors de l\'éxecution de ', __FILE__) . $action['cmd'] . __('. Détails : ', __FILE__) . $e->getMessage());
			}
		}
	}

}

class alarmCmd extends cmd {
	/*     * *************************Attributs****************************** */

	public function imperihomeGenerate($ISSStructure) {
		$eqLogic = $this->getEqLogic();
		$object = $eqLogic->getObject();
		$type = 'DevMotion';
		if ($this->getLogicalId() == 'mode') {
			$type = 'DevMultiSwitch';
		}
		$info_device = array(
			'id' => $this->getId(),
			'name' => $eqLogic->getName(),
			'room' => (is_object($object)) ? $object->getId() : 99999,
			'type' => $type,
			'params' => array(),
		);
		$info_device['params'] = $ISSStructure[$info_device['type']]['params'];
		if ($this->getLogicalId() == 'mode') {
			$info_device['params'][0]['value'] = '#' . $this->getId() . '#';
			$modes = $eqLogic->getConfiguration('modes');
			foreach ($modes as $mode) {
				$info_device['params'][1]['value'] .= $mode['name'] . ',';
			}
			$info_device['params'][1]['value'] = trim($info_device['params'][1]['value'], ',');
			return $info_device;
		}
		$info_device['params'][0]['value'] = 1;
		$info_device['params'][2]['value'] = '#' . $eqLogic->getCmd('info', 'enable')->getId() . '#';
		$info_device['params'][3]['value'] = '#' . $eqLogic->getCmd('info', 'state')->getId() . '#';
		return $info_device;
	}

	public function imperihomeAction($_action, $_value) {
		$eqLogic = $this->getEqLogic();
		if ($_action == 'setArmed') {
			if ($_value == 1) {
				$eqLogic->getCmd('action', 'armed')->execCmd();
			} else {
				$eqLogic->getCmd('action', 'released')->execCmd();
			}
		}
		if ($_action == 'setChoice') {
			foreach ($eqLogic->getCmd() as $cmd) {
				if ($cmd->getConfiguration('mode') == '1' && $cmd->getConfiguration('state') == $_value) {
					$cmd->execCmd();
				}
			}
		}
	}

	public function dontRemoveCmd() {
		return true;
	}

	public function execute($_options = array()) {
		$eqLogic = $this->getEqLogic();
		$cmd_armed = $eqLogic->getCmd(null, 'enable');
		$cmd_state = $eqLogic->getCmd(null, 'state');
		$cmd_immediateState = $eqLogic->getCmd(null, 'immediatState');

		if ($this->getLogicalId() == 'released') {
			$cmd_armed->event(0);
			$eqLogic->doAction('release');
			if ($cmd_immediateState->execCmd() == 1) {
				$cmd_immediateState->setCollectDate('');
				$cmd_immediateState->event(0);
				log::add('alarm', 'debug', __('Remise à zero immédiate de l\'alarme', __FILE__));
				$eqLogic->doAction('razImmediate');
			}
			if ($cmd_state->execCmd() == 1) {
				$cmd_state->setCollectDate('');
				$cmd_state->event(0);
				log::add('alarm', 'debug', __('Remise à zero de l\'alarme', __FILE__));
				$eqLogic->doAction('raz');
			}
			$eqLogic->setConfiguration('pingState', 1);
			$eqLogic->save();
			return;
		}
		if ($this->getLogicalId() == 'armed') {
			$cmd_armed->event(1);
			$cmd_mode = $eqLogic->getCmd(null, 'mode');
			$select_mode = $cmd_mode->execCmd();
			$modes = $eqLogic->getConfiguration('modes');
			$zones = $eqLogic->getConfiguration('zones');
			foreach ($modes as $mode) {
				if ($mode['name'] == $select_mode) {
					foreach ($zones as $zone) {
						if ((!is_array($mode['zone']) && $zone['name'] == $mode['zone']) || (is_array($mode['zone']) && in_array($zone['name'], $mode['zone']))) {
							log::add('alarm', 'debug', __('Vérification de la zone : ', __FILE__) . $zone['name']);
							foreach ($zone['triggers'] as $trigger) {
								$cmd = cmd::byId(str_replace('#', '', $trigger['cmd']));
								if (is_object($cmd)) {
									log::add('alarm', 'debug', __('Vérification de la commande : ', __FILE__) . $cmd->getHumanName());
									$result = $cmd->execCmd();
									if (isset($trigger['invert']) && $trigger['invert'] == 1) {
										$result = ($result == 1 || $result) ? 0 : 1;
									}
									if ($result == 1) {
										log::add('alarm', 'debug', __('La commande est active : ', __FILE__) . $cmd->getHumanName());
										if (isset($trigger['armedDelay']) && is_numeric($trigger['armedDelay']) && $trigger['armedDelay'] > 0) {
											continue;
										}
										$eqLogic->doAction('activationKo');
										$eqLogic->launch($cmd->getId(), $result);
										return;
									}
								}
							}
						}
					}
				}
			}

			/*             * *****************Activation reussi***************** */
			log::add('alarm', 'debug', 'Activation de l\'alarme réussie');
			$eqLogic->doAction('activationImmediateOk');
			$this->setConfiguration('armedComplete', 0);
			$this->setConfiguration('armedDatetime', strtotime('now'));
			$this->save();
			return;
		}
		if ($this->getConfiguration('mode') == '1') {
			$cmd_zone = $eqLogic->getCmd(null, 'mode');
			$cmd_zone->event($this->getConfiguration('state'));
			if ($eqLogic->getConfiguration('always_active') == 1) {
				/* RaZ immediate */
				if ($cmd_immediateState->execCmd() == 1) {
					log::add('alarm', 'debug', __('Remise à zero immédiate de l\'alarme', __FILE__));
					$eqLogic->doAction('razImmediate');
				}
				/* RaZ */
				if ($cmd_state->execCmd() == 1) {
					log::add('alarm', 'debug', __('Remise à zero de l\'alarme', __FILE__));
					$eqLogic->doAction('raz');
				}
				log::add('alarm', 'debug', __('Envoi etat alarm ok', __FILE__));
				$cmd_state->setCollectDate('');
				$cmd_state->event(0);
				$cmd_immediateState->setCollectDate('');
				$cmd_immediateState->event(0);
				$armed = $eqLogic->getCmd(null, 'armed');
				$armed->setConfiguration('armedComplete', 0);
				$armed->setConfiguration('armedDatetime', strtotime('now'));
				$armed->save();
				$eqLogic->setConfiguration('pingState', 1);
				$eqLogic->save();
			}
		}
	}

	/*     * ***********************Methode static*************************** */

	/*     * *********************Methode d'instance************************* */
}

?>