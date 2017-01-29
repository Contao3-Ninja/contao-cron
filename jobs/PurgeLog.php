<?php 

/**
 * Contao Open Source CMS, Copyright (C) 2005-2017 Leo Feyer
 *
 * Contao Module "Cron Scheduler"
 * Sample PHP script to execute by cron: Purges the system log
 * Job: system/modules/cron/jobs/PurgeLog.php
 *
 * @copyright  Glen Langer 2017 <http://contao.ninja>
 * @author     Glen Langer (BugBuster)
 * @package    Cron
 * @license    LGPL
 * @filesource
 * @see	       https://github.com/BugBuster1701/contao-cron
 */

/**
 * Initialize the system
 */
if (!defined('TL_MODE')) 
{
    define('TL_MODE', 'BE');
    
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
    require($dir . '/system/initialize.php');
}


/**
 * Class PurgeLog
 * 
 * @copyright  Glen Langer 2012..2017 <http://contao.ninja>
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

