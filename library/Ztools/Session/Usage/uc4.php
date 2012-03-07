<?php

/**
 * Adding data container to session
 */

$session->setData( array( "Foo" => "Bar",
                          "Bar" => "Foo" ) );

$myData = $session->getData();