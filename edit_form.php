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
 * Form for editing ild_alumniblock block instances.
 *
 * @package   block_ild_oauthblock
 * @copyright Jan Rieger
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_ild_oauthblock_edit_form extends block_edit_form {
    protected function specific_definition($mform) {
        global $CFG, $DB;

        // Fields for editing HTML block title and contents.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $mform->addElement('text', 'config_title', get_string('configtitle', 'block_ild_oauthblock'));
        $mform->setType('config_title', PARAM_TEXT);
		
		$mform->addElement('text', 'config_linktext', get_string('configlinktext', 'block_ild_oauthblock'));
        $mform->setType('config_linktext', PARAM_TEXT);
		
		$issuers = $DB->get_records('oauth2_issuer', array());
		$options = array('a' => get_string('choose', 'block_ild_oauthblock'));
		foreach ($issuers as $issuer) {
			$options[$issuer->id] = $issuer->name;
		}
		$mform->addElement('select', 'config_issuer', get_string('issuer', 'block_ild_oauthblock'), $options);
		$mform->setDefault('config_issuer', 'a');
		$mform->addRule('config_issuer', get_string('error_choose', 'block_ild_oauthblock'), 'numeric', null, 'client');
		$mform->addRule('config_issuer', null, 'required', null, 'client');

        $mform->addElement('editor', 'config_description', get_string('description', 'block_ild_oauthblock'));
        $mform->setType('config_description', PARAM_RAW);
        //$mform->addRule('config_description', null, 'required', null, 'client');
    }
}
