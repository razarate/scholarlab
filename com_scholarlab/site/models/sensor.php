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

	public function getSensorList($sensorid = NULL) {
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		$query
			->select('*')
			->from($db->quoteName('#__scholarlab_sensor_details'))
			->where($db->quoteName('published') . " = 1");

		if ($sensorid) {
			$query->where($db->quoteName('id') . " = " . $sensorid);
		}

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

	/**
	 * Get sensor data
	 *
	 * @param   Text 	$sensor_type
	 * @param 	Text 	$sensor_id
	 * @param 	json 	$data
	 * @return  true / false
	 */
	public function getSensorReadings($sensorid = NULL, $fromDate = NULL, $toDate = NULL, $timeframe = 'day') {

		if (is_null($sensorid)) {
			return false;
		}

		$records = $this->distinctRecords($sensorid, $fromDate, $toDate);
		$days = count($records);

		if ($days == 0) {
			return false;
		}

		// Check sensor Type
		$sensorInfo = self::getSensorList($sensorid);

		$chartData = self::chartData($records, $sensorid, $timeframe, $sensorInfo[0]['sensor_type']);

		return $chartData;

	}

	protected function chartData($records = array(), $sensorid = NULL, $timeframe = 'day', $sensor_type) {
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		$query = $db->getQuery(true);

		if ($sensor_type == 'bme280') {
			$query->select("AVG(JSON_EXTRACT(data, '$.Temp')) as temp, AVG(JSON_EXTRACT(data, '$.Humidity')) as humidity,
					AVG(JSON_EXTRACT(data, '$.Pressure')) as pressure, AVG(JSON_EXTRACT(data, '$.Alt')) as altitud");
		} elseif ($sensor_type == 'ds18b20') {
			$query->select("AVG(JSON_EXTRACT(data, '$.Temp')) as temp");
		}
		
		if ($timeframe == 'day') {
			$query->select("DATE_FORMAT(" . $db->quoteName('created') .", " . $db->quote('%d-%m-%Y') . ") as date");
		}
		
		if ($timeframe == 'hour') {
			$query->select("DATE_FORMAT(" . $db->quoteName('created') .", " . $db->quote('%d-%m-%Y %H') . ") as date");
		}

		$query
			->from($db->quoteName('#__scholarlab_sensor_measurement'))
			->where($db->quoteName('sensorid') . ' = ' . $sensorid)
			->where($db->quoteName('created') . ' BETWEEN ' . $db->quote(end($records) . ' 00:00:00') . ' AND ' . $db->quote($records[0] . ' 23:59:59'));
		
		if ($timeframe == 'day') {
			$query->group("DATE_FORMAT(" . $db->quoteName('created') .", " . $db->quote('%d-%m-%Y') . ")");
		}

		if ($timeframe == 'hour') {
			$query->group("DATE_FORMAT(" . $db->quoteName('created') .", " . $db->quote('%d-%m-%Y %H') . ")");
		}

		$query->order($query->quoteName('created') . ' ASC');
	
		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		return $db->loadAssocList();
	}


	protected function distinctRecords($sensorid = NULL, $fromDate = NULL, $toDate = NULL) {
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select all records from the scholar sensor table where $sensorType, $sensorId and dates.
		// Order it by the ordering field.
		$query
			->select("DISTINCT DATE(" . $db->quoteName('created') . ")")
			->from($db->quoteName('#__scholarlab_sensor_measurement'))
			->where($db->quoteName('sensorid') . ' = ' . $sensorid)
			->where($db->quoteName('created') . ' BETWEEN ' . $db->quote($fromDate . ' 00:00:00') . ' AND ' . $db->quote($toDate . ' 23:59:59'))
			->order($query->quoteName('created') . ' DESC')
			->setLimit('500');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		
		return $db->loadColumn();
	}
}