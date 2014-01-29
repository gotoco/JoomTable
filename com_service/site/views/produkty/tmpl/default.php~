<?php
/**
 * @version     1.0.0
 * @package     com_service
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// no direct access
defined('_JEXEC') or die;
?>
<script type="text/javascript">
    function deleteItem(item_id){
        if(confirm("<?php echo JText::_('COM_SERVICE_DELETE_MESSAGE'); ?>")){
            document.getElementById('form-produkt-delete-' + item_id).submit();
        }
    }
</script>

<div class="items">

<?php $show = false; ?>
   <table style="width: 100%; " >
   <tr style="border-bottom: 1px solid #dadada;">
      <td style="color: #0088cc; font-weight: bold">Nazwa</td>
      <td style="color: #0088cc; font-weight: bold">Kategoria</td>
      <td style="color: #0088cc; font-weight: bold">Cena</td>
      <td style="color: #0088cc; font-weight: bold">Promocja</td>
   </tr>
        <?php foreach ($this->items as $item) : ++$x; ?>

            
				<?php
					if($item->state == 1 || ($item->state == 0 && JFactory::getUser()->authorise('core.edit.own',' com_service.produkt.'.$item->id))):
						$show = true;
						?>
							<tr style="border-bottom: 1px solid #dadada; background: #<?php echo $x%2 == 0 ? 'fff' : 'f9f9f9' ?>">
								<td><a style="color: #0088cc" href="<?php echo JRoute::_('index.php?option=com_service&view=produkt&id=' . (int)$item->id); ?>"><?php echo $item->name; ?></a></td>
                <td><?php echo $item->category; ?></td>
                <td><?php echo $item->price; ?></td>
 		<td><?php echo $item->off; ?></td>                          
							</tr>
						<?php endif; ?>

<?php endforeach; ?>
        <?php
        if (!$show):
            echo JText::_('COM_SERVICE_NO_ITEMS');
        endif;
        ?>
    </table>
</div>
<?php if ($show): ?>
    <div class="pagination">
        <p class="counter">
            <?php echo $this->pagination->getPagesCounter(); ?>
        </p>
        <?php echo $this->pagination->getPagesLinks(); ?>
    </div>
<?php endif; ?>

