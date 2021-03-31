<?php
 /**
 * @package Component com_webinaradministrator for Joomla! 3.5+
 * @version $Id: clashroyale.php 3.8 2018-05-05 14:26:33Z Piensocial $
 * @author Piensocial.com
 * @copyright (C) 2010- Piensocial.com
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die;
//JFactory::getApplication()->enqueueMessage('<pre>dates: ' . print_r($dates,1) .'</pre>' , 'error');

class ScholarlabModelSensor extends JModelList {

	/**
	 * Method to get a table object, load it if necessary.
	 *
	 * @param   string  $type    The table name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JTable  A JTable object
	 *
	 * @since   1.6
	 */
	public function getTable($type = 'Sensor', $prefix = 'ScholarlabTable', $config = array()){
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getSensorList() {
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select all records from the user profile table where key begins with "custom.".
		// Order it by the ordering field.
		$query
			->select('*')
			->from($db->quoteName('#__scholarlab_sensor_details'))
			->where($db->quoteName('published') . " = 1")
			/*->group($db->quoteName('sensor_type'))*/;

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$results = $db->loadAssocList();

		return $results;

	}

	/**
	 * Insert sensor data
	 *
	 * @param   Text 	$sensor_type
	 * @param 	Text 	$sensor_id
	 * @param 	json 	$data
	 * @return  true / false
	 */
	public function insertSensorData($sensor_type = NULL, $sensor_id = NULL, $data = NULL) {

		if (!is_null($sensor_type) AND !is_null($sensor_id) AND !is_null($data)) {

			// Create and populate an object.
			$sensorData = new stdClass();
			$sensorData->sensor_type = $sensor_type;
			$sensorData->sensorid = $sensor_id;
			$sensorData->data = $data;

			// Insert the object into the user profile table.
			$result = JFactory::getDbo()->insertObject('#__scholarlab_sensor_measurement', $sensorData);

			return TRUE;
		}
		return FALSE;
	}

	protected function distinctRecords($sensorType = NULL, $sensorId = NULL, $fromDate = NULL, $toDate = NULL) {
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select all records from the scholar sensor table where $sensorType, $sensorId and dates.
		// Order it by the ordering field.
		$query
			->select("DISTINCT DATE(" . $db->quoteName('created') . ")")
			->from($db->quoteName('#__scholarlab_sensor_measurement'))
			->where($db->quoteName('sensor_type') . ' LIKE ' . $db->quote($sensorType))
			->order($query->quoteName('created') . ' DESC');
		
		// Select specific sensor ID
		if (!is_null($sensorId)) {
			$query->where($db->quoteName('sensor_id') . ' LIKE ' . $db->quote($sensorId));
		}

		// Limit query
		if (!is_null($fromDate) AND !is_null($toDate)) {
			$query->where($db->quoteName('created') . ' BETWEEN ' . $db->quote($fromDate . ' 00:00:00') . ' AND ' . $db->quote($toDate . ' 23:59:59'));
		} else {
			$query->setLimit('24');
		}
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		return $db->loadColumn();
	}
}