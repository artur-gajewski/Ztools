<?php

/**
 * Method to fetch IP information of given domain.
 */

$ipData = new Zend_Service_IpInfoDb();
$ipData->setIp('zend.com');
$ipData->fetch();

$countryCode = $ipData->countryCode;
$countryName = $ipData->countryName;

$ipArray = $ipData->toArray();