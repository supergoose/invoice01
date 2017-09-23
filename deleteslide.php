<?php

//Go get the xml
include_once('formatcontent.php');
    

$slide_id = $_GET['slideId'];

//Sanity check
if(isset($slide_id))
{
    //delete this slide
    $one_to_delete = $xml->xpath('slide[@id="'.$slide_id.'"]')[0];
    unset($one_to_delete[0]);
    
    //Make sure the ids for the others all reduce to compensate
    foreach($xml->slide as $slide)
    {
        if($slide["id"] > $slide_id)
        {
            $slide["id"] = $slide["id"]-1;
        }
    }
    
    //Save
    $xml->asXml('content.xml');
}

?>