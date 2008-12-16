<?php

require_once 'Services/Flickr/Photos.php';

$flickr = new Services_Flickr_Photos();
$flickr->apiKey = 'YOURXXXAPIXXXXXXKEYXXXXXXHEREXXX';
try {
    $result = $flickr->getRecent();
    foreach ($result->photos->photo as $photo) {
        echo $photo['id']."\n";
    }
} catch (PEAR_Exception $error) {
    echo $error->getMessage()."\n";
}

?>
