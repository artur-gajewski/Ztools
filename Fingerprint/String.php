<?php

/**
 * The Ztools_Fingerprint_String component
 *
 * @copyright  2010 Artur Gajewski
 * @license    http://framework.zend.com/license   BSD License
 * @version    Release: @package_version@
 * @link       http://ztools.arturgajewski.com
 * @since      Class available since Release 1.0.0
 */
class Ztools_Fingerprint_String extends Ztools_Fingerprint_Abstract
{
    /**
     * Create fingerprint
     */
    public function create($data) 
    {
      	if (is_array($data)) {
      		  $this->_result[] = md5(implode('', $data));
      	} else {
      		  $this->_result = md5($data);
      	}
      	return $this->_result;    
    }
}
