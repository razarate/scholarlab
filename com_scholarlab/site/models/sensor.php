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
	public function getSensorReadings($sensorid = NULL, $fromDate = NULL, $toDate = NULL) {

		if (is_null($sensorid)) {
			return false;
		}

		$records = $this->distinctRecords($sensorid, $fromDate, $toDate);
		$days = count($records);

		if ($days == 0) {
			return false;
		}

		if ($days < 4) {
			$timeframe = 'hour';
		} else {
			$timeframe = 'day';
		}

		// Check sensor Type
		$sensorInfo = self::getSensorList($sensorid);
		if ($sensorInfo[0]['sensor_type'] == 'bme280') {
			$sensorReadings = self::bme280ChartData($records, $sensorid, $timeframe);
		}

		if ($sensorInfo[0]['sensor_type'] == 'ds18b20') {
			$sensorReadings = self::ds18b20ChartData($records, $sensorid, $timeframe);
		}

		return $sensorReadings; 
	}


	protected function bme280ChartData($records = array(), $sensorid = NULL, $timeframe = 'day') {
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		$i = 0;
		if ($timeframe == 'hour') {

			$records = self::timeFrimeHours($records, $sensorid);

			while ($i < count($records)) {
				// Create a new query object.
				$query = $db->getQuery(true);

				$query
					->select("AVG(JSON_EXTRACT(data, '$.Temp')), AVG(JSON_EXTRACT(data, '$.Humidity')),
							AVG(JSON_EXTRACT(data, '$.Pressure')), AVG(JSON_EXTRACT(data, '$.Alt'))")
					->from($db->quoteName('#__scholarlab_sensor_measurement'))
					->where($db->quoteName('sensorid') . ' = ' . $sensorid)
					->where($db->quoteName('created') . ' BETWEEN ' . $db->quote($records[$i][1] . ' ' . $records[$i][0] .':00:00') . ' AND ' . $db->quote($records[$i][1] . ' ' . $records[$i][0] .':59:59'));

				// Reset the query using our newly populated query object.
				$db->setQuery($query);

				// Packing results to return data
				$rawData = $db->loadRow();
			    $tempData[$i] = $rawData[0];
			    $humidityData[$i] = $rawData[1];

			    $d = new DateTime($records[$i][1] . ' ' . $records[$i][0] . ':00:00');
			    $dateData[$i] = "'" . date_format($d, 'd-m-Y H:i') . "'";

			    $i++;
			}
		} elseif ($timeframe == 'day') {

			while ($i < count($records)) {
			// Create a new query object.
			$query = $db->getQuery(true);

			$query
				->select("AVG(JSON_EXTRACT(data, '$.Temp')), AVG(JSON_EXTRACT(data, '$.Humidity')),
							AVG(JSON_EXTRACT(data, '$.Pressure')), AVG(JSON_EXTRACT(data, '$.Alt'))")
				->from($db->quoteName('#__scholarlab_sensor_measurement'))
				->where($db->quoteName('sensorid') . ' = ' . $sensorid)
				->where($db->quoteName('created') . ' BETWEEN ' . $db->quote($records[$i] . ' 00:00:00') . ' AND ' . $db->quote($records[$i] . ' 23:59:59'));

			// Reset the query using our newly populated query object.
			$db->setQuery($query);

			// Packing results to return data
			$rawData = $db->loadRow();
			$tempData[$i] = $rawData[0];
			$humidityData[$i] = $rawData[1];

			$d = new DateTime($records[$i] . ' 00:00:00');
			$dateData[$i] = "'" . date_format($d, 'd-m-Y') . "'";

			$i++;
			}
		}

		// Packing arrays to return data
        $bme280GraphData['temp'] = array_reverse($tempData);
        $bme280GraphData['humidity'] = array_reverse($humidityData);
        $bme280GraphData['date'] = array_reverse($dateData);

        return $bme280GraphData; 
	}


	protected function ds18b20ChartData($records = array(), $sensorid = NULL, $timeframe = 'day') {
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		$i = 0;
		if ($timeframe == 'hour') {

			$records = self::timeFrimeHours($records, $sensorid);

			while ($i < count($records)) {
				// Create a new query object.
				$query = $db->getQuery(true);

				$query
					->select("AVG(JSON_EXTRACT(data, '$.Temp'))")
					->from($db->quoteName('#__scholarlab_sensor_measurement'))
					->where($db->quoteName('sensorid') . ' = ' . $sensorid)
					->where($db->quoteName('created') . ' BETWEEN ' . $db->quote($records[$i][1] . ' ' . $records[$i][0] .':00:00') . ' AND ' . $db->quote($records[$i][1] . ' ' . $records[$i][0] .':59:59'));

				// Reset the query using our newly populated query object.
				$db->setQuery($query);

				// Packing results to return data
				$rawData = $db->loadRow();
			    $tempData[$i] = $rawData[0];

			    $d = new DateTime($records[$i][1] . ' ' . $records[$i][0] . ':00:00');
			    $dateData[$i] = "'" . date_format($d, 'd-m-Y H:i') . "'";

			    $i++;
			}
		} elseif ($timeframe == 'day') {

			while ($i < count($records)) {
			// Create a new query object.
			$query = $db->getQuery(true);

			$query
				->select("AVG(JSON_EXTRACT(data, '$.Temp'))")
				->from($db->quoteName('#__scholarlab_sensor_measurement'))
				->where($db->quoteName('sensorid') . ' = ' . $sensorid)
				->where($db->quoteName('created') . ' BETWEEN ' . $db->quote($records[$i] . ' 00:00:00') . ' AND ' . $db->quote($records[$i] . ' 23:59:59'));

			// Reset the query using our newly populated query object.
			$db->setQuery($query);

			// Packing results to return data
			$rawData = $db->loadRow();
			$tempData[$i] = $rawData[0];

			$d = new DateTime($records[$i] . ' 00:00:00');
			$dateData[$i] = "'" . date_format($d, 'd-m-Y') . "'";

			$i++;
			}
		}

		// Packing arrays to return data
        $ds18b20ChartData['temp'] = array_reverse($tempData);
        $ds18b20ChartData['date'] = array_reverse($dateData);

        return $ds18b20ChartData; 
	}

	protected function timeFrimeHours($records = array(), $sensorid = NULL){
		// Get a db connection.
		$db = JFactory::getDbo();
		// Create a new query object.
		$query = $db->getQuery(true);

		$query
			->select($query->hour($query->quoteName('created')))
			->select("DATE(" . $db->quoteName('created') . ")")
			->from($db->quoteName('#__scholarlab_sensor_measurement'))
			->where($db->quoteName('sensorid') . ' = ' . $sensorid)
			->where($db->quoteName('created') . ' BETWEEN ' . $db->quote(end($records) . ' 00:00:00') . ' AND ' . $db->quote($records[0] . ' 23:59:59'))
			->group($query->day($query->quoteName('created')))
			->group($query->hour($query->quoteName('created')))
			->order(array($query->day($query->quoteName('created')) . ' ASC', $query->hour($query->quoteName('created')) . ' ASC'));
		$db->setQuery($query);
		
		return $db->loadRowList();
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
			->order($query->quoteName('created') . ' DESC');

		// Limit query
		if (!is_null($fromDate) || !is_null($toDate)) {
			$query->where($db->quoteName('created') . ' BETWEEN ' . $db->quote($fromDate . ' 00:00:00') . ' AND ' . $db->quote($toDate . ' 23:59:59'));
		} else {
			$query->setLimit('24');
		}
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		return $db->loadColumn();
	}
}