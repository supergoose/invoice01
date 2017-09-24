<?php

//Go get the xml
include_once('formatcontent.php');

//Get the number of slides
$slideId = sizeof($slides); //this is also our new id

//Sanity check
$slide = $xml->addChild('slide');
$slide->addAttribute('id', $slideId);
$slide->addAttribute('enabled', 'yes');
$slide->addAttribute('fadetime', 5.0);
$slide->addChild('background');
$slide_english = $slide->addChild('english');
$slide_english->addChild('title', 'Enter English title');
$slide_english->addChild('description', 'Enter English description');
$slide_arabic = $slide->addChild('arabic');
$slide_arabic->addChild('title', 'Enter Arabic title');
$slide_arabic->addChild('description', 'Enter Arabic description');

//Save
$xml->asXml('content.xml');
print_r($slideId);

?>