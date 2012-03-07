<?php

/**
 * The Ztools_Fingerprint_Abstract class
 *
 * @copyright  2010 Artur Gajewski
 * @license    http://framework.zend.com/license   BSD License
 * @version    Release: @package_version@
 * @link       http://ztools.arturgajewski.com
 * @since      Class available since Release 1.0.0
 */
class Ztools_Fingerprint_Abstract
{
    /**
     * Fingerprint type
     *
     * @var mixed $_source
     */
    private $_data;
    
    /**
     * Resulting MD5 hash
     *
     * @var mixed $_result
     */
    private $_result;
    
    /**
     * Sets the data to be fingerprinted
     *
     * @param mixed $value
     * @return Ztools_Fingerprint
     */
    public function setData($value)
    {
        $this->_data = $value;
        return $this;
    }
    
    /**
     * Gets the data to be fingerprinted
     *
     * @return mixed $_data
     */
    public function getData()
    {
        return $this->_data;
    }
    
    /**
     * Gets the MD5 hashed result.
     *
     * @return string $_result
     */
    public function getResult()
    {
        return $this->_result;
    }

}




