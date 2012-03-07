<?php

/**
 * Creating a session with one hour expiration
 */

Zend_Session::start();

$session = new Ztools_Session( 'Blaa' );
$session->setExpiration(3600)
        ->start();