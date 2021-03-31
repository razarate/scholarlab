<?php
/**
 * @package     Joomla.Front end
 * @subpackage  com_scholarlab
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Scholarlab Table class
 *
 * @since  0.0.1
 */
class ScholarlabTableSensor extends JTable
{
	/**
	 * Constructor
	 *
	 * @param   JDatabaseDriver  &$db  A database connector object
	 */
	function __construct(&$db)
	{
		parent::__construct('#__scholarlab_sensor_details', 'id', $db);
	}
}