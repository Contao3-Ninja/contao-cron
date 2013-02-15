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
 * Language file for table tl_cron (en).
 *
 * PHP version 5
 * @copyright  Acenes 2007
 * @author     Acenes
 * @package    Cron
 * @license    GNU GENERAL PUBLIC LICENSE (GPL) Version 2, June 1991
 * @filesource
 */
 
$text = &$GLOBALS['TL_LANG']['tl_crontab'];

/**
 * Fields
 */
$text['title'] = array(
	'Title',
	'Enter a descriptive title for the job.'
);
$text['job'] = array(
	'Job', 
	'Enter the path of the PHP script to execute.'
);
$text['t_minute'] = array(
	'Minute', 
	'List the minutes for example as 5,10,15-20,30.<br />'.
	'Use the form */15 for example for every 15 minutes.<br />'.
	'Enter * for every minute.'
);
$text['t_hour'] = array(
	'Hour', 
	'List the hours for example as 2,4,5-7,9.<br />'.
	'Use the form */3 for example for every 3 hours.<br />'.
	'Enter * for every hour.'
);
$text['t_dom'] = array(
	'Day of month', 
	'List the days of month for example as 1,10,14-16,20.<br />'.
	'Enter * for all days.'
);
$text['t_month'] = array(
	'Month',
	'List the month numbers as 1,3,7-9, or name shortcuts as Jan,Mar,Jul-Sep for example.<br />'.
	'Enter * for every month.'
);
$text['t_dow'] = array(
	'Day of week', 
	'List the day numbers (0=sunday) as 0,2-4,7 or name shortcuts as Sun,Tue-Thu,Sat for example.<br />'.
	'Enter * for every day of week.'
);
$text['runonce'] = array(
	'Run once', 
	'Disable job after completion.'
);
$text['enabled'] = array(
	'Enabled', 
	'Enable execution of this job.'
);
$text['logging'] = array(
	'Logging', 
	'Make log entry when job is executed'
);

/**
 * Reference
 */
$text['tl_minute']	= 'Minute';
$text['tl_hour']	= 'Hour';
$text['tl_dom']		= 'DOM';
$text['tl_month']	= 'Month';
$text['tl_dow']		= 'DOW';
$text['lastrun']	= 'Last run';
$text['nextrun']	= 'Next run';


/**
 * Buttons
 */
$text['new']		= array('New', 'Create a new job.');
$text['edit']		= array('Edit', 'Edit the settings of this job.');
$text['copy']		= array('Copy', 'Copy this job.');
$text['delete']		= array('Delete', 'Delete this job.');
$text['show']		= array('Show', 'View the details.');
$text['ena_logging']= array('Enable logging', 'Enable logging for job %s');
$text['dis_logging']= array('Disable logging', 'Disable logging for job %s');
$text['enable']		= array('Enable execution', 'Enable execution of job %s');
$text['disable']	= array('Disable execution', 'Disable execution of job %s');

