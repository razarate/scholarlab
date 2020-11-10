<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * View class for a list of contacts.
 *
 * @since  1.6
 */
class ScholarlabViewDashboard extends JViewLegacy
{

	/**
	 * The sidebar markup
	 *
	 * @var  string
	 */
	protected $sidebar;

	/**
	 * Display the view.
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise an Error object.
	 */
	public function display($tpl = null)
	{

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors), 500);
		}
		self::addToolbar();
		return parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   1.0.0
	 */
	protected function addToolbar()
	{
		JToolbarHelper::title('Scholar Lab Dashboard');
		JToolbarHelper::preferences('com_scholarlab');
		//JHtmlSidebar::setAction('index.php?option=com_scholarlab');
	}

}
