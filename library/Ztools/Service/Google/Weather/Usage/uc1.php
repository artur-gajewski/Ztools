<?php

/**
 * Method to fetch weather forecast for given city
 * from the Google Weather API.
 */

$gweather = new Ztools_Service_Google_Weather();
$gweather->setCityName('Helsinki')
         ->setLanguage('fi')
         ->setCelsius(true);
$weather = $gweather->fetch();

// Get the current weather of Helsinki
echo $weather['current']['temperature'] . '<br/>';
echo $weather['current']['condition'] . '<br/>';
echo $weather['current']['icon'] . '<br/>';

// Get tomorrow's forecast for Helsinki
echo $weather['forecast'][0]['low'] . '<br/>';
echo $weather['forecast'][0]['high'] . '<br/>';
echo $weather['forecast'][0]['condition'] . '<br/>';
echo $weather['forecast'][0]['icon'] . '<br/>';