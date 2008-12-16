--TEST--
Services_Flickr_People::getInfo()
--FILE--
<?php

require_once 'tests-config.php';

$ppl = Services_Flickr::factory('People');
$info = $ppl->getPublicGroups(array(
    'user_id' => '36998705@N00'
));

foreach ($info->groups as $g) {
    if ($g->group['name'] == 'tuaw') {
        echo $g->group['name'] . "\n";
        echo $g->group['nsid'] . "\n";
    }
}

?>
--EXPECT--
tuaw
41224503@N00
