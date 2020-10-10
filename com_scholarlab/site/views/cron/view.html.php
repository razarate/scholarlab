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
 * HTML View class for the HelloWorld Component
 *
 * @since  0.0.1
 */
class ScholarLabViewCron extends JViewLegacy
{

    function display($tpl = null)
    {
        // Assign data to the view

        $sensors = array('bme280', 'ds18b20');
        SensorHelper::cronSaveSensorData($sensors);
         
        // Check for errors.
        if (count($errors = $this->get('Errors')))
        {
            JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');

            return false;
        }

        // Display the view
        parent::display($tpl);
    }

}