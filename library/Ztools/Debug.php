<?php

/**
 * Zend_Debug
 */
require_once 'Zend/Debug.php';

/**
 * This Ztools_Debug component is used to easily create debug points
 * and later retrieve all leg data in one HTML friendly block.
 * Information includes leg number, leg duration and entered debug message.
 *
 * @copyright  2010 Artur Gajewski
 * @license    http://framework.zend.com/license   BSD License
 * @version    Release: @package_version@
 * @link       http://ztools.arturgajewski.com
 * @since      Class available since Release 1.0.4
 */
class Ztools_Debug
{
    /**
     * Timestamp of start time
     *
     * @var float $_start
     */
    private $_debugChainTitle;

    /**
     * Timestamp of start time
     *
     * @var float $_start
     */
    private $_start;

    /**
     * Timestamp of last leg
     *
     * @var float $_end
     */
    private $_end;

    /**
     * Total amount of time recorded
     *
     * @var float $_total
     */
    private $_total;

    /**
     * Container for each recorded leg
     *
     * @var array $_legs
     */
    private $_legs = array();

    /**
     * The Constructor
     */
    public function __construct($debugChainTitle = '')
    {
        $this->_start = microtime(true);
        $this->_debugChainTitle = $debugChainTitle;
    }

    /**
     *  Get debug chain's title
     *
     *  @return string
     */
    public function getTitle()
    {
        return $this->_debugChainTitle;
    }

    /**
     *  Set debug chain's title
     *
     *  @param string $value
     *  @return Ztools_Debug
     */
    public function setTitle($value)
    {
        $this->_debugChainTitle = $value;
        return $this;
    }

    /**
     * Generates stripped output.
     */
    public function add($message = '', $echo = false)
    {
        $current    = microtime(true);
        $this->_end = microtime(true);

        if (!isset($this->_legs[sizeof($this->_legs)-1]["legtime"])) {
            $legTime = $this->_start - $current;
        } else {
            $legTime = $current - $this->_legs[sizeof($this->_legs)-1]["starttime"];
        }
        $totalTime  = $current - $this->_start;

        if ($legTime < 0) {
            $legTime = $totalTime;
        }

        $this->_total = $totalTime;

        $this->_legs[] = array("message"     => $message,
                               "starttime"   => $current,
                               "legtime"     => $legTime,
                               "totaltime"   => $totalTime);

        if ($echo == true) {
            $this->getLastLeg();
        } else {
            return $this->getLastLeg(false);
        }
    }

    /**
     *  Get information about generated debug chain
     *
     *  @return array
     */
    public function getInfo()
    {
        return array( "title" => $this->_debugChainTitle,
                      "start" => $this->_start,
                      "end"   => $this->_end,
                      "total" => $this->_total,
                      "legs"  => $this->_legs);
    }

    /**
     *  Echo last leg's information.
     *  @param boolean $echo
     *  @return string
     */
    public function getLastLeg($echo = true)
    {
        $leg = $this->_legs[sizeOf($this->_legs) -1];
        if ($echo == true) {
            Zend_Debug::dump($this->_legs[sizeOf($this->_legs) -1], null, true);
        } else {
            return Zend_Debug::dump($this->_legs[sizeOf($this->_legs) -1], null, false);
        }
    }

    /**
     *  Get the size of generated debug chain
     *
     *  @return int
     */
    public function count()
    {
        return sizeOf($this->_legs);
    }

    /**
     * Get elapsed time since beginning of chain
     *
     *  @return int
     */
    public function getElapsedTime()
    {
        return $this->_total;
    }

    /**
     *  Dump the whole chain data into HTML or other output.
     *
     *  @param boolean $echo
     *  @param boolean $reset
     *  @return string
     */
    public function dump($echo = true, $reset = false, $newTitle = null)
    {
        $data = $this->getInfo();

        if ($reset) {
            $this->reset($newTitle);
        }

        if ($echo == true) {
            Zend_Debug::dump($data, null, true);
        } else {
            return Zend_Debug::dump($data, null, false);
        }
    }

    /**
     *  Reset the debug chain
     */
    public function reset($newTitle = null)
    {
        if ($newTitle != null) {
            $this->_debugChainTitle = $newTitle;
        }
        $this->_start = microtime(true);
        $this->_legs = array();
    }

}