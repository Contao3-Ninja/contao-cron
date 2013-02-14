<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');
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
 * Extends module tl_settings.
 *
 * PHP version 5
 * @copyright  Acenes 2007
 * @author     Acenes
 * @package    Cron
 * @license    GNU GENERAL PUBLIC LICENSE (GPL) Version 2, June 1991
 * @filesource
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

?>