<?php

function sort_slides($s1, $s2)
{
    //echo $s1['id'];
    return $s1['id']-$s2['id'];
}

$slides;
$xml;

//Check if xml file exists
if(file_exists('content.xml'))
{
    
    //If so, load the file
    $xml = simplexml_load_file('content.xml');

    //Sort the nodes according to their id (which the user can changes)
    foreach($xml->slide as $slide)
    {
        $slides[] = $slide;
    }
    usort($slides, 'sort_slides');
    
}else{
    
    //Failed
    exit('Failed to find file content.xml');
}

?>