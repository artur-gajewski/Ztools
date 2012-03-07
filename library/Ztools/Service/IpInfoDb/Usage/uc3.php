<?php

/**
 * Method to fetch URL for the Google Maps location of given domain or IP address.
 */

$ipData = new Zend_Service_IpInfoDb();
$ipData->setIp('zend.com');
$ipData->fetch();

$url = $ipData->getGoogleMapsUrl();

echo '<a href="' . $url . '">Link to Google Map location of this IP address </a>';