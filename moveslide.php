<?php

//Go get the content.xml
include('formatcontent.php');

   

$from = $_GET['from'];
$to = $_GET['to'];

//Sanity check
if(isset($from) && isset($to))
{
    //delete this slide
    $one_to_move = $xml->xpath('slide[@id="'.$from.'"]')[0];
    
    $one_to_move['id'] = $to;
    
    //Make sure the ids for the others all reduce to compensate
    foreach($xml->slide as $slide)
    {
        if($one_to_move != $slide)
        {
        
            if($slide["id"] < $from && $slide['id'] >= $to)
            {
                echo "Increasing id: " . $slide['id'];
                $slide['id'] = $slide['id']+1;
            }else if($slide['id'] > $from && $slide['id'] <= $to)
            {
                echo "Decreasing id: " . $slide['id'];
                $slide['id'] = $slide['id']-1;
            }
        }
        
    }
    
    
    //Save
    $xml->asXml('content.xml');
}

?>