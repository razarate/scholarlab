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

$doc = JFactory::getDocument();
$doc->addStylesheet( JURI::base(true) . '/components/com_scholarlab/assets/css/bootstrap.min.css' );
$doc->addStylesheet( JURI::base(true) . '/components/com_scholarlab/assets/css/weather-icons.min.css' );
$doc->addStylesheet( JURI::base(true) . '/components/com_scholarlab/assets/css/style.css' );
$doc->addStylesheet( JURI::base(true) . '/components/com_scholarlab/assets/font-awesome/css/font-awesome.min.css' );

//$doc->addScript( JURI::base(true) . '/components/com_scholarlab/assets/js/bootstrap.min.js' );
//$doc->addScript( JURI::base(true) . '/components/com_scholarlab/assets/js/jquery.min.js' );


//$sensorValuesArray = $this->result;
$sensorValuesArray = json_decode($this->result, true);
print_r($sensorValuesArray);
?>

<!-- Weather Widget - START -->
<div class="container">
<div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="weather">
                <div class="current">
                    <div class="info">
                        <div>&nbsp;</div>
                        <div class="city"><small><small>CITY:</small></small> London</div>
                        <div class="temp"><?php echo number_format($sensorValuesArray['Temp'], 1) ?>&deg; <small>C</small></div>
                        <div class="wind"><small><small>WIND:</small></small> 22 km/h</div>
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
                <div class="col-md-6">
                    <h3 class="text-info">
                        Configured GPIO <span class="hidden-xs">(board mode)</span></a>
                    </h3>
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>
                                    PIN
                                </th>
                                <th>
                                    Description
                                </th>
                                <th>
                                    State
                                </th>
                                <th>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                            {% for pin in pins %}
                            {% if pins[pin].mode == 'NO' %}
                            <tr {% if pins[pin].state== true %} class="success" {% else %}class="danger" {% endif %}>
                                <td>{{ pins[pin].pin }}</td>
                                <td>{{ pins[pin].name }}</td>
                                <td>
                                    {% if pins[pin].state == true %}
                                    On
                                    {% else %}
                                    Off
                                    {% endif %}
                                </td>
                                <td>
                                    {% if pins[pin].state == true %}
                                    <a href="/{{pin}}/off">Off</a>
                                    {% else %}
                                    <a href="/{{pin}}/on">On</a>
                                    {% endif %}
                                    | <a href="/{{pin}}/blink">Blink</a>
                                </td>
                                {% else %}
                            <tr {% if pins[pin].state== true %} class="danger" {% else %}class="success" {% endif %}>
                                <td>{{ pins[pin].pin }}</td>
                                <td>{{ pins[pin].name }}</td>
                                <td>
                                    {% if pins[pin].state == true %}
                                    Off
                                    {% else %}
                                    On
                                    {% endif %}
                                </td>
                                <td>
                                    {% if pins[pin].state == true %}
                                    <a href="/{{pin}}/off">On</a>
                                    {% else %}
                                    <a href="/{{pin}}/on">Off</a>
                                    {% endif %}
                                    | <a href="/{{pin}}/blink">Blink</a>
                                </td>
                                {% endif %}
                            </tr>
                            {% endfor %}
                        </tbody>
                    </table>
                    <span><strong>Fast actions: </strong><a href="/off_all_gpio">All OFF</a> | <a href="/on_all_gpio">All ON</a></span>
                    <br />



                </div>
                <div class="col-md-6">

                    <ul class="nav nav-tabs">
                        
                        <li  class="active"><a class="tab_mobile" data-toggle="tab" href="#menu_sensors">Connections</a></li>
                        <li><a class="tab_mobile" data-toggle="tab" href="#home">Audio & Video</a></li>
                        <li><a class="tab_mobile" data-toggle="tab" href="#menu1" OnClick="javascript:getGpioStatus();">GPIO Status</a></li>
                        
                    </ul>

                    <div class="tab-content">
                        <div id="home" class="tab-pane fade  ">
                            <h3 class="text-info">
                                Video controls
                            </h3>

                            <div class="row">
                                <div class="col-md-6">

                                    <a href="/start_video" class="button btn btn-primary btn-block">
                                        Start video
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a href="/stop_audio_video" class="button btn btn-danger btn-block">
                                        Stop video
                                    </a>
                                </div>
                            </div>
                            <h3>
                                Audio controls
                            </h3>
                            <div class="row">
                                <div class="col-md-4">

                                    <a href="/sample_audio_hdmi" class="button btn btn-info btn-block">
                                        Sample audio HDMI
                                    </a>
                                </div>

                                <div class="col-md-4">
                                    <a href="/sample_audio_jack" class="button btn btn-info btn-block">
                                        Sample audio 3.5mm
                                    </a>
                                </div>

                                <div class="col-md-4">
                                    <a href="/stop_audio_video" class="button btn btn-danger btn-block">
                                        Stop audio
                                    </a>
                                </div>

                            </div>
                        </div>
                        <div id="menu1" class="tab-pane fade">

                            <pre id="gpio_status">
                        
                            </pre>
                        </div>
                        
                        <div id="menu_sensors" class="tab-pane fade in active">


    <!-- **************************+  YOU CAN ADD IN THIS SECTION YOUR SENSORS *************************** -->   

                            {% if temperature_sensor == True %}
                            <div  style="margin: 20px 0 20px 0;">
                                    <div class = "list-group">
                                       <a href = "#" class = "list-group-item active">
                                          <h4 class = "list-group-item-heading">
                                             Temperature & Humidity
                                          </h4>
                                       </a>
                                       
                                       <a href = "#" class = "list-group-item">
                                          <h4 class = "list-group-item-heading">
                                            <div id="temperature">
                                                <strong>Temp: <?php echo $sensorValuesArray['Temp'] ?></strong><br/>
                                                <strong>Humidity: <?php echo $sensorValuesArray['Pressure'] ?></strong>
                                            </div>
                                          </h4>
                                          
                                          <p class = "list-group-item-text">
                                             Distancia: <?php echo $sensorValuesArray->Distancia ?>
                                          </p>
                                       </a>
                                    </div>
                                </div>
                            {% endif %}

                            {% if lcd_display == True %}
                                <div  style="margin: 20px 0 20px 0;">
                                    <div class = "list-group">
                                       <a href = "#" class = "list-group-item active">
                                          <h4 class = "list-group-item-heading">
                                             LCD Display control
                                          </h4>
                                       </a>
                                       
                                       <a href = "#" class = "list-group-item">
                                          <h4 class = "list-group-item-heading">

                                            <label>Set a message: </label>
                                                <input type="text" id="lcd_message" name="lcd_message" value="" placeholder=""/> 
                                                <button>Set message</button> <span style="display:inline" id="message_set"></span>
                                          </h4>
                                          
                                       </a>
                                    </div>
                                </div>
                            {% endif %}

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