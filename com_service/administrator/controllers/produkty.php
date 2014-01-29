<?php
/**
 * @version     1.0.0
 * @package     com_service
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

/**
 * Kontroler produktów.
 */
class ServiceControllerProdukty extends JControllerAdmin
{
	/**
	 * getModel
	 */
	public function getModel($name = 'produkt', $prefix = 'ServiceModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
    
    
	/**
	 * Zapisywanie kolejnosci (AJAX)
	 *
	 * @return  void
	 *
	 */
	public function saveOrderAjax()
	{
		// pobieramy dane
		$input = JFactory::getApplication()->input;
		$pks = $input->post->get('cid', array(), 'array');
		$order = $input->post->get('order', array(), 'array');

		JArrayHelper::toInteger($pks);
		JArrayHelper::toInteger($order);

		// tworzymy model
		$model = $this->getModel();

		// zapisujemy kolejnosc
		$return = $model->saveorder($pks, $order);

		if ($return)
		{
			echo "1";
		}

		// koniec
		JFactory::getApplication()->close();
	}
    
    
    
}