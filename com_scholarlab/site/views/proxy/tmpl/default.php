<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Get Webinar Administrator configuration params
$params = JComponentHelper::getParams('com_scholarlab');

?>
{"0": {"Temp":<?php echo json_encode($this->sensorData['ds18b20'][$params->get('termometro1')]['Temp']); ?>}, "1": {"Temp":<?php echo json_encode($this->sensorData['ds18b20'][$params->get('termometro2')]['Temp']); ?>}, "2": {"Temp":<?php echo json_encode($this->sensorData['ds18b20'][$params->get('termometro3')]['Temp']); ?>}}
