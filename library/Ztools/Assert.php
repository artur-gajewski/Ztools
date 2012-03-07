<?php

/**
 * The Ztools_Assert component is a wrapper class for Zend_Validate.
 * Purpose of this class is to validate given instances as the Zend_Validate
 * class does, but the focus is more on asserting values than validating them.
 * Ztools_Assert package includes many useful assertion classes to be added
 * as assertions to Ztools_Assert object.
 *
 * @copyright  2010 Artur Gajewski
 * @license    http://framework.zend.com/license   BSD License
 * @version    Release: @package_version@
 * @link       http://ztools.arturgajewski.com
 * @since      Class available since Release 1.2.2
 */
class Ztools_Assert extends Zend_Validate
{
    /**
     * Adds the given assertion class to the validation object.
     *
     * @param  Class $class
     * @return Ztools_Assert
     */
    public function add($class)
    {
        $this->addValidator($class);
        return $this;
    }

}
