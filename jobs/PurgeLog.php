<?php 

/**
 * Contao Open Source CMS, Copyright (C) 2005-2015 Leo Feyer
 *
 * Contao Module "Cron Scheduler"
 * Sample PHP script to execute by cron: Purges the system log
 * Job: system/modules/cron/jobs/PurgeLog.php
 *
 * @copyright  Glen Langer 2015 <http://contao.ninja>
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

// Suche nach initialize.php, damit auch über composer nutzbar    
$dir = __DIR__;

while ($dir != '.' && $dir != '/' && !is_file($dir . '/system/initialize.php'))
{
    $dir = dirname($dir);
}

if (!is_file($dir . '/system/initialize.php'))
{
    echo 'Could not find initialize.php!';
    exit(1);
}
// require_once to prevent PHP Fatal error:  Cannot redeclare __error()
require_once($dir . '/system/initialize.php');


/**
 * Class PurgeLog
 * 
 * @copyright  Glen Langer 2012..2015 <http://contao.ninja>
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
        global  $cronJob; // from CronController Class
        
        //At this time the job should be defered,
        //no new actions should be started after this time.
        if (time() >= $cronJob['endtime'])
        {
            $cronJob['completed'] = false;
            return;
        }
        
        $this->Database->prepare("DELETE FROM `tl_log`")->executeUncached();
        if ($cronJob['logging'])
        {
            $this->log('System log purged by cron job.', 'PurgeLog run()', TL_GENERAL);
        }
    } // run
	
} // class PurgeLog

/**
 * Instantiate log purger
 */
$objPurge = new PurgeLog();
$objPurge->run();

