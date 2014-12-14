<?php

/**
 * Contao Open Source CMS, Copyright (C) 2005-2014 Leo Feyer
*
* Contao Module "Cron Scheduler", FE Module
* for use on the frondend to trigger cron.
*
* @copyright  Glen Langer 2013..2014 <http://www.contao.glen-langer.de>
* @author     Glen Langer (BugBuster)
* @package    Cron
* @license    LGPL
* @filesource
* @see	       https://github.com/BugBuster1701/contao-cron
*/

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace BugBuster\Cron;

/**
 * Class ModuleCron
 *
 * @copyright  Glen Langer 2013..2014 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    Cron
 * @license    LGPL
 */
class ModuleCron extends \Module
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_cron_fe';
    
    /**
     * Display a wildcard in the back end
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### Scheduler FE ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id    = $this->id;
            $objTemplate->link  = $this->name;
            $objTemplate->href  = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;
    
            return $objTemplate->parse();
        }
        return parent::generate();
    }
    
    /**
     * Generate module
     */
    protected function compile()
    {
        //$this->log('cron job start.', 'ModuleCron', CRON);
        $return = $this->run();
        $this->Template->out = "<!-- cron extension {$return} -->\n";
    }
    
    public function run()
    {
        $objRequest = new \Request();
        $objRequest->redirect = true;
        $objRequest->rlimit   = 10;
        $objRequest->send( \Environment::get('base') . 'system/modules/cron/public/CronController.php');
        if ( $objRequest->hasError() )
        {
            return $objRequest->error;
        }
        return 'OK';
    } // run
    
} // class
