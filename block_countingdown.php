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
 * Countdown block for Moodle 3.x
 *
 * @package   block_countingdown
 * @copyright 2015 Kamil Łuczak    www.limsko.pl     kamil@limsko.pl
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_countingdown extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_countingdown');
    }
    // The PHP tag and the curly bracket for the class definition
    // will only be closed after there is another function added in the next section.

    public function get_content() {
        global $DB, $CFG;
        require_once($CFG->libdir . '/filelib.php');
        $this->page->requires->jquery();
        $this->page->requires->js('/blocks/countingdown/js/counting_down.js');

		$pozostalo = $this->config->countto;

		$left = $pozostalo - time();



		if($this->config->modern){
			$this->page->requires->css('/blocks/countingdown/modern.css');
		}

        if ($this->content !== null) {
            return $this->content;
        }

		$id = $this->instance->id;

        $this->content = new stdClass;

        $this->content->text .= html_writer::start_tag('div', array('class'=>'count_down'));

		if (!empty($this->config->text)) {
            $this->content->text .= html_writer::tag('h3', $this->config->text, array('class'=>'head'));
        }


		if($left > 0) {
			if($this->config->desc_before){
				$this->content->text .= html_writer::tag('h4', $this->config->desc_before);
			}
		} else {
			if($this->config->desc_after){
				$this->content->text .= html_writer::tag('h4', $this->config->desc_after);
			}
		}

		if($left < 0 and $this->config->display_alternate and $this->config->clock_text) {
			$this->content->text .= html_writer::tag('h2', $this->config->clock_text);
		} else {
			$this->content->text .= html_writer::tag('div', '', array('class'=>'result_countblock'.$id));
	   		$this->content->text .= html_writer::tag('div', '<div class="ddesc span3">'.$this->config->days.'</div><div class="hdesc span3">'.$this->config->hours.'</div><div class="mdesc span3">'.$this->config->minutes.'</div><div class="sdesc span3">'.$this->config->seconds.'</div>', array('class'=>'kl_counter_desc row-fluid'));
		}


		if($left > 0) {
			if($this->config->footer_before){
				$this->content->text .= html_writer::tag('h4', $this->config->footer_before);
			}
		} else {
			if($this->config->footer_after){
				$this->content->text .= html_writer::tag('h4', $this->config->footer_after);
			}
		}

        $this->content->text .= html_writer::end_tag('div'); //'</div>';



        $this->content->footer = '
		<script type="text/javascript">
			$(function(){
				setInterval(read'.$id.', 1000);
			});

			function read'.$id.'() {
				$.get("'.$CFG->wwwroot.'/blocks/countingdown/counter.php", { timeleft: "'.$pozostalo.'" } )
  				.done(function( data ) {
				    $( ".result_countblock'.$id.'" ).html( data );

				});

			}
		</script>';

        return $this->content;
    }

    function has_config() {
        return true;
    }

    public function instance_allow_multiple() {
        return true;
    }

    public function applicable_formats() {
        return array(
        'site' => true,
        'course-view' => true,
        'my'=> true
        );
    }

	// thinking of possibleturning off the header
    public function hide_header() {
        global $PAGE;
        if($PAGE->user_is_editing()) {
            return false;
        } else {
			if($this->config->disable_header){
            	return true;
			} else {
				return false;
			}
        }
    }

}
// Here's the closing bracket for the class definition
/*
//get and display images
        $fs = get_file_storage();
        $files = $fs->get_area_files($this->context->id, 'block_countingdown', 'content');
        foreach ($files as $file) {
            $filename = $file->get_filename();
            if ($filename <> '.') {
                $url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), null, $file->get_filepath(), $filename);
                $this->content->text .= '<img src="'.$url.'" alt="'.$filename.'" />';
            }
        }
*/