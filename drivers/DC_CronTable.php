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
 * DC_CronTable class implementation.
 *
 * PHP version 5
 * @copyright  Acenes 2007
 * @author     Acenes
 * @package    Cron
 * @license    GNU GENERAL PUBLIC LICENSE (GPL) Version 2, June 1991
 * @filesource
 */

 require_once 'DC_Table.php';

/**
 * Class DC_CronTable
 *
 * Provide methods to access and modify data stored in a table.
 * @copyright  Acenes 2007
 * @author     Acenes
 * @package    Helpdesk
 */
class DC_CronTable extends DC_Table
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
			$this->Database->prepare(
				"UPDATE " . $this->strTable . " SET `enabled`='1' WHERE id=?"
			)->execute($this->intId);
		$this->redirect($this->getReferer());
	} // enable
	
	public function disable()
	{
		if ($this->intId) 
			$this->Database->prepare(
				"UPDATE " . $this->strTable . " SET `enabled`='0', `nextrun`=0, `scheduled`=0 WHERE id=?"
			)->execute($this->intId);
		$this->redirect($this->getReferer());
	} // disable
	
	public function ena_logging()
	{
		if ($this->intId) 
			$this->Database->prepare(
				"UPDATE " . $this->strTable . " SET `logging`='1' WHERE id=?"
			)->execute($this->intId);
		$this->redirect($this->getReferer());
	} // ena_logging
	
	public function dis_logging()
	{
		if ($this->intId) 
			$this->Database->prepare(
				"UPDATE " . $this->strTable . " SET `logging`='0' WHERE id=?"
			)->execute($this->intId);
		$this->redirect($this->getReferer());
	} // dis_logging
	
} // class DC_CronTable

?>