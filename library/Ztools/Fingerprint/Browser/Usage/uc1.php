<?php

/**
 * Method to get fingerprint of a browser client
 */

$fingerprint = new Ztools_Fingerprint_Browser();

$result = $fingerprint->create();

echo $result;