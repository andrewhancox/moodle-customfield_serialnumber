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

namespace customfield_serialnumber;

use MoodleQuickForm;

/**
 * Menu profile field.
 *
 * @package    customfield_serialnumber
 * @copyright  2007 onwards Shane Elliot {@link http://pukunui.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Class profile_field_menu
 *
 * @copyright  2007 onwards Shane Elliot {@link http://pukunui.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class data_controller extends \core_customfield\data_controller {
    /**
     * Return the name of the field where the information is stored
     *
     * @return string
     */
    public function datafield(): string {
        return 'shortcharvalue';
    }

    /**
     * Add fields for editing a checkbox field.
     *
     * @param MoodleQuickForm $mform
     */
    public function instance_form_definition(MoodleQuickForm $mform) {
        $mform->addElement('text', $this->get_form_element_name(), $this->field->get_formatted_name());
        $mform->setType($this->get_form_element_name(), PARAM_TEXT);
        $mform->freeze($this->get_form_element_name());
    }

    /**
     * Returns the default value as it would be stored in the database (not in human-readable format).
     *
     * @return mixed
     */
    public function get_default_value() {
        return null;
    }

    /**
     * Returns value in a human-readable format
     *
     * @return mixed|null value or null if empty
     */
    public function get_value() {
        $this->setvalue_if_empty_and_possible($this->get('instanceid'));

        $value = $this->get($this->datafield());

        if (empty($value)) {
            return get_string('yettoallocate', 'customfield_serialnumber');
        }

        $prefix = $this->field->get_configdata_property('prefix');

        if (!empty($prefix)) {
            $prefix .= '-';
        }
        return $prefix . $value;
    }

    public function instance_form_save(\stdClass $datanew) {
        $this->setvalue_if_empty_and_possible($datanew->id);
    }

    public function instance_form_before_set_data(\stdClass $instance) {
        $this->setvalue_if_empty_and_possible($instance->id);

        $instance->{$this->get_form_element_name()} = $this->export_value();
    }

    /**
     * @param \stdClass $instance
     * @return void
     * @throws \coding_exception
     */
    public function setvalue_if_empty_and_possible(int $instanceid): void {
        global $DB;

        if (!empty($instanceid) && empty($this->data->get($this->datafield()))) {
            $value = strtolower(random_string(4) . '-' . random_string(4));
            if ($DB->record_exists('customfield_data', [$this->datafield() => $value])) {
                $value = strtolower(random_string(4) . '-' . random_string(4));
            }
            if ($DB->record_exists('customfield_data', [$this->datafield() => $value])) {
                throw new \Exception('Unable to generate unique serial number');
            }

            $this->data->set('contextid', $this->get_field()->get_category()->get_handler()->get_instance_context($instanceid)->id);
            $this->data->set($this->datafield(), $value);
            $this->data->set('value', $value);
            $this->data->set('valueformat', 0);
            $this->save();
        }
    }
}


