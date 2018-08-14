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
 * Block "ild_oauthblock"
 *
 * @package    block_ild_oauthblock
 * @copyright  2018 Jan Rieger
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author     Jan Rieger
 */

class block_ild_oauthblock extends block_base {

    public function init() {
        global $PAGE;
        $this->title = get_string('pluginname', 'block_ild_oauthblock');
    }

    public function instance_allow_multiple() {
        return true;
    }

    public function has_config() {
        return false;
    }

    public function instance_allow_config() {
        return true;
    }

    public function applicable_formats() {
        return array(
            'all' => true
        );
    }

    public function specialization() {
        $this->title = isset($this->config->title) ? format_string($this->config->title) : '';
    }

    public function get_content() {
        global $DB, $USER, $CFG;

        if ($this->content !== null) {
            return $this->content;
        }

        $content = '';

        if (!isloggedin() or isguestuser()) {
            $content .= '<p>'.$this->config->description['text'].'</p>';

            //$issuer = $DB->get_record('oauth2_issuer', array('id' => $this->config->issuer));
            $id = $this->config->issuer;//isset($issuer->id) ? $issuer->id : -1;
            $wantsurl = '%2F';
            $sesskey = $USER->sesskey;
            $linktext = (isset($this->config->linktext) and $this->config->linktext != '') ? format_string($this->config->linktext) : 'Login';
            $content .= '<a href="'.$CFG->wwwroot.'/auth/oauth2/login.php?id='.$id.'&wantsurl='.$wantsurl.'&sesskey='.$sesskey.'">'.$linktext.'</a>';
        }
        $this->content = new stdClass();
        $this->content->text = $content;

        return $this->content;
    }
	
}
