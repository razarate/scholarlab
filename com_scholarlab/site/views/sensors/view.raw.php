<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_scholarlab
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * HTML View class for the Scholar Lab Component
 *
 * @since  0.0.1
 */
class ScholarLabViewSensors extends JViewLegacy {
    /**
     * Display the Hello World view
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void
     */
    public function display($tpl = null) {
        // Assign data to the view
       
        $this->bme280GraphData = self::bme280GraphData('bme280', NULL, NULL);
        
        
        // Check for errors.
        if (count($errors = $this->get('Errors')))
        {
            JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');

            return false;
        }

        // Display the view
        parent::display($tpl);
    }

    protected function bme280GraphData($sensorType = NULL, $fromDate = NULL, $toDate = NULL) {

        if (is_null($fromDate) || is_null($toDate)) {
            $fromDate = date('Y-m-d',strtotime('-30 days'));    //Thirty days before 'now'
            $toDate = date('Y-m-d');
        }

        if ($fromDate <= $toDate) {

        }

        // Load Temp data from database
        $sensor_model = JModelLegacy::getInstance( 'Sensor', 'ScholarLabModel', array() );

        $tempGraphData = $sensor_model->getSensorReadings(4);

        return $tempGraphData;

    }

}