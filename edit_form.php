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
 * Simple slider block for Moodle
 *
 * @package   block_countingdown
 * @copyright 2015 Kamil Łuczak    www.limsko.pl     kamil@limsko.pl
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */
class block_countingdown_edit_form extends block_edit_form {

    protected function specific_definition($mform) {

        //nagłówek bloku
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        //nagłówek licznika
        $mform->addElement('text', 'config_text', get_string('header', 'block_countingdown'));
        $mform->setDefault('config_text', '');
        $mform->setType('config_text', PARAM_RAW);

        //opis licznika
        $mform->addElement('text', 'config_desc_before', get_string('desc_before', 'block_countingdown'));
        $mform->setDefault('config_desc_before', '');
        $mform->setType('config_desc_before', PARAM_RAW);

		$mform->addElement('text', 'config_footer_before', get_string('foot_before', 'block_countingdown'));
        $mform->setDefault('config_footer_before', '');
        $mform->setType('config_footer_before', PARAM_RAW);

        //wybór czasu do którego będziemy odliczać
		/*$params = array(
    		'startyear' => date(Y),
		    'stopyear'  => date(Y)+5
		); */
		$mform->addElement('date_time_selector', 'config_countto', get_string('to'), $params);
		//$mform->addRule('date_time_selector', null, 'required');

		//opis wyświetlany pod zegarem po zakończeniu odliczania
        $mform->addElement('text', 'config_desc_after', get_string('desc_after', 'block_countingdown'));
        $mform->setDefault('config_desc_after', '');
        $mform->setType('config_desc_after', PARAM_RAW);

		$mform->addElement('text', 'config_footer_after', get_string('foot_after', 'block_countingdown'));
        $mform->setDefault('config_footer_after', '');
        $mform->setType('config_footer_after', PARAM_RAW);

        //text displayed opposite clock after count down completion
        $mform->addElement('text', 'config_clock_text', get_string('clock_text', 'block_countingdown'));
        $mform->setDefault('config_clock_text', '');
        $mform->setType('config_interval', PARAM_RAW);


        /*$mform->addElement('select', 'config_effect', get_string('effect', 'block_countingdown'), array('fade','slide'), null);*/

		//display desc
	   /*	$mform->addElement('advcheckbox', 'config_display_desc', get_string('display_desc', 'block_countingdown'), get_string('display_desc_desc', 'block_countingdown'), array('group' => 1), array(0, 1));
		$mform->setDefault('config_display_desc', 1); */

        //display alternative text after count down completion
        $mform->addElement('advcheckbox', 'config_display_alternate', get_string('display_alternate', 'block_countingdown'), get_string('display_alternate_desc', 'block_countingdown'), array('group' => 1), array(0, 1));
        $mform->setDefault('config_pagination', 1);

		//disable header
        $mform->addElement('advcheckbox', 'config_disable_header', get_string('disable_header', 'block_countingdown'), get_string('disable_header_desc', 'block_countingdown'), array('group' => 1), array(0, 1));
        $mform->setDefault('config_disable_header', 0);

		//modern design
        $mform->addElement('advcheckbox', 'config_modern', get_string('modern', 'block_countingdown'), get_string('modern_desc', 'block_countingdown'), array('group' => 1), array(0, 1));
        $mform->setDefault('config_modern', 0);


		$mform->addElement('header', 'strings', get_string('header_strings', 'block_countingdown'));

		$mform->addElement('text', 'config_days', get_string('config_days', 'block_countingdown'));
        $mform->setDefault('config_days', 'DAYS');
        $mform->setType('config_days', PARAM_RAW);
	   	$mform->addRule('config_days', null, 'required');

		$mform->addElement('text', 'config_hours', get_string('config_days', 'block_countingdown'));
        $mform->setDefault('config_hours', 'HOURS');
        $mform->setType('config_hours', PARAM_RAW);
	   	$mform->addRule('config_hours', null, 'required');

		$mform->addElement('text', 'config_minutes', get_string('config_days', 'block_countingdown'));
        $mform->setDefault('config_minutes', 'MIN');
        $mform->setType('config_minutes', PARAM_RAW);
	   	$mform->addRule('config_minutes', null, 'required');

		$mform->addElement('text', 'config_seconds', get_string('config_days', 'block_countingdown'));
        $mform->setDefault('config_seconds', 'SEC');
        $mform->setType('config_seconds', PARAM_RAW);
	   	$mform->addRule('config_seconds', null, 'required');


        /*$mform->addElement('filemanager', 'config_attachments', get_string('images', 'block_countingdown'), null,
        array('subdirs' => 0, 'maxbytes' => 5000000, 'maxfiles' => 1,
        'accepted_types' => array('.png', '.jpg', '.gif') )); */
    }

    function set_data($defaults) {

        if (empty($entry->id)) {
            $entry = new stdClass;
            $entry->id = null;
        }

        $draftitemid = file_get_submitted_draft_itemid('config_attachments');

        file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_countingdown', 'content', 0,
        array('subdirs'=>true));

        $entry->attachments = $draftitemid;

        parent::set_data($defaults);
        if ($data = parent::get_data()) {
            file_save_draft_area_files($data->config_attachments, $this->block->context->id, 'block_countingdown', 'content', 0,
            array('subdirs' => true));
        }
    }
}