--TEST--
Services_Flickr_People::findByEmail()
--FILE--
<?php

require_once 'tests-config.php';

$ppl = Services_Flickr::factory('People');
$person = $ppl->findByEmail(array(
    'find_email' => 'joe@joestump.net'
));

echo strval($person->user->username);

?>
--EXPECT--
joestump
