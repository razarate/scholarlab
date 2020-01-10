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

//JFactory::getApplication()->enqueueMessage( print_r($this->hardware, 1), 'notice');
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
                      <strong>PROCESADOR</strong> <?php echo $this->hardware['processor'] ?>
                  </div>

                  <div>
                      <strong>OS</strong> <?php echo $this->survey_data['osrelease'] ?>
                  </div>

                  <div>
                      <strong>KERNEL</strong> <?php echo $this->survey_data['kernel'] ?>
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
                      <strong>#</strong> <?php echo ($this->get_throttled_state['undervoltageoccurred'] == FALSE) ? "No" : "Si" ?>
                  </div>

                  <div>
                      <strong>DECLINED</strong> 182
                  </div>

              </div>

              <div class="stats">

                  <div>
                      <strong>Frec ARM</strong> <?php echo ($this->get_throttled_state['armfrequencycapped'] == FALSE) ? "No" : "Si" ?>
                  </div>

                  <div>
                      <strong>#</strong> <?php echo ($this->get_throttled_state['armfrequencycappedoccurred'] == FALSE) ? "No" : "Si" ?>
                  </div>

                  <div>
                      <strong>DECLINED</strong> 182
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
                      <strong>DECLINED</strong> 182
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
      <div class="col-md-1 col-xs-6" >
        <!--
          <img alt="Bootstrap Image Preview" src="/static/digitalborder_logo.jpg" style="max-width:62px"/>
        -->
        Imagen
      </div>
      <div class="col-md-11 col-xs-6">
          <p style="margin-top:20px">Cuellos de botella <a href="http://www.piensocial.com" target="_blank">Piensocial.com</a> <span class="hidden-xs"> | <?php echo ($this->get_throttled_state['currentlythrottled'] == FALSE) ? "No" : "Si" ?></span></p>
          Eventos ocurridos <?php echo ($this->get_throttled_state['throttlingoccurred'] == FALSE) ? "No" : "Si" ?>
      </div>
  </div>