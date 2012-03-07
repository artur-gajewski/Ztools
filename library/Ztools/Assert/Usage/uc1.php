<?php

// Create the data to create asserts against
$data = 'This is a string to be asserted';

// Instantiate Zend_Validate object and add Ztools_Assert_String validator.
$assert = new Ztools_Assert();
$assert->add(new Ztools_Assert_String());

// Check if assertion passed
$assert->isValid($data);

