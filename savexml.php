<?php

//Go get the content.xml
include('formatcontent.php');

//Edit this node as slide[node id]
$slide_id = $_POST["slideId"];

//sanitize strings
$english_title = '';
$arabic_title = '';
$english_description = '';
$arabic_description = '';
$duration = '';


$background = $_POST['background'];

$img_extensions = array('jpg', 'jpeg', 'png');
$vid_extensions = array('mp4');
$ext = strtolower(pathinfo($background, PATHINFO_EXTENSION));
$type='';
if(in_array($ext, $img_extensions))
{
    $type='image';
    
    $english_title = filter_var ( $_POST["englishtitle"], FILTER_SANITIZE_STRING);
    $arabic_title = filter_var ( $_POST["arabictitle"], FILTER_SANITIZE_STRING);
    $english_description = filter_var ( $_POST["englishtext"], FILTER_SANITIZE_STRING);
    $arabic_description = filter_var ( $_POST["arabictext"], FILTER_SANITIZE_STRING);
    $duration = $_POST["duration"];
    
}else if(in_array($ext, $vid_extensions))
{
    $type='video';
    $english_title = explode('/', $background)[1];
}

$editing_node = $xml->xpath('slide[@id="'.$slide_id.'"]')[0];
$editing_node->background = $background;
$editing_node['type'] = $type;
$editing_node->english->title = $english_title;
$editing_node->arabic->title = $arabic_title;
$editing_node->english->description = nl2br(trim($english_description));
$editing_node->arabic->description = nl2br(trim($arabic_description));
$editing_node['fadetime'] = $duration;


$xml->asXml('content.xml');

header( 'Location: slideshow.html' ) ;

?>