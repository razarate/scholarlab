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

setlocale(LC_TIME,"es_MX.utf8");
$time = time();
$today = strftime('%A, %e de %B de %Y' , $time);
$hours = date("h:i",$time);
$am =date("A",$time);

// Weather images
$h = date('H'); // it will return hour in 24 format.
if ($h >= 5 && $h < 16) $weatherPic = JURI::base(true).'/components/com_scholarlab/assets/img/weatherMorning.jpg'; //if it's between 5am and 4pm show day strength 1 image
  else if (($h >= 16 && $h < 21)) $weatherPic = JURI::base(true).'/components/com_scholarlab/assets/img/weather.jpg'; //it's between 4pm and 8pm show evening condition 1 image
  else if (($h >= 21 && $h <=23 )  || ($h >= 0 && $h <= 4)) $weatherPic = JURI::base(true).'/components/com_scholarlab/assets/img/weatherNight.jpg'; //if it's between 8pm and 4am show rest image

// Project images
$projectImage1 = JURI::base(true).'/components/com_scholarlab/assets/img/project1.jpg';
$projectImage2 = JURI::base(true).'/components/com_scholarlab/assets/img/project2.jpg';

//JFactory::getApplication()->enqueueMessage($h , 'notice');
?>

<div class="row">
  <form class="form-inline" action="<?php echo JURI::current() ?>" method="get">
    <input type="hidden"
        name="timeframe"
        value="<?php echo $this->timeframe ?>">

    <label for="fromDate" class="mr-sm-2">Inicia el:</label>
    <input type="text" class="form-control mb-2 mr-sm-2"
        value="<?php echo $this->fromDate ?>"
        name="fromDate">

    <label for="toDate" class="mr-sm-2">Termina el:</label>
    <input type="text" class="form-control mb-2 mr-sm-2"
        value="<?php echo $this->toDate ?>"
        name="toDate">

    <button type="submit" class="btn btn-primary mb-2">Cambiar</button>

    <div class="btn-group" role="group" aria-label="Basic example">
      <a href="<?php echo JURI::current().'?timeframe=hour&fromDate='.$this->fromDate.'&toDate='.$this->toDate ?>"
         class="btn btn-secondary mx-sm-3 mb-2">
         Horas
      </a>
      <a href="<?php echo JURI::current().'?timeframe=day&fromDate='. $this->fromDate.'&toDate='.$this->toDate ?>"
         class="btn btn-secondary mx-sm-3 mb-2">
         Días
      </a>
    </div>
  </form>
</div>

