<?php
/**
 * @version     1.0.0
 * @package     com_service
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

class ServiceModelProdukt extends JModelAdmin
{
	protected $text_prefix = 'COM_SERVICE';


	public function getTable($type = 'Produkt', $prefix = 'ServiceTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getForm($data = array(), $loadData = true)
	{
		$app	= JFactory::getApplication();
		$form = $this->loadForm('com_service.produkt', 'produkt', array('control' => 'jform', 'load_data' => $loadData));
        
		if (empty($form)) {
			return false;
		}

		return $form;
	}


	protected function loadFormData()
	{
		$data = JFactory::getApplication()->getUserState('com_service.edit.produkt.data', array());

		if (empty($data)) {
			$data = $this->getItem();
            
		}

		return $data;
	}

	public function getItem($pk = null)
	{
		return parent::getItem($pk);
	}

	protected function prepareTable($table)
	{
		jimport('joomla.filter.output');

		if (empty($table->id)) {

			// ustaw kolejnosć na ostatnia pozycje
			if (@$table->ordering === '') {
				$db = JFactory::getDbo();
				$db->setQuery('SELECT MAX(ordering) FROM #__service');
				$max = $db->loadResult();
				$table->ordering = $max+1;
			}

		}
	}

}