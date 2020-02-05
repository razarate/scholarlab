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
				->where($db->quoteName('created') . ' BETWEEN ' . $db->quote($fromDate) . ' AND ' . $db->quote($toDate));

			// Reset the query using our newly populated query object.
			$db->setQuery($query);

			$dates = $db->loadColumn();

			$days = count($dates);

			if ($days > 12) {
				# some code here ...
			} else {
				# some code here ...
			}


			// Get a db connection.
			$db = JFactory::getDbo();

			foreach ($dates as $date) {
			
				// Create a new query object.
				$query = $db->getQuery(true);

				// Select all records from sensor measurement table.
				// Order it by table id.
				$query
					->select("AVG(JSON_EXTRACT(data, '$.Temp'))")
					->from($db->quoteName('#__scholarlab_sensor_measurement'))
					->where($db->quoteName('created') . ' BETWEEN ' . $db->quote($date) . ' AND ' . $db->quote($date . ' 23:59:59'));

				// Reset the query using our newly populated query object.
				$db->setQuery($query);

				// Packing result to return data
		        $tempData[] = $db->loadResult();
		        $dateData[] = $date;
			}

			// Packing both arrays to return data
	        $tempGraphData['temp'] = $tempData;
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
