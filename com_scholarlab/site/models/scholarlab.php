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

class ScholarlabModelScholarlab extends JModelList {

	/**
	 * @var string message
	 */
	protected $sensor_data;

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
	public function getTable($type = 'ScholarLab', $prefix = 'Table', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Get sensor data
	 *
	 * @param   integer  $id  Sensor Data Id
	 *
	 * @return  json     Fetched Json from Table for relevant Id
	 */


	public function tempGraphData($sensorType = NULL, $fromDate = NULL, $toDate = NULL) {

		if ($fromDate <= $toDate) {
			
			// Get a db connection.
			$db = JFactory::getDbo();

			// Create a new query object.
			$query = $db->getQuery(true);

			// Select all records from the user profile table where key begins with "custom.".
			// Order it by the ordering field.
			$query
				->select(" DISTINCT DATE(created) ")
				->from($db->quoteName('#__scholarlab_sensor_measurement'))
				->where($db->quoteName('sensor_id') . ' LIKE ' . $db->quote($sensorType));
				if (!is_null($fromDate) AND !is_null($toDate)) {
					//$query->where($db->quoteName('created') . ' BETWEEN ' . $db->quote($fromDate) . ' AND ' . $db->quote($toDate));
				}

			// Reset the query using our newly populated query object.
			$db->setQuery($query);

			$dates = $db->loadColumn();

			$days = count($dates);

			
			if ($days > 12) {

				list($whole, $decimal) = explode('.', $days/12);

			} else {
				$whole = 1;
				$decimal = 0;
			}

			// Get a db connection.
			$db = JFactory::getDbo();

			$i = $whole;
			$extra = $decimal;

			foreach ($dates as $date) {
		
				if ($i == $whole) {
					$i = $i-1;

					// Create a new query object.
					$query = $db->getQuery(true);

					// Select all records from sensor measurement table.
					// Order it by table id.

					$query
						->select("AVG(JSON_EXTRACT(data, '$.Temp')), AVG(JSON_EXTRACT(data, '$.Pressure'))")
						->from($db->quoteName('#__scholarlab_sensor_measurement'))
						->where($db->quoteName('sensor_id') . ' LIKE ' . $db->quote($sensorType))
						->where($db->quoteName('created') . ' BETWEEN ' . $db->quote($date . ' 00:00:00') . ' AND ' . $db->quote($date . ' 23:59:59'));

					// Reset the query using our newly populated query object.
					$db->setQuery($query);

					// Packing result to return data
					$rawData = $db->loadRow();
			        $tempData[] = $rawData[0];
			        $pressureData[] = $rawData[1];
			        $dateData[] = "'" . date('d M y', strtotime($date)) . "'";

				} else {
					if ($i <= 0) {
						$i = $whole;
					} else {
						$i-1;	
					} 

				}
			}

			// Packing both arrays to return data
	        $tempGraphData['temp'] = $tempData;
	        $tempGraphData['press'] = $pressureData;
	        $tempGraphData['date'] = $dateData;

			return $tempGraphData;

		}else {
			JFactory::getApplication()->enqueueMessage( 'La fecha de fin es menor que fecha de inicio' , 'notice');

		}
		
	}


	public function tempGraphDht11($sensorType = NULL, $fromDate = NULL, $toDate = NULL) {

		if ($fromDate <= $toDate) {

			// Get a db connection.
			$db = JFactory::getDbo();

			// Create a new query object.
			$query = $db->getQuery(true);

			// Select all records from the user profile table where key begins with "custom.".
			// Order it by the ordering field.
			$query
				->select(" DISTINCT DATE(created) ")
				->from($db->quoteName('#__scholarlab_sensor_measurement'))
				->where($db->quoteName('sensor_id') . ' LIKE ' . $db->quote($sensorType))
				->where($db->quoteName('created') . ' BETWEEN ' . $db->quote($fromDate) . ' AND ' . $db->quote($toDate));

			// Reset the query using our newly populated query object.
			$db->setQuery($query);

			$dates = $db->loadColumn();

			$days = count($dates);

			
			if ($days > 12) {

				list($whole, $decimal) = explode('.', $days/12);

			} else {
				$whole = 1;
				$decimal = 0;
			}

			// Get a db connection.
			$db = JFactory::getDbo();

			$i = $whole;
			$extra = $decimal;

			foreach ($dates as $date) {
		
				if ($i == $whole) {
					$i = $i-1;

					// Create a new query object.
					$query = $db->getQuery(true);

					// Select all records from sensor measurement table.
					// Order it by table id.

					$query
						->select("AVG(JSON_EXTRACT(data, '$.Temp')), AVG(JSON_EXTRACT(data, '$.Humidity'))")
						->from($db->quoteName('#__scholarlab_sensor_measurement'))
						->where($db->quoteName('sensor_id') . ' LIKE ' . $db->quote($sensorType))
						->where($db->quoteName('created') . ' BETWEEN ' . $db->quote($date . ' 00:00:00') . ' AND ' . $db->quote($date . ' 23:59:59'));

					// Reset the query using our newly populated query object.
					$db->setQuery($query);

					// Packing result to return data
					$rawData = $db->loadRow();

			        $tempData[] = $rawData[0];
			        $humidityData[] = $rawData[1];
			        $dateData[] = "'" . date('d M y', strtotime($date)) . "'";


				} else {
					if ($i <= 0) {
						$i = $whole;
					} else {
						$i-1;	
					} 

				}
			}

			// Packing both arrays to return data
	        $tempGraphData['temp'] = $tempData;
	        $tempGraphData['humidity'] = $humidityData;
	        $tempGraphData['date'] = $dateData;

			return $tempGraphData;
		}else {
			JFactory::getApplication()->enqueueMessage( 'La fecha de fin es menor que fecha de inicio' , 'notice');

		}
		
	}


	/**
	 * Get sensor data
	 *
	 * @param   integer  $id  Sensor Data Id
	 *
	 * @return  json     Fetched Json from Table for relevant Id
	 */
// >>>>>>>>>>>>>>>>>>>>>>>>>>>>> Cambiar nombre a insertSensorData - generalizar la función <<<<<<<<<<<<<<<<<<<<<<<
	public function saveSensorData ($sensor_id = NULL, $data = NULL) {

		if (!is_null($sensor_id) AND !is_null($data)) {

			// Create and populate an object.
			$sensorData = new stdClass();
			$sensorData->sensor_id = $sensor_id;
			$sensorData->data = $data;

			// Insert the object into the user profile table.
			$result = JFactory::getDbo()->insertObject('#__scholarlab_sensor_measurement', $sensorData);

			return TRUE;
		}
		return FALSE;
	}
}
