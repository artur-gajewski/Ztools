<?php

/**
 * Method to get fingerprint of a given string
 */

$fingerprint = new Ztools_Fingerprint_String();

$results = $fingerprint->create('Let me try to hash a string');

echo $results;