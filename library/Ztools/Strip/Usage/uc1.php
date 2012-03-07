<?php

$data = file_get_contents('my_homepage.html');
    
$stripper = new Ztools_Strip();
    
$stripper->setData($data)
         ->addRemoveOnlyTag(array('title', 'a', 'b'))
         ->addRemoveTag(array('br', 'meta','link','span'))
         ->setRemoveComments(true)
         ->setRemoveEmptyBlocks(true)
         ->setRemoveBlankLines(true)
         ->strip();
             
echo $stripper->getResult();