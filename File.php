<?php

/**
* Create and manage files.
*
* @copyright  2010 Artur Gajewski
* @license    http://framework.zend.com/license   BSD License
* @version    Release: @package_version@
* @link       http://ztools.arturgajewski.com
* @since      Class available since Release 1.2.3
*/
class Ztools_File
{
    protected static $_mimeTypes = array(
        'css'         => 'text/css',
        'doc'         => 'application/msword',
        'docm'        => 'application/vnd.ms-word.document.macroEnabled.12',
        'docx'        => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'dot'         => 'application/msword',
        'dotm'        => 'application/vnd.ms-word.template.macroEnabled.12',
        'dotx'        => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
        'dtd'         => 'text/dtd',
        'eps'         => 'application/postscript',
        'gif'         => 'image/gif',
        'htm'         => 'text/htm',
        'html'        => 'text/html',
        'ico'         => 'image/x-icon',
        'ifd'         => 'application/octet-stream', # Jet Form
        'jpe'         => 'image/jpe',
        'jpeg'        => 'image/jpeg',
        'jpg'         => 'image/jpeg',
        'pdf'         => 'application/pdf',
        'png'         => 'image/png',
        'properties'  => 'application/octet-stream',
        'mp3'         => 'audio/mpeg',
        'potm'        => 'application/vnd.ms-powerpoint.template.macroEnabled.12',
        'potx'        => 'application/vnd.openxmlformats-officedocument.presentationml.template',
        'ppam'        => 'application/vnd.ms-powerpoint.addin.macroEnabled.12',
        'pps'         => 'application/vnd.ms-powerpoint',
        'ppsm'        => 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12',
        'ppsx'        => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
        'ppt'         => 'application/vnd.ms-powerpoint',
        'pptm'        => 'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
        'pptx'        => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'ps'          => 'application/postscript',
        'rtf'         => 'application/rtf',
        'sgm'         => 'text/sgml',
        'sgml'        => 'text/sgml',
        'swf'         => 'application/x-shockwave-flash',
        'tif'         => 'image/tiff',
        'tiff'        => 'image/tiff',
        'txt'         => 'text/plain',
        'xhtml'       => 'text/html',
        'xlam'        => 'application/vnd.ms-excel.addin.macroEnabled.12',
        'xls'         => 'application/vnd.ms-excel',
        'xlsb'        => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
        'xlsm'        => 'application/vnd.ms-excel.sheet.macroEnabled.12',
        'xlsx'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'xltm'        => 'application/vnd.ms-excel.template.macroEnabled.12',
        'xltx'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
        'xml'         => 'text/xml',
        'zip'         => 'application/zip');

    /**
     * Write contents to a file
     * @param  $filename
     * @param  $contents
     */
    static function write( $filename, $contents )
    {
        file_put_contents($filename, $contents);
    }

    /**
     * Get contents of a file
     * @param  string $filename
     * @return mixed  $contents
     */
    static function read( $filename )
    {
        return file_get_contents($filename);
    }

    /**
     * Get contents of a file and split lines into array
     * @param  string $filename
     * @return array
     */
    static function readToArray( $filename )
    {
        $contents = file_get_contents($filename);
        return explode("\n", $contents);
    }

    /**
     * Check if a file exists
     * @param  string $filename
     * @return boolean
     */
    static function exists( $filename )
    {
        return is_file($filename);
    }

	/**
     * Delete a file
     * @param  string $filename
     */
    static function delete( $filename )
    {
        if (file_exists( $filename )) {
            return unlink($filename);
        }
    }

	/**
     * Create a blank file
     * @param  $filename
     */
    static function touch( $filename )
    {
        file_put_contents($filename, null);
    }

    /**
     * Highlight given file with PHP syntax
     * @param  string $filename
     * @param  boolean $return
     * @return string or null
     */
    static function highlight( $filename )
    {
        return highlight_file($filename, true);
    }

    /**
     * Obtain extension of a filename
     * @param  string $filename
     * @return string
     */
    static function getExtension( $filename )
    {
        return end(explode(".", $filename));
    }

    /**
     * Obtain mimetype of a filename
     * @param  string $filename
     * @return string
     */
    static function getMimeType( $filename )
    {
        $extension = self::getExtension( $filename );
        if (!isset(self::$_mimeTypes[$extension])) {
            throw new Ztools_File_Exception('Unknown extension: ' . $filename);
        }
        return self::$_mimeTypes[$extension];
    }

}

