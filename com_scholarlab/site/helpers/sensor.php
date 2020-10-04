<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Scholarlab Component Sensor Tree
 *
 * @since  1.0.0
 */
abstract class SensorHelper extends JHelperContent{

    /* __________________ ADMINISTRATION METHODS _________________ */
    /* The methods in the following section support the following categories of the BBB API:
    -- 
    --
    */

    /**
     * Get all or specific sensor data connected to GPIO
     * @return json with all sensor data
     * @var $sensor is an array of sensor type or empty for all sensor.
     * @throws \RuntimeException
     */
    public function getSensorData($sensor = array()) {
    	if (empty($sensor)) {
    		$sensorData = self::restService('allData');
    	} else {
    		foreach ($sensor as $device) {
    			$sensorData[$device] = json_decode(self::restService($device), true);
    		}
    	}

        return $sensorData;
    }

/**
     * Get all or specific sensor data connected to GPIO
     * @return json with all sensor data
     * @var $sensor is an array of sensor type or empty for all sensor.
     * @throws \RuntimeException
     */
    public function cronSaveSensorData($sensor = array()) {
    	if (empty($sensor)) {
    		$sensorData = self::restService('allData');
    	} else {
    		foreach ($sensor as $device) {
    			$sensorData[$device] = json_decode(self::restService($device), true);

    			switch ($device) {
    				case 'ds18b20':
    					foreach ($sensorData[$device] as $item) {
    						// Saving all records to populate database
					        $scholarlab_model = JModelLegacy::getInstance( 'ScholarLab', 'ScholarLabModel', array() );
					        $sensor_id = $item['Id'];
					        unset($item['Id']);
					        $data = json_encode($item);
					        $scholarlab_model->insertSensorData ($device, $sensor_id, $data);	
    					}
    					break;
    				
    				default:
    					// Saving all records to populate database
				        $scholarlab_model = JModelLegacy::getInstance( 'ScholarLab', 'ScholarLabModel', array() );
				        $sensor_id = $sensorData[$device]['Id'];
				        unset($sensorData[$device]['Id']);
				        $data = json_encode($sensorData[$device]);
				        $scholarlab_model->insertSensorData ($device, $sensor_id, $data);

    					break;
    			}
    		}
    	}

        return ;
    }

    protected function restService($endPoint = 'allData') {
    	// create curl resource
        $ch = curl_init();
        // set url
        $url = self::getRestUrl($endPoint);
        curl_setopt($ch, CURLOPT_URL, $url);
        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string
        $response = curl_exec($ch);
        // close curl resource to free up system resources
        curl_close($ch);

        return $response;
    }

    protected function getRestUrl($endPoint) {
    	$url = 'http://192.168.0.13:8080/' . $endPoint;
    	return $url;
	}
	
}
