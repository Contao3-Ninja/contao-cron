<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2013 Leo Feyer
 * 
 * @package Cron
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'BugBuster',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Jobs
	'PurgeLog'                      => 'system/modules/cron/jobs/PurgeLog.php',
	'PurgeDemoFiles'                => 'system/modules/cron/jobs/PurgeDemoFiles.php',

	// Drivers
	'Contao\DC_CronTable'           => 'system/modules/cron/drivers/DC_CronTable.php',

	// Public
	'BugBuster\Cron\CronController' => 'system/modules/cron/public/CronController.php',

	// Module
	'BugBuster\Cron\ModuleCron'     => 'system/modules/cron/modules/ModuleCron.php',
	
	// Classes
	'BugBuster\Cron\DCA_crontab'    => 'system/modules/cron/classes/DCA_crontab.php',
));

/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
    'mod_cron_fe' => 'system/modules/cron/templates',
));
