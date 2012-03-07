<?php

/**
 * Method to get fingerprint of a given strings within array
 */

$strings = array("This string should be fingerprinted",
                 "I wonder what this looks like",
                 "There are other types available also");

$fingerprint = new Ztools_Fingerprint_String();

$results = $fingerprint->create($strings);

foreach ($results as $fprint) {
	echo '<p>' . $fprint . '</p>';
}
