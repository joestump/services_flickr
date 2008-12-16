--TEST--
Services_Flickr_People::getInfo()
--FILE--
<?php

require_once 'tests-config.php';

$ppl = Services_Flickr::factory('People');
$info = $ppl->getInfo(array(
    'user_id' => '36998705@N00'
));

echo $info->person['nsid'] . "\n";
echo $info->person->username . "\n";

?>
--EXPECT--
36998705@N00
joestump
