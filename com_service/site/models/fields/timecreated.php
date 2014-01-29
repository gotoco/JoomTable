<?php
/**
 * @version     1.0.0
 * @package     com_service
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

class JFormFieldTimecreated extends JFormField
{
	protected $type = 'timecreated';

	protected function getInput() {
        $html = array();

        $time_created = $this->value;
        if (!strtotime($time_created)) {
            $time_created = date("Y-m-d H:i:s");
            $html[] = '<input type="hidden" name="' . $this->name . '" value="' . $time_created . '" />';
        }
        $hidden = (boolean) $this->element['hidden'];
        if ($hidden == null || !$hidden) {
            $jdate = new JDate($time_created);
            $pretty_date = $jdate->format(JText::_('DATE_FORMAT_LC2'));
            $html[] = "<div>" . $pretty_date . "</div>";
        }
        return implode($html);
    }
}