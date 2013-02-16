<?php 

/**
 * Contao Open Source CMS, Copyright (C) 2005-2013 Leo Feyer
 *
 * Contao Module "Cron Scheduler"
 * TL_ROOT/system/modules/cron/languages/de/explain.php 
 * Deutsch translation file
 * 
 * @copyright  Glen Langer 2013 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    Cron
 * @license    LGPL
 * @filesource
 * @see	       https://github.com/BugBuster1701/contao-cron
 */
 
$GLOBALS['TL_LANG']['XPL']['cron_elements']['0']['0'] = "Grund-Syntax der Elemente";
$GLOBALS['TL_LANG']['XPL']['cron_elements']['0']['1'] = "Die Grund-Syntax des Zeit-Elements lautet:<br/><br/><pre>\n    begin[-end][/step]\n</pre><br/>Die Angaben innerhalb der Klammern sind optional. Die Einheit kommt auf die Art des Elements an und kann Minute (minute), Stunde(hour), Tag im Monat(day of month), Wochentag(day of week) oder Monat (month) sein. Der <code>begin[-end]</code> Teil kann durch ein * ersetzt werden um das Element zu <em>jeder</em> vollen Einheit auszuf&uuml;hren.<br/>Dies sind korrekte Beispielangaben:<br/><br/><pre>\n    5       minute,hour,day,... number 5\n    3-5     minutes,hours,days,... 3,4,5\n    5-10/2  minutes,hours,days,... 5,7,9\n    *       all minutes,hours,days,...\n    */3     minutes,hours,days,... 0,3,6,...\n</pre>";
$GLOBALS['TL_LANG']['XPL']['cron_elements']['1']['0'] = "Element Liste";
$GLOBALS['TL_LANG']['XPL']['cron_elements']['1']['1'] = "Jeder Teil des Ablaufplans kann als Komma-separierte Liste eingetragen werden, zum Beispiel:<br/><br/><pre>\n   5,7,10-15/2,21  = Zahlen 5,7,10,12,14,21\n</pre>";
$GLOBALS['TL_LANG']['XPL']['cron_elements']['2']['0'] = "Wochentag";
$GLOBALS['TL_LANG']['XPL']['cron_elements']['2']['1'] = "Wochentage kännen entweder als Zahl 0...6 angegeben werden, wobei 0 = Sonntag, oder as 3-Zeichen englische Abkürzung als Mon, Tue, Wed, Thu, Fri, Sat, Sun:<br/><br/>\n<pre>Mon-Fri/2 ist äquivalent zu 1-5/2 </pre>";
$GLOBALS['TL_LANG']['XPL']['cron_elements']['3']['0'] = "Monate";
$GLOBALS['TL_LANG']['XPL']['cron_elements']['3']['1'] = "Monate können entweder als Zahl von 1 bis 12 oder als dreistellige englische Abkürzung als Jan, Feb, Mar, Apr, May, Jun, Jul, Aug, Sep, Oct, Nov, Dec angegeben werden:<br/>\n<br/><pre>Feb-Nov/3 ist äquivalent zu 2-11/3</pre>";
 
