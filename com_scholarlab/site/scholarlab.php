<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$doc = JFactory::getDocument();
$doc->addStylesheet( JURI::base(true) . '/components/com_scholarlab/assets/css/bootstrap.min.css' );
$doc->addStylesheet( JURI::base(true) . '/components/com_scholarlab/assets/css/weather-icons.min.css' );
$doc->addStylesheet( JURI::base(true) . '/components/com_scholarlab/assets/css/style.css' );
$doc->addStylesheet( JURI::base(true) . '/components/com_scholarlab/assets/font-awesome/css/font-awesome.min.css' );

//$doc->addScript( JURI::base(true) . '/components/com_scholarlab/assets/js/bootstrap.min.js' );
//$doc->addScript( JURI::base(true) . '/components/com_scholarlab/assets/js/jquery.min.js' );
	
// Get an instance of the controller prefixed by HelloWorld
$controller = JControllerLegacy::getInstance('ScholarLab');

// Perform the Request task
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));

// Redirect if set by the controller
$controller->redirect();