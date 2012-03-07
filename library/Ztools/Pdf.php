<?php

/**
 * The Ztools_Pdf component is used to create PDF file from given source.
 * Pagination and word wrapping is done automatically. You can also select
 * predefined sizes with templates to obtain best font sizes and margins
 * for each page sizes supported.
 *
 * @copyright  2010 Artur Gajewski
 * @license    http://framework.zend.com/license   BSD License
 * @version    Release: @package_version@
 * @link       http://ztools.arturgajewski.com
 * @since      Class available since Release 1.2.4
 */
class Ztools_Pdf
{

    /**
     * Constant for A4 template with small font
     */
    const TEMPLATE_A4_SMALL_FONT  = 1;

    /**
     * Constant for A4 template with medium font
     */
    const TEMPLATE_A4_MEDIUM_FONT = 2;

    /**
     * Constant for A4 template with large font
     */
    const TEMPLATE_A4_LARGE_FONT  = 3;

    /**
     * Constant for LETTER template with small font
     */
    const TEMPLATE_LETTER_SMALL_FONT  = 4;

    /**
     * Constant for LETTER template with medium font
     */
    const TEMPLATE_LETTER_MEDIUM_FONT = 5;

    /**
     * Constant for LETTER template with large font
     */
    const TEMPLATE_LETTER_LARGE_FONT  = 6;

    /**
     * Constant for A4 page size
     */
    const PAGE_SIZE_A4 = Zend_Pdf_Page::SIZE_A4;

    /**
     * Constant for LETTER page size
     */
    const PAGE_SIZE_LETTER = Zend_Pdf_Page::SIZE_LETTER;

    /**
     * Content string
     *
     * @var string $_content
     */
    private $_content;

    /**
     * Content color
     *
     * @var string $_color
     */
    private $_color;

    /**
     * Page size
     *
     * @var string $_pageSize
     */
    private $_pageSize;

    /**
     * Top margin
     *
     * @var string $_topMargin
     */
    private $_topMargin;

    /**
     * Font size
     *
     * @var string $_fontSize
     */
    private $_fontSize;

    /**
     * Filename of created PDF file
     *
     * @var string $_filename
     */
    private $_filename;

    /**
     * Encoding of the content
     *
     * @var string $_encoding
     */
    private $_encoding;

    /**
     * Sets the string data to be created into PDF format.
     *
     * @param string $value
     * @return Ztools_Pdf
     */
    public function setContent($value)
    {
        $this->_content = $value;
        return $this;
    }

    /**
     * Gets the string data to be created into PDF format.
     *
     * @return $this->_content
     */
    public function getContent()
    {
        return $this->_content;
    }

    /**
     * Sets the text color.
     *
     * @param string $value
     * @return Ztools_Pdf
     */
    public function setColor($value)
    {
        $this->_color = $value;
        return $this;
    }

    /**
     * Gets the text color.
     *
     * @return $this->_color
     */
    public function getColor()
    {
        return $this->_color;
    }

    /**
     * Sets the page size.
     *
     * @param string $value
     * @return Ztools_Pdf
     */
    public function setPageSize($value)
    {
        $this->_pageSize = $value;
        return $this;
    }

    /**
     * Gets the page size.
     *
     * @return $this->_pageSize
     */
    public function getPageSize()
    {
        return $this->_pageSize;
    }

    /**
     * Sets the font size.
     *
     * @param string $value
     * @return Ztools_Pdf
     */
    public function setFontSize($value)
    {
        $this->_fontSize = $value;
        return $this;
    }

    /**
     * Gets the font size.
     *
     * @return $this->_fontSize
     */
    public function getFontSize()
    {
        return $this->_fontSize;
    }

    /**
     * Sets the pageWidth.
     *
     * @param string $value
     * @return Ztools_Pdf
     */
    public function setPageWidth($value)
    {
        $this->_pageWidth = $value;
        return $this;
    }

    /**
     * Gets the page width.
     *
     * @return $this->_pageWidth
     */
    public function getPageWidth()
    {
        return $this->_pageWidth;
    }

    /**
     * Sets the top margin.
     *
     * @param string $value
     * @return Ztools_Pdf
     */
    public function setTopMargin($value)
    {
        $this->_topMargin = $value;
        return $this;
    }

    /**
     * Gets the top margin.
     *
     * @return $this->_topMargin
     */
    public function getTopMargin()
    {
        return $this->_topMargin;
    }

