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

JHtml::_('bootstrap.tooltip');

$sensorData = $this->sensorData;

//JFactory::getApplication()->enqueueMessage( print_r($sensorData, 1), 'notice');

?>
<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'datosAmbientales')); ?>
  <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'datosAmbientales', 'Datos ambientales'); ?>



    <div class="row">
      <div class="col-sm-6">
        <div class="weather-card one">
          <div class="top">
            <div class="wrapper">
  <!--
              <div class="mynav">
                <a href="javascript:;"><span class="lnr lnr-chevron-left"></span></a>
                <a href="javascript:;"><span class="lnr lnr-cog"></span></a>
              </div>
  -->
              <h1 class="heading">Datos ambientales</h1>
              <h3 class="location">Xalapa, Veracruz</h3>
              <p class="temp">
                <span class="temp-value"><?php echo round($sensorData['bme280']['Temp'], 2) ?></span>
                <span class="deg">0</span>
                <a href="javascript:;"><span class="temp-type">C</span></a>
              </p>
            </div>
          </div>
          <div class="bottom">
            <div class="wrapper">
              <ul class="forecast">
                <span class="lnr lnr-chevron-up go-up"></span>
                <li class="active">
                  <span class="date">Presión</span>
                  <span class="lnr lnr-sun condition">
                    <span class="temp"><?php echo round($sensorData['bme280']['Humidity'], 2) ?><span class="deg">0</span><span class="temp-type">C</span></span>
                  </span>
                </li>
                <li class="active">
                  <span class="date">Altitud</span>
                  <span class="lnr lnr-cloud condition">
                    <span class="temp"><?php echo round($sensorData['bme280']['Alt'], 2) ?><span class="deg">0</span><span class="temp-type">C</span></span>
                  </span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="weather-card chart">
          <div class="top">
            <div class="wrapper">
              <canvas id="weatherChart" width="100%"></canvas>
            </div>
          </div>
          <div class="bottom">
            <div class="wrapper">
              <ul class="forecast">
                <span class="lnr lnr-chevron-up go-up"></span>
                <li class="active">
                  <span class="date">Temperatura promedio</span>
                  <span class="lnr lnr-sun condition">
                    <span class="temp"><?php echo round(array_sum($this->bme280GraphData['temp'])/count($this->bme280GraphData['temp']), 2) ?><span class="deg">0</span><span class="temp-type">C</span></span>
                  </span>
                </li>
                <li class="active">
                  <span class="date">Presión promedio</span>
                  <span class="lnr lnr-cloud condition">
                    <span class="temp"><?php echo round(array_sum($this->bme280GraphData['humidity'])/count($this->bme280GraphData['humidity']), 2) ?><span class="deg">0</span><span class="temp-type">C</span></span>
                  </span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>




  <?php echo JHtml::_('bootstrap.endTab'); ?>

  <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'DS18B20', 'Termómetros'); ?>
    <div class="row">
      <div class="col">
        <div class="weather-card one">
          <div class="top">
            <div class="wrapper">
  <!--
              <div class="mynav">
                <a href="javascript:;"><span class="lnr lnr-chevron-left"></span></a>
                <a href="javascript:;"><span class="lnr lnr-cog"></span></a>
              </div>
  -->
              <h1 class="heading">Termómetro 1</h1>
              <h3 class="location">vaso de agua</h3>
              <p class="temp">
                <span class="temp-value"><?php echo round($sensorData['ds18b20'][0]['Temp'], 2) ?></span>
                <span class="deg">0</span>
                <a href="javascript:;"><span class="temp-type">C</span></a>
              </p>
            </div>
          </div>
          <div class="bottom">
            <div class="wrapper">
              <ul class="forecast">
                <span class="lnr lnr-chevron-up go-up"></span>
                <li class="active">
                  <span class="date">Promedio</span>
                  <span class="lnr lnr-sun condition">
                    <span class="temp">18<span class="deg">0</span><span class="temp-type">C</span></span>
                  </span>
                </li>
                <li class="active">
                  <span class="date">mas bajo</span>
                  <span class="lnr lnr-cloud condition">
                    <span class="temp">8<span class="deg">0</span><span class="temp-type">C</span></span>
                  </span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="weather-card rain">
          <div class="top">
            <div class="wrapper">
  <!--
              <div class="mynav">
                <a href="javascript:;"><span class="lnr lnr-chevron-left"></span></a>
                <a href="javascript:;"><span class="lnr lnr-cog"></span></a>
              </div>
  -->
              <h1 class="heading">Termómetro 2</h1>
              <h3 class="location">en tierra</h3>
              <p class="temp">
                <span class="temp-value"><?php echo round($sensorData['ds18b20'][1]['Temp'], 2) ?></span>
                <span class="deg">0</span>
                <a href="javascript:;"><span class="temp-type">C</span></a>
              </p>
            </div>
          </div>
          <div class="bottom">
            <div class="wrapper">
              <ul class="forecast">
                <span class="lnr lnr-chevron-up go-up"></span>
                <li class="active">
                  <span class="date">Promedio</span>
                  <span class="lnr lnr-sun condition">
                    <span class="temp">18<span class="deg">0</span><span class="temp-type">C</span></span>
                  </span>
                </li>
                <li class="active">
                  <span class="date">mas bajo</span>
                  <span class="lnr lnr-cloud condition">
                    <span class="temp">8<span class="deg">0</span><span class="temp-type">C</span></span>
                  </span>
                </li>
              </ul> 
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <canvas id="termometro1" width="90%"></canvas>
      </div>
      <div class="col-sm-6">
        <canvas id="termometro2" width="90%"></canvas>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <canvas id="2termometros" width="90%"></canvas>
      </div>
    </div>
  <?php echo JHtml::_('bootstrap.endTab'); ?>
  <?php echo JHtml::_('bootstrap.endTabSet'); ?>


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

