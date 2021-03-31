<?php
 /**
 * @package Component com_webinaradministrator for Joomla! 3.5+
 * @version $Id: webinaradministrator.php 3.8 2018-05-05 14:26:33Z Piensocial $
 * @author Piensocial.com
 * @copyright (C) 2010- Piensocial.com
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Webinar Admnistrator component helper.
 *
 * @param   string  $submenu  The name of the active view.
 *
 * @return  void
 *
 * @since   3.8.0
 */
abstract class ScholarlabHelper  extends JHelperContent{
	/**
	 * Configure the Linkbar.
	 *
	 * @return Bool
	 */
	public static function addSubmenu($vName = 'sensors'){
		
		//Rooms submenu
		JHtmlSidebar::addEntry(
			JText::_('COM_SCHOLARLAB_SUBMENU_SENSORS'),
			'index.php?option=com_scholarlab&view=sensors',
			$vName == 'sensors'
		);

		//Categories submenu
		JHtmlSidebar::addEntry(
			JText::_('COM_SCHOLARLAB_SUBMENU_CATEGORIES'),
			'index.php?option=com_categories&view=categories&extension=com_scholarlab',
			$vName == 'categories'
		);
		if ($vName == 'categories') {
			JToolbarHelper::title(JText::sprintf('COM_SCHOLARLAB_CATEGORIES_TITLE', JText::_('com_scholarlab')),'sensors-categories'); 
		}

	}
	
	public static function getActions($categoryId = 0){

		$user  = JFactory::getUser();
	    $result  = new JObject;

	    if (empty($categoryId))
	    {
	      $assetName = 'com_scholarlab';
	      $level = 'component';
	    }
	    else
	    {
	      $assetName = 'com_scholarlab.category.'.(int) $categoryId;
	      $level = 'category';
	    }

	    $actions = JAccess::getActions('com_scholarlab', $level);

	    foreach ($actions as $action)
	    {
	    	$result->set($action->name,  $user->authorise($action->name, $assetName));
	    }

	    return $result;
	  }
}
