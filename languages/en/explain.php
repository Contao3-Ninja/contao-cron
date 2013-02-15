<?php 
/**
 * TYPOlight Cron Scheduler
 *
 * Cron is a scheduler module for the TYPOlight CMS. It allows to automaticly 
 * execute php on a time schedule similar to the unix cron/crontab scheme.  
 * TYPOlight is a web content management system that specializes in accessibility
 * and generates W3C-compliant HTML code.
 *
 * If you need to contact the author of this module, please use the forum at 
 * http://www.typolight.org/forum. Additional documentation can be found at the 
 * 3rd party extensions WIKI http://www.typolight.org/wiki/extensions:extensions
 * For more information about TYPOlight and additional applications please visit 
 * the project website http://www.typolight.org. 
 *
 * NOTE: this file was edited with tabs set to 4.
 *
 * Language file for explains (en).
 *
 * PHP version 5
 * @copyright  Acenes 2007
 * @author     Acenes
 * @package    Cron
 * @license    GNU GENERAL PUBLIC LICENSE (GPL) Version 2, June 1991
 * @filesource
 */

$GLOBALS['TL_LANG']['XPL']['cron_elements'] = array(
	array(
		'Basic element syntax', 
		'The basic syntax for the time element is:<br/><br/>'.
		"<pre>\n".
		"    begin[-end][/step]\n".
		'</pre><br/>' .
		'The parts enclosed in brackets are optional. The units dependend on the ' .
		'element type and can be minute, hour, day of month, day of week or month. '.
		'The part <code>begin[-end]</code> may be replaced by a * which means <em>all</em>.<br/>'.
		'For example, these are valid elements:<br/><br/>'.
		"<pre>\n".
		"    5       minute,hour,day,... number 5\n".
		"    3-5     minutes,hours,days,... 3,4,5\n".
		"    5-10/2  minutes,hours,days,... 5,7,9\n".
		"    *       all minutes,hours,days,...\n".
		"    */3     minutes,hours,days,... 0,3,6,...\n".
		'</pre>'
	),
	array(
		'Element list',
		'Every part of the schedule can be entered as a comma separated list, for '.
		'example:<br/><br/>'.
		"<pre>\n".
		"   5,7,10-15/2,21  = Numbers 5,7,10,12,14,21\n".
		'</pre>'
	),
	array(
		'Day of week',
		'Days of week can be entered either as number 0...6 where 0 = sunday, '.
		'or as 3 character english shortcut as Mon, Tue, Wed, Thu, Fri, Sat, Sun:<br/><br/>'.
		"<pre>\n".
		"   Mon-Fri/2 is equivalent to 1-5/2\n".
		'</pre>'
	),
	array(
		'Months',
		'Months can be entered either as number 1...12, or as 3 character english shortcut '.
		'as Jan, Feb, Mar, Apr, May, Jun, Jul, Aug, Sep, Oct, Nov, Dec:<br/><br/>'.
		"<pre>\n".
		"   Feb-Nov/3 is equivalent to 2-11/3\n".
		'</pre>'
	)
);

