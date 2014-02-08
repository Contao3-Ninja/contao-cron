<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
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
	'PurgeLog'                       => 'system/modules/cron/jobs/PurgeLog.php',

	// Drivers
	'Contao\DC_CronTable'            => 'system/modules/cron/drivers/DC_CronTable.php',

	// Modules
	'BugBuster\Cron\ModuleCron'      => 'system/modules/cron/modules/ModuleCron.php',

	// Public
	'CronStart'                      => 'system/modules/cron/public/CronStart.php',
	'BugBuster\Cron\CronController'  => 'system/modules/cron/public/CronController.php',

	// Classes
	'BugBuster\Cron\DCA_crontab'     => 'system/modules/cron/classes/DCA_crontab.php',
	'BugBuster\Cron\Cron_Encryption' => 'system/modules/cron/classes/Cron_Encryption.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_cron_start_now' => 'system/modules/cron/templates',
	'mod_cron_fe'        => 'system/modules/cron/templates',
));
