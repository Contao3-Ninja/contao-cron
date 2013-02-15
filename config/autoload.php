<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2013 Leo Feyer
 * 
 * @package Cron3
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'CronController'      => 'system/modules/cron/public/CronController.php',
	// Drivers
	'Contao\DC_CronTable' => 'system/modules/cron/drivers/DC_CronTable.php',
	'PurgeLog'            => 'system/modules/cron/jobs/PurgeLog.php',
));
