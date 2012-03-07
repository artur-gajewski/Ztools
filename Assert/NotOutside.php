<?php

/**
 * @see Zend_Validate_Abstract
 */
require_once 'Zend/Validate/Abstract.php';

/**
 * This Ztools_NotOutside component is addition to default Zend_Validate validators.
 * Assert that data is not outside a given value.
 * 
 * @copyright  2010 Artur Gajewski
 * @license    http://framework.zend.com/license   BSD License
 * @version    Release: @package_version@
 * @throws     Ztools_Assert_Equal
 * @link       http://ztools.arturgajewski.com
 * @since      Class available since Release 1.0.10
 */
class Ztools_Assert_NotOutside extends Zend_Validate_Abstract
{
    /**
     * Validation failure message key
     */
    const ASSERT_FAILED_MSG            = 'notOutside';

    /**
     * Validation failure message template definitions
     *
     * @var array
     */
    protected $_messageTemplates = array(
        self::ASSERT_FAILED_MSG        => "'%value%' is outside values '%assertValueMin%\ and '%assertValueMax%'",
    );

    /**
     * Additional variables available for validation failure messages
     *
     * @var array
     */
    protected $_messageVariables = array(
        'assertValueMin' => '_assertValueMin',
        'assertValueMax' => '_assertValueMax'
    );

    /**
     * Assert value against this variable
     *
     * @var mixed
     */
    protected $_assertValueMin;

    /**
     * Assert value against this variable
     *
     * @var mixed
     */
    protected $_assertValueMax;
    
    /**
     * Sets validator options
     *
     * @param  mixed $assertValue
     * @return void
     */
    public function __construct($assertValueMin, $assertValueMax)
    {
        $this->setAssertValueMin($assertValueMin);
        $this->setAssertValueMax($assertValueMax);
    }

    /**
     * Returns the assertValueMin
     *
     * @return mixed
     */
    public function getAssertValueMin()
    {
        return $this->_assertValueMin;
    }

    /**
     * Sets the assertValueMin
     *
     * @param  mixed $assertValueMin
     * @return Zend_Validate_Equal Provides a fluent interface
     */
    public function setAssertValueMin($assertValueMin)
    {
        $this->_assertValueMin = $assertValueMin;
        return $this;
    }
    
    /**
     * Returns the assertValueMax
     *
     * @return mixed
     */
    public function getAssertValueMax()
    {
        return $this->_assertValueMax;
    }

    /**
     * Sets the assertValueMax
     *
     * @param  mixed $assertValueMax
     * @return Zend_Validate_Equal Provides a fluent interface
     */
    public function setAssertValueMax($assertValueMax)
    {
        $this->_assertValueMax = $assertValueMax;
        return $this;
    }

    /**
     * Defined by Zend_Validate_Interface
     *
     * Assert that data is not outside a given value
     *
     * @param  mixed $value
     * @return boolean
     */
    public function isValid($value)
    {
        $this->_setValue($value);
        
        if ($value >= $this->getAssertValueMin() && $value <= $this->getAssertValueMax()) {
            $this->_error(self::ASSERT_FAILED_MSG);
            return false;
        }
        return true;
    }

}
