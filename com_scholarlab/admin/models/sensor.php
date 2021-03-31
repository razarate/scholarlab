<?php
 /**
 * @package Component com_webinaradministrator for Joomla! 3.5+
 * @version $Id: room.php 3.8 2018-05-05 14:26:33Z Piensocial $
 * @author Piensocial.com
 * @copyright (C) 2010- Piensocial.com
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Factory;

/**
 * Room Model
 *
 * @since  3.8.0
 */
class ScholarlabModelSensor extends JModelAdmin {

	/**
	 * Method to get a table object, load it if necessary.
	 *
	 * @param   string  $type    The table name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JTable  A JTable object
	 *
	 * @since   3.8.0
	 */
	public function getTable($type = 'Sensor', $prefix = 'ScholarlabTable', $config = array()){
		return JTable::getInstance($type, $prefix, $config);
	}


	public function getItem(){
		$input = JFactory::getApplication()->input;
		$id = $input->get('id', 0, 'int');
		$table = $this->getTable();
		$table->load($id);

		return $table;
	}

	/**
	 * Method to get the record form.
	 *
	 * @param   array    $data      Data for the form.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  mixed    A JForm object on success, false on failure
	 *
	 * @since   3.8.0
	 */
	public function getForm($data = array(), $loadData = true){

		// Get the form.
		$form = $this->loadForm(
			'com_scholarlab.sensor',
			'sensor',
			array(
				'control' => 'sensorform',
				'load_data' => $loadData
			)
		);
		if (empty($form)) {
			return false;
		}
		return $form;
	}	

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return  mixed  The data for the form.
	 *
	 * @since   3.8.0
	 */
	protected function loadFormData(){
		$data = JFactory::getApplication()->getUserState(
			'com_scholarlab.edit.sensor.data',
			array()
		);
		
		if (empty($data)) {
			$data = $this->getItem();
		}
		return $data;
	}

	public function save($data){

		$table = $this->getTable();
		$table->bind($data);
		$table->store();

		return $table->id;
	}
	
	public function delete(&$pks) {

		$table = $this->getTable();
		
		foreach ($pks as $id) {

			$table->delete($id);
		}

	}

}