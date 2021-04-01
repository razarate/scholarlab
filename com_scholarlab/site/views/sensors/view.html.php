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

        $device_id = array(1,2,4);
        $this->dashboardData = self::dashboardData($device_id);

        // Check for errors.
        if (count($errors = $this->get('Errors')))
        {
            JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');

            return false;
        }


        self::addJavascript();

        // Display the view
        parent::display($tpl);
    }

    protected function dashboardData($device_id = array()) {
        $input = JFactory::getApplication()->input;
        $time_frame = $input->get('timeframe', 'hour', 'STR');

        if ($time_frame == 'hour') {
            $fromDate = date('Y-m-d', strtotime("-2 days"));
            $toDate = date('Y-m-d', time());

        } else {
            $fromDate = date('Y-m-d', strtotime("-14 days"));
            $toDate = date('Y-m-d', time());
        }

        foreach ($device_id as $device) {
            $dashboardData[$device] = self::sensorChartData($device, $fromDate, $toDate);
        }

        return $dashboardData;
    }

    protected function sensorChartData($sensorid = NULL, $fromDate = NULL, $toDate = NULL) {

        // Load Temp data from database
        $sensor_model = JModelLegacy::getInstance( 'Sensor', 'ScholarLabModel', array() );

        $tempGraphData = $sensor_model->getSensorReadings($sensorid, $fromDate, $toDate);

        return $tempGraphData;

    }

    protected function addJavascript() {

        $document = JFactory::getDocument();
        // everything's dependent upon JQuery
        JHtml::_('jquery.framework');

        //  load JS and CSS
        $document->addScript(JURI::root() . "media/com_scholarlab/js/sensor.js");

    }

}