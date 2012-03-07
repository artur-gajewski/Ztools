<?php

/**
 * Zend_Http_Client
 */
require_once 'Zend/Http/Client.php';

/**
 * Zend_Http_Client_Exception
 */
require_once 'Zend/Http/Client/Exception.php';

/**
 * The Ztools_Service_Google_Weather component is used to obtain weather forecast information
 * of a given city from Google Weather API.
 *
 * @copyright  2010 Artur Gajewski
 * @license    http://framework.zend.com/license   BSD License
 * @version    Release: @package_version@
 * @link       http://ztools.arturgajewski.com
 * @since      Class available since Release 1.0.0
 */
class Ztools_Service_Google_Weather
{
    /**
     * IpInfoDb's API URL
     */
    const SERVICE_API_URL = 'http://www.google.com/ig/api';

    /**
     * Google Map's service URL
     */
    const GOOGLE_BASE_URL = "http://www.google.com";
    
    /**
     * The HTTP Client object to use to perform requests
     *
     * @var Zend_Http_Client
     */
    protected $_httpclient;
    
    /**
     * Containers for the response
     */
    private $_lows = array();
    private $_highs = array();
    private $_icons = array();
    private $_daysOfWeek = array();
    private $_conditions = array();
    private $_currentIcon;
    private $_currentTemperature;
    private $_currentCondition;
    
    /**
     * The city of weather forecast
     *
     * @var string $_cityName
     */
    private $_cityName;
    
    /**
     * The ISO code for language
     *
     * @var string $_language
     */
    private $_language;

    /**
     * Sets the Zend_Http_Client object to use in requests. If not provided a default will
     * be used.
     *
     * @param Zend_Http_Client $client The HTTP client instance to use
     * @return Ztools_Service_Google_Weather
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
     * Sets the city name to be used in requests.
     *
     * @param string $ip The IP address used for query
     * @return Ztools_Service_Google_Weather
     */
    public function setCityName($cityName)
    {
        $this->_cityName = $cityName;
        return $this;
    }
    
    /**
     * Gets the city name to be used in requests.
     *
     * @return string $_ip
     */
    public function getCityName()
    {
        return $this->_cityName;
    }
    
/**
     * Sets the language code used in requests.
     *
     * @param string $language The language code
     * @return Ztools_Service_Weather
     */
    public function setLanguage($language)
    {
        $this->_language = $language;
        return $this;
    }
    
    /**
     * Gets the language code to be used in requests.
     *
     * @return string $_language
     */
    public function getLanguage()
    {
        return $this->_language;
    }
    
    /**
     * Sets the flag for Celcius degrees to be used
     *
     * @param boolean $value
     * @return Ztools_Service_Google_Weather
     */
    public function setCelsius($value)
    {
        $this->_celsius = $value;
        return $this;
    }
    
    /**
     * Gets the flag for Celcius degrees to be used
     *
     * @return boolean $_celsius
     */
    public function getCelsius()
    {
        return $this->_celsius;
    }
    
    /**
     * The Constructor
     */
    public function __construct()
    {
        $this->_httpclient = new Zend_Http_Client(self::SERVICE_API_URL);
    	  $this->setCelsius(false);
    }
    
    /**
     * Fetches the weather forecast for the given city.
     */
    public function fetch() 
    {
        $client = $this->getHttpClient();
        $params = array('weather' => $this->getCityName());
        
        if ($this->getLanguage() != null) {
            $params['hl'] = $this->getLanguage();
        }
        
        $client->setParameterGet($params);
        $response = null;
        
        try {
            $response = $client->request('POST');
        } catch(Zend_Http_Client_Exception $e) {
        	 throw new Zend_Exception("Service Request Failed: {$e->getMessage()}");
        }
        
        $xml = new SimpleXMLElement(utf8_encode($response->getBody()));
        $information = $xml->xpath("/xml_api_reply/weather/forecast_information");
		    $current = $xml->xpath("/xml_api_reply/weather/current_conditions");
		    $forecast_list = $xml->xpath("/xml_api_reply/weather/forecast_conditions");
        
    		foreach ($forecast_list as $forecast) {
      			if ($this->getCelsius() == true) {
      				  $this->_lows[] = intval((intval($forecast->low['data']) - 32) / 1.8);
      				  $this->_highs[] = intval((intval($forecast->high['data']) - 32) / 1.8);
      			} else {
      				  $this->_lows[] = $forecast->low['data'];
      				  $this->_highs[] = $forecast->high['data'];
      			}
      			$this->_icons[] = self::GOOGLE_BASE_URL . $forecast->icon['data'];
      			$this->_daysOfWeek[] = $forecast->day_of_week['data'];
      			$this->_conditions[] = $forecast->condition['data'];
    		}
    
    		foreach ($forecast_list as $forecast) {
    			  $this->_currentIcon = self::GOOGLE_BASE_URL . $current[0]->icon['data'];
    			  if ($this->getCelsius() == true) {
    				    $this->_currentTemperature = intval($current[0]->temp_c['data']);
    			} else {
    				    $this->_currentTemperature = intval($current[0]->temp_f['data']);
    			}
    			$this->_currentCondition = $current[0]->condition['data'];
        }
        
        $forecastArray = array();
        $count = 0;
        foreach($this->_conditions as $data) {
          	$forecastArray[] = array("low"         => $this->_lows[$count],
          	                         "high"        => $this->_highs[$count],
          	                         "icon"        => $this->_icons[$count],
          	                         "day_of_week" => $this->_daysOfWeek[$count],
          	                         "condition"   => $this->_conditions[$count]);
          	$count++;
        }
        
        return array( "current" => array("icon" => $this->_currentIcon,
                                         "temperature" => $this->_currentTemperature,
                                         "condition" => $this->_currentCondition),
                      "forecast" => $forecastArray);
    }
}
