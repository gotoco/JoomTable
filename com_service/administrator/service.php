<?php
/**
 * @version     1.0.0
 * @package     com_service
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */


// no direct access
defined('_JEXEC') or die;

if (!JFactory::getUser()->authorise('core.manage', 'com_service')) 
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

jimport('joomla.application.component.controller');

$controller	= JControllerLegacy::getInstance('Service');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
