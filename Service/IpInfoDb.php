<?php

/**
 * Zend_Http_Client
 */
require_once 'Zend/Http/Client.php';

/**
 * The Ztools_Service_IpInfoDb component is used to obtain information of a given IP address.
 *
 * @copyright  2010 Artur Gajewski
 * @license    http://framework.zend.com/license   BSD License
 * @version    Release: @package_version@
 * @link       http://ztools.arturgajewski.com
 * @since      Class available since Release 1.0.0
 */
class Ztools_Service_IpInfoDb
{
    /**
     * IpInfoDb's API URL
     */
    const SERVICE_API_URL             = 'http://www.ipinfodb.com/ip_query2.php';
    const SERVICE_API_BACKUP_URL      = 'http://backup.ipinfodb.com/ip_query2.php';
    
    /**
     * The return type of the results
     */
    const SERVICE_API_RESPONSE_TYPE   = "xml";

    /**
     * Google Map's service URL
     */
    const GOOGLE_MAPS_URL             = "http://maps.google.com/maps";
    
    /**
     * The HTTP Client object to use to perform requests
     *
     * @var Zend_Http_Client
     */
    protected $_httpclient;
    
    /**
     * The IP address
     *
     * @var string $_ip
     */
    private $_ip;

    /**
     * The IP address' data container
     *
     * @var string $_ip
     */
    private $_data = array();
    
    /**
     * Setter for the IP data container
     *
     * @var string $key, $value
     */
    public function __set($key, $value) 
    {
        $this->_data[$key] = $value;
    }

    /**
     * Getter for the IP data container
     *
     * @var string $key
     * @return mixed
     */
    public function __get($key) 
    {
        return $this->_data[$key];
    }
    
    /**
     * Sets the Zend_Http_Client object to use in requests. If not provided a default will
     * be used.
     *
     * @param Zend_Http_Client $client The HTTP client instance to use
     * @return Ztools_Service_IpInfoDb
     */
    public function setHttpClient(Zend_Http_Client $client)
    {
        $this->_httpclient = $client;
        return $this;
    }

    /**
     * Returns the instance of the Zend_Http_Client which will be used. Creates an instance
     * of Zend_Http_Client if no previous client was set.
     *
     * @return Zend_Http_Client The HTTP client which will be used
     */
    public function getHttpClient()
    {
        if(!($this->_httpclient instanceof Zend_Http_Client)) {
            $client = new Zend_Http_Client();
            
            $client->setConfig(array('maxredirects' => 2,
                                     'timeout' => 5));

            $this->setHttpClient($client);
        }

        $this->_httpclient->resetParameters();
        return $this->_httpclient;
    }
    
    /**
     * Sets the IP address to be used in requests.
     *
     * @param string $ip The IP address used for query
     * @return Ztools_Service_IpInfoDb
     */
    public function setIp($ip)
    {
        if (!isset($ip)) {
            $ip = $this->getRequest()->getServer('REMOTE_ADDR'); 
        }
      
        if ($ip == '127.0.0.1' || $ip == 'localhost') {
            throw new Zend_Exception("Localhost or 127.0.0.1 cannot be set as IP address");
        }

        $this->_ip = $ip;
        return $this;
    }
    
    /**
     * Gets the IP address to be used in requests.
     *
     * @return string $_ip
     */
    public function getIp()
    {
        return $this->_ip;
    }
    
    /**
     * The Constructor
     *
     * @param string $ip The IP address to be used to fetch information about
     * @param boolean $fetch Whether information should be fetched automatically
     */
    public function __construct($ip = null, $fetch = false)
    {
        if (isset($ip)) {
            $this->setIp($ip);
        }
        $this->_httpclient = new Zend_Http_Client(self::SERVICE_API_URL);
        
        if ($fetch) {
            $this->fetch();
        }
    }
    
    /**
     * Fetches the IP address information with set IP address and sets
     * data container with corresponing data.
     */
    public function fetch() 
    {
        $client = $this->getHttpClient();
        
        $params = array('ip'     => $this->getIp(),
                        'output' => self::SERVICE_API_RESPONSE_TYPE);
        
        $client->setParameterGet($params);
        
        require_once 'Zend/Http/Client/Exception.php';
        try {
            $response = $client->request('POST');
        } catch(Zend_Http_Client_Exception $e) {
            try {
                $this->_httpclient->setUri(self::SERVICE_API_BACKUP_URL);
                $response = $client->request('POST');
            } catch(Zend_Http_Client_Exception $e) {
                throw new Zend_Exception("Service Request Failed: {$e->getMessage()}");
            }
        }
        
        $xml = new SimpleXMLElement($response->getBody());
        
        $this->_data['ip']            = $xml->Location[0]->Ip;
        $this->_data['status']        = $xml->Location[0]->Status;
        $this->_data['countryCode']   = $xml->Location[0]->CountryCode;
        $this->_data['countryName']   = $xml->Location[0]->CountryName;
        $this->_data['regionName']    = $xml->Location[0]->regionName;
        $this->_data['city']          = $xml->Location[0]->city;
        $this->_data['zipPostalCode'] = $xml->Location[0]->ZipPostalCode;
        $this->_data['latitude']      = $xml->Location[0]->Latitude;
        $this->_data['longitude']     = $xml->Location[0]->Longitude;
        $this->_data['gmtOffset']     = $xml->Location[0]->Gmtoffset;
        $this->_data['dstOffset']     = $xml->Location[0]->Dstoffset;
    }
    
    /**
     * Creates an array represantation of the object
     *
     * @return array Array of the IP data container.
     */
    public function toArray()
    {
       return $this->_data;
    }
    
    /**
     * Creates an URL to link to Google Maps' service for the IP location
     *
     * @return string $url URL for the Google Maps application of IP location
     */
    public function getGoogleMapsUrl() 
    {
      $url = self::GOOGLE_MAPS_URL . '?q=' .
             $this->_data['latitude'] . ',' .
             $this->_data['longitude'];
      
      return $url;
    }
    
    /**
     * Validates given IP address
     *
     * @param string $ip The IP address to be validated
     * @return boolean Validation result as boolean of the IP address
     */
    public function validateIpAddress($ip)
    {
        if(preg_match("/^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/", $ip)) {
          $sections = explode(".", $ip);
        
          foreach($sections as $part) {
              if(intval($part)>255 || intval($part)<0) {
                  return false;
              }
          }
          return true;
        
        } else { 
            return false;
        }
    }
}
