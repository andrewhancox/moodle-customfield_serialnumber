<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Menu profile field definition.
 *
 * @package    customfield_serialnumber
 * @copyright  2007 onwards Shane Elliot {@link http://pukunui.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace customfield_serialnumber;

use core_customfield\field;
use MoodleQuickForm;

/**
 * Class profile_define_menu
 *
 * @copyright  2007 onwards Shane Elliot {@link http://pukunui.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class field_controller extends \core_customfield\field_controller {
    /**
     * Adds elements to the form for creating/editing this type of profile field.
     * @param MoodleQuickForm $form
     */
    public function config_form_definition(MoodleQuickForm $form) {
        $form->addElement('text', 'configdata[prefix]', get_string('prefix', 'customfield_serialnumber'));
        $form->setType('configdata[prefix]', PARAM_TEXT);
    }
}

