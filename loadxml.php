<?php

//Go get the xml
include_once('formatcontent.php');
    

$slide_id = $_GET['slideId'];

//If we are only getting one slide, go get it. Otherwise get all.
if(isset($slide_id))
{
    print_r(json_encode($slides[$slide_id]));
}else{
    //Return it as json encoded
    print_r(json_encode($slides));
}

?>