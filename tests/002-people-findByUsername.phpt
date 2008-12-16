--TEST--
Services_Flickr_People::findByUsername()
--FILE--
<?php

require_once 'tests-config.php';

$ppl = Services_Flickr::factory('People');
$person = $ppl->findByUsername(array(
    'username' => 'joestump'
));

echo $person->user['nsid'];

?>
--EXPECT--
36998705@N00
