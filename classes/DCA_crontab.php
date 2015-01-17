<?php 

/**
 * Contao Open Source CMS, Copyright (C) 2005-2015 Leo Feyer
 *
 * Contao Module "Cron Scheduler"
 *
 * @copyright  Glen Langer 2013..2015 <http://contao.ninja>
 * @author     Glen Langer (BugBuster)
 * @package    Cron
 * @license    LGPL
 * @filesource
 * @see	       https://github.com/BugBuster1701/contao-cron
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace BugBuster\Cron;


use Contao\DC_CronTable;
use BugBuster\Cron\Cron_Encryption;

/**
 * Class DCA_crontab
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class DCA_crontab extends \Backend
{
	/**
	 * List a particular record
	 */
	public function listJobs($row)
	{
	    $this->setNextRun($row);
		$text = &$GLOBALS['TL_LANG']['tl_crontab'];
		$link = $this->Environment->script . '?do=cron&amp;act=edit&amp;id=' . $row['id'] .'&amp;rt=' . REQUEST_TOKEN;
		return 
			'<a class="cron-list" href="'.$link.'"><div>' .
				'<div class="main">' .
					'<div class="title">' . $row['title'] . '</div>' .
//					'<div class="job">' . $row['job'] . '</div>' .
				'</div>' .
				'<div>' .
					'<div class="floatleft">' .
						'<div class="caption">' . $text['tl_minute'] . '</div>' .
						'<div class="data">' . ($row['t_minute']=='' ? '*' : $row['t_minute']) . '</div>' .
					'</div>' .
					'<div class="floatleft">' .
						'<div class="caption">' . $text['tl_hour'] . '</div>' .
						'<div class="data">' . ($row['t_hour']=='' ? '*' : $row['t_hour']) . '</div>' .
					'</div>' .
					'<div class="floatleft">' .
						'<div class="caption">' . $text['tl_dom'] . '</div>' .
						'<div class="data">' . ($row['t_dom']=='' ? '*' : $row['t_dom']) . '</div>' .
					'</div>' .
					'<div class="floatleft">' .
						'<div class="caption">' . $text['tl_month'] . '</div>' .
						'<div class="data">' . ($row['t_month']=='' ? '*' : $row['t_month']) . '</div>' .
					'</div>' .
					'<div class="floatleft">' .
						'<div class="caption">' . $text['tl_dow'] . '</div>' .
						'<div class="data">' . ($row['t_dow']=='' ? '*' : $row['t_dow']) . '</div>' .
					'</div>' .
					'<div class="floatleft">' .
						'<div class="caption">' . $text['lastrun'] . '</div>' .
						'<div class="data">' . ($row['lastrun']==0 ? '' : date($GLOBALS['TL_CONFIG']['datimFormat'], $row['lastrun'])) . '</div>' .
					'</div>' .
					'<div class="floatleft">' .
						'<div class="caption">' . $text['nextrun'] . '</div>' .
						'<div class="data">' . ($row['nextrun']==0 ? '' : date($GLOBALS['TL_CONFIG']['datimFormat'], $row['nextrun'])) . '</div>' .
					'</div>' .
				'</div>' .
			'</div></a>';
	} // listJobs
	
	/**
	 * Create the enabled/disabled button
	 */
	public function enabledButton($row, $href, $label, $title, $icon, $attributes)
	{
		if ($row['enabled']=='1') 
		{		
			$href = 'act=disable';
			$label = &$GLOBALS['TL_LANG']['tl_crontab']['disable'];
			$icon = 'system/modules/cron/assets/enabled.png';
		} 
		else 
		{
			$href = 'act=enable';
			$label = &$GLOBALS['TL_LANG']['tl_crontab']['enable'];
			$icon = 'system/modules/cron/assets/disabled.png';
		} // if
		$title = sprintf($label[1], $row['id']);
		return 
			'<a href="' . $this->addToUrl($href.'&amp;id='.$row['id']) . 
			 '" title="' . specialchars($title) . '"' . $attributes . '>' . 
				'<img src="'.$icon.'" width="16" height="16" alt="'.specialchars($title).'" />' .
			'</a> ';
	} // enabledButton
	
	/**
	 * Create the logging on/off button
	 */
	public function loggingButton($row, $href, $label, $title, $icon, $attributes)
	{
		if ($row['logging']=='1') 
		{		
			$href = 'act=dis_logging';
			$label = &$GLOBALS['TL_LANG']['tl_crontab']['dis_logging'];
			$icon = 'system/modules/cron/assets/logging.png';
		} 
		else 
		{
			$href = 'act=ena_logging';
			$label = &$GLOBALS['TL_LANG']['tl_crontab']['ena_logging'];
			$icon = 'system/modules/cron/assets/notlogging.png';
		} // if
		$title = sprintf($label[1], $row['id']);
		return 
			'<a href="' . $this->addToUrl($href.'&amp;id='.$row['id']) . 
			 '" title="' . specialchars($title) . '"' . $attributes . '>' . 
				'<img src="'.$icon.'" width="16" height="16" alt="'.specialchars($title).'" />' .
			'</a> ';
	} // loggingButton
	
	public function startnowButton($row, $href, $label, $title, $icon, $attributes)
	{
	    $href = 'act=start_now';
	    $label = &$GLOBALS['TL_LANG']['tl_crontab']['startnow'];
	    $icon = 'system/modules/cron/assets/start_now.png';
	    $title = sprintf($label[1], $row['id']);

	    if (in_array('mcrypt', get_loaded_extensions()))
	    {
	        $strEncypt = base64_encode( \Encryption::encrypt( serialize( array( $title,$row['id'] ) ) ) );
	    }
	    else 
	    {
	        $strEncypt = base64_encode( Cron_Encryption::encrypt( serialize( array( $title,$row['id'] ) ) ) );
	    }
	    
	    $href = 'system/modules/cron/public/CronStart.php?crcst='.$strEncypt.'';
	    
	    return
    	    '<a href="' . $href . '"' .
    	    'onclick="if(!confirm(\''.$title.'?\'))return false;Backend.openModalIframe({\'width\':735,\'height\':405,\'title\':\'Cronjob Start\',\'url\':this.href});return false"'.
    	    ' title="' . specialchars($title) . '"' . $attributes . '>' .
    	    '<img src="'.$icon.'" width="16" height="16" alt="'.specialchars($title).'" />' .
    	    '</a> ';
	}
	
	
	/**
	 * Adjust data fields
	 */
	public function adjustFields(DC_CronTable $dc)
	{
		$q = \Database::getInstance()->prepare("SELECT * FROM tl_crontab WHERE id=?")
                                     ->limit(1)
                                     ->execute($dc->id);
		if (!$q->next()) return;

		$arrSet = array(
			'scheduled'	=> 0,
			'nextrun'	=> 0
		);
		if ( !strlen( trim($q->t_minute) ) ) $arrSet['t_minute'] = '*';
		if ( !strlen( trim($q->t_hour)   ) ) $arrSet['t_hour']   = '*';
		if ( !strlen( trim($q->t_dom)    ) ) $arrSet['t_dom']    = '*';
		if ( !strlen( trim($q->t_month)  ) ) $arrSet['t_month']  = '*';
		if ( !strlen( trim($q->t_dow)    ) ) $arrSet['t_dow']    = '*';
		
		\Database::getInstance()->prepare("UPDATE tl_crontab %s WHERE id=?")
                                ->set($arrSet)
                                ->execute($dc->id);
	} // adjustFields
	
	/**
	 * Set next run date, if it enabled but it is not set
	 * @param array $row    Job Array
	 */
	private function setNextRun(&$row)
	{
	    if ($row['enabled']=='1' && $row['nextrun']=='0')
	    {
	        //get job
	        $q = \Database::getInstance()->prepare("SELECT * FROM `tl_crontab`
                                                    WHERE `enabled`='1'
                                                    AND id=?")
                                        ->executeUncached($row['id']);
	        //set next run date
	        $dataset = array(
	                'nextrun'	=> $this->schedule($q),
	                'scheduled'	=> time()
	        );
	        \Database::getInstance()->prepare("UPDATE `tl_crontab` %s WHERE id=?")
                        	        ->set($dataset)
                        	        ->executeUncached($q->id);
	        $row['nextrun'] = $dataset['nextrun'];
	    }
	    return ;
	} 
	
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
	    if (trim($element)=='') 
	    {
	        $element = '*';
	    }
	    $subelements = explode(',', $element);
	    for ($i = $base; $i < $base+$numberOfElements; $i++)
	    {
	        $targetArray[$i] = $subelements[0] == "*";
	    }
	
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
                {
                    $matches[6] = 1;			// default step
                }
                $from	= intval(ltrim($matches[2],'0'));
                $to		= intval(ltrim($matches[4],'0'));
                $step	= intval(ltrim($matches[6],'0'));
                for ($j = $from; $j <= $to; $j += $step) 
                {
                    $targetArray[$j] = true;
                }
	        } // if
        } // for
	} // parseElement
	
} // class

