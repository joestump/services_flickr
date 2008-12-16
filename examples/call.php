<?php

// Usage: 
// php -q call.php flickr.photos.getExif YOURXXXAPIXXXXXXKEYXXXXXXHEREXXX photo_id=249935855
// 
// Anything after the API key are arguments in the form of name=val with spaces
// in between.

$function = $argv[1];
$parts = explode('.', $function);
$function = array_pop($parts);
foreach ($parts as $i => $part) {
    $parts[$i] = ucwords($part);
}
$class = 'Services_' . implode('_', $parts);
$file = str_replace('_', '/', $class) . '.php';

require_once($file);
$flickr = new $class();
$flickr->apiKey = $argv[2];

$start = 3;
$stop = count($argv);
$parms = array();
for ($i = $start ; $i < $stop ; $i++) {
    if (isset($argv[$i])) {
        list($key,$val) = explode('=', $argv[$i]);
        $parms[$key] = $val;
    }
}

echo 'Calling '.$class.'::'.$function.'()'."\n";
echo 'Parameters: ';
print_r($parms);
echo "\n\n";

try {
    $result = $flickr->$function($parms);
    echo $result->asXML();
} catch (PEAR_Exception $error) {
    echo "ERROR: " . $error->getMessage() . " (Code: " . $error->getCode() . ")\n";
}

?>
