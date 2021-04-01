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
class ScholarLabViewProxy extends JViewLegacy {

    /**
     * This display function returns in json format true or false when opening or closing room
     */

	public function display($tpl = null) {

        $input = JFactory::getApplication()->input;
        $device = $input->get('device', '', 'STR');

        $this->sensorData = call_user_func_array("array_merge", SensorHelper::getSensorData($device));
        echo new JResponseJson(json_encode($this->sensorData));
    }

}
