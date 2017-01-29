<?php

/**
 * Contao Open Source CMS, Copyright (C) 2005-2015 Leo Feyer
 *
 * Contao Module "Cron Scheduler"
 * CronStart: Cron start now button
 * 
 * @copyright  Glen Langer 2013..2015 <http://contao.ninja>
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

use BugBuster\Cron\Cron_Encryption;

/**
 * Class CronStart 
 *
 * @copyright  Glen Langer 2013..2015 <http://contao.ninja>
 * @author     Glen Langer (BugBuster)
 * @package    Cron
 */
class CronStart extends Backend
{

	/**
	 * Initialize the object (do not remove)
	 */
	public function __construct()
	{
        $this->import('BackendUser', 'User');
        parent::__construct();
        $this->User->authenticate();

		// See #4099
		define('BE_USER_LOGGED_IN', false);
		define('FE_USER_LOGGED_IN', false);
	}


	/**
	 * Run the controller and parse the template
	 */
	public function run()
	{
	    $output = '';
		$strEncypt = Input::get('crcst');
	    $arrDecypt = deserialize( Cron_Encryption::decrypt( base64_decode($strEncypt) ) );
		
		if (is_array($arrDecypt) && $arrDecypt[1] >0) 
		{
			$title  = $arrDecypt[0];
			$jobId  = $arrDecypt[1];
		}
		else 
		{
			//Hack Attack!
			//$this->loadLanguageFile('tl_cron_info');
			
			$this->Template = new BackendTemplate('mod_cron_start_now');
			$this->Template->referer = $this->getReferer(ENCODE_AMPERSANDS); //$this->Environment->get(httpReferer);
			$this->Template->theme = $this->getTheme();
			$this->Template->base = Environment::get('base');
			$this->Template->language = $GLOBALS['TL_LANGUAGE'];
			$this->Template->title = 'Cron';
			$this->Template->charset = $GLOBALS['TL_CONFIG']['characterSet'];
			
			$this->Template->cronjob      = 'Hack Attack!';
			$this->Template->cronlogtitle = '';
			$this->Template->cronlog      = 'Wrong parameter. Bug or hack attack.';
			$this->Template->output();
			exit;
		}
		
		
		//$this->loadLanguageFile('tl_cron_info');

		$this->Template = new BackendTemplate('mod_cron_start_now');
		$this->Template->referer = $this->getReferer(ENCODE_AMPERSANDS); //$this->Environment->get(httpReferer);
		$this->Template->theme = $this->getTheme();
		$this->Template->base = Environment::get('base');
		$this->Template->language = $GLOBALS['TL_LANGUAGE'];
		$this->Template->title = $title;
		$this->Template->charset = $GLOBALS['TL_CONFIG']['characterSet'];
		$this->Template->cronlogtitle = $title;//$GLOBALS['TL_LANG']['CronInfo']['cron_tl_log'] . ':';
		
		$GLOBALS['TL_CONFIG']['debugMode'] = false;
		
		$q = Database::getInstance()->prepare("SELECT * FROM `tl_crontab`
                                                WHERE id=?
                                                ")
                                    ->executeUncached($jobId);
		if ( $q->numRows > 0 )
		{
		    $this->Template->cronjob = $q->job;
		    $this->Template->cronlogtitle = $q->title;
    		$this->Template->start_time = time();
    		
    		$this->log('Running scheduler job manually', 'CronStart run()', TL_CRON);
    		$output .= sprintf("[%s] %s<br>", date('d-M-Y H:i:s'), 'Running scheduler job manually');
    		$output .= '::'.$this->runJob($q).'<br>';
    		$this->log('Manually scheduler job complete', 'CronStart run()', TL_CRON);
    		$output .= sprintf("[%s] %s<br>", date('d-M-Y H:i:s'), 'Manually scheduler job complete');
		}
		else
		{
		    $output .= '<br>Job not found!';
		}
		
		$this->Template->cronlog = $output;
		
		$this->Template->output();
	}
	
	/**
	 * Run job and return the captured output
	 */
	private function runJob(&$qjob)
	{
	    global  $cronJob;
	    $limit = is_null($GLOBALS['TL_CONFIG']['cron_limit']) ? 5 : intval($GLOBALS['TL_CONFIG']['cron_limit']);
	    if ($limit<=0)
	    {
	        return;
	    }
	    $currtime = time();
	    $endtime  = $currtime+$limit;
	    $cronJob = array(
	            'id'		=> $q->id,
	            'title'		=> $q->title,
	            'lastrun'	=> $q->lastrun,
	            'endtime'	=> $endtime,
	            'runonce'	=> intval($q->runonce) > 0,
	            'logging'	=> intval($q->logging) > 0,
	            'completed'	=> true
	    );
	    ob_start();
	    $e = error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED & ~E_USER_DEPRECATED);
	    include(TL_ROOT . '/' . $qjob->job);
	    error_reporting($e);
	    return str_replace("\n",'<br />', trim(preg_replace('#<\s*br\s*/?\s*>#i', "\n", ob_get_flush())));
	} // runJob
	
}


/**
 * Instantiate the controller
 */
$objCronStart = new CronStart();
$objCronStart->run();
