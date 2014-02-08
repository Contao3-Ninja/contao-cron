<?php 

/**
 * Contao Open Source CMS, Copyright (C) 2005-2014 Leo Feyer
 *
 * Contao Module "Cron Scheduler"
 * CronImage.php: Pseudo-image (invisible gif) for use on the frondend to trigger cron.
 *
 * @copyright  Glen Langer 2013..2014 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    Cron
 * @license    LGPL
 * @filesource
 * @see	       https://github.com/BugBuster1701/contao-cron
 */

Header("Content-Type: image/gif");
include("./CronController.php");
echo base64_decode("R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==");
