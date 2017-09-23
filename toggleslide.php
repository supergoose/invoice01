<?php

//Go get the content.xml
include('formatcontent.php');

//Edit this node as slide[node id]
$slide_id = $_GET["slideId"];
$editing_node = $xml->xpath('slide[@id="'.$slide_id.'"]')[0];

//Toggle
$editing_node['enabled'] = ($editing_node['enabled'] == 'yes')?"no":"yes";

echo ($editing_node['enabled'] == 'yes')?"1":"0";

//Save
$xml->asXml('content.xml');



?>