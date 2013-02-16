<?php 

/**
 * Contao Open Source CMS, Copyright (C) 2005-2013 Leo Feyer
 *
 * Contao Module "Cron Scheduler"
 *
 * @copyright  Glen Langer 2013 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    Cron
 * @license    LGPL
 * @filesource
 * @see	       https://github.com/BugBuster1701/contao-cron
 */

/**
 * Add to palette
 */
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{cron_legend},cron_limit'; 

/**
 * Add field
 */
$GLOBALS['TL_DCA']['tl_settings']['fields']['cron_limit'] = array(
	'label'		=> &$GLOBALS['TL_LANG']['tl_settings']['cron_limit'],
	'inputType'	=> 'text',
	'default'	=> '5',
	'eval'		=> array('mandatory'=>true, 'rgxp'=>'digit', 'nospace'=>true)
);

