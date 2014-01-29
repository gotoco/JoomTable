<?php
/**
 * @version     1.0.0
 * @package     com_service
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt

 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class ServiceViewProdukt extends JViewLegacy
{
	protected $state;
	protected $item;
	protected $form;


	public function display($tpl = null)
	{
		$this->state	= $this->get('State');
		$this->item		= $this->get('Item');
		$this->form		= $this->get('Form');

		if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
		}

		$this->addToolbar();
		parent::display($tpl);
	}

	protected function addToolbar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);

		$user		= JFactory::getUser();
		$isNew		= ($this->item->id == 0);
        if (isset($this->item->checked_out)) {
		    $checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));
        } else {
            $checkedOut = false;
        }
		$canDo		= ServiceHelper::getActions();

		JToolBarHelper::title(JText::_('COM_SERVICE_TITLE_PRODUKT'), 'produkt.png');

		if (!$checkedOut && ($canDo->get('core.edit')||($canDo->get('core.create'))))
		{

			JToolBarHelper::apply('produkt.apply', 'JTOOLBAR_APPLY');
			JToolBarHelper::save('produkt.save', 'JTOOLBAR_SAVE');
		}
		if (!$checkedOut && ($canDo->get('core.create'))){
			JToolBarHelper::custom('produkt.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
		}
		if (!$isNew && $canDo->get('core.create')) {
			JToolBarHelper::custom('produkt.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
		}
		if (empty($this->item->id)) {
			JToolBarHelper::cancel('produkt.cancel', 'JTOOLBAR_CANCEL');
		}
		else {
			JToolBarHelper::cancel('produkt.cancel', 'JTOOLBAR_CLOSE');
		}

	}
}
