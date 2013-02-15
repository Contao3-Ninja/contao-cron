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
 * This is the data container array for table tl_crontab.
 *
 * PHP version 5
 * @copyright  Acenes 2007
 * @author     Acenes
 * @package    Cron
 * @license    GNU GENERAL PUBLIC LICENSE (GPL) Version 2, June 1991
 * @filesource
 */

/**
 * Table tl_cron
 */
$GLOBALS['TL_DCA']['tl_crontab'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'			=> 'CronTable',
		'enableVersioning'		=> true,
		'onsubmit_callback'		=> array(array('tl_crontab', 'adjustFields'))
	),

	// List
	'list' => array
	(	
		'sorting' => array
		(
			'mode'				=> 1,
			'fields'			=> array('title'),
			'flag'				=> 1
		),
		'label' => array
		(
			'fields'			=> array('title'),
			'format'			=> '%s',
			'label_callback'	=> array('tl_crontab', 'listJobs')
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'			=> &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'			=> 'act=select',
				'class'			=> 'header_edit_all',
				'attributes'	=> 'onclick="Backend.getScrollOffset();"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'			=> &$GLOBALS['TL_LANG']['tl_crontab']['edit'],
				'href'			=> 'act=edit',
				'icon'			=> 'edit.gif'
			),
			'copy' => array
			(
				'label'			=> &$GLOBALS['TL_LANG']['tl_crontab']['copy'],
				'href'			=> 'act=copy',
				'icon'			=> 'copy.gif'
			),
			'delete' => array
			(
				'label'			=> &$GLOBALS['TL_LANG']['tl_crontab']['delete'],
				'href'			=> 'act=delete',
				'icon'			=> 'delete.gif',
				'attributes'	=> 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'			=> &$GLOBALS['TL_LANG']['tl_crontab']['show'],
				'href'			=> 'act=show',
				'icon'			=> 'show.gif'
			),
			'enabled' => array
			(
				'button_callback'	=>	array('tl_crontab', 'enabledButton')
			),
			'logging' => array
			(
				'button_callback'	=>	array('tl_crontab', 'loggingButton')
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'	=> 'title,job;t_minute,t_hour,t_dom,t_month,t_dow;runonce,enabled,logging'
	),

	// Fields
	'fields' => array
	(
		'title' => array
		(
			'label'			=> &$GLOBALS['TL_LANG']['tl_crontab']['title'],
			'exclude'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>true, 'maxlength'=>100)
		),
		'job' => array
		(
			'label'			=> &$GLOBALS['TL_LANG']['tl_crontab']['job'],
			'exclude'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>true, 'maxlength'=>100)
		),
		't_minute' => array
		(
			'label'			=> &$GLOBALS['TL_LANG']['tl_crontab']['t_minute'],
			'exclude'		=> true,
			'inputType'		=> 'text',
			'default'		=> '*',
			'explanation'	=> 'cron_elements',
			'eval'			=> array('nospace'=>true,'maxlength'=>100, 'helpwizard'=>true)
		),
		't_hour' => array
		(
			'label'			=> &$GLOBALS['TL_LANG']['tl_crontab']['t_hour'],
			'exclude'		=> true,
			'inputType'		=> 'text',
			'default'		=> '*',
			'explanation'	=> 'cron_elements',
			'eval'			=> array('nospace'=>true,'maxlength'=>100, 'helpwizard'=>true)
		),
		't_dom' => array
		(
			'label'			=> &$GLOBALS['TL_LANG']['tl_crontab']['t_dom'],
			'exclude'		=> true,
			'inputType'		=> 'text',
			'default'		=> '*',
			'explanation'	=> 'cron_elements',
			'eval'			=> array('nospace'=>true,'maxlength'=>100, 'helpwizard'=>true)
		),
		't_month' => array
		(
			'label'			=> &$GLOBALS['TL_LANG']['tl_crontab']['t_month'],
			'exclude'		=> true,
			'inputType'		=> 'text',
			'default'		=> '*',
			'explanation'	=> 'cron_elements',
			'eval'			=> array('nospace'=>true,'maxlength'=>100, 'helpwizard'=>true)
		),
		't_dow' => array
		(
			'label'			=> &$GLOBALS['TL_LANG']['tl_crontab']['t_dow'],
			'exclude'		=> true,
			'inputType'		=> 'text',
			'default'		=> '*',
			'explanation'	=> 'cron_elements',
			'eval'			=> array('nospace'=>true,'maxlength'=>100, 'helpwizard'=>true)
		),
		'runonce' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_crontab']['runonce'],
			'exclude'		=> true,
			'inputType'		=> 'checkbox'
		),
		'enabled' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_crontab']['enabled'],
			'exclude'		=> true,
			'inputType'		=> 'checkbox'
		),
		'logging' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_crontab']['logging'],
			'exclude'		=> true,
			'inputType'		=> 'checkbox'
		)
	)
);

/**
 * Class tl_cron
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class tl_crontab extends Backend
{
	/**
	 * List a particular record
	 */
	public function listJobs($row)
	{
		$text = &$GLOBALS['TL_LANG']['tl_crontab'];
		$link = $this->Environment->script . '?do=cron&amp;act=edit&amp;id=' . $row['id'];
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
		if ($row['enabled']=='1') {		
			$href = 'act=disable';
			$label = &$GLOBALS['TL_LANG']['tl_crontab']['disable'];
			$icon = 'system/modules/cron/assets/enabled.png';
		} else {
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
		if ($row['logging']=='1') {		
			$href = 'act=dis_logging';
			$label = &$GLOBALS['TL_LANG']['tl_crontab']['dis_logging'];
			$icon = 'system/modules/cron/assets/logging.png';
		} else {
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
	
	/**
	 * Adjust data fields
	 */
	public function adjustFields(DataContainer $dc)
	{
		$q = $this->Database->prepare("SELECT * FROM tl_crontab WHERE id=?")
				->limit(1)
				->execute($dc->id);
		if (!$q->next()) return;

		$arrSet = array(
			'scheduled'	=> 0,
			'nextrun'	=> 0
		);
		if (!strlen(trim($q->t_minute))) $arrSet['t_minute'] = '*';
		if (!strlen(trim($q->t_hour))) $arrSet['t_hour'] = '*';
		if (!strlen(trim($q->t_dom))) $arrSet['t_dom'] = '*';
		if (!strlen(trim($q->t_month))) $arrSet['t_month'] = '*';
		if (!strlen(trim($q->t_dow))) $arrSet['t_dow'] = '*';
		
		$this->Database->prepare("UPDATE tl_crontab %s WHERE id=?")
			->set($arrSet)
			->execute($dc->id);
	} // adjustFields
	
} // class

