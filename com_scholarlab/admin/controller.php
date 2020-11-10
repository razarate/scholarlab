<?php
 /**
 * @package Component com_raspberrypilab for Joomla! 3.5+
 * @version $Id: controller.php 3.8 2018-05-05 14:26:33Z Piensocial $
 * @author Piensocial.com
 * @copyright (C) 2010- Piensocial.com
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

defined('_JEXEC') or die;

/**
 * Component Controller
 *
 * @since  1.0.0
 */
class ScholarlabController extends JControllerLegacy
{
	/**
	 * The default view.
	 *
	 * @var    string
	 * @since  1.0.0
	 */
	protected $default_view = 'dashboard';

	/**
	 * Method to display a view.
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached
	 * @param   array    $urlparams  An array of safe URL parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return  RaspberrypilabController  This object to support chaining.
	 *
	 * @since   1.0.0
	 */
	public function display($cachable = false, $urlparams = array())
	{
		//JLoader::register('RaspberrypilabHelper', JPATH_ADMINISTRATOR . '/components/com_raspberrypilab/helpers/raspberrypilab.php');
/*
		$document = JFactory::getDocument();
		$document->addStyleSheet(JUri::base(true) . '/components/com_raspberrypilab/assets/css/style.css');
        $document->addStyleSheet(JUri::base(true) . '/components/com_raspberrypilab/assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css');
		$document->addStylesheet( JURI::base(true) . '/components/com_raspberrypilab/assets/chartjs/Chart.min.css' );
		$document->addScript( JURI::base(true) . '/components/com_raspberrypilab/assets/chartjs/Chart.min.js' );
*/
		$view   = $this->input->get('view', 'dashboard');
		$layout = $this->input->get('layout', 'default');
//		$id     = $this->input->getInt('id');

		return parent::display();
	}
}
