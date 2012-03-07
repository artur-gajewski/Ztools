<?php

/**
 * Ztools_Ftp component is used to easily create FTP connection to server
 * and managing files on it. Upload, download, delete, rename among other
 * features are available.
 *
 * @copyright  2010 Artur Gajewski
 * @license    http://framework.zend.com/license   BSD License
 * @version    Release: @package_version@
 * @link       http://ztools.arturgajewski.com
 * @since      Class available since Release 1.2.3
 */
class Ztools_Ftp
{
    /**
     * @var $connectionId
     */
    private $connectionId;

    /**
     * @var $host
     */
    private $host;

    /**
     * @var $username
     */
    private $username;

    /**
     * @var $password
     */
    private $password;

    /**
     * @var $port
     */
    private $port;

    /**
     * @var $timeout
     */
    public $timeout = 60;

    /**
     * @var $passive
     */
    public $passive = false;

    /**
     * @var $ssl
     */
    public $ssl = false;

    /**
     * @var $sysType
     */
    public $sysType = '';

    /**
     * The constructor
     */
    public function __construct($host, $username, $password, $port = 21)
    {
        $this->host     = $host;
        $this->username = $username;
        $this->password = $password;
        $this->port     = $port;
    }

    /*
     * The destructor
     */
    public function __destruct()
    {
        if ($this->connectionId)
        {
            ftp_close($this->connectionId);
        }
    }

    /**
     * Connect to the server
     * @return boolean
     */
    public function connect()
    {
        if ($this->ssl == false) {
            $this->connectionId = ftp_connect($this->host, $this->port);
        } else {
          if (function_exists('ftp_ssl_connect')) {
              $this->connectionId = ftp_ssl_connect($this->host, $this->port);
          } else {
              return false;
          }
        }

        $result = ftp_login($this->connectionId, $this->username, $this->password);

        if ($result == true) {
            ftp_set_option($this->connectionId, FTP_TIMEOUT_SEC, $this->timeout);

            if ($this->passive == true) {
                ftp_pasv($this->connectionId, true);
            } else {
                ftp_pasv($this->connectionId, false);
            }

            $this->sysType = ftp_systype($this->connectionId);

            return true;
        } else {
            return false;
        }
    }

    /**
     * Obtain server's current directory path
     * return string
     */
    public function getCurrentDirectory()
    {
        return ftp_pwd($this->connectionId);
    }

    /**
     * Change server's directory
     * @param $directory
     */
    public function chdir($directory)
    {
        ftp_chdir($this->connectionId, $directory);
    }

    /**
     * Create a directory on the server
     * @param $directory
     * @return boolean
     */
    public function makeDirectory($directory)
    {
        if (ftp_mkdir($this->connectionId, $directory)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Remove a directory from the server
     * @param $directory
     * @return boolean
     */
    public function removeDirectory($directory)
    {
        if (ftp_rmdir($this->connectionId, $directory)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Create an array of files and directories
     * @param $directory
     * @return array $contents
     */
    public function listFiles($directory)
    {
        $contents = ftp_nlist($this->connectionId, $directory);
        return $contents;
    }

    /**
     * Upload a file to the server
     * @param $localFilePath
     * @param $remoteFilePath
     * @param $mode
     * @return boolean
     */
    public function put($localFilePath, $remoteFilePath, $mode = FTP_ASCII)
    {
        if (ftp_put($this->connectionId, $remoteFilePath, $localFilePath, $mode)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Download a file from the server
     * @param $localFilePath
     * @param $remoteFilePath
     * @param $mode
     * @return boolean
     */
    public function get($localFilePath, $remoteFilePath, $mode = FTP_ASCII)
    {
        if (ftp_get($this->connectionId, $localFilePath, $remoteFilePath, $mode)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Change permission on the server's file
     * @param $permissions
     * @param $remoteFilename
     * @return boolean
     * @throws Ztools_Ftp_Exception
     */
    public function chmod($permissions, $remoteFilename)
    {
      if ($this->isOctal($permissions)) {
          $result = ftp_chmod($this->connectionId, $permissions, $remoteFilename);
          if ($result) {
              return true;
          } else {
              return false;
          }
      } else {
          throw new Ztools_Ftp_Exception('Permission must be entered in octal format');
      }
    }

    /**
     * Delete a file on the server
     * @param $remoteFilePath
     * @return boolean
     */
    public function delete($remoteFilePath)
    {
        if (ftp_delete($this->connectionId, $remoteFilePath)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Rename a file on the server
     * @param $oldName
     * @param $newName
     * @return boolean
     */
    public function rename($oldName, $newName)
    {
        if (ftp_rename($this->connectionId, $oldName, $newName)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if given value is octal
     * @param $value
     * @return boolean
     */
    private function isOctal($value) {
        return decoct(octdec($value)) == $value;
    }

}