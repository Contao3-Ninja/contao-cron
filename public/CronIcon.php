<?php 

/**
 * Contao Open Source CMS, Copyright (C) 2005-2015 Leo Feyer
 *
 * Contao Module "Cron Scheduler"
 * CronIcon.php: Pseudo-icon used in the backend to trigger cron.
 *
 * @copyright  Glen Langer 2013..2015 <http://contao.ninja>
 * @author     Glen Langer (BugBuster)
 * @package    Cron
 * @license    LGPL
 * @filesource
 * @see	       https://github.com/BugBuster1701/contao-cron
 */

Header("Content-Type: image/png");
include("./CronController.php");
//readfile(TL_ROOT . '/system/modules/cron/assets/cron.png');
readfile('../assets/cron.png');
