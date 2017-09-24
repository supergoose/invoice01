<?php

//Go get the content.xml
include('formatcontent.php');

//Edit this node as slide[node id]
$slide_id = $_POST["slideId"];

//sanitize strings
$english_title = $_POST["englishtitle"];
$arabic_title = $_POST["arabictitle"];
$english_description = $_POST["englishtext"];
$arabic_description = $_POST["arabictext"];
$duration = $_POST["duration"];

$editing_node = $xml->xpath('slide[@id="'.$slide_id.'"]')[0];

$editing_node->english->title = $english_title;
$editing_node->arabic->title = $arabic_title;
$editing_node->english->description = $english_description;
$editing_node['fadetime'] = $duration;


$xml->asXml('content.xml');

header( 'Location: edit/slideshow.html' ) ;

?>