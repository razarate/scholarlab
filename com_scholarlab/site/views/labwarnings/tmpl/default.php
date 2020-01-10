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

//JFactory::getApplication()->enqueueMessage( print_r($this->vcgencmd_data, 1), 'notice');
?>

<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
      <div class="tile">
          <div class="wrapper">
              <div class="header">Hardware</div>

              <div class="banner-img">
                  <img src="<?php echo JURI::base(true) . '/components/com_scholarlab/assets/img/RasPiLogo.png' ?>" alt="Raspberry Pi">
              </div>
<!--
              <div class="dates">
                  <div class="start">
                      <strong>STARTS</strong> 12:30 JAN 2015
                      <span></span>
                  </div>
                  <div class="ends">
                      <strong>ENDS</strong> 14:30 JAN 2015
                  </div>
              </div>
-->

              <div class="stats">

                  <div>
                      <strong>Revisión</strong> <?php echo $this->hardware['revision'] ?>
                  </div>

                  <div>
                      <strong>RaspberryPi</strong> <?php echo $this->hardware['model'] ?>
                  </div>

                  <div>
                      <strong>ID</strong> <?php echo $this->survey_data['deviceid'] ?>
                  </div>

              </div>

              <div class="stats">

                  <div>
                      <strong>CPU TEMP</strong> <?php echo $this->vcgencmd_data['cputemp'] ?>
                  </div>

                  <div>
                      <strong>FRECUENCY</strong> <?php echo ($this->vcgencmd_data['armfreq'] / 1000000) ?> <small>MHz</small>
                  </div>

                  <div>
                      <strong>CORE VOLTAGE</strong> <?php echo $this->vcgencmd_data['corevoltage'] ?>
                  </div>

              </div>

              <div class="stats">

                  <div>
                      <strong>PROCESADOR</strong> <?php echo $this->hardware['processor'] ?>
                  </div>

                  <div>
                      <strong>OS</strong> ds
                  </div>

                  <div>
                      <strong>KERNEL</strong> sd
                  </div>

              </div>

              <div class="footer">
                  <a href="#" class="Cbtn Cbtn-primary">View</a>
                  <a href="#" class="Cbtn Cbtn-danger">Delete</a>
              </div>
          </div>
      </div> 
  </div>

  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
      <div class="tile">
          <div class="wrapper">
              <div class="header">Warnings</div>
              <div class="banner-img">
                  <img src="<?php echo JURI::base(true) . '/components/com_scholarlab/assets/img/RasPiLogoWarning.png' ?>" alt="Warning">
              </div>
<!--
              <div class="dates">
                  <div class="start">
                      <strong>STARTS</strong> 12:30 JAN 2015
                      <span></span>
                  </div>
                  <div class="ends">
                      <strong>ENDS</strong> 14:30 JAN 2015
                  </div>
              </div>
-->

              <div class="stats">

                  <div>
                      <strong>Bajo Voltaje</strong> <?php echo ($this->get_throttled_state['undervoltagedetected'] == FALSE) ? "No" : "Si" ?>
                  </div>

                  <div>
                      <strong>Frecuencia</strong> <?php echo ($this->get_throttled_state['armfrequencycapped'] == FALSE) ? "No" : "Si" ?>
                  </div>

                  <div>
                      <strong>Bloqueo</strong> <?php echo ($this->get_throttled_state['currentlythrottled'] == FALSE) ? "No" : "Si" ?>
                  </div>

              </div>

              <div class="stats">

                  <div>
                      <strong># LV</strong> <?php echo ($this->get_throttled_state['undervoltageoccurred'] == FALSE) ? "No" : "Si" ?>
                  </div>

                  <div>
                      <strong># Frec</strong> <?php echo ($this->get_throttled_state['armfrequencycappedoccurred'] == FALSE) ? "No" : "Si" ?>
                  </div>

                  <div>
                      <strong># Bloqueo</strong> <?php echo ($this->get_throttled_state['throttlingoccurred'] == FALSE) ? "No" : "Si" ?>
                  </div>

              </div>

              <div class="stats">

                  <div>
                      <strong>Temp Alta</strong> <?php echo ($this->get_throttled_state['templimitactive'] == FALSE) ? "No" : "Si" ?>
                  </div>

                  <div>
                      <strong>#</strong> <?php echo ($this->get_throttled_state['templimitoccurred'] == FALSE) ? "No" : "Si" ?>
                  </div>

                  <div>
                      <strong>DECLINED</strong> <i class="far fa-check-circle"></i>
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

  <div class="row" style="background-color:#fafafa;padding:15px">
      <div class="col-md-3 col-xs-6" >
          <img alt="Raspi" src="<?php echo JURI::base(true) . '/components/com_scholarlab/assets/img/RasPiLogo.png' ?>" style="max-width:100px"/>
      </div>
      <div class="col-md-8 col-xs-6">
          <p style="margin-top:20px">Sistema Operativo: <?php echo $this->survey_data['osrelease'] ?> </p>
          <p style="margin-top:2px">Kernel: <?php echo $this->survey_data['kernel'] ?> </span></p>
      </div>
  </div>