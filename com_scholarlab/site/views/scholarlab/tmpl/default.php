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
            <div class="row" style="background-color:#fafafa;padding:15px">
                <div class="col-md-6">
                  <?php echo $this->msg ?>
                    <div class="row">
                        <h3 class="text-info">
                            Histórico de temperatura
                        </h3>
                        <canvas id="tempChart" width="400" height="400"></canvas>

                    </div>
                    <div class="row">
                        <h3 class="text-info">
                            Advertencias del sistema
                        </h3>
                        <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Parámetro</th>
                            <th>Información</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Bajo voltaje</td>
                            <td>
                                <?php echo ($this->getThrottledState['undervoltagedetected'] == FALSE) ? "No" : "Si" ?></td>
                          </tr>
                          <tr>
                            <td>Frecuencia ARM limitada</td>
                            <td><?php echo ($this->getThrottledState['armfrequencycapped'] == FALSE) ? "No" : "Si" ?></td>
                          </tr>
                          <tr>
                            <td>Cuello de botella</td>
                            <td><?php echo ($this->getThrottledState['currentlythrottled'] == FALSE) ? "No" : "Si" ?></td>
                          </tr>
                          <tr>
                            <td>Temperatura alta</td>
                            <td><?php echo ($this->getThrottledState['templimitactive'] == FALSE) ? "No" : "Si" ?></td>
                          </tr>
                          <tr>
                            <td>Eventos de Bajo Voltaje</td>
                            <td><?php echo ($this->getThrottledState['undervoltageoccurred'] == FALSE) ? "No" : "Si" ?></td>
                          </tr>
                          <tr>
                            <td>Eventos de ARM saturado</td>
                            <td><?php echo ($this->getThrottledState['armfrequencycappedoccurred'] == FALSE) ? "No" : "Si" ?></td>
                          </tr>
                          <tr>
                            <td>Cuellos de botella ocurridos</td>
                            <td><?php echo ($this->getThrottledState['throttlingoccurred'] == FALSE) ? "No" : "Si" ?></td>
                          </tr>
                          <tr>
                            <td>Eventos de Temperatura alta</td>
                            <td><?php echo ($this->getThrottledState['templimitoccurred'] == FALSE) ? "No" : "Si" ?></td>
                          </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class=row>
                        <h3 class="text-info">
                            Estado del tiempo
                        </h3>
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
                </div>
            </div>
            
            <div class="row" style="background-color:#fafafa;padding:15px">
                <div class="col-md-1 col-xs-6" >
                    <img alt="Bootstrap Image Preview" src="/static/digitalborder_logo.jpg" style="max-width:62px"/>
                </div>
                <div class="col-md-11 col-xs-6">
                    <p style="margin-top:20px">Powered by <a href="http://www.digitalborder.net" target="_blank">DigitalBorder</a> <span class="hidden-xs"> | Compatible with Raspberry pi 2-3. Tested on Raspberry pi 3 Model B</span></p>
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