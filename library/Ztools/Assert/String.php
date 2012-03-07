<?php

/**
 * @see Zend_Validate_Abstract
 */
require_once 'Zend/Validate/Abstract.php';

/**
 * This Ztools_String component is addition to default Zend_Validate validators.
 * Assert that data is string.
 * 
 * @copyright  2010 Artur Gajewski
 * @license    http://framework.zend.com/license   BSD License
 * @version    Release: @package_version@
 * @throws     Ztools_Assert_Equal
 * @link       http://ztools.arturgajewski.com
 * @since      Class available since Release 1.0.10
 */
class Ztools_Assert_String extends Zend_Validate_Abstract
{
    /**
     * Validation failure message key
     */
    const ASSERT_FAILED_MSG            = 'string';

    /**
     * Validation failure message template definitions
     *
     * @var array
     */
    protected $_messageTemplates = array(
        self::ASSERT_FAILED_MSG        => "Value is not string",
    );

    /**
     * Additional variables available for validation failure messages
     *
     * @var array
     */
    protected $_messageVariables = array(
        'assertValue' => '_assertValue'
    );

    /**
     * Assert value against this variable
     *
     * @var mixed
     */
    protected $_assertValue;

    /**
     * Sets validator options
     *
     */
    public function __construct()
    {
    }

    /**
     * Returns the assertValue
     *
     * @return mixed
     */
    public function getAssertValue()
    {
        return $this->_assertValue;
    }

    /**
     * Sets the assertValue
     *
     * @param  mixed $assertValue
     * @return Zend_Validate_Equal Provides a fluent interface
     */
    public function setAssertValue($assertValue)
    {
        $this->_assertValue = $assertValue;
        return $this;
    }

    /**
     * Defined by Zend_Validate_Interface
     *
     * Assert that data is string
     *
     * @param  mixed $value
     * @return boolean
     */
    public function isValid($value)
    {
        $this->_setValue($value);

        if (!is_string($value)) {
            $this->_error(self::ASSERT_FAILED_MSG);
            return false;
        }
        return true;
    }

}
