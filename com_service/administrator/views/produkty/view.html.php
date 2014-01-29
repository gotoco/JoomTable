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


class ServiceViewProdukty extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;


	public function display($tpl = null)
	{
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');

		if (count($errors = $this->get('Errors'))) {
			throw new Exception(implode("\n", $errors));
		}
        
		ServiceHelper::addSubmenu('produkty');
        
		$this->addToolbar();
        
        $this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}

	protected function addToolbar()
	{
		require_once JPATH_COMPONENT.'/helpers/service.php';

		$state	= $this->get('State');
		$canDo	= ServiceHelper::getActions($state->get('filter.category_id'));

		JToolBarHelper::title(JText::_('COM_SERVICE_TITLE_PRODUKTY'), 'produkty.png');

        $formPath = JPATH_COMPONENT_ADMINISTRATOR.'/views/produkt';
        if (file_exists($formPath)) {

            if ($canDo->get('core.create')) {
			    JToolBarHelper::addNew('produkt.add','JTOOLBAR_NEW');
		    }

		    if ($canDo->get('core.edit') && isset($this->items[0])) {
			    JToolBarHelper::editList('produkt.edit','JTOOLBAR_EDIT');
		    }

        }

		if ($canDo->get('core.edit.state')) {

            if (isset($this->items[0]->state)) {
			    JToolBarHelper::divider();
			    JToolBarHelper::custom('produkty.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
			    JToolBarHelper::custom('produkty.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                JToolBarHelper::deleteList('', 'produkty.delete','JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
			    JToolBarHelper::divider();
			    JToolBarHelper::archiveList('produkty.archive','JTOOLBAR_ARCHIVE');
            }
            if (isset($this->items[0]->checked_out)) {
            	JToolBarHelper::custom('produkty.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
		}
        
        if (isset($this->items[0]->state)) {
		    if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
			    JToolBarHelper::deleteList('', 'produkty.delete','JTOOLBAR_EMPTY_TRASH');
			    JToolBarHelper::divider();
		    } else if ($canDo->get('core.edit.state')) {
			    JToolBarHelper::trash('produkty.trash','JTOOLBAR_TRASH');
			    JToolBarHelper::divider();
		    }
        }

		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_service');
		}
        
		JHtmlSidebar::setAction('index.php?option=com_service&view=produkty');
        
        $this->extra_sidebar = '';
        
		JHtmlSidebar::addFilter(

			JText::_('JOPTION_SELECT_PUBLISHED'),

			'filter_published',

			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true)

		);

        
	}
    
	protected function getSortFields()
	{
		return array(
		'a.id' => JText::_('JGRID_HEADING_ID'),
		'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
		'a.state' => JText::_('JSTATUS'),
		'a.checked_out' => JText::_('COM_SERVICE_PRODUKTY_CHECKED_OUT'),
		'a.checked_out_time' => JText::_('COM_SERVICE_PRODUKTY_CHECKED_OUT_TIME'),
		'a.created_by' => JText::_('COM_SERVICE_PRODUKTY_CREATED_BY'),
		'a.name' => JText::_('COM_SERVICE_PRODUKTY_NAME'),
		'a.category' => JText::_('COM_SERVICE_PRODUKTY_CATEGORY'),
		'a.price' => JText::_('COM_SERVICE_PRODUKTY_PRICE'),
		'a.description' => JText::_('COM_SERVICE_PRODUKTY_DESCRIPTION'),
		'a.active' => JText::_('COM_SERVICE_PRODUKTY_ACTIVE'),
		);
	}

    
}
