<?php
/**
 * @version     1.0.0
 * @package     com_service
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

require_once JPATH_COMPONENT.'/controller.php';

class ServiceControllerProdukt extends ServiceController
{

	public function edit()
	{
		$app			= JFactory::getApplication();

		$previousId = (int) $app->getUserState('com_service.edit.produkt.id');
		$editId	= JFactory::getApplication()->input->getInt('id', null, 'array');

		$app->setUserState('com_service.edit.produkt.id', $editId);

		$model = $this->getModel('Produkt', 'ServiceModel');

		if ($editId) {
            $model->checkout($editId);
		}

		if ($previousId) {
            $model->checkin($previousId);
		}
		$this->setRedirect(JRoute::_('index.php?option=com_service&view=produktform&layout=edit', false));
	}

	public function save()
	{
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		$app	= JFactory::getApplication();
		$model = $this->getModel('Produkt', 'ServiceModel');
		$data = JFactory::getApplication()->input->get('jform', array(), 'array');
		$form = $model->getForm();
		if (!$form) {
			JError::raiseError(500, $model->getError());
			return false;
		}
		$data = $model->validate($form, $data);
		if ($data === false) {
			$errors	= $model->getErrors();
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
				if ($errors[$i] instanceof Exception) {
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				} else {
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}

			$app->setUserState('com_service.edit.produkt.data', JRequest::getVar('jform'),array());
			$id = (int) $app->getUserState('com_service.edit.produkt.id');
			$this->setRedirect(JRoute::_('index.php?option=com_service&view=produkt&layout=edit&id='.$id, false));
			return false;
		}

		$return	= $model->save($data);

		if ($return === false) {
			$app->setUserState('com_service.edit.produkt.data', $data);

			$id = (int)$app->getUserState('com_service.edit.produkt.id');
			$this->setMessage(JText::sprintf('Save failed', $model->getError()), 'warning');
			$this->setRedirect(JRoute::_('index.php?option=com_service&view=produkt&layout=edit&id='.$id, false));
			return false;
		}

            
        if ($return) {
            $model->checkin($return);
        }
        
        $app->setUserState('com_service.edit.produkt.id', null);

        $this->setMessage(JText::_('COM_SERVICE_ITEM_SAVED_SUCCESSFULLY'));
        $menu = & JSite::getMenu();
        $item = $menu->getActive();
        $this->setRedirect(JRoute::_($item->link, false));

		$app->setUserState('com_service.edit.produkt.data', null);
	}
    
    
    function cancel() {
		$menu = & JSite::getMenu();
        $item = $menu->getActive();
        $this->setRedirect(JRoute::_($item->link, false));
    }
    
	public function remove()
	{

		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));


		$app	= JFactory::getApplication();
		$model = $this->getModel('Produkt', 'ServiceModel');


		$data = JFactory::getApplication()->input->get('jform', array(), 'array');


		$form = $model->getForm();
		if (!$form) {
			JError::raiseError(500, $model->getError());
			return false;
		}

		$data = $model->validate($form, $data);

		if ($data === false) {
			$errors	= $model->getErrors();

			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
				if ($errors[$i] instanceof Exception) {
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				} else {
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}

			$app->setUserState('com_service.edit.produkt.data', $data);

			$id = (int) $app->getUserState('com_service.edit.produkt.id');
			$this->setRedirect(JRoute::_('index.php?option=com_service&view=produkt&layout=edit&id='.$id, false));
			return false;
		}

		$return	= $model->delete($data);

		if ($return === false) {
			// Save the data in the session.
			$app->setUserState('com_service.edit.produkt.data', $data);

			$id = (int)$app->getUserState('com_service.edit.produkt.id');
			$this->setMessage(JText::sprintf('Delete failed', $model->getError()), 'warning');
			$this->setRedirect(JRoute::_('index.php?option=com_service&view=produkt&layout=edit&id='.$id, false));
			return false;
		}

            
        if ($return) {
            $model->checkin($return);
        }
        
        $app->setUserState('com_service.edit.produkt.id', null);

        $this->setMessage(JText::_('COM_SERVICE_ITEM_DELETED_SUCCESSFULLY'));
        $menu = & JSite::getMenu();
        $item = $menu->getActive();
        $this->setRedirect(JRoute::_($item->link, false));

		$app->setUserState('com_service.edit.produkt.data', null);
	}
    
    
}