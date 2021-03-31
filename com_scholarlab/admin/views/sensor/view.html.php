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
 * Room View
 *
 * @since  3.8.0
 */
class ScholarlabViewSensor extends JViewLegacy{

	/**
	 * View form
	 *
	 *@var         form
	 *@var         item 
	 *@var         canDo
	 */
	protected $form;
	protected $item;
	protected $canDo;
	
	/**
	 * Display the Room view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 */
	public function display($tpl = null){

		// Get the Data
		$this->form			= $this->get('Form');
		$this->item			= $this->get('Item');

		// What Access Permissions does this user have? What can do?
		$this->canDo = JHelperContent::getActions('com_scholarlab', 'sensor', $this->item->id);

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors), 500);
		}

		// Set the toolbar
		$this->addToolbar();
		
		// Display the template
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}
	
	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   3.8.0
	 */
	protected function addToolbar() {

		$input = JFactory::getApplication()->input;

		// Hide Joomla Administrator Main menu
		$input->set('hidemainmenu', true);


		$isNew = ($this->item->id == 0);

		JToolBarHelper::title($isNew ? JText::_('COM_SCHOLARLAB_SENSOR_NEW')
		                             : JText::_('COM_SCHOLARLAB_SENSOR_EDIT'), 'sensor');

		// Build the actions for new and existing records.
		if ($isNew)
		{
			// For new records, check the create permission.
			if ($this->canDo->get('core.create')) 
			{
				JToolBarHelper::apply('sensor.apply');
				JToolBarHelper::save('sensor.save');
				JToolBarHelper::save2new('sensor.save2new');
				JToolBarHelper::save2copy('sensor.save2copy');
			}
			JToolBarHelper::cancel('sensor.cancel');
		}
		else
		{
			if ($this->canDo->get('core.edit'))
			{
				// We can save the new record
				JToolBarHelper::apply('sensor.apply');
				JToolBarHelper::save('sensor.save');
 
				// We can save this record, but check the create permission to see
				// if we can return to make a new one.
				if ($this->canDo->get('core.create')) 
				{
					JToolBarHelper::save2new('sensor.save2new');
					JToolBarHelper::save2copy('sensor.save2copy');
				}
			}
			JToolBarHelper::cancel('sensor.cancel', 'JTOOLBAR_CLOSE');
		}
	}

	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
		$isNew = ($this->item->id < 1);
		$document = JFactory::getDocument();
		$document->setTitle($isNew ? JText::_('COM_WEBINAR_ADMINISTRATOR_ROOM_NEW') :
                JText::_('COM_WEBINAR_ADMINISTRATOR_ROOM_EDIT'));
	}
}
