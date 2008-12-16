<?php

// Set our include paths
$path = ini_get('include_path');
ini_set('include_path', realpath('../') . ':' . $path);

require_once 'Services/Flickr.php';
Services_Flickr::$apiKey = '1a9122759f433ee479d788c83331efe3';
Services_Flickr::$sharedSecret = '674fe1c2775672da';

?>
