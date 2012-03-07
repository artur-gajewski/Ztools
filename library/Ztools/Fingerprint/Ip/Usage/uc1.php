<?php

/**
 * Method to get fingerprint of the request's IP address
 */

$fingerprint = new Ztools_Fingerprint_Ip();

$result = $fingerprint->create();

echo $result;