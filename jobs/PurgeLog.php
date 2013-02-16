<?php 

/**
 * Contao Open Source CMS, Copyright (C) 2005-2013 Leo Feyer
 *
 * Contao Module "Cron Scheduler"
 * Sample PHP script to execute by cron: Purges the system log
 *
 * @copyright  Glen Langer 2013 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    Cron
 * @license    LGPL
 * @filesource
 * @see	       https://github.com/BugBuster1701/contao-cron
 */

/**
 * Initialize the system
 */
define('TL_MODE', 'BE');
require_once('../../../initialize.php');

/**
 * Class PurgeLog
 * 
 * @copyright  Glen Langer 2012..2013 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    Cron
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
		$this->Database->prepare("DELETE FROM `tl_log`")->executeUncached();
		$this->log('System log purged by cron job.', 'PurgeLog run()', TL_GENERAL);
	} // run
	
} // class PurgeLog

/**
 * Instantiate log purger
 */
$objPurge = new PurgeLog();
$objPurge->run();