<?php
if ($this->partialview === 'weather'){
?>
  <div class="row">
    <div class="col-sm-6">
      <div class="container-fluid px-1 px-md-4 py-5 mx-auto">
        <div class="row d-flex justify-content-center px-3">
            <div class="card border-0" style="background-image:url(<?php echo $weatherPic; ?>)">
                <h2 class="ml-auto mr-4 mt-3 mb-0">La Joya</h2>
                <p class="ml-auto mr-4 mb-0 med-font">&#176;C</p>
                <h1 id='bme280Temp' class="d-flex justify-content-center large-font">0</h1>
                <p class="time-font mb-0 ml-4 mt-auto"><?php echo $hours ?> <span class="sm-font"><?php echo $am ?></span></p>
                <p class="ml-4 mb-4"><?php echo $today ?></p>
                  <div class="card-footer" style="background-color: #fff; color: #000; box-shadow: 0px 8px 16px 4px #9E9E9E; border-radius: 0px 0px 20px 20px;">
                    <div class="d-flex med-font">
                      <div class="mr-auto p-2">Humedad %</div>
                        <div id='bme280Humidity' class="p-2">0</div>
                    </div>
                    <div class="d-flex med-font">
                      <div class="mr-auto p-2">Presión mmHg</div>
                        <div id="bme280Pressure" class="p-2">0</div>
                    </div>
                  </div>
            </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="container-fluid px-1 px-md-4 py-5 mx-auto">
        <div class="row d-flex justify-content-center px-3">
            <div class="chart-card border-0">
                <canvas id="weatherChart" width="100%"></canvas>
                  <div class="card-footer" style="background-color: #fff; color: #000; box-shadow: 0px 8px 16px 4px #9E9E9E; border-radius: 0px 0px 20px 20px;">
                    <div class="d-flex med-font">
                      <div class="mr-auto p-2">Humedad promedio</div>
                        <div class="p-2"><?php echo round(array_sum(array_column($dashboardData[4], 'humidity'))/count(array_column($dashboardData[4], 'humidity')), 2) ?></div>
                    </div>
                    <div class="d-flex med-font">
                      <div class="mr-auto p-2">Presión promedio</div>
                        <div class="p-2"><?php echo round(array_sum(array_column($dashboardData[4], 'pressure'))/count(array_column($dashboardData[4], 'pressure')), 2) ?></div>
                    </div>
                  </div>
            </div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    var ctx = document.getElementById('weatherChart');

    var options = {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }

    var data = {
            labels: <?php echo json_encode(array_column($dashboardData[4], 'date')) ?>,
            datasets: [{
                label: 'Temperatura',
                data: <?php echo json_encode(array_column($dashboardData[4], 'temp')) ?>,
                backgroundColor: [
                    'rgba(204, 0, 0, 1)'
                ],
                borderColor: [
                    'rgba(255, 0, 0, 1)'
                ],
                borderWidth: 2,
                pointBorderColor: "black",
                pointBackgroundColor: "black",
                pointBorderWidth: 1,
                pointHoverRadius: 8,
                pointHoverBackgroundColor: "yellow",
                pointHoverBorderColor: "brown",
                pointHoverBorderWidth: 2,
                pointRadius: 3,
                pointHitRadius: 10
            },
            {
                label: 'Humedad',
                data: <?php echo json_encode(array_column($dashboardData[4], 'humidity')) ?>,
                backgroundColor: [
                    'rgba(13, 109, 101, 1)'
                ],
                borderColor: [
                    'rgba(1, 121, 111, 1)'
                ],
                borderWidth: 2,
                pointBorderColor: "rgba(1, 97, 89, 1)",
                pointBackgroundColor: "rgba(1, 97, 89, 1)",
                pointBorderWidth: 1,
                pointHoverRadius: 8,
                pointHoverBackgroundColor: "yellow",
                pointHoverBorderColor: "brown",
                pointHoverBorderWidth: 2,
                pointRadius: 3,
                pointHitRadius: 10,
            }]
        }

    var myChart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: options
    });


  </script>

<?php
}
?>

