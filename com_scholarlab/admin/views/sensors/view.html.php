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

class ScholarlabViewSensors extends JViewLegacy {

	protected $items;
	protected $pagination;

	/**
	 * Display the Webinar Administrator view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 */
	public function display($tpl = null){

		// Get application
		$app = JFactory::getApplication();
		$context = "scholarlab.list.admin.scholarlab";

		// Get data from the model
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state			= $this->get('State');
		$this->filter_order 	= $app->getUserStateFromRequest($context.'filter_order', 'filter_order', 'title', 'cmd');
		$this->filter_order_Dir = $app->getUserStateFromRequest($context.'filter_order_Dir', 'filter_order_Dir', 'asc', 'cmd');
		$this->filterForm    	= $this->get('FilterForm');
		$this->activeFilters 	= $this->get('ActiveFilters');

		// What Access Permissions does this user have? What can do?
		$this->canDo = JHelperContent::getActions('com_scholarlab');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors), 500);
		}

		// Set the submenu
		ScholarlabHelper::addSubmenu('sensors');

		// Set the toolbar
		$this->addToolbar();

		// Display the template
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}

	protected function addToolbar(){

		$title = JText::_('COM_SCHOLARLAB_SENSORS_TOOLBAR_TITLE');
/*
		if ($this->pagination->total)
		{
			$title .= "<span style='font-size: 0.5em; vertical-align: middle;'>(" . $this->pagination->total . ")</span>";
		}
*/
		JToolBarHelper::title($title, "scholarlab");

		if ($this->canDo->get('core.create')){
			JToolbarHelper::addNew('sensor.add');
		}
		
		if ($this->canDo->get('core.edit')){
			JToolbarHelper::editList('sensor.edit');
		}
	    
	    if ($this->canDo->get('core.delete')){
	    	JToolbarHelper::deleteList('', 'sensors.delete', 'JTOOLBAR_DELETE');
	    }
	    
	    if ($this->canDo->get('core.admin')){
	    	JToolBarHelper::divider();
	    	JToolbarHelper::preferences('com_scholarlab');
	    }
	    
	}

	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_WEBINAR_ADMINISTRATOR_ADMINISTRATION'));
	}
	
}
