<?php
 /**
 * @package Component com_webinaradministrator for Joomla! 3.5+
 * @version $Id: default.php 3.8 2018-05-05 14:26:33Z Piensocial $
 * @author Piensocial.com
 * @copyright (C) 2010- Piensocial.com
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

JHtml::_('formbehavior.chosen', 'select');

$listOrder     = $this->escape($this->filter_order);
$listDirn      = $this->escape($this->filter_order_Dir);
?>

<form action="<?php echo JRoute::_('index.php?option=com_scholarlab&view=sensors'); ?>" method="post" name="adminForm" id="adminForm">
	<div id="j-sidebar-container" class="span2">
		<?php echo JHtmlSidebar::render(); ?>
	</div>
	<div id="j-main-container" class="span10">

	<div class="row-fluid">
		<div class="span6">
			<?php echo JText::_('COM_SCHOLARLAB_FILTER'); ?>
			<?php
				echo JLayoutHelper::render(
					'joomla.searchtools.default',
					array('view' => $this)
				);
			?>
		</div>
	</div>

	<?php if (!empty( $this->sidebar)) : ?>
		<div id="j-sidebar-container" class="span2">
			<?php echo $this->sidebar; ?>
		</div>
		<div id="j-main-container" class="span10">
	<?php else : ?>
		<div id="j-main-container">
	<?php endif;?>

		<table class="table table-striped table-hover" id="roomList" style="position: relative;">
			<thead>
			<tr>
				<th width="1%"><?php echo JText::_('COM_SCHOLARLAB_NUM'); ?></th>
				<th width="2%">
					<?php echo JHtml::_('grid.checkall'); ?>
				</th>
				<th width="30%">
					<?php echo JHtml::_('grid.sort', 'COM_SCHOLARLAB_SENSOR_NAME_LABEL', 'title', $listDirn, $listOrder) ;?>
				</th>
				<th width="30%">
					<?php echo JText::_('COM_SCHOLARLAB_SENSOR_TYPE_LABEL') ;?>
				</th>
				<th width="30%">
					<?php echo JText::_('COM_SCHOLARLAB_SENSOR_ID_LABEL') ;?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'COM_SCHOLARLAB_STATUS','published', $listDirn, $listOrder); ?>
				</th>
				<th width="2%">
					<?php echo JHtml::_('grid.sort', 'COM_SCHOLARLAB_ID', 'id', $listDirn, $listOrder); ?>
				</th>
			</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="5">
						<?php echo $this->pagination->getListFooter(); ?>
					</td>
				</tr>
			</tfoot>
			<tbody class="">
				<?php if (!empty($this->items)) : ?>
					<?php foreach ($this->items as $i => $row) :
						$link = JRoute::_('index.php?option=com_scholarlab&task=sensor.edit&id=' . $row->id);
					?>
						<tr>
							<td><?php echo $this->pagination->getRowOffset($i); ?></td>

							<td>
								<?php echo JHtml::_('grid.id', $i, $row->id); ?>
							</td>

							<td>
								<a href="<?php echo $link; ?>" title=" ">
									<?php echo $row->title; ?>
								</a>
								<div class="small">
									<?php echo JText::_('JCATEGORY') . ': ' . $this->escape($row->category_title); ?>
								</div>
							</td>

							<td>
								<?php echo $this->escape($row->sensor_type); ?>
							</td>

				        	<td>
				            	<?php echo $this->escape($row->sensor_id); ?>
				        	</td>

							<td align="center">
								<?php echo JHtml::_('jgrid.published', $row->published, $i, 'sensors.', true, 'cb'); ?>
							</td>

							<td align="center">
								<?php echo $row->id; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
	<?php echo JHtml::_('form.token'); ?>
    </div>
</form>
