<?php

/**
 * Creating a session with five page load expiration
 */

Zend_Session::start();

$session = new Ztools_Session( 'Blaa' );
$session->setHops(5)
        ->start();