    /**
     * Sets the name of the PDF file.
     *
     * @param string $value
     * @return Ztools_Pdf
     */
    public function setFilename($value)
    {
        $this->_filename = $value;
        return $this;
    }

    /**
     * Gets the name of the file.
     *
     * @return $this->_filename
     */
    public function getFilename()
    {
        return $this->_filename;
    }

    /**
     * Sets the encoding of the content.
     *
     * @param string $value
     * @return Ztools_Pdf
     */
    public function setEncoding($value)
    {
        $this->_encoding = $value;
        return $this;
    }

    /**
     * Gets the encoding of the content.
     *
     * @return $this->_encoding
     */
    public function getEncoding()
    {
        return $this->_encoding;
    }

    /**
     * The Constructor
     */
    public function __construct( $content )
    {
        $this->_content = $content;
        $this->_color = '#000000';
        $this->_pageSize = self::PAGE_SIZE_A4;
        $this->_fontSize = 8;
        $this->_pageWidth = 143;
        $this->_topMargin = 800;
        $this->_encoding = 'UTF-8';
        $this->_filename = time() . '.pdf';
    }

    /*
     * Function to generate different templates.
     *
     * @param integer $template
     */
    function setTemplate( $template )
    {
        switch ($template) {
            case 1:
                $this->_color = '#000000';
                $this->_pageSize = self::PAGE_SIZE_A4;
                $this->_fontSize = 8;
                $this->_pageWidth = 143;
                $this->_topMargin = 800;
                break;
            case 2:
                $this->_color = '#000000';
                $this->_pageSize = self::PAGE_SIZE_A4;
                $this->_fontSize = 10;
                $this->_pageWidth = 115;
                $this->_topMargin = 800;
                break;
            case 3:
                $this->_color = '#000000';
                $this->_pageSize = self::PAGE_SIZE_A4;
                $this->_fontSize = 12;
                $this->_pageWidth = 93;
                $this->_topMargin = 800;
                break;
            case 4:
                $this->_color = '#000000';
                $this->_pageSize = self::PAGE_SIZE_LETTER;
                $this->_fontSize = 8;
                $this->_pageWidth = 150;
                $this->_topMargin = 750;
                break;
            case 5:
                $this->_color = '#000000';
                $this->_pageSize = self::PAGE_SIZE_LETTER;
                $this->_fontSize = 10;
                $this->_pageWidth = 118;
                $this->_topMargin = 750;
                break;
            case 6:
                $this->_color = '#000000';
                $this->_pageSize = self::PAGE_SIZE_LETTER;
                $this->_fontSize = 12;
                $this->_pageWidth = 98;
                $this->_topMargin = 750;
                break;
        }
    }

    /*
     * Create PDF data and either return it or echo it as application/x-pdf
     *
     * @param boolean $echo
     */
    function create( $echo = false )
    {
        $style = new Zend_Pdf_Style();
        $style->setFont( Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), $this->_fontSize);
        $style->setFillColor(new Zend_Pdf_Color_Html($this->_color));

        $pdf = new Zend_Pdf();
        $pdf->pages[] = ($page = $pdf->newPage($this->_pageSize));

        $page->setStyle($style);

        $text = $this->_content;
        $text = wordwrap($text, $this->_pageWidth, "\n", false);

        $token = strtok($text, "\n");

        $style->setFillColor(new Zend_Pdf_Color_Html($this->_color));
        $page->setStyle($style);

        $y = $this->_topMargin;
        if ($this->_pageSize == self::PAGE_SIZE_A4) {
            $y = 800;
        } elseif ($this->_pageSize == self::PAGE_SIZE_LETTER) {
            $y = 750;
        } else {
            $y = $this->_topMargin;
        }

        while ($token != false) {
          if ($y < 60) {
            $pdf->pages[] = ($page = $pdf->newPage($this->_pageSize));
            $page->setStyle($style);
            if ($this->_pageSize == self::PAGE_SIZE_A4) {
                $y = 800;
            } elseif ($this->_pageSize == self::PAGE_SIZE_LETTER) {
                $y = 750;
            } else {
                $y = $this->_topMargin;
            }
          }
          else {
            $page->drawText($token, 40, $y, $this->_encoding);
            $y-=15;
          }
          $token = strtok("\n");
        }

        $pdfData = $pdf->render();

        if ($echo == true) {
            header("Content-Disposition: inline; filename={$this->_filename}");
            header("Content-type: application/x-pdf");
            echo $pdfData;
        } else {
            return $pdfData;
        }
    }
}
