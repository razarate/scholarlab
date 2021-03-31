<?php
 /**
 * @package Component com_webinaradministrator for Joomla! 3.5+
 * @version $Id: view.html.php 3.8 2018-05-05 14:26:33Z Piensocial $
 * @author Piensocial.com
 * @copyright (C) 2010- Piensocial.com
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Render room view
 *
 * @since  3.8.0
 */
class ScholarLabViewCronjob extends JViewLegacy {

	public function display($tpl = null) {
        // Assign data to the view
         
        $this->sensorList = self::saveSensorData();
        // Check for errors.
        if (count($errors = $this->get('Errors')))
        {
            JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');

            return false;
        }

        // Display the view
        parent::display($tpl);
    }

    protected function saveSensorData ($sensor = array()) {
        $sensor_model = JModelLegacy::getInstance( 'Sensor', 'ScholarLabModel', array() );
        $sensorList = $sensor_model->getSensorList();

        foreach ($sensorList as $key => $sensor) {
            $sensorData[$sensor['sensor_type']][$sensor['sensor_id']] = $sensor;
        }
        
        $sensorsType = array_keys($sensorData);
        
        foreach ($sensorsType as $sensorType) {
            $sensorsLiveData[$sensorType] = json_decode(SensorHelper::restService($sensorType), true);
            foreach ($sensorsLiveData[$sensorType] as $device => $value) {
                unset($value['Id']);
                $sensorsLiveData[$sensorType][$device]['data'] = json_encode($value);
            }
        }
        $array_merge = array_merge_recursive($sensorData, $sensorsLiveData);

        $sensors_array_data = call_user_func_array("array_merge", $array_merge);

        
        foreach ($sensors_array_data as $sensor_array_data) {
            $sensor_model->insertSensorData($sensor_array_data['sensor_type'], $sensor_array_data['id'], $sensor_array_data['data']);
        }
        
        
        return $sensors_array_data;
    }
}
