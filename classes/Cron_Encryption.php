<?php 

/**
 * Contao Open Source CMS, Copyright (C) 2005-2014 Leo Feyer
 *
 * Contao Module "Cron Scheduler"
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
 * Class Cron Encryption, an alternative for mcrypt extension for hosters without it.
 * (Extension mcrypt ist used by the Contao class "Encryption".)
 *
 * @copyright  Glen Langer 2013..2014 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @author     http://stackoverflow.com/a/802957       
 */
class Cron_Encryption
{
    /**
     * Encrypt a string
     *
     * @param string $strValue The string to encrypt
     * @param string $strKey   An optional encryption key
     *
     * @return string The encrypted string
     */
    public static function encrypt($strValue, $strKey=null)
    {
        if ($strValue == '')
        {
            return '';
        }
        if (!$strKey)
        {
            if ($GLOBALS['TL_CONFIG']['encryptionKey'] == '')
            {
                throw new \Exception('Encryption key not set');
            }
            else 
            {
                $strKey = $GLOBALS['TL_CONFIG']['encryptionKey'];
            }
        }
        
        $result = '';
        for($i = 0; $i < strlen($strValue); $i++) 
        {
            $char    = substr($strValue, $i, 1);
            $keychar = substr($strKey, ($i % strlen($strKey))-1, 1);
            $char    = chr(ord($char) + ord($keychar));
            $result .= $char;
        }
        
        return base64_encode($result);
    }
    
    
    /**
     * Decrypt a string
     *
     * @param string $strValue The string to decrypt
     * @param string $strKey   An optional encryption key
     *
     * @return string The decrypted string
     */
    public static function decrypt($strValue, $strKey=null)
    {
        if ($strValue == '')
        {
            return '';
        }
        if (!$strKey)
        {
            if ($GLOBALS['TL_CONFIG']['encryptionKey'] == '')
            {
                throw new \Exception('Encryption key not set');
            }
            else
            {
                $strKey = $GLOBALS['TL_CONFIG']['encryptionKey'];
            }
        }
        
        $result = '';
        $strValue = base64_decode($strValue);
        
        for($i = 0; $i < strlen($strValue); $i++) 
        {
            $char    = substr($strValue, $i, 1);
            $keychar = substr($strKey, ($i % strlen($strKey))-1, 1);
            $char    = chr(ord($char) - ord($keychar));
            $result .= $char;
        }
        
        return $result;
    }
    
}

/*
 * Test the class
 * 
 */
/*
$strkey   = 'The quick brown fox jumps over the lazy ';
$strValue = 'Hey we are testing encryption';
echo Cron_Encryption::decrypt(Cron_Encryption::encrypt($strValue, $strkey), $strkey)."\n";
*/

