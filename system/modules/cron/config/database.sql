-- 
--  TYPOlight Cron Scheduler
-- 
--  Cron is a scheduler module for the TYPOlight CMS. It allows to automaticly 
--  execute php on a time schedule similar to the unix cron/crontab scheme.  
--  TYPOlight is a web content management system that specializes in accessibility
--  and generates W3C-compliant HTML code.
-- 
--  If you need to contact the author of this module, please use the forum at 
--  http://www.typolight.org/forum. Additional documentation can be found at the 
--  3rd party extensions WIKI http://www.typolight.org/wiki/extensions:extensions
--  For more information about TYPOlight and additional applications please visit 
--  the project website http://www.typolight.org. 
-- 
--  NOTE: this file was edited with tabs set to 4.
-- 
--  Database table setup
-- 
--  copyright  Acenes 2007
--  author     Acenes
--  package    Cron
--  license    GNU GENERAL PUBLIC LICENSE (GPL) Version 2, June 1991
--  filesource
-- 
-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the TYPOlight *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************

-- --------------------------------------------------------

-- 
-- Table `tl_cron`
-- 

CREATE TABLE `tl_cron` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `lastrun` int(10) unsigned NOT NULL default '0',
  `nextrun` int(10) unsigned NOT NULL default '0',
  `scheduled` int(10) unsigned NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `job` varchar(100) NOT NULL default '',
  `t_minute` varchar(100) NOT NULL default '',
  `t_hour` varchar(100) NOT NULL default '',
  `t_dom` varchar(100) NOT NULL default '',
  `t_month` varchar(100) NOT NULL default '',
  `t_dow` varchar(100) NOT NULL default '',
  `runonce` char(1) NOT NULL default '0',
  `enabled` char(1) NOT NULL default '0',
  `logging` char(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
