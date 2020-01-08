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

/**
 * HTML View class for the HelloWorld Component
 *
 * @since  0.0.1
 */
class ScholarLabViewScholarLab extends JViewLegacy
{
	/**
	 * Display the Hello World view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 */
	function display($tpl = null)
	{
		// Assign data to the view
		$this->msg = 'Scholar Lab';
		$this->result = $this->getSensor();
		$this->getThrottledState = $this->get_throttled_state();
		$this->hardware = $this->get_hardware_model();

		// Display the view
		parent::display($tpl);
	}

	function getSensor() {
//		$output = exec('sudo python3 /home/moodlebox/scholarlab/sensorData.py');
//		$this->result = $output;

		        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, "moodlebox.home:8080/allData");

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);
        return $output;
	}

    function get_throttled_state() {
        $throttledstate = null;

        $command = "sudo vcgencmd get_throttled | awk -F'=' '{print $2}'";
        // Get bit pattern from device.
        if ( $throttledstate = exec($command, $out) ) {
            $throttledstate = hexdec($throttledstate);
            // Get raw values using bitwise operations.
            $undervoltagedetected = ($throttledstate & 0x1);
            $armfreqcapped = ($throttledstate & 0x2) >> 1;
            $currentlythrottled = ($throttledstate & 0x4) >> 2;
            $templimitactive = ($throttledstate & 0x8) >> 3;
            $undervoltageoccurred = ($throttledstate & 0x10000) >> 16;
            $armfreqwascapped = ($throttledstate & 0x20000) >> 17;
            $throttlingoccurred = ($throttledstate & 0x40000) >> 18;
            $templimitoccurred = ($throttledstate & 0x80000) >> 19;

            return array(
                'undervoltagedetected' => ($undervoltagedetected == 1),
                'armfrequencycapped' => ($armfreqcapped == 1),
                'currentlythrottled' => ($currentlythrottled == 1),
                'templimitactive' => ($templimitactive == 1),
                'undervoltageoccurred' => ($undervoltageoccurred == 1),
                'armfrequencycappedoccurred' => ($armfreqwascapped == 1),
                'throttlingoccurred' => ($throttlingoccurred == 1),
                'templimitoccurred' => ($templimitoccurred == 1),
            );
        } else {
            return false;
        }
    }

    function get_hardware_model() {
        $revisionnumber = null;

        // Read revision number from device.
        if ( $cpuinfo = @file_get_contents('/proc/cpuinfo') ) {
            if ( preg_match_all('/^Revision.*/m', $cpuinfo, $revisionmatch) > 0 ) {
                $revisionnumber = explode(' ', $revisionmatch[0][0]);
                $revisionnumber = end($revisionnumber);
            }
        }
        $revisionnumber = hexdec($revisionnumber);

        // Define arrays of various hardware parameter values.
        $memorysizes = array('256 MB', '512 MB', '1 GB', '2 GB', '4 GB');
        $models = array('A', 'B', 'A+', 'B+', '2B', 'Alpha', 'CM1', 'Unknown',
                '3B', 'Zero', 'CM3', 'Unknown', 'ZeroW', '3B+', '3A+', 'Internal use',
                'CM3+', '4B');
        $processors = array('BCM2835', 'BCM2836', 'BCM2837', 'BCM2711');
        $manufacturers = array('Sony UK', 'Egoman', 'Embest', 'Sony Japan',
                'Embest', 'Stadium');

        // Get raw values of hardware parameters using bitwise operations.
        $rawrevision = ($revisionnumber & 0xf);
        $rawmodel = ($revisionnumber & 0xff0) >> 4;
        $rawprocessor = ($revisionnumber & 0xf000) >> 12;
        $rawmanufacturer = ($revisionnumber & 0xf0000) >> 16;
        $rawmemory = ($revisionnumber & 0x700000) >> 20;
        $rawversionflag = ($revisionnumber & 0x800000) >> 23;

        // If recent hardware present, return associative array of parameters, value.
        // Return false otherwise.
        if ($rawversionflag) {
            $revision = '1.' . $rawrevision;
            $model = $models[$rawmodel];
            $processor = $processors[$rawprocessor];
            $manufacturer = $manufacturers[$rawmanufacturer];
            $memorysize = $memorysizes[$rawmemory];

            return array(
                'revision' => $revision,
                'model' => $model,
                'processor' => $processor,
                'manufacturer' => $manufacturer,
                'memory' => $memorysize
            );
        } else {
            return false;
        }
    }

}
