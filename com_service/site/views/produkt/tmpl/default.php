<?php
/**
 * @version     1.0.0
 * @package     com_service
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// no direct access
defined('_JEXEC') or die;


$lang = JFactory::getLanguage();
$lang->load('com_service', JPATH_ADMINISTRATOR);

?>
<?php if ($this->item) : ?>

    <div class="item_fields">

        <ul class="fields_list">

            			<li><?php echo JText::_('COM_SERVICE_FORM_LBL_PRODUKT_ID'); ?>:
			<?php echo $this->item->id; ?></li>
			<li><?php echo JText::_('COM_SERVICE_FORM_LBL_PRODUKT_ORDERING'); ?>:
			<?php echo $this->item->ordering; ?></li>
			<li><?php echo JText::_('COM_SERVICE_FORM_LBL_PRODUKT_STATE'); ?>:
			<?php echo $this->item->state; ?></li>
			<li><?php echo JText::_('COM_SERVICE_FORM_LBL_PRODUKT_CREATED_BY'); ?>:
			<?php echo $this->item->created_by; ?></li>
			<li><?php echo JText::_('COM_SERVICE_FORM_LBL_PRODUKT_NAME'); ?>:
			<?php echo $this->item->name; ?></li>
			<li><?php echo JText::_('COM_SERVICE_FORM_LBL_PRODUKT_CATEGORY'); ?>:
			<?php echo $this->item->category; ?></li>
			<li><?php echo JText::_('COM_SERVICE_FORM_LBL_PRODUKT_PRICE'); ?>:
			<?php echo $this->item->price; ?></li>
			<li><?php echo JText::_('COM_SERVICE_FORM_LBL_PRODUKT_DESCRIPTION'); ?>:
			<?php echo $this->item->description; ?></li>
			<li><?php echo JText::_('COM_SERVICE_FORM_LBL_PRODUKT_ACTIVE'); ?>:
			<?php echo $this->item->active; ?></li>


        </ul>

    </div>
    
<?php
else:
    echo JText::_('COM_SERVICE_ITEM_NOT_LOADED');
endif;
?>
