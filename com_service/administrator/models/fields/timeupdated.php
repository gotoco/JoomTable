<?php
/**
 * @version     1.0.0
 * @package     com_service
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

class JFormFieldTimeupdated extends JFormField
{


	protected $type = 'timeupdated';


	protected function getInput()
	{

		$html = array();
        
        
		$old_time_updated = $this->value;
        $hidden = (boolean) $this->element['hidden'];
        if ($hidden == null || !$hidden){
            if (!strtotime($old_time_updated)) {
                $html[] = '-';
            } else {
                $jdate = new JDate($old_time_updated);
                $pretty_date = $jdate->format(JText::_('DATE_FORMAT_LC2'));
                $html[] = "<div>".$pretty_date."</div>";
            }
        }
        $time_updated = date("Y-m-d H:i:s");
        $html[] = '<input type="hidden" name="'.$this->name.'" value="'.$time_updated.'" />';
        
		return implode($html);
	}
}