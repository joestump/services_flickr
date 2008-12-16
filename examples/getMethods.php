<?php

require_once 'Services/Flickr/Reflection.php';

$flickr = new Services_Flickr_Reflection();
$flickr->apiKey = 'YOURXXXAPIXXXXXXKEYXXXXXXHEREXXX';
try {
    $result = $flickr->getMethods();
    echo $result->asXML();
} catch (PEAR_Exception $error) {
    echo $error->getMessage()."\n";
}

?>