<?php 

 ?>
<script>
    /**
     * 2 linear charts using 2 different Y axes
     * See https://stackoverflow.com/questions/38085352/how-to-use-two-y-axes-in-chart-js-v2.
     */
    var ctx = document.getElementById('weatherChart');

    // Global Options:
    Chart.defaults.global.defaultFontColor = 'black';
    Chart.defaults.global.defaultFontSize = 12;

    var data = {
      labels: [<?php echo implode(',', $this->bme280GraphData['date']); ?>],
      datasets: [{
          label: "Temperatura",
          fill: false,
          lineTension: 0.1,
          backgroundColor: "rgba(225,0,0,0.4)",
          borderColor: "red", // The main line color
          borderCapStyle: 'square',
          borderDash: [], // try [5, 15] for instance
          borderDashOffset: 0.0,
          borderJoinStyle: 'miter',
          pointBorderColor: "black",
          pointBackgroundColor: "white",
          pointBorderWidth: 1,
          pointHoverRadius: 8,
          pointHoverBackgroundColor: "yellow",
          pointHoverBorderColor: "brown",
          pointHoverBorderWidth: 2,
          pointRadius: 4,
          pointHitRadius: 10,
          yAxisID: 'A',
          // notice the gap in the data and the spanGaps: true
          data: [<?php echo implode(',', $this->bme280GraphData['temp']) ?>],
          spanGaps: true,
        }, {
          label: "Presión",
          fill: false,
          lineTension: 0.1,
          backgroundColor: "rgba(167,105,0,0.4)",
          borderColor: "rgb(167, 105, 0)",
          borderCapStyle: 'butt',
          borderDash: [],
          borderDashOffset: 0.0,
          borderJoinStyle: 'miter',
          pointBorderColor: "white",
          pointBackgroundColor: "black",
          pointBorderWidth: 1,
          pointHoverRadius: 8,
          pointHoverBackgroundColor: "brown",
          pointHoverBorderColor: "yellow",
          pointHoverBorderWidth: 2,
          pointRadius: 4,
          pointHitRadius: 10,
          yAxisID: 'B',
          // notice the gap in the data and the spanGaps: false
          data: [<?php echo implode(',', $this->bme280GraphData['humidity']) ?>],
          spanGaps: false,
        }

      ]
    };

    // Notice the scaleLabel at the same level as Ticks
    var options = {
      scales: {
                yAxes: [{
                    id:'A',
                    type: 'linear',
                    position: 'left',
                    }, {
                    id: 'B',
                    type: 'linear',
                    position: 'right',
                    ticks: {
                        beginAtZero:false
                    },
                    scaleLabel: {
                         display: false,
                         labelString: 'Moola',
                         fontSize: 20 
                      }
                }]            
            }  
    };

    // Chart declaration:
    var myBarChart = new Chart(ctx, {
      type: 'line',
      data: data,
      options: options
    });
</script>

<script>
  var ctx = document.getElementById('termometro1').getContext('2d');
  var myChart = new Chart(ctx, {
      type: 'line',
      data: {
          labels: [<?php echo implode(',', $this->termometro1GraphData['date']); ?>],
          datasets: [{
              label: 'Termómetro 1',
              data: [<?php echo implode(',', $this->termometro1GraphData['temp']) ?>],
              fill: false,
              borderColor: [
                  'rgb(75, 192, 192)'
              ],
              lineTension: 0.1,              
              borderWidth: 1
          }]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }]
          }
      }
  });
</script>

<script>
  var ctx = document.getElementById('termometro2').getContext('2d');
  var myChart = new Chart(ctx, {
      type: 'line',
      data: {
          labels: [<?php echo implode(',', $this->termometro2GraphData['date']); ?>],
          datasets: [{
              label: 'Termómetro 2',
              data: [<?php echo implode(',', $this->termometro2GraphData['temp']) ?>],
              fill: false,
              borderColor: [
                  'rgb(75, 192, 192)'
              ],
              lineTension: 0.1,              
              borderWidth: 1
          }]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }]
          }
      }
  });
</script>

<script>
  var ctx = document.getElementById('2termometros').getContext('2d');
  var myChart = new Chart(ctx, {
      type: 'line',
      data: {
          labels: [<?php echo implode(',', $this->termometro2GraphData['date']); ?>],
          datasets: [
            {
              label: 'Termómetro 1',
              data: [<?php echo implode(',', $this->termometro1GraphData['temp']) ?>],
              fill: false,
              borderColor: [
                  'rgb(75, 192, 192)'
              ],
              lineTension: 0.1,              
              borderWidth: 1
          },
          {
            label: 'Termómetro 2',
            data: [<?php echo implode(',', $this->termometro2GraphData['temp']) ?>],
            fill: false,
            borderColor: [
                'red'
            ],
            lineTension: 0.1,              
            borderWidth: 1
          }]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }]
          }
      }
  });
</script>