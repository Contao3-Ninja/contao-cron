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
 * Sample PHP script to execute by cron: Purges the system log
 *
 * PHP version 5
 * @copyright  Acenes 2007-2010
 * @author     Acenes
 * @package    Cron
 * @license    GNU GENERAL PUBLIC LICENSE (GPL) Version 2, June 1991
 * @filesource
 */

/**
 * Initialize the system
 */
define('TL_MODE', 'BE');
require_once('../../../initialize.php');

/**
 * Class PurgeLog
 */
class PurgeLog extends Backend
{

	/**
	 * Initialize the controller
	 */
	public function __construct()
	{
		parent::__construct();
	} // __construct
	
	/**
	 * Implement the commands to run by this batch program
	 */
	public function run()
	{
		$execute = (method_exists($this->Database, 'executeUncached')) ? 'executeUncached' : 'execute';
		$this->Database->prepare("delete from `tl_log`")->$execute();
		$this->log('System log purged by cron job.', 'PurgeLog run()', TL_GENERAL);
	} // run
	
} // class PurgeLog

/**
 * Instantiate log purger
 */
$objPurge = new PurgeLog();
$objPurge->run();

