<?php

/**
 * Method to fetch information of given IP address.
 */

$ipData = new Zend_Service_IpInfoDb();
$ipData->setIp('64.255.169.100');
$ipData->fetch();

$countryCode = $ipData->countryCode;
$countryName = $ipData->countryName;

$ipArray = $ipData->toArray();