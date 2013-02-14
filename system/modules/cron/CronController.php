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
 * CronController class implementation
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
require_once('../../initialize.php');

define('CRON_MAX_RUN', 5);	// stop processung jobs in one trigger after this time in seconds 

/**
 * Class CronController
 */
class CronController extends Backend
{
	/**
	 * Initialize the controller
	 */
	public function __construct()
	{
		parent::__construct();
	} // __construct

	/**
	 * Run controller
	 */
	public function run()
	{
		global $cronJob;
		
		$limit = is_null($GLOBALS['TL_CONFIG']['cron_limit']) ? 5 : intval($GLOBALS['TL_CONFIG']['cron_limit']);
		if ($limit<=0) return;
		$currtime = time();
		$endtime = $currtime+$limit;
		$execute = (method_exists($this->Database, 'executeUncached')) ? 'executeUncached' : 'execute';
        
		// process cron list
		$q = $this->Database->prepare(
			"select * from `tl_cron` ".
			"where `enabled`='1' ".
			"and ((`nextrun`>0 and `nextrun`<?) or (`nextrun`=0 and `scheduled`<?)) ".
			"order by `nextrun`, `scheduled`"
		)->$execute($currtime, $currtime-86400);
		$locked = false;
		while ($q->next()) {
			$currtime = time();
			if ($currtime >= $endtime) break; 
			if (!$locked) {
				// ensure exclusive access
				$ql = $this->Database->prepare("select get_lock('cronlock',0) as lockstate")->$execute();
				if (!$ql->next() || !intval($ql->lockstate)) return;
				$locked = true;
			} // if
			if ($q->nextrun>0) { // due to execute
				$cronJob = array(
					'id'		=> $q->id,
					'title'		=> $q->title,
					'lastrun'	=> $q->lastrun,
					'endtime'	=> $endtime,
					'runonce'	=> intval($q->runonce) > 0,
					'logging'	=> intval($q->logging) > 0,
					'completed'	=> true
				);
				$output = $this->runJob($q);
				if ($cronJob['completed']) {
					if ($cronJob['runonce'])
						$dataset = array(
							'lastrun'	=> $currtime,
							'nextrun'	=> 0,
							'scheduled'	=> 0,
							'enabled'	=> '0'
						);
					else
						$dataset = array(
							'lastrun'	=> $currtime,
							'nextrun'	=> $this->schedule($q),
							'scheduled'	=> $currtime
						);
					$this->Database->prepare("update `tl_cron` %s where id=?")
						->set($dataset)
						->$execute($q->id);
				} // if
				if ($cronJob['logging'] || $output!='') {
					if ($output!='') 
						$this->log(
							'Cron job <em>'.$q->title.'</em> failed:<br/>'.$output, 
							'CronController run()', 
							TL_ERROR);
					else
						$this->log(
							'Cron job <em>'.$q->title.'</em> '.($cronJob['completed'] ? 'completed.' : 'processed partially.'), 
							'CronController run()', 
							TL_GENERAL);
				} // if
			} else {
				$dataset = array(
					'nextrun'	=> $this->schedule($q),
					'scheduled'	=> $currtime
				);
				$this->Database->prepare("update `tl_cron` %s where id=?")
					->set($dataset)
					->$execute($q->id);
			} // if
		} // while
		
		// release lock
		if ($locked)
			$this->Database->prepare("select release_lock('cronlock')")->$execute();
	} // run
	
	/**
	 * Run job and return the captured output
	 */
	private function runJob(&$qjob)
	{
		ob_start();
		$e = error_reporting(E_ALL);
		include(TL_ROOT . '/' . $qjob->job);
		error_reporting($e);
		return str_replace("\n",'<br />', trim(preg_replace('#<\s*br\s*/?\s*>#i', "\n", ob_get_flush())));
	} // runJob
		
	/**
	 * Find new schedule time for job
	 */
	private function schedule(&$qjob)
	{
		$dowNum = 
			str_ireplace(
				array('Sun','Mon','Tue','Wed','Thu','Fri','Sat'),
				array(0,1,2,3,4,5,6),
				$qjob->t_dow
			);
		$monthNum = 
			str_ireplace(
				array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'),
				array(1,2,3,4,5,6,7,8,9,10,11,12),
				$qjob->t_month
			);
		$this->parseElement($qjob->t_minute,	$minute,	0,	60);
		$this->parseElement($qjob->t_hour,		$hour,		0,	24);
		$this->parseElement($qjob->t_dom,		$dom,		1,	31);
		$this->parseElement($monthNum,			$month,		1,	12);
		$this->parseElement($dowNum,			$dow,		0,	 7);	
		
		$nextrun = time()+60;
		$maxdate = $nextrun+31536000; // schedule for one year ahead max
		while ($nextrun < $maxdate) {
			$dateArr	= getdate($nextrun);
			$_seconds	= $dateArr['seconds'];
			$_minutes	= $dateArr['minutes'];
			$_hours		= $dateArr['hours'];
			$_mday		= $dateArr['mday'];
			$_wday		= $dateArr['wday'];
			$_mon		= $dateArr['mon'];
			
			if (!$month[$_mon] || !$dom[$_mday] || !$dow[$_wday]) {
				// increment to 00:00:00 of next day
				$nextrun += 60*(60*(24-$_hours)-$_minutes)-$_seconds;
				continue;
			} // if
			
			$allhours = ($_hours==0);
			while ($_hours < 24) {
				if ($hour[$_hours]) {
					$allminutes = ($_minutes==0);
					while ($_minutes < 60) {
						if ($minute[$_minutes]) return $nextrun;
						// increment to next minute
						$nextrun += 60-$_seconds;
						$_minutes++;
						$_seconds = 0;
					} // while
					if ($allminutes) return 0;
					$_hours++;
					$_minutes = 0;
				} else {
					// increment to next hour
					$nextrun += 60*(60-$_minutes)-$_seconds;
					$_hours++;
					$_minutes = $_seconds = 0;
				} // if
			} // while
			if ($allhours) return 0;
		} // while
		return 0;
	} // schedule
	
	/**
	 * Parse timer element of syntax  from[-to][/step] or *[/step] and set flag for each tick
	 */
	private function parseElement($element, &$targetArray, $base, $numberOfElements) 
	{
		if (trim($element)=='') $element = '*';
		$subelements = explode(',', $element);
		for ($i = $base; $i < $base+$numberOfElements; $i++)
			$targetArray[$i] = $subelements[0] == "*";
	
		for ($i = 0; $i < count($subelements); $i++) {
			if ( preg_match("~^(\\*|([0-9]{1,2})(-([0-9]{1,2}))?)(/([0-9]{1,2}))?$~", $subelements[$i], $matches) ) {
				if ($matches[1]=='*') {
					$matches[2] = $base;					// all from
					$matches[4] = $base+$numberOfElements;	// all to
				} elseif ($matches[4]=='') {
					$matches[4] = $matches[2];	// to = from
				} // if
				if ($matches[5][0]!='/')
					$matches[6] = 1;			// default step
				$from	= intval(ltrim($matches[2],'0'));
				$to		= intval(ltrim($matches[4],'0'));
				$step	= intval(ltrim($matches[6],'0'));
				for ($j = $from; $j <= $to; $j += $step) $targetArray[$j] = true;
			} // if
		} // for
	} // parseElement

} // class CronController

/**
 * Instantiate controller
 */
$objCron = new CronController();
$objCron->run();

?>