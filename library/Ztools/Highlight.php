<?php

/**
 * The Ztools_Highlight component is used to highlight found occurances in string into
 * specific format. Automatically ignores context within HTML tags so HTML output can be
 * searched as well.
 *
 * @copyright  2010 Artur Gajewski
 * @license    http://framework.zend.com/license   BSD License
 * @version    Release: @package_version@
 * @link       http://ztools.arturgajewski.com
 * @since      Class available since Release 1.0.0
 */
class Ztools_Highlight
{
    /**
     * Array container of the data strings
     *
     * @var string $_stringArray
     */
    private $_stringArray = array();
    
    /**
     * Array container of the search keywords
     *
     * @var string $_keywordArray
     */
    private $_keywordArray = array();
    
    /**
     * Array container of the resulting highlights
     *
     * @var string $_resultsArray
     */
    private $_resultArray = array();
    
    /**
     * CSS class defitionion for the highlighter word wrapper
     *
     * @var string $_htmlClass
     */
    private $_htmlClass;
    
    /**
     * Adds the keyword to be searched for.
     *
     * @param string $value
     * @return Ztools_Highlight
     */
    public function addKeyword($value)
    {
        if (is_array($value)) {
            foreach ($value as $entry) {
                $this->_keywordArray[] = $entry;
            }
        } else {
            $this->_keywordArray[] = $value;
        }
        return $this;
    }

    /**
     * Gets the array container of added keywords.
     *
     * @return array $_keywordArray
     */
    public function getKeywords()
    {
        return $this->_keywordArray;
    }
    
    /**
     * Adds the string to be searched and highlighted.
     *
     * @param string $value
     * @return Ztools_Highlight
     */
    public function addString($value)
    {
        if (is_array($value)) {
            foreach ($value as $entry) {
                $this->_stringArray[] = $entry;
            }
        } else {
            $this->_stringArray[] = $value;
        }
        return $this;
    }
    
    /**
     * Gets the array container of added strings.
     *
     * @return array $_stringArray
     */
    public function getStrings()
    {
        return $this->_stringArray;
    }
    
    /**
     * Adds a resulting highlighted entry into resultArray container.
     *
     * @param string $value
     * @return Ztools_Highlight
     */
    private function addResult($value)
    {
        if (is_array($value)) {
            foreach ($value as $entry) {
                $this->_resultArray[] = $entry;
            }
        } else {
            $this->_resultArray[] = $value;
        }
        return $this;
    }
    
    /**
     * Gets the array container of results.
     *
     * @return array $_resultArray
     */
    public function getResults()
    {
        return $this->_resultArray;
    }
    
    /**
     * Sets the CSS class definition for the HTML tag's wrapper.
     *
     * @param string $value
     * @return Ztools_Highlight
     */
    public function setHtmlClass($value)
    {
        $this->_htmlClass = $value;
        return $this;
    }
    
    /**
     * Gets the CSS class definition of highlighted portions.
     *
     * @return string $$_htmlClass;
     */
    public function getHtmlClass()
    {
        return $this->_htmlClass;
    }
    
    /**
     * The Constructor
     */
    public function __construct()
    {
        $this->_htmlClass = 'highlight';
    }
    
    /**
     * Goes through the array container and highlights
     * the keywords in the container.
     */
    public function highlight() 
    {
        if (isset($this->_stringArray) && isset($this->_keywordArray)) {
            foreach($this->_stringArray as $entry) {
                foreach($this->_keywordArray as $keyword) {
                    if(strlen($entry) != strlen(strip_tags($entry))) { 
                        $entry = preg_replace_callback('/>(.*?)</',
                                 create_function('$matches',
                                                 'return preg_replace("/\b(' . 
                                                  preg_quote($keyword) . 
                                                  ')\b/i", "<span class=\"' . $this->_htmlClass . '\">\\\1</span>", $matches[0]);'),
                                                  $entry);
                    } else {
                        $entry = preg_replace('/(' . $keyword . ')/i', '<span class="' . $this->_htmlClass . '">$1</span>', $entry);
                    } 
                }
                $this->addResult($entry);
            }
        }
    }
}
