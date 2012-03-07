<?php

/**
 * Zend_Session_Namespace
 */
require_once 'Zend/Session/Namespace.php';

/**
 * The Ztools_Security_Token component
 *
 * @copyright  2010 Artur Gajewski
 * @license    http://framework.zend.com/license   BSD License
 * @version    Release: @package_version@
 * @link       http://ztools.arturgajewski.com
 * @since      Class available since Release 1.0.0
 */
class Ztools_Security_Token
{
    /**
     * Create token based on given key and save it to session
     * 
     * @param string $key
     * @return string $token
     */
    public function generate($key='ztools_token') 
    {
        $token = md5($key . microtime());
        $tokenSession = new Zend_Session_Namespace('ztools_token');
        $tokenSession->token = $token;
        return $token;
    }

    /**
     * Check token from the session with the one given
     * 
     * @param string token
     * @return boolean
     */
    public function isValid($token) 
    {
        $tokenSession = new Zend_Session_Namespace('ztools_token');
        if ($tokenSession->token == $token) {
          return true;
        } else {
          return false;
        }
    }
    
    /**
     * Get the generated token from the session
     * 
     * @return string $tokenSession->token
     */
    public function get() 
    {
        $tokenSession = new Zend_Session_Namespace('ztools_token');
        return $tokenSession->token;
    }
    
}
