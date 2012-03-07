<?php

/**
* Create and manage sessions in easy and fast manner.
* Includes expiration hops and automatic expiration time reset
* on page loads.
*
* @copyright  2010 Artur Gajewski
* @license    http://framework.zend.com/license   BSD License
* @version    Release: @package_version@
* @link       http://ztools.arturgajewski.com
* @since      Class available since Release 1.2.1
*/
class Ztools_Session
{

    /**
     * Name of the namespace for the session object
     * @var
     */
    private $namespace;

    /**
     * Expiration time of given session namespace in seconds
     * @var
     */
    private $expiration;

    /**
     * Expiration hops of given session namespace in seconds
     * If this value is set, it will override the expiration date
     * even if it it set as well.
     * @var
     */
    private $hops;

    /**
     * Constructor method for this class
     * @param
     */
    public function __construct( $namespace = null )
    {
        if ($namespace == null) {
            $this->namespace = 'defaultNamespace';
        } else {
            $this->namespace = $namespace;
        }

        $this->timestamp = time();
        $this->expiration = 3600; // Default expiration of one hour
    }

    /**
     * Setter for session namespace
     * @param $value
     * @return $this
     */
    function setNamespace( $value )
    {
        $this->namespace = $value;
        return $this;
    }

    /**
     * Getter for session namespace
     * @return $this->sessionNamespace
     */
    function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Setter for session expiration time
     * @param $value
     * @return $this
     */
    function setExpiration( $value )
    {
        $this->expiration = $value;
        return $this;
    }

    /**
     * Getter for session namespace
     * @return $this->expirationTime
     */
    function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * Setter for session expiration hops
     * @param $value
     * @return $this
     */
    function setHops( $value )
    {
        $this->hops = $value;
        return $this;
    }

    /**
     * Getter for session expiration hops
     * @return $this->hops
     */
    function getHops()
    {
        return $this->hops;
    }

    /**
     * Getter for session's start/refresh timestamp
     * @return integer $session->timestamp
     */
    function getTimestamp()
    {
        $session = new Zend_Session_Namespace( $this->getNamespace() );
        return $session->timestamp;
    }

    /**
     * Setter for session data container
     * @param $value
     */
    function setData( $value )
    {
        $session = new Zend_Session_Namespace( $this->getNamespace() );
        $session->sessionData = $value;
        return $this;
    }

    /**
     * Getter for session data container
     * @return $this->data
     */
    function getData()
    {
        $session = new Zend_Session_Namespace( $this->getNamespace() );
        return $session->sessionData;
    }

    /**
     * Start the sessionw with given data
     */
    function start()
    {
        $session = new Zend_Session_Namespace( $this->getNamespace() );
        if ($this->getHops() != null && is_numeric($this->getHops())) {
            $session->setExpirationHops( $this->getHops() );
        } else {
            $session->setExpirationSeconds( $this->getExpiration() );
        }
        $session->timestamp = time();
    }

    /**
     * Check session if it is still actual and if it is, reset the expiration time
     * If expiration hops is set, the expiration secods are ignored and not refreshed.
     * If $reset is false, reset of timestamp will not occur.
     * @param  boolean $reset
     * @return boolean
     */
    function check( $reset = false )
    {
        $session = new Zend_Session_Namespace( $this->getNamespace() );
        if ($session->timestamp) {
            if ($this->getHops() == null) {
                if ($reset == true) {
                    $session->timestamp = time();
                    $session->setExpirationSeconds( $this->getExpiration() );
                }
            }
            return true;
        }
        return false;
    }

    /**
     * End the session
     */
    function end()
    {
        Zend_Session::namespaceUnset( $this->getNamespace() );
    }

}

