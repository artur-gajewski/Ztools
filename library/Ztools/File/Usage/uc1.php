<?php

/**
 * Create a new file and write content to it
 */
Ztools_File::write('MyFile.txt', 'This is content for MyFile.txt');

/**
 * Read file contents into a variable
 */
$contents = Ztools_File::read('MyFile.txt');

/**
 * Read file contents into an array
 */
$contents = Ztools_File::readToArray('MyFile.txt');

/**
 * Delete a file
 */
Ztools_File::delete('MyFile.txt');

/**
 * Create a blank file
 */
Ztools_File::touch('MyNewFile.txt');

/**
 * Get an extension of given file name
 */
$extension = Ztools_File::getExtension('MyNewFile.txt');

/**
 * Check if a file exists
 */
$exists = Ztools_File::exists('MyNewFile.txt');

/**
 * Get the mimetype of the file
 */
$mimetype = Ztools_File::getMimeType('MyNewFile.txt');