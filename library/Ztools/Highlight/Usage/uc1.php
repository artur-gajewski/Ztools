<?php

/**
 * Method to search for keywords and highlight them for output.
 */

$strings = array("Hello world!",
                 "What a wonderful world",
                 "This component is cool");

$keywords = array("hello",
                  "wonderful",
                  "cool");

$highlighter = new Ztools_Highlight();
$highlighter->addString($strings)
            ->addKeyword($keywords)
            ->setHtmlClass('myClass')
            ->highlight();
    
$results = $highlighter->getResults();

foreach ($results as $paragraph) {
    echo '<p>' . $paragraph . '</p>';
}