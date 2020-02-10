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
		$this->result = self::getAliveData();
		$this->getThrottledState = self::get_throttled_state();
		$this->hardware = self::get_hardware_model();
        $this->tempGraphData = self::getTempGraphData();
        // Assign data to the view
        //$this->sensorData = $this->get('Sensor');
         
        // Check for errors.
        if (count($errors = $this->get('Errors')))
        {
            JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');

            return false;
        }
/*
JFactory::getApplication()->enqueueMessage( print_r(self::get_ethernet_interface_name(), 1), 'notice');
JFactory::getApplication()->enqueueMessage( print_r(self::get_wireless_interface_name(), 1), 'notice');
JFactory::getApplication()->enqueueMessage( print_r(self::unallocated_free_space(), 1), 'notice');
JFactory::getApplication()->enqueueMessage( print_r(self::get_survey_data(), 1), 'notice');
*/
		// Display the view
		parent::display($tpl);
	}

    function getTempGraphData ($sensorType = NULL, $fromDate = NULL, $toDate = NULL) {
        // Testing dates

        if (is_null($fromDate) || is_null($toDate)) {
            $fromDate = date('Y-m-d',strtotime('-30 days'));    //Thirty days before 'now'
            $toDate = date('Y-m-d');
        }

        if ($fromDate <= $toDate) {

        }

        // Load Temp data from database
        $scholarlab_model = JModelLegacy::getInstance( 'ScholarLab', 'ScholarLabModel', array() );
        $tempGraphData = $scholarlab_model->tempGraphData($sensorType = NULL, $fromDate, $toDate);

        return $tempGraphData;

    }

	function getAliveData() {
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

        // Saving all records to populate database
        $scholarlab_model = JModelLegacy::getInstance( 'ScholarLab', 'ScholarLabModel', array() );
        $scholarlab_model->saveSensorData('bmp280', $output);

        return $output;
	}

    /**
     * Get Raspberry Pi throttled state
     * See https://github.com/raspberrypi/documentation/blob/JamesH65-patch-vcgencmd-vcdbg-docs/raspbian/applications/vcgencmd.md.
     * See https://www.raspberrypi.org/forums/viewtopic.php?f=63&t=147781&start=50#p972790.
     *
     * +----+----+----+----+----+
     * |3210|FEDC|BA98|7654|3210|
     * +----+----+----+----+----+
     * |    |    |    |    |   A|
     * |    |    |    |    |  B |
     * |    |    |    |    | C  |
     * |    |    |    |    |D   |
     * |   E|    |    |    |    |
     * |  F |    |    |    |    |
     * | G  |    |    |    |    |
     * |H   |    |    |    |    |
     * +----+----+----+----+----+
     * |9876|5432|1098|7654|3210|
     * +----+----+----+----+----+
     *
     * +---+------+-------------–-----------------------+
     * | # | bits | contains                            |
     * +---+------+------------–------------------------+
     * | A |  01  | Under voltage detected              |
     * | B |  02  | Arm frequency capped                |
     * | C |  03  | Currently throttled                 |
     * | D |  04  | Soft temperature limit active       |
     * |   |      |                                     |
     * | E |  16  | Under voltage has occurred          |
     * | F |  17  | Arm frequency capped has occurred   |
     * | G |  18  | Throttling has occurred             |
     * | H |  19  | Soft temperature limit has occurred |
     * +---+------+-------------------------------------+
     *
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     *
     * @return associative array of parameters, value or false if unsupported hardware.
     */
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

    /**
     * Get Raspberry Pi hardware model
     *
     * Revision field in /proc/cpuinfo. The bit fields are as follows.
     * See https://www.raspberrypi.org/documentation/hardware/raspberrypi/revision-codes/.
     * See https://github.com/AndrewFromMelbourne/raspberry_pi_revision/.
     *
     * +----+----+----+----+----+----+----+----+
     * |FEDC|BA98|7654|3210|FEDC|BA98|7654|3210|
     * +----+----+----+----+----+----+----+----+
     * |    |    |    |    |    |    |    |AAAA|
     * |    |    |    |    |    |BBBB|BBBB|    |
     * |    |    |    |    |CCCC|    |    |    |
     * |    |    |    |DDDD|    |    |    |    |
     * |    |    | EEE|    |    |    |    |    |
     * |    |    |F   |    |    |    |    |    |
     * |    |   G|    |    |    |    |    |    |
     * |    |  H |    |    |    |    |    |    |
     * +----+----+----+----+----+----+----+----+
     * |1098|7654|3210|9876|5432|1098|7654|3210|
     * +----+----+----+----+----+----+----+----+
     *
     * +---+-------+-------------–-+----------------------------------------------------+
     * | # | bits  | contains      | values                                             |
     * +---+-------+------------–--+----------------------------------------------------+
     * | A | 00-03 | PCB Revision  | The PCB revision number                            |
     * | B | 04-11 | Model name    | A, B, A+, B+, 2B, Alpha, CM1, unknown, 3B, Zero,   |
     * |   |       |               | CM3, unknown, Zero W, 3B+, 3A+, internal, CM3+, 4B |
     * | C | 12-15 | Processor     | BCM2835, BCM2836, BCM2837, BCM2711                 |
     * | D | 16-19 | Manufacturer  | Sony UK, Egoman, Embest, Sony Japan,               |
     * |   |       |               | Embest, Stadium                                    |
     * | E | 20-22 | Memory size   | 256 MB, 512 MB, 1 GB, 2 GB, 4 GB                   |
     * | F | 23-23 | Revision flag | (if set, new-style revision)                       |
     * | G | 24-24 | Warranty bit  | (if set, warranty void - Pre Pi2)                  |
     * | H | 25-25 | Warranty bit  | (if set, warranty void - Post Pi2)                 |
     * +---+-------+---------------+----------------------------------------------------+
     *
     * @return associative array of parameters, value or false if unsupported hardware.
     */
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

    /**
     * Get ethernet interface name. Usually 'eth0'.
     *
     * @return string containing interface name
     */
    function get_ethernet_interface_name() {
        $path = realpath('/sys/class/net');

        $iter = new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS +
                \RecursiveDirectoryIterator::FOLLOW_SYMLINKS);
        $iter = new \RecursiveIteratorIterator($iter, \RecursiveIteratorIterator::CHILD_FIRST);
        $iter = new \RegexIterator($iter, '|^.*/device$|i', \RecursiveRegexIterator::GET_MATCH);
        $iter->setMaxDepth(2);
        $matches = array_values(preg_grep('#^.*/(eth|en).*$#i', array_keys(iterator_to_array($iter))))[0];

        return explode('/', $matches)[4];
    }

    /**
     * Get wireless interface name. Usually 'wlan0'.
     *
     * @return string containing interface name
     */
    static function get_wireless_interface_name() {
        $path = realpath('/sys/class/net');

        $iter = new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS +
                \RecursiveDirectoryIterator::FOLLOW_SYMLINKS);
        $iter = new \RecursiveIteratorIterator($iter, \RecursiveIteratorIterator::CHILD_FIRST);
        $iter = new \RegexIterator($iter, '|^.*/wireless$|i', \RecursiveRegexIterator::GET_MATCH);
        $iter->setMaxDepth(2);

        return explode('/', array_keys(iterator_to_array($iter))[0])[4];
    }

    /**
     * Find unallocated space on SD card.
     *
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     *
     * @return float value if unallocated space, in MB.
     */
    static function unallocated_free_space() {
        // @codingStandardsIgnoreLine
        $command = "sudo parted /dev/mmcblk0 unit MB print free | tail -n2 | grep 'Free Space' | awk '{print $3}' | sed -e 's/MB$//'";
        $unallocatedfreespace = exec($command, $out);
        return (float)$unallocatedfreespace;
    }

    /**
     * Get survey data.
     *
     * @return associative array of parameters, value
     */
    static function get_survey_data() {
        //require(dirname(dirname(dirname(__FILE__))).'/version.php');

        // Read serial number from device.
        if ( $cpuinfo = @file_get_contents('/proc/cpuinfo') ) {
            if ( preg_match_all('/^Serial.*/m', $cpuinfo, $serialmatch) > 0 ) {
                $serialnumber = explode(' ', $serialmatch[0][0]);
                $serialnumber = end($serialnumber);
            }
        }
        // Compute device identifier.
        $deviceid = hash('md5', $serialnumber);

        // Get hardware model.
        $hardware = self::get_hardware_model();

        // Get MoodleBox image version.
        if ( file_exists('/etc/moodlebox-info') ) {
            $moodleboxinfo = file('/etc/moodlebox-info');
            if ( preg_match_all('/^.*version ((\d+\.)+(.*|\d+)), (\d{4}-\d{2}-\d{2})$/i',
                    $moodleboxinfo[0], $moodleboxinfomatch) > 0 ) {
                $moodleboxinfo = $moodleboxinfomatch[1][0] . ' (' . $moodleboxinfomatch[4][0] . ')';
            }
        }

        $surveydata = array(
            'deviceid' => $deviceid,
            'osrelease' => self::parse_config_file('/etc/os-release')['PRETTY_NAME'],
            'kernel' => php_uname('s') . ' ' . php_uname('r') . ' ' .  php_uname('m'),
            'hardware' => $hardware['model'] . ' ' . $hardware['memory'],
            'moodleboxversion' => $moodleboxinfo,
            'pluginversion' => $plugin->release . ' (' . $plugin->version . ')',
            'sdsize' => disk_total_space('/'),
        );

        return $surveydata;
    }

    /**
     * Parse config files with "setting=value" syntax, ignoring commented lines
     * beginnning with a hash (#).
     *
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     *
     * @param file $file to parse
     * @param bool $mode (optional)
     * @param int $scannermode (optional)
     * @return associative array of parameters, value
     */
    static function parse_config_file($file, $mode = false, $scannermode = INI_SCANNER_NORMAL) {
        return parse_ini_string(preg_replace('/^#.*\\n/m', '', @file_get_contents($file)), $mode, $scannermode);
    }
}
