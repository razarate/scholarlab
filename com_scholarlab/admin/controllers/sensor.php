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

/**
 * Room Controller
 *
 * @package     Webinar Administrator
 * @subpackage  com_webinaradministrator
 * @since       3.8.0
 */
class ScholarlabControllerSensor extends JControllerLegacy {

	public function add(){
		$msg = 'Redirecting from add Room Controller';
		$this->setRedirect(JRoute::_('index.php?option=com_scholarlab&view=sensor&layout=edit&id=0', false));
	}

	public function edit(){
		$input = JFactory::getApplication()->input;
		$id = $input->get('id', 0, 'int');
		if ($id == 0){
			$ids = $input->get('cid', array(), 'array');
			$id = $ids[0];
		}

		$msg = 'Redirecting from edit Room Controller';
		$this->setRedirect(JRoute::_("index.php?option=com_scholarlab&view=sensor&layout=edit&id=$id", false));
	}

	public function save($useId = 1){
		$input = JFactory::getApplication()->input;
		$data = $input->post->get('sensorform', array(), 'array');

		if (!$useId) {
			$data['id'] = 0;
			$data['title'] = $data['title'] . ' (copy)';
		}

		// Store data
		$model = $this->getModel();
		$id = $model->save($data);

		$this->setRedirect(JRoute::_("index.php?option=com_scholarlab&view=sensor&layout=edit&id=$id", false));
		
		return $id;
	}

	public function apply(){
		$input = JFactory::getApplication()->input;
		$id = $input->get('id', 0, 'int');
		$this->save();
		$this->setRedirect(JRoute::_("index.php?option=com_scholarlab&view=sensor&layout=edit&id=$id", false));
	}

	public function save2new(){
		$this->save();
		$this->setRedirect(JRoute::_("index.php?option=com_scholarlab&view=sensor&layout=edit&id=0", false));
	}

	public function save2copy(){
		$useId = 0;
		$id = $this->save($useId);
		$this->setRedirect(JRoute::_("index.php?option=com_scholarlab&view=sensor&layout=edit&id=$id", false));
	}

	public function cancel(){
		$this->setRedirect(JRoute::_("index.php?option=com_scholarlab", false), JText::_('COM_WEBINAR_ADMINISTRATOR_ROOM_CANCEL'));
	}

	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  object  The model.
	 *
	 * @since   1.6
	 */
	public function getModel($name = 'Sensor', $prefix = 'ScholarlabModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}
}