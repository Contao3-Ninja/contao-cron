<?php

/**
 * Contao Open Source CMS, Copyright (C) 2005-2016 Leo Feyer
*
* Contao Module "Cron Scheduler", FE Module
* for use on the frondend to trigger cron.
*
* @copyright  Glen Langer 2013..2016 <http://contao.ninja>
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
 * @copyright  Glen Langer 2013..2016 <http://contao.ninja>
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
        $return = $this->run();
        $this->Template->out = $return;
    }
    
    public function run() 
    {
        global $objPage;
        $blnXhtml = ($objPage->outputFormat == 'xhtml');
        $strScripts = \Template::generateInlineScript('
            setTimeout(
                function(){
                        try{
                            var n=new XMLHttpRequest();
                        }catch(r){
                            return;
                        }
                        n.open("GET","system/modules/cron/public/CronFeController.php",true);
                        n.send();
                },1300
            ); ', $blnXhtml);
        return $strScripts;
    } // run
    
} // class
