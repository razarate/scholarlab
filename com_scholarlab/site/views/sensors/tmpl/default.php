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

$dashboardData = $this->dashboardData;

//JFactory::getApplication()->enqueueMessage('<pre>' . print_r($dashboardData, 1) . '</pre>' , 'notice');

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
              <h1 class="heading">Estado del tiempo</h1>
              <h3 class="location">Xalapa, Veracruz</h3>
              <p class="temp">
                <span id='bme280Temp' class="temp-value">0</span>
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
                  <span class="date">Humedad</span>
                  <span class="lnr lnr-drop condition">
                    <span id='bme280Humidity' class="temp"> %</span><span class="temp-type"></span></span>
                  </span>
                </li>
                <li class="active">
                  <span class="date">Altitud</span>
                  <span class="lnr lnr-cloud condition">
                    <span id='bme280Alt' class="temp">0<span class="deg"></span><span class="temp-type"></span></span>
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
                  <span class="date">Temp. promedio</span>
                  <span class="lnr lnr-sun condition">
                    <span class="temp"><?php echo round(array_sum($dashboardData[4]['temp'])/count($dashboardData[4]['temp']), 2) ?><span class="deg">0</span><span class="temp-type">C</span></span>
                  </span>
                </li>
                <li class="active">
                  <span class="date">Humedad promedio</span>
                  <span class="lnr lnr-drop condition">
                    <span class="temp"><?php echo round(array_sum($dashboardData[4]['humidity'])/count($dashboardData[4]['humidity']), 2) ?><span class="deg">0</span><span class="temp-type">C</span></span>
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
        <div class="weather-card one" style="height: 510px;">
          <div class="top">
            <div class="wrapper">
  <!--
              <div class="mynav">
                <a href="javascript:;"><span class="lnr lnr-chevron-left"></span></a>
                <a href="javascript:;"><span class="lnr lnr-cog"></span></a>
              </div>
  -->
              <h1 class="heading">Termómetro 1</h1>
              <h3 class="location"></h3>
              <p class="temp">
                <span id='ds18b20_1' class="temp-value"><?php echo round($dashboardData[1]['Temp'], 2) ?></span>
                <span class="deg">0</span>
                <a href="javascript:;"><span class="temp-type">C</span></a>
              </p>
            </div>
          </div>
          <div class="bottom">
            <canvas id="termometro1" width="90%"></canvas>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="weather-card rain" style="height: 510px;">
          <div class="top">
            <div class="wrapper">
  <!--
              <div class="mynav">
                <a href="javascript:;"><span class="lnr lnr-chevron-left"></span></a>
                <a href="javascript:;"><span class="lnr lnr-cog"></span></a>
              </div>
  -->
              <h1 class="heading">Termómetro 2</h1>
              <h3 class="location"></h3>
              <p class="temp">
                <span id='ds18b20_2' class="temp-value"><?php echo round($dashboardData[2]['Temp'], 2) ?></span>
                <span class="deg">0</span>
                <a href="javascript:;"><span class="temp-type">C</span></a>
              </p>
            </div>
          </div>
          <div class="bottom">
            <canvas id="termometro2" width="90%"></canvas>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12">
        <canvas id="2termometros" width="80%"></canvas>
      </div>
    </div>
  <?php echo JHtml::_('bootstrap.endTab'); ?>

  <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'DS18B20-3', 'Medidor de temperatura'); ?>
    <div class="row">
      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
        <div class="thumbnail">
            <div class="caption">
              <div class='col-lg-12 well well-add-card'>
                  <h4>Temperatura</h4>
              </div>
              <div class='col-lg-12'>
                <p class="temp">
                  <span id='ds18b20_3' class="temp-value" style="font-size: 40px;"><?php echo round($dashboardData[3]['Temp'], 2) ?></span>
                  <span class="temp-type" style="font-size: 40px">°C</span>
                </p>
                <p class="text-muted">Fecha: <?php echo date("d-M-Y"); ?></p>
              </div>
          </div>
        </div>
      </div>
    </div><!-- End container -->
  <?php echo JHtml::_('bootstrap.endTab'); ?>
<?php echo JHtml::_('bootstrap.endTabSet'); ?>
    </div>

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
          labels: [<?php echo implode(',', $dashboardData[4]['date']); ?>],
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
          data: [<?php echo implode(',', $dashboardData[4]['temp']) ?>],
          spanGaps: true,
          },
          {
          label: "Humedad",
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
          // notice the gap in the data and the spanGaps: false
          data: [<?php echo implode(',', $dashboardData[4]['humidity']) ?>],
          spanGaps: false,
        }
      ]
    };

    // Notice the scaleLabel at the same level as Ticks
    var options = {
      scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
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
          labels: [<?php echo implode(',', $dashboardData[1]['date']); ?>],
          datasets: [{
              label: 'Termómetro 1',
              data: [<?php echo implode(',', $dashboardData[1]['temp']) ?>],
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
          labels: [<?php echo implode(',', $dashboardData[2]['date']); ?>],
          datasets: [{
              label: 'Termómetro 2',
              data: [<?php echo implode(',', $dashboardData[2]['temp']) ?>],
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
          labels: [<?php echo implode(',', $dashboardData[1]['date']); ?>],
          datasets: [
            {
              label: 'Termómetro 1',
              data: [<?php echo implode(',', $dashboardData[1]['temp']) ?>],
              fill: false,
              borderColor: [
                  'rgb(75, 192, 192)'
              ],
              lineTension: 0.1,              
              borderWidth: 1
          },
          {
            label: 'Termómetro 2',
            data: [<?php echo implode(',', $dashboardData[2]['temp']) ?>],
            fill: false,
            borderColor: [
                'red'
            ],
            lineTension: 0.1,              
            borderWidth: 1
          }]
      },
      options: {
        responsive: true,
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