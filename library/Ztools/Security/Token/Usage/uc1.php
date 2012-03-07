<?php

/**
 * Method to randomly generate session token and also to validate tokens.
 */

$sessionToken = new Ztools_Security_Token();
$token = $sessionToken->generate();

$isValid = $sessionToken->isValid($_POST['token']);