<?php
if ($this->partialview === 'project'){
?>

  <div class="row">
     <div class="col-sm-6">
        <div class="container-fluid px-1 px-md-4 py-5 mx-auto">
           <div class="row d-flex justify-content-center px-3">
              <div class="card border-0" style="background-image:url(<?php echo $projectImage1; ?>)">
                 <h2 class="ml-auto mr-4 mt-3 mb-0">Termómetro 1</h2>
                 <p class="ml-auto mr-4 mb-0 med-font">&#176;C</p>
                 <h1 id='ds18b20_1' class="d-flex justify-content-center large-font">0</h1>
                 <p class="time-font mb-0 ml-4 mt-auto"><?php echo $hours ?> <span class="sm-font"><?php echo $am ?></span></p>
                 <p class="ml-4 mb-4"><?php echo $today ?></p>
                 <div class="card-footer" style="background-color: #CFD8DC; color: #000; box-shadow: 0px 8px 16px 4px #9E9E9E; border-radius: 0px 0px 20px 20px;">
                    <canvas id="termometro1" width="90%"></canvas>
                 </div>
              </div>
           </div>
        </div>
     </div>
     <div class="col-sm-6">
        <div class="container-fluid px-1 px-md-4 py-5 mx-auto">
           <div class="row d-flex justify-content-center px-3">
              <div class="card border-0" style="background-image:url(<?php echo $projectImage2; ?>)">
                 <h2 class="ml-auto mr-4 mt-3 mb-0">Termómetro 2</h2>
                 <p class="ml-auto mr-4 mb-0 med-font">&#176;C</p>
                 <h1 id='ds18b20_2' class="d-flex justify-content-center large-font">0</h1>
                 <p class="time-font mb-0 ml-4 mt-auto"><?php echo $hours ?> <span class="sm-font"><?php echo $am ?></span></p>
                 <p class="ml-4 mb-4"><?php echo $today ?></p>
                 <div class="card-footer" style="background-color: #CFD8DC; color: #000; box-shadow: 0px 8px 16px 4px #9E9E9E; border-radius: 0px 0px 20px 20px;">
                    <canvas id="termometro2" width="90%"></canvas>
                 </div>
              </div>
           </div>
        </div>
     </div>
  </div>
  <div class="row">
     <div class="col-sm-12">
        <div class="container-fluid px-1 px-md-4 py-5 mx-auto">
           <div class="row d-flex justify-content-center px-3">
              <div class="big-chart-card border-0">
                 <canvas id="2termometros" width="80%"></canvas>
              </div>
           </div>
        </div>
     </div>
  </div>

  <script>
    var ctx = document.getElementById('termometro1').getContext('2d');
    var options = {
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }

    var data = {
            labels: <?php echo json_encode(array_column($dashboardData[1], 'date')) ?>,
            datasets: [{
                label: 'Termómetro 1',
                data: <?php echo json_encode(array_column($dashboardData[1], 'temp')) ?>,
                backgroundColor: [
                    'rgba(204, 0, 0, 1)'
                ],
                borderColor: [
                    'rgba(255, 0, 0, 1)'
                ],
                borderWidth: 2,
                pointBorderColor: "black",
                pointBackgroundColor: "black",
                pointBorderWidth: 1,
                pointHoverRadius: 8,
                pointHoverBackgroundColor: "yellow",
                pointHoverBorderColor: "brown",
                pointHoverBorderWidth: 2,
                pointRadius: 3,
                pointHitRadius: 10
            }]
        }

    var myChart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: options
    });

  </script>

  <script>
    var ctx = document.getElementById('termometro2').getContext('2d');
    var options = {
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }

    var data = {
            labels: <?php echo json_encode(array_column($dashboardData[2], 'date')) ?>,
            datasets: [{
                label: 'Termómetro 2',
                data: <?php echo json_encode(array_column($dashboardData[2], 'temp')) ?>,
                backgroundColor: [
                    'rgba(0, 0, 204, 1)'
                ],
                borderColor: [
                    'rgba(0, 0, 255, 1)'
                ],
                borderWidth: 2,
                pointBorderColor: "rgba(36, 17, 120, 1)",
                pointBackgroundColor: "rgba(36, 17, 120, 1)",
                pointBorderWidth: 1,
                pointHoverRadius: 8,
                pointHoverBackgroundColor: "yellow",
                pointHoverBorderColor: "brown",
                pointHoverBorderWidth: 2,
                pointRadius: 3,
                pointHitRadius: 10
            }]
        }

    var myChart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: options
    });
  </script>

  <script>
    var ctx = document.getElementById('2termometros').getContext('2d');
    var options = {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }

    var data = {
            labels: <?php echo json_encode(array_column($dashboardData[1], 'date')) ?>,
            datasets: [{
                label: 'Temperatura',
                data: <?php echo json_encode(array_column($dashboardData[1], 'temp')) ?>,
                backgroundColor: [
                    'rgba(204, 0, 0, 1)'
                ],
                borderColor: [
                    'rgba(255, 0, 0, 1)'
                ],
                borderWidth: 2,
                pointBorderColor: "black",
                pointBackgroundColor: "black",
                pointBorderWidth: 1,
                pointHoverRadius: 8,
                pointHoverBackgroundColor: "yellow",
                pointHoverBorderColor: "brown",
                pointHoverBorderWidth: 2,
                pointRadius: 3,
                pointHitRadius: 10
            },
            {
                label: 'Humedad',
                data: <?php echo json_encode(array_column($dashboardData[2], 'temp')) ?>,
                backgroundColor: [
                    'rgba(0, 0, 204, 1)'
                ],
                borderColor: [
                    'rgba(0, 0, 255, 1)'
                ],
                borderWidth: 2,
                pointBorderColor: "rgba(36, 17, 120, 1)",
                pointBackgroundColor: "rgba(36, 17, 120, 1)",
                pointBorderWidth: 1,
                pointHoverRadius: 8,
                pointHoverBackgroundColor: "yellow",
                pointHoverBorderColor: "brown",
                pointHoverBorderWidth: 2,
                pointRadius: 3,
                pointHitRadius: 10,
            }]
        }

    var myChart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: options
    });
  </script>
<?php
}
?>

<?php
if ($this->partialview === 'thermometer'){
?>
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
  </div>

<?php
}
?>