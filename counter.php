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
require(__DIR__ . '/../../config.php');
$left = required_param("timeleft", PARAM_INT);

$pozostalo = $left - time();
if($pozostalo < 0) {
	$pozostalo = time() - $left;
}
$days 	= 	floor($pozostalo / 86400);
$hours 	= 	($pozostalo / 3600) % 24;
$mins 	= 	($pozostalo / 60) % 60;
$secs 	= 	($pozostalo) % 60;
$hours 	=	sprintf("%02s", $hours);
$mins 	=	sprintf("%02s", $mins);
$secs 	=	sprintf("%02s", $secs);

echo "<div class=\"kl_counter row-fluid\"><div class=\"days span3\">$days</div><div class=\"hours span3\">$hours</div><div class=\"minutes span3\">$mins</div><div class=\"seconds span3\">$secs</div></div>";