<?php

// Create the object and set the title for debug chain
$debugger = new Ztools_Debug("My debug chain 1");

// Add first debug point but don't echo it
$debugger->add("First leg");

// Add debug point and echo it's information
$debugger->add("Second leg", true);

// Add third debug point
$debugger->add("Third leg");

// Dump the debug chain
$debugger->dump();

// Dump the chain, reset it and set new title for it
$debugger->dump(true, true, "My debug chain 2");

// Add fourth leg afte resetting the container
// Should be first debug point now.
$debugger->add("Fourth leg");

// Dump the messages again but don't the reset container
$debugger->dump();

// Place debug into a variable
$myDebugInfo = $debugger->dump(false);

// Get the overall elapsed time
$myDebugTime = $debugger->getElapsedTime();

// Get the debug of last leg
$debugger->getLastLeg();

// Reset the debug chain and set new title for it
$debugger->reset("My final debug chain");