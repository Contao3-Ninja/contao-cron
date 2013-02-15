-- --------------------------------------------------------

-- 
-- Table `tl_crontab`
-- 

CREATE TABLE `tl_crontab` (
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
