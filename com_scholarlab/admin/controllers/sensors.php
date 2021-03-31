<?php
 /**
 * @package Component com_webinaradministrator for Joomla! 3.5+
 * @version $Id: rooms.php 3.8 2018-05-05 14:26:33Z Piensocial $
 * @author Piensocial.com
 * @copyright (C) 2010- Piensocial.com
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Rooms Controller
 *
 * @since  3.8.0
 */
class ScholarlabControllerSensors extends JControllerAdmin
{
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

	public function delete() {
JFactory::getApplication()->enqueueMessage('Se utilizó el controlador sensors para borra', 'error');
		$input = JFactory::getApplication()->input;
		$pks = $input->post->get('cid', array(), 'array');
		$npks = $input->post->get('boxchecked', 0, 'int');
		$model = $this->getModel();
		$model->delete($pks);
		$msg = JText::_('COM_WEBINARADMINISTRATOR_N_ITEMS_TRASHED');
		$this->setRedirect(JRoute::_('index.php?option=com_scholarlab&view=sensors'), $msg);
	}
}
