<?php 

/**
 * Contao Open Source CMS, Copyright (C) 2005-2014 Leo Feyer
 *
 * Contao Module "Cron Scheduler" - Driver DC_CronTable
 *
 * @copyright  Glen Langer 2013..2014 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    Cron
 * @license    LGPL
 * @filesource
 * @see	       https://github.com/BugBuster1701/contao-cron
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace Contao; // BugBuster\Cron; 
use BugBuster\Cron\CronController;

/**
 * Class DC_CronTable
 *
 * Provide methods to access and modify data stored in a table.
 * 
 * @copyright  Glen Langer 2013..2014 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    Cron
 */
class DC_CronTable extends \DC_Table
{

    /**
	 * Initialize the object
	 * @param string
	 */
    public function __construct($strTable)
    {
		parent::__construct($strTable);
    }
	
	public function enable()
	{
		if ($this->intId)
		{ 
		    //set enabled
			\Database::getInstance()->prepare("UPDATE " . $this->strTable . " SET `enabled`='1' WHERE id=?")
                                    ->executeUncached($this->intId);
		    //get job
    		$q = \Database::getInstance()->prepare("SELECT * FROM `tl_crontab`
                                                    WHERE `enabled`='1'
                                                    AND id=?")
                                        ->executeUncached($this->intId);
    		//set next run date
    		$dataset = array(
    		        'nextrun'	=> $this->schedule($q),
    		        'scheduled'	=> time()
    		);
    		\Database::getInstance()->prepare("UPDATE " . $this->strTable . " %s WHERE id=?")
                            		->set($dataset)
                            		->executeUncached($q->id);
		}
		$this->redirect($this->getReferer());
	} // enable
	
	public function disable()
	{
		if ($this->intId) 
		{
			\Database::getInstance()->prepare("UPDATE " . $this->strTable . " SET `enabled`='0', `nextrun`=0, `scheduled`=0 WHERE id=?")
                                    ->execute($this->intId);
		}
		$this->redirect($this->getReferer());
	} // disable
	
	public function ena_logging()
	{
		if ($this->intId)
		{ 
			\Database::getInstance()->prepare("UPDATE " . $this->strTable . " SET `logging`='1' WHERE id=?")
                                    ->execute($this->intId);
		}
		$this->redirect($this->getReferer());
	} // ena_logging
	
	public function dis_logging()
	{
		if ($this->intId) 
		{
			\Database::getInstance()->prepare("UPDATE " . $this->strTable . " SET `logging`='0' WHERE id=?")
                                    ->execute($this->intId);
		}
		$this->redirect($this->getReferer());
	} // dis_logging
	
	public function start_now()
	{
	    if ($this->intId)
	    {
	        //set next run date to now
	        $dataset = array(
        	                'nextrun'	=> $nextrun = time()-60,
        	                'scheduled'	=> time()
        	                );
	        \Database::getInstance()->prepare("UPDATE " . $this->strTable . " %s 
                                                WHERE `enabled`='1'
                                                AND id=?")
                                    ->set($dataset)
                                    ->executeUncached($this->intId);
	    }
	    $this->redirect($this->getReferer());
	} // start_now
	
	/**
	 * Find new schedule time for job
	 * @see CronController
	 */
	private function schedule(&$qjob)
	{
	    $minute = array();
	    $hour   = array();
	    $dom    = array();
	    $month  = array();
	    $dow    = array();
	     
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
	    while ($nextrun < $maxdate)
	    {
	        $dateArr	= getdate($nextrun);
	        $_seconds	= $dateArr['seconds'];
	        $_minutes	= $dateArr['minutes'];
	        $_hours		= $dateArr['hours'];
	        $_mday		= $dateArr['mday'];
	        $_wday		= $dateArr['wday'];
	        $_mon		= $dateArr['mon'];
	        	
	        if (!$month[$_mon] || !$dom[$_mday] || !$dow[$_wday])
	        {
	            // increment to 00:00:00 of next day
	            $nextrun += 60*(60*(24-$_hours)-$_minutes)-$_seconds;
	            continue;
	        } // if
	        	
	        $allhours = ($_hours==0);
	        while ($_hours < 24)
	        {
	            if ($hour[$_hours])
	            {
	                $allminutes = ($_minutes==0);
	                while ($_minutes < 60)
	                {
	                    if ($minute[$_minutes]) return $nextrun;
	                    // increment to next minute
	                    $nextrun += 60-$_seconds;
	                    $_minutes++;
	                    $_seconds = 0;
	                } // while
	                if ($allminutes) return 0;
	                $_hours++;
	                $_minutes = 0;
	            }
	            else
	            {
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
	 * @see CronControllers
	 */
	private function parseElement($element, &$targetArray, $base, $numberOfElements)
	{
	    if (trim($element)=='') $element = '*';
	    $subelements = explode(',', $element);
	    for ($i = $base; $i < $base+$numberOfElements; $i++)
	        $targetArray[$i] = $subelements[0] == "*";
	
	    for ($i = 0; $i < count($subelements); $i++) 
	    {
	        if ( preg_match("~^(\\*|([0-9]{1,2})(-([0-9]{1,2}))?)(/([0-9]{1,2}))?$~", $subelements[$i], $matches) )
	        {
	            if ($matches[1]=='*')
	            {
	                $matches[2] = $base;					// all from
	                $matches[4] = $base+$numberOfElements;	// all to
	            }
	            elseif ($matches[4]=='')
	            {
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
	
} // class DC_CronTable

