<?php

/**
 * The Ztools_Strip component is used to strip given string from unwanted HTML 
 * tags and their containing attributes.
 * .
 *
 * @copyright  2010 Artur Gajewski
 * @license    http://framework.zend.com/license   BSD License
 * @version    Release: @package_version@
 * @link       http://ztools.arturgajewski.com
 * @since      Class available since Release 1.0.0
 */
class Ztools_Strip
{
    /**
     * Data string
     *
     * @var string $_data
     */
    private $_data;
    
    /**
     * List of tags to be removed
     *
     * @var array $_removeTags
     */
    private $_removeTags = array();
    
    /**
     * List of tags to be removed but content remained
     *
     * @var array $_removeOnlyTags
     */
    private $_removeOnlyTags = array();
    
     /**
     * Remove all comment blocks from input
     * 
     * @var boolean $_removeComments
     */
    private $_removeComments;
    
    /**
     * Remove all empty tag blocks
     * 
     * @var boolean $_removeEmptyBlocks
     */ 
    private $_removeEmptyBlocks;

    /**
     * Remove all blank lines from the input
     * 
     * @var boolean $_removeBlankLines
     */
    private $_removeBlankLines;
    
    /**
     * Resulting stripped string
     *
     * @var string $_result
     */
    private $_result;
    
    /**
     * Sets the string data to be stripped.
     *
     * @param string $value
     * @return Ztools_Highlight
     */
    public function setData($value)
    {
        $this->_data = $value;
        return $this;
    }
    
    /**
     * Gets the string data to be stripped.
     *
     * @return $this->_data
     */
    public function getData()
    {
        return $this->_data;
    }
    
    /**
     * Adds the tag to be removed.
     *
     * @param mixed $value
     * @return Ztools_Highlight
     */
    public function addRemoveTag($value)
    {
        if (is_array($value)) {
            foreach ($value as $entry) {
                $entry = $this->cleanTag($entry);
                $this->_removeTags[] = $entry;
            }
        } else {
            $this->_removeTags[] = $value;
        }
        return $this;
    }

    /**
     * Gets the array container of added removal tags.
     *
     * @return array $_removeTags
     */
    public function getRemoveTags()
    {
        return $this->_removeTags;
    }
    
    /**
     * Adds the tag to be removed while the content
     * remained as is.
     *
     * @param mixed $value
     * @return Ztools_Highlight
     */
    public function addRemoveOnlyTag($value)
    {
        if (is_array($value)) {
            foreach ($value as $entry) {
                $entry = $this->cleanTag($entry);
                $this->_removeOnlyTags[] = $entry;
            }
        } else {
            $this->_removeOnlyTags[] = $value;
        }
        return $this;
    }
    
    /**
     * Gets the array container of added removal tags
     * while content remained.
     *
     * @return array $_removeOnlyTags
     */
    public function getRemoveOnlyTags()
    {
        return $this->_removeOnlyTags;
    }
    
    /**
     * Sets a value for removing comment blocks.
     *
     * @param boolean $value
     * @return Ztools_Highlight
     */
    public function setRemoveComments($value)
    {
        $this->_removeComments = $value;
        return $this;
    }

    /**
     * Gets the value of comment removal.
     *
     * @return boolean $_removeComments
     */
    public function getRemoveComments()
    {
        return $this->_removeComments;
    }
    
    /**
     * Sets a value for removing empty tag blocks.
     *
     * @param boolean $value
     * @return Ztools_Highlight
     */
    public function setRemoveEmptyBlocks($value)
    {
        $this->_removeEmptyBlocks = $value;
        return $this;
    }

    /**
     * Gets the value of empty tag block removal.
     *
     * @return boolean $_removeEmptyBlocks
     */
    public function getRemoveEmptyBlocks()
    {
        return $this->_removeEmptyBlocks;
    }
    
    /**
     * Sets a value for removing blank lines.
     *
     * @param boolean $value
     * @return Ztools_Highlight
     */
    public function setRemoveBlankLines($value)
    {
        $this->_removeBlankLines = $value;
        return $this;
    }

    /**
     * Gets the value of empty tag block removal.
     *
     * @return boolean $_removeBlankLines
     */
    public function getRemoveBlankLines()
    {
        return $this->_removeBlankLines;
    }
    
    /**
     * Gets the string representation of the array container of added removed tags.
     *
     * @return string $tagString
     */
    public function getTagsString()
    {
        $tagString = '';
        foreach($this->_removeTags as $tag) {
            $tagString .= '<' . $tag . '>';
        }
        return $tagString;
    }
    
    /**
     * Gets the result of stripped data.
     *
     * @return string $_result
     */
    public function getResult()
    {
        return $this->_result;
    }
    
    /**
     * Clean tag from < and > characters
     * 
     * @param $tag
     * @return unknown_type
     */
    private function cleanTag($tag) 
    {
        $tag = str_replace('<', '', $tag);
        $tag = str_replace('>', '', $tag);
        $tag = str_replace('&lt;', '', $tag);
        $tag = str_replace('&gt;', '', $tag);
        
        return $tag;
    }
    
    /**
     * The Constructor
     */
    public function __construct()
    {
        $this->_removeComments = false;
        $this->_removeEmptyBlocks = false;
        $this->_removeBlankLines = false;
    }
    
    /**
     * Generates stripped output.
     */
    public function strip() 
    {   
        $text = $this->_data;
        
        foreach ($this->_removeOnlyTags as $tag) {
            $text = preg_replace('/<\/?'.$tag.'[^>]*?>/i', '', $text);
        }
        
        $removeTags = '';
        foreach ($this->_removeTags as $tag) {
            $removeTags .= '<' . $tag . '>';
            $text = preg_replace('/<' . $tag . '[\S\s]*?\/>/', '', $text);
            $text = preg_replace('/<!--[\S\s]*?-->/', '', $text);
        }   
        
        $this->_result = $this->strip_selected_tags($text, $removeTags, $stripContent = true);
    
        // Strip blocks that contain no data
        if ($this->_removeEmptyBlocks == true) {
            $this->_result = preg_replace('/<[^\/>]*>([\s]?)*<\/[^>]*>/', '', $this->_result);
        } 
        
        // Strip blank lines
        if ($this->_removeBlankLines == true) {
            $this->_result = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $this->_result);
        }
    }
    
    function strip_selected_tags($str, $tags = "", $stripContent = false)
    {
        preg_match_all("/<([^>]+)>/i", $tags, $allTags, PREG_PATTERN_ORDER);
        foreach ($allTags[1] as $tag) {
            $replace = "%(<$tag.*?>)(.*?)(<\/$tag.*?>)%is";
            $replace2 = "%(<$tag.*?>)%is";
            
            if ($stripContent) {
                $str = preg_replace($replace,'',$str);
                $str = preg_replace($replace2,'',$str);
            }
                $str = preg_replace($replace,'${2}',$str);
                $str = preg_replace($replace2,'${2}',$str);
        }
        return $str;
    } 
}
