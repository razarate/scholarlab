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

//$sensorValuesArray = $this->result;
$sensorValuesArray = json_decode($this->result, true);
//JFactory::getApplication()->enqueueMessage( print_r($sensorValuesArray, 1), 'notice');
//JFactory::getApplication()->enqueueMessage( print_r($this->getThrottledState, 1), 'notice');
//JFactory::getApplication()->enqueueMessage( 'Default vista: <pre>' . print_r($this->sensorData, 1) . '</pre>', 'notice');
?>
<!--  https://bootsnipp.com/snippets/exy4M  -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="tile">
                    <div class="wrapper">
                        <div class="header">Histórico de Temperaturas</div>

                        <div class="banner-img">
                            <!-- Weather Widget - START -->
                            <div class="weather">
                                <canvas id="tempChart" width="400" height="400"></canvas>
                            </div>
                        </div>

                        <div class="dates">
                            <div class="start">
                                <strong>De</strong> 12:30 JAN 2015
                                <span></span>
                            </div>
                            <div class="ends">
                                <strong>Hasta</strong> 14:30 JAN 2015
                            </div>
                        </div>

                    </div>
                </div> 
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="tile">
                    <div class="wrapper">
                        <div class="header">El clima de hoy</div>

                        <div class="banner-img">
                            <!-- Weather Widget - START -->
                            <div class="weather">
                                <div class="current">
                                    <div class="info">
                                        <div>&nbsp;</div>
                                        <div class="city"><small><small>CITY:</small></small> Xalapa</div>
                                        <div class="temp"><?php echo number_format($sensorValuesArray['Temp'], 1) ?>&deg; <small>C</small></div>
                                        <div class="wind"><small><small>Presión:</small></small> <?php echo number_format($sensorValuesArray['Pressure']) ?> hPa</div>
                                        <div>&nbsp;</div>
                                    </div>
                                    <div class="icon">
                                        <span class="wi-day-sunny"></span>
                                    </div>
                                </div>
                                <div class="future">
                                    <div class="day">
                                        <h3>Mon</h3>
                                        <p><span class="wi-day-cloudy"></span></p>
                                    </div>
                                    <div class="day">
                                        <h3>Tue</h3>
                                        <p><span class="wi-showers"></span></p>
                                    </div>
                                    <div class="day">
                                        <h3>Wed</h3>
                                        <p><span class="wi-rain"></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="footer">
                            <a href="#" class="Cbtn Cbtn-primary">View</a>
                            <a href="#" class="Cbtn Cbtn-danger">Delete</a>
                        </div>
                    </div>
                </div> 
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="tile">
                    <div class="wrapper">
                        <div class="header">Utilizamos las siguientes tecnologías</div>
                            <div class="dates" style="background-color:#fafafa">
                                <div class="start">
                                    <strong><img alt="Raspi" src="<?php echo JURI::base(true) . '/components/com_scholarlab/assets/img/RasPiLogo.png' ?>" style="max-width:100px"/></strong> Raspberry Pi
                                    <span></span>
                                </div>
                                <div class="ends">
                                    <strong><img alt="Raspi" src="<?php echo JURI::base(true) . '/components/com_scholarlab/assets/img/chartjs-logo.svg' ?>" style="max-width:55px"/></strong> Chart.js
                                </div>
                            </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>


<script>
var ctx = document.getElementById('tempChart');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [<?php echo implode(',', $this->tempGraphData['date']); ?>],
        datasets: [{
            label: 'Temperature',
            data: [ <?php echo implode(',', $this->tempGraphData['temp']) ?>],
            borderColor: [
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: false
                }
            }]
        }
    }
});
</script>