<?php

/**
 * Method to randomly generate strong passwords.
 */

$password = new Ztools_Security_Password();

echo $password->generate();
