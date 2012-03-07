<?php

/**
 * Instanciate Ztools_Ftp object by supporting server, username and password
 */
$ftp = new Ztools_Ftp('ftp.arturgajewski.com', 'arturnmd', 'salaisuus1');

/**
 * Connect to FTP server
 */
$ftp->connect();

/**
 * Get an array representation of current remote directory contents
 */
$files = $ftp->listFiles('public_html');

/**
 * Download file myRemoteFile.txt into local directory and myLocalFile.txt
 */
$ftp->get('myRemoteFile.txt', 'myLocalFile.txt');

/**
 * Upload file mylocalFile.txt into remote directory and myRemoteFile.txt
 */
$ftp->put('myLocalFile.txt', 'myRemoteFile.txt');

/**
 * Rename a file on current remote directory
 */
$ftp->rename('oldname.txt', 'newname.txt');