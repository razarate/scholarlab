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


	public function bme280GraphData($sensorType = NULL, $sensorId = NULL, $fromDate = NULL, $toDate = NULL) {
		// Get a db connection.
		$db = JFactory::getDbo();

			// Create a new query object.
			$query = $db->getQuery(true);

			// Select all records from the user profile table where key begins with "custom.".
			// Order it by the ordering field.
			$query
				->select("DISTINCT DATE(" . $db->quoteName('created') . ")")
				->from($db->quoteName('#__scholarlab_sensor_measurement'))
				->where($db->quoteName('sensor_type') . ' LIKE ' . $db->quote($sensorType));
			// Reset the query using our newly populated query object.
			$db->setQuery($query);
			$dates = $db->loadColumn();
			$days = count($dates);

			if ($days == 0) {
				
				return ;

			} elseif ($days == 1) { // Todo: Si son mas de 12 divirlo.
				$startHour = 0;
				$endHour = 0;
				// Create a new query object.
				$query = $db->getQuery(true);

				// Select all records from sensor measurement table.
				// Order it by table id.
				$query
					->select("JSON_EXTRACT(data, '$.Temp'), JSON_EXTRACT(data, '$.Pressure')")
					->from($db->quoteName('#__scholarlab_sensor_measurement'))
					->where($db->quoteName('sensor_type') . ' LIKE ' . $db->quote($sensorType))
					->where($db->quoteName('created') . ' BETWEEN ' . $db->quote($dates[0] . ' 00:00:00') . ' AND ' . $db->quote($dates[0] . ' 23:59:59'));

				// Reset the query using our newly populated query object.
				$db->setQuery($query);

				// Packing result to return data
				$rawData = $db->loadRowList();

				foreach ($rawData as $singleData) {
			        $tempData[] = $singleData[0];
			        $pressureData[] = $singleData[1];
			        $dateData[] = "'" . date('d M y', strtotime($date)) . "'";
				}

			} else {
				if ($days > 12) {
					list($whole, $decimal) = explode('.', $days/12);
				} else {
					$whole = 1;
					$decimal = 0;
				}
				$i = $whole;

				foreach ($dates as $date) {
					if ($whole == $i) {
						// Create a new query object.
						$query = $db->getQuery(true);

						// Select all records from sensor measurement table.
						$query
							->select("AVG(JSON_EXTRACT(data, '$.Temp')), AVG(JSON_EXTRACT(data, '$.Humidity')), AVG(JSON_EXTRACT(data, '$.Pressure'))")
							->from($db->quoteName('#__scholarlab_sensor_measurement'))
							->where($db->quoteName('sensor_type') . ' LIKE ' . $db->quote($sensorType))
							->where($db->quoteName('created') . ' BETWEEN ' . $db->quote($date . ' 00:00:00') . ' AND ' . $db->quote($date . ' 23:59:59'));

						// Reset the query using our newly populated query object.
						$db->setQuery($query);

						// Packing results to return data
						$rawData = $db->loadRow();
				        $tempData[] = $rawData[0];
				        $humidityData[] = $rawData[1];
				        $dateData[] = "'" . date('d M y', strtotime($date)) . "'";

				        $i = $i-1;
				        if ($i <= 0) {
				        	$i = $whole;
				        }
					}
				}	
			}

		// Packing arrays to return data
        $bme280GraphData['temp'] = $tempData;
        $bme280GraphData['humidity'] = $humidityData;
        $bme280GraphData['date'] = $dateData;

		return $bme280GraphData;
	}

	/**
	 * Get sensor data
	 *
	 * @param   integer  $id  Sensor Data Id
	 *
	 * @return  json     Fetched Json from Table for relevant Id
	 */


	public function bmp280GraphData($sensorType = NULL, $sensorId = NULL, $fromDate = NULL, $toDate = NULL) {
		// Get a db connection.
		$db = JFactory::getDbo();

			// Create a new query object.
			$query = $db->getQuery(true);

			// Select all records from the user profile table where key begins with "custom.".
			// Order it by the ordering field.
			$query
				->select("DISTINCT DATE(" . $db->quoteName('created') . ")")
				->from($db->quoteName('#__scholarlab_sensor_measurement'))
				->where($db->quoteName('sensor_type') . ' LIKE ' . $db->quote($sensorType));
			// Reset the query using our newly populated query object.
			$db->setQuery($query);
			$dates = $db->loadColumn();
			$days = count($dates);

			if ($days == 0) {
				
				return ;

			} elseif ($days == 1) { // Todo: Si son mas de 12 divirlo.
				$startHour = 0;
				$endHour = 0;
				// Create a new query object.
				$query = $db->getQuery(true);

				// Select all records from sensor measurement table.
				// Order it by table id.
				$query
					->select("JSON_EXTRACT(data, '$.Temp'), JSON_EXTRACT(data, '$.Pressure')")
					->from($db->quoteName('#__scholarlab_sensor_measurement'))
					->where($db->quoteName('sensor_type') . ' LIKE ' . $db->quote($sensorType))
					->where($db->quoteName('created') . ' BETWEEN ' . $db->quote($dates[0] . ' 00:00:00') . ' AND ' . $db->quote($dates[0] . ' 23:59:59'));

				// Reset the query using our newly populated query object.
				$db->setQuery($query);

				// Packing result to return data
				$rawData = $db->loadRowList();

				foreach ($rawData as $singleData) {
			        $tempData[] = $singleData[0];
			        $pressureData[] = $singleData[1];
			        $dateData[] = "'" . date('d M y', strtotime($date)) . "'";
				}

			} else {
				if ($days > 12) {
					list($whole, $decimal) = explode('.', $days/12);
				} else {
					$whole = 1;
					$decimal = 0;
				}
				$i = $whole;

				foreach ($dates as $date) {
					if ($whole == $i) {
						// Create a new query object.
						$query = $db->getQuery(true);

						// Select all records from sensor measurement table.
						$query
							->select("AVG(JSON_EXTRACT(data, '$.Temp')), AVG(JSON_EXTRACT(data, '$.Pressure'))")
							->from($db->quoteName('#__scholarlab_sensor_measurement'))
							->where($db->quoteName('sensor_type') . ' LIKE ' . $db->quote($sensorType))
							->where($db->quoteName('created') . ' BETWEEN ' . $db->quote($date . ' 00:00:00') . ' AND ' . $db->quote($date . ' 23:59:59'));

						// Reset the query using our newly populated query object.
						$db->setQuery($query);

						// Packing results to return data
						$rawData = $db->loadRow();
				        $tempData[] = $rawData[0];
				        $pressureData[] = $rawData[1];
				        $dateData[] = "'" . date('d M y', strtotime($date)) . "'";

				        $i = $i-1;
				        if ($i <= 0) {
				        	$i = $whole;
				        }
					}
				}	
			}

		// Packing arrays to return data
        $bmp280GraphData['temp'] = $tempData;
        $bmp280GraphData['press'] = $pressureData;
        $bmp280GraphData['date'] = $dateData;

		return $bmp280GraphData;
	}

	/**
	 * Get sensor data
	 *
	 * @param   integer  $id  Sensor Data Id
	 *
	 * @return  json     Fetched Json from Table for relevant Id
	 */


	public function ds18b20GraphData($sensorType = NULL, $sensorId = NULL, $fromDate = NULL, $toDate = NULL) {
		// Get a db connection.
		$db = JFactory::getDbo();

			// Create a new query object.
			$query = $db->getQuery(true);

			// Select all records from the user profile table where key begins with "custom.".
			// Order it by the ordering field.
/* Versión para varios días.
			$query
				->select("DISTINCT DATE(" . $db->quoteName('created') . ")")
				->from($db->quoteName('#__scholarlab_sensor_measurement'))
				->where($db->quoteName('sensor_type') . ' LIKE ' . $db->quote($sensorType))
				->where($db->quoteName('sensor_id') . ' LIKE ' . $db->quote($sensorId));
*/
			// Versión para horas

			$fecha = date("Y-m-d");

/* Se realizó una consulta mas eficiente abajo. Obtiene las últimas 24 horas.
			$query
				->select("TIME(" . $db->quoteName('created') . ")")
				->from($db->quoteName('#__scholarlab_sensor_measurement'))
				->where($db->quoteName('sensor_type') . ' LIKE ' . $db->quote($sensorType))
				->where($db->quoteName('sensor_id') . ' LIKE ' . $db->quote($sensorId))
				->where($db->quoteName('created') . ' BETWEEN ' . $db->quote($fecha . ' 00:00:00') . ' AND ' . $db->quote($fecha . ' 23:59:59'));

			// Reset the query using our newly populated query object.
			$db->setQuery($query);
			$dates = $db->loadColumn();
			$days = count($dates);
*/
///////////////////////////////////////////////////////////////////////////////////////
// Create a new query object.
$query = $db->getQuery(true);
$query
	->select($query->hour($query->quoteName('created')))
	->select("DATE(" . $db->quoteName('created') . ")")
	->from($db->quoteName('#__scholarlab_sensor_measurement'))
	->where($db->quoteName('sensor_type') . ' LIKE ' . $db->quote($sensorType))
	->where($db->quoteName('sensor_id') . ' LIKE ' . $db->quote($sensorId))
	->where($db->quoteName('created') . ' >= NOW() - INTERVAL 24 HOUR')
	->group($query->hour($query->quoteName('created')))
	->order(array($query->day($query->quoteName('created')) . ' ASC', $query->hour($query->quoteName('created')) . ' ASC'));
$db->setQuery($query);
$hours = $db->loadRowList();
//JFactory::getApplication()->enqueueMessage('<pre>' . print_r($hours, 1) . '</pre>', 'notice');
///////////////////////////////////////////////////////////////////////////////////////
			if ($hours == 0) {
				
				return ;

			} elseif ($hours == 1) { // Todo: Si son mas de 12 divirlo.
				$startHour = 0;
				$endHour = 0;
				// Create a new query object.
				$query = $db->getQuery(true);

				// Select all records from sensor measurement table.
				// Order it by table id.
				$query
					->select("JSON_EXTRACT(data, '$.Temp')")
					->from($db->quoteName('#__scholarlab_sensor_measurement'))
					->where($db->quoteName('sensor_type') . ' LIKE ' . $db->quote($sensorType))
					->where($db->quoteName('sensor_id') . ' LIKE ' . $db->quote($sensorId))
					->where($db->quoteName('created') . ' BETWEEN ' . $db->quote($dates[0] . ' 00:00:00') . ' AND ' . $db->quote($dates[0] . ' 23:59:59'));

				// Reset the query using our newly populated query object.
				$db->setQuery($query);

				// Packing result to return data
				$rawData = $db->loadRowList();

				foreach ($rawData as $singleData) {
			        $tempData[] = $singleData[0];
			        $dateData[] = "'" . date('d M y', strtotime($date)) . "'";
				}

			} else {
				/*
				list($whole, $decimal) = explode('.', $days/12);
				$count = count($dates);
				$decimal = '.'.$decimal;
				$i = 0;
				$decimalCorrection = 0;
				*/
				$i = 0;
				while ($i < 24) {
						// Create a new query object.
						$query = $db->getQuery(true);

/* Versión para varios días.
						// Select all records from sensor measurement table.
						$query
							->select("AVG(JSON_EXTRACT(data, '$.Temp'))")
							->from($db->quoteName('#__scholarlab_sensor_measurement'))
							->where($db->quoteName('sensor_type') . ' LIKE ' . $db->quote($sensorType))
							->where($db->quoteName('sensor_id') . ' LIKE ' . $db->quote($sensorId))
							->where($db->quoteName('created') . ' BETWEEN ' . $db->quote($date . ' 00:00:00') . ' AND ' . $db->quote($date . ' 23:59:59'));
*/

						// Versión para horas
						$query
							->select("AVG(JSON_EXTRACT(data, '$.Temp'))")
							->from($db->quoteName('#__scholarlab_sensor_measurement'))
							->where($db->quoteName('sensor_type') . ' LIKE ' . $db->quote($sensorType))
							->where($db->quoteName('sensor_id') . ' LIKE ' . $db->quote($sensorId))
							->where($db->quoteName('created') . ' BETWEEN ' . $db->quote($hours[$i][1] . ' ' . $hours[$i][0] .':00:00') . ' AND ' . $db->quote($hours[$i][1] . ' ' . $hours[$i][0] .':59:59'));

						// Reset the query using our newly populated query object.
						$db->setQuery($query);

						// Packing results to return data
						$rawData = $db->loadRow();
				        $tempData[] = $rawData[0];
				        $dateData[] = "'" . $hours[$i][0] . ':00' . "'";

				        $i++;
				    /*
				    $i = $i + $whole;
					$decimalCorrection = $decimalCorrection + $decimal;
					if ($decimalCorrection >= 1) {
						$i++;
						$decimalCorrection = strstr($decimalCorrection, '.' );
					}
					*/
				}
			}

		// Packing arrays to return data
        $ds18b20GraphData['temp'] = $tempData;
        $ds18b20GraphData['date'] = $dateData;

		return $ds18b20GraphData;
	}

	/**
	 * Insert sensor data
	 *
	 * @param   Text 	$sensor_type
	 * @param 	Text 	$sensor_id
	 * @param 	json 	$data
	 * @return  true / false
	 */
	public function insertSensorData ($sensor_type = NULL, $sensor_id = NULL, $data = NULL) {

		if (!is_null($sensor_type) AND !is_null($sensor_id) AND !is_null($data)) {

			// Create and populate an object.
			$sensorData = new stdClass();
			$sensorData->sensor_type = $sensor_type;
			$sensorData->sensor_id = $sensor_id;
			$sensorData->data = $data;

			// Insert the object into the user profile table.
			$result = JFactory::getDbo()->insertObject('#__scholarlab_sensor_measurement', $sensorData);

			return TRUE;
		}
		return FALSE;
	}
}