<?php

/**
 * Checking if session is valid, no expiration time resetting
 */

$isValid = $session->check();

/**
 * Checking if session is valid and resetting the expiration time
 */

$isValid = $session->check( true );