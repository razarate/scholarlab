<?php
 /**
 * @package Component com_webinaradministrator for Joomla! 3.5+
 * @version $Id: edit.php 3.8 2018-05-05 14:26:33Z Piensocial $
 * @author Piensocial.com
 * @copyright (C) 2010- Piensocial.com
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

// No direct access
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.formvalidator');
JHtml::_('behavior.keepalive');

?>

<form action="<?php echo JRoute::_('index.php?option=com_scholarlab&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
	<div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'details')); ?>
            <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', empty($this->item->id) ? JText::_('COM_SCHOLARLAB_SENSOR_NEW') : JText::_('COM_SCHOLARLAB_SENSOR_EDIT')); ?>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="row-fluid form-horizontal-desktop float-cols" >
                            <div class="span6">
                                <?php echo $this->form->renderField('id'); ?>
                                <?php echo $this->form->renderField('title'); ?>
                                <?php echo $this->form->renderField('sensor_type'); ?>
                                <?php echo $this->form->renderField('sensor_id'); ?>
                            </div>
                            <div class="span6">
                                <?php echo $this->form->renderField('catid'); ?>
                                <?php echo $this->form->renderField('published'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php echo JHtml::_('bootstrap.endTab'); ?>
        <?php echo JHtml::_('bootstrap.endTabSet'); ?>
	</div>
    <input type="hidden" name="task" value="sensor.edit" />
    <?php echo JHtml::_('form.token'); ?>
</form>