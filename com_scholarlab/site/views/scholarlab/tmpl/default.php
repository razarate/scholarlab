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

// Get Webinar Administrator configuration params
$params = JComponentHelper::getParams('com_scholarlab');
//JFactory::getApplication()->enqueueMessage( print_r($params, 1) . '<br> ' . $params->get('vpn-url'), 'notice');

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
                  <span class="date">Humedad</span>
                  <span class="lnr lnr-drop condition">
                    <span class="temp"><?php echo round($sensorData['bme280']['Humidity'], 2) ?> %</span><span class="temp-type"></span></span>
                  </span>
                </li>
                <li class="active">
                  <span class="date">Altitud</span>
                  <span class="lnr lnr-cloud condition">
                    <span class="temp"><?php echo round($sensorData['bme280']['Alt'], 2) ?><span class="deg"></span><span class="temp-type"></span></span>
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
                    <span class="temp"><?php echo round(array_sum($this->bme280GraphData['temp'])/count($this->bme280GraphData['temp']), 2) ?><span class="deg">0</span><span class="temp-type">C</span></span>
                  </span>
                </li>
                <li class="active">
                  <span class="date">Humedad promedio</span>
                  <span class="lnr lnr-drop condition">
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
                <span id='temp1' class="temp-value"><?php echo round($sensorData['ds18b20'][$params->get('termometro1')]['Temp'], 2) ?></span>
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
                <span id='temp2' class="temp-value"><?php echo round($sensorData['ds18b20'][$params->get('termometro2')]['Temp'], 2) ?></span>
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
<?php 
if ($params->get('termometro3')) {
?>
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
                  <span id='temp3' class="temp-value" style="font-size: 40px;"><?php echo round($sensorData['ds18b20'][$params->get('termometro3')]['Temp'], 2) ?></span>
                  <span class="temp-type" style="font-size: 40px">°C</span>
                </p>
                <p class="text-muted">Fecha: <?php echo date("d-M-Y"); ?></p>
              </div>
          </div>
        </div>
      </div>
    </div><!-- End container -->
  <?php echo JHtml::_('bootstrap.endTab'); ?>
<?php 
}
?>
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
          data: [<?php echo implode(',', $this->bme280GraphData['temp']) ?>],
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
          data: [<?php echo implode(',', $this->bme280GraphData['humidity']) ?>],
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
 <script type="text/javascript">
      function loadTemp() {
          var xmlhttp;
          if (window.XMLHttpRequest) {
              xmlhttp = new XMLHttpRequest();
          }
          else {// code for IE6, IE5
              xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp.onreadystatechange = function () {
              if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    // change content from div
          var resp = JSON.parse(xmlhttp.responseText);
                  document.getElementById("temp1").innerHTML = parseFloat(resp[0].Temp).toFixed(2);
                  document.getElementById("temp2").innerHTML = parseFloat(resp[1].Temp).toFixed(2);
                  if (document.getElementById('temp3')){
                    document.getElementById("temp3").innerHTML = parseFloat(resp[2].Temp).toFixed(2);
                  }
              }
          }
          xmlhttp.open("GET", <?php echo '"https://' . $params->get('vpn-url') . '/proxy?sensor=ds18b20"' ?>, true);
          xmlhttp.send();
      }

      // first page load
      loadTemp();
      setInterval(loadTemp, 5000);
    
</script>