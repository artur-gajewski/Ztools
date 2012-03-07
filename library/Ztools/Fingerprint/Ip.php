<?php

/**
 * The Ztools_Fingerprint_Ip component
 *
 * @copyright  2010 Artur Gajewski
 * @license    http://framework.zend.com/license   BSD License
 * @version    Release: @package_version@
 * @link       http://ztools.arturgajewski.com
 * @since      Class available since Release 1.0.0
 */
class Ztools_Fingerprint_Ip extends Ztools_Fingerprint_Abstract
{
    /**
     * Create fingerprint of the request IP
     * return string
     */
    public function create()
    {
        $this->_result = md5( $this->getIp() );
        return $this->_result;
    }

    /**
     * Obtain client's IP address if available
     * @return string $ip
     * @throws Ztools_Ftp_Exception
     */
    private function getIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            throw new Ztools_Ftp_Exception('IP address could not be obtained.');
        }
        return $ip;
    }
}
