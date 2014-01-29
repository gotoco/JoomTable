<?php
/**
 * @version     1.0.0
 * @package     com_service
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modelform');
jimport('joomla.event.dispatcher');


class ServiceModelProdukt extends JModelForm
{
    
    var $_item = null;
    
	protected function populateState()
	{
		$app = JFactory::getApplication('com_service');


        if (JFactory::getApplication()->input->get('layout') == 'edit') {
            $id = JFactory::getApplication()->getUserState('com_service.edit.produkt.id');
        } else {
            $id = JFactory::getApplication()->input->get('id');
            JFactory::getApplication()->setUserState('com_service.edit.produkt.id', $id);
        }
		$this->setState('produkt.id', $id);

		$params = $app->getParams();
        $params_array = $params->toArray();
        if(isset($params_array['item_id'])){
            $this->setState('produkt.id', $params_array['item_id']);
        }
		$this->setState('params', $params);

	}
        


	public function &getData($id = null)
	{
		if ($this->_item === null)
		{
			$this->_item = false;

			if (empty($id)) {
				$id = $this->getState('produkt.id');
			}


			$table = $this->getTable();


			if ($table->load($id))
			{

				if ($published = $this->getState('filter.published'))
				{
					if ($table->state != $published) {
						return $this->_item;
					}
				}


				$properties = $table->getProperties(1);
				$this->_item = JArrayHelper::toObject($properties, 'JObject');
			} elseif ($error = $table->getError()) {
				$this->setError($error);
			}
		}

		return $this->_item;
	}
    
	public function getTable($type = 'Produkt', $prefix = 'ServiceTable', $config = array())
	{   
        $this->addTablePath(JPATH_COMPONENT_ADMINISTRATOR.'/tables');
        return JTable::getInstance($type, $prefix, $config);
	}     

	public function checkin($id = null)
	{
		$id = (!empty($id)) ? $id : (int)$this->getState('produkt.id');

		if ($id) {
            
			$table = $this->getTable();

            if (method_exists($table, 'checkin')) {
                if (!$table->checkin($id)) {
                    $this->setError($table->getError());
                    return false;
                }
            }
		}

		return true;
	}

	public function checkout($id = null)
	{
		$id = (!empty($id)) ? $id : (int)$this->getState('produkt.id');

		if ($id) {
            
			$table = $this->getTable();

			$user = JFactory::getUser();
            if (method_exists($table, 'checkout')) {
                if (!$table->checkout($user->get('id'), $id)) {
                    $this->setError($table->getError());
                    return false;
                }
            }
		}

		return true;
	}    
    
	public function getForm($data = array(), $loadData = true)
	{
		$form = $this->loadForm('com_service.produkt', 'produkt', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		return $form;
	}

	protected function loadFormData()
	{
		$data = $this->getData(); 
        
        return $data;
	}

	public function save($data)
	{
		$id = (!empty($data['id'])) ? $data['id'] : (int)$this->getState('produkt.id');
        $state = (!empty($data['state'])) ? 1 : 0;
        $user = JFactory::getUser();

        if($id) {
            $authorised = $user->authorise('core.edit', 'com_service.produkt.'.$id) || $authorised = $user->authorise('core.edit.own', 'com_service.produkt.'.$id);
            if($user->authorise('core.edit.state', 'com_service.produkt.'.$id) !== true && $state == 1){ //The user cannot edit the state of the item.
                $data['state'] = 0;
            }
        } else {
            $authorised = $user->authorise('core.create', 'com_service');
            if($user->authorise('core.edit.state', 'com_service.produkt.'.$id) !== true && $state == 1){ //The user cannot edit the state of the item.
                $data['state'] = 0;
            }
        }

        if ($authorised !== true) {
            JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
            return false;
        }
        
        $table = $this->getTable();
        if ($table->save($data) === true) {
            return $id;
        } else {
            return false;
        }
        
	}
    
     function delete($data)
    {
        $id = (!empty($data['id'])) ? $data['id'] : (int)$this->getState('produkt.id');
        if(JFactory::getUser()->authorise('core.delete', 'com_service.produkt.'.$id) !== true){
            JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
            return false;
        }
        $table = $this->getTable();
        if ($table->delete($data['id']) === true) {
            return $id;
        } else {
            return false;
        }
        
        return true;
    }
    
    function getCategoryName($id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query 
            ->select('title')
            ->from('#__categories')
            ->where('id = ' . $id);
        $db->setQuery($query);
        return $db->loadObject();
    }
    
}