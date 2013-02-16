<?php 

/**
 * Contao Open Source CMS, Copyright (C) 2005-2013 Leo Feyer
 *
 * Contao Module "Cron Scheduler" - Driver DC_CronTable
 *
 * @copyright  Glen Langer 2013 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    Cron
 * @license    LGPL
 * @filesource
 * @see	       https://github.com/BugBuster1701/contao-cron
 */

/**
 * HACK, only for POC
 * Run in a custom namespace, so the class can be replaced
 */
namespace Contao; //TODO; own Namespace

/**
 * Class DC_CronTable
 *
 * Provide methods to access and modify data stored in a table.
 * 
 * @copyright  Glen Langer 2013 <http://www.contao.glen-langer.de>
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
			$this->Database->prepare("UPDATE " . $this->strTable . " SET `enabled`='1' WHERE id=?")
                           ->execute($this->intId);
		}
		$this->redirect($this->getReferer());
	} // enable
	
	public function disable()
	{
		if ($this->intId) 
		{
			$this->Database->prepare("UPDATE " . $this->strTable . " SET `enabled`='0', `nextrun`=0, `scheduled`=0 WHERE id=?")
                           ->execute($this->intId);
		}
		$this->redirect($this->getReferer());
	} // disable
	
	public function ena_logging()
	{
		if ($this->intId)
		{ 
			$this->Database->prepare("UPDATE " . $this->strTable . " SET `logging`='1' WHERE id=?")
                           ->execute($this->intId);
		}
		$this->redirect($this->getReferer());
	} // ena_logging
	
	public function dis_logging()
	{
		if ($this->intId) 
		{
			$this->Database->prepare("UPDATE " . $this->strTable . " SET `logging`='0' WHERE id=?")
                           ->execute($this->intId);
		}
		$this->redirect($this->getReferer());
	} // dis_logging
	
} // class DC_CronTable

