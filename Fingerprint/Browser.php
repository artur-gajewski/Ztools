<?php

/**
 * The Ztools_Fingerprint_Browser component
 *
 * @copyright  2010 Artur Gajewski
 * @license    http://framework.zend.com/license   BSD License
 * @version    Release: @package_version@
 * @link       http://ztools.arturgajewski.com
 * @since      Class available since Release 1.0.0
 */
class Ztools_Fingerprint_Browser extends Ztools_Fingerprint_Abstract
{
    /**
     * Create fingerprint of the browser
     */
    public function create() 
    {
        $keys = array('HTTP_USER_AGENT',
                      'SERVER_PROTOCOL',
                      'HTTP_ACCEPT_CHARTSET',
                      'HTTP_ACCEPT_ENCODING',
                      'HTTP_ACCEPT_LANGUAGE');
        
        $tmp = '';
        foreach ($keys as $key) {
            if (isset($_SERVER[$key])) {
                $tmp .= $_SERVER[$key];
            }
        }
        $this->_result = md5($tmp);
        return $this->_result;    
    }
}
