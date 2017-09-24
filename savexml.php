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
    
    $english_title = $_POST["englishtitle"];
    $arabic_title = $_POST["arabictitle"];
    $english_description = $_POST["englishtext"];
    $arabic_description = $_POST["arabictext"];
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
$editing_node->english->description = $english_description;
$editing_node['fadetime'] = $duration;


$xml->asXml('content.xml');

header( 'Location: edit/slideshow.html' ) ;

?>