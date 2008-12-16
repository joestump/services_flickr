<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * An implementation of Flickr's API
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Services
 * @package    Services_Flickr
 * @author     Joe Stump <joe@joestump.net> 
 * @copyright  1997-2006 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    CVS: $Id:$
 * @link       http://pear.php.net/package/Services_Flickr
 */

define('SERVICES_FLICKR_PRIVACY_PUBLIC',                    1);
define('SERVICES_FLICKR_PRIVACY_FRIENDS',                   2);
define('SERVICES_FLICKR_PRIVACY_FAMILY',                    3);
define('SERVICES_FLICKR_PRIVACY_FRIENDS_FAMILY',            4);
define('SERVICES_FLICKR_PRIVACY_PRIVATE',                   5);

define('SERVICES_FLICKR_PERMS_COMMENT_NOBODY',              0);
define('SERVICES_FLICKR_PERMS_COMMENT_FRIENDS_FAMILY',      1);
define('SERVICES_FLICKR_PERMS_COMMENT_CONTACTS',            2);
define('SERVICES_FLICKR_PERMS_COMMENT_EVERYBODY',           3);

define('SERVICES_FLICKR_PERMS_META_NOBODY',                 0);
define('SERVICES_FLICKR_PERMS_META_FRIENDS_FAMILY',         1);
define('SERVICES_FLICKR_PERMS_META_CONTACTS',               2);
define('SERVICES_FLICKR_PERMS_META_EVERYBODY',              3);

require_once 'Services/Flickr/Common.php';
require_once 'Services/Flickr/Exception.php';

abstract class Services_Flickr 
{
    /**
     * $apiKey
     *
     * @access      public
     * @var         string      $apiKey     Your Flickr API Key
     * @link        http://www.flickr.com/services/api/key.gne
     * @static
     */
    static public $apiKey = '';

    /**
     * $sharedSecret
     *
     * Each API key is given a shared secret. You need to go to your API
     * keys page and then click "Edit Configuration/Not Configured" next to
     * the "Authentication" title for a given API key.
     *
     * @access      public
     * @var         string      $sharedSecret   Your API's shared secret
     * @link        http://www.flickr.com/services/api/key_setup.gne
     * @static
     */
    static public $sharedSecret = '';


    static public function factory($class)
    {
        $file = 'Services/Flickr/' . $class . '.php';
        require_once($file);
        $class = 'Services_Flickr_' . $class;
        if (!class_exists($class)) {
            throw new Services_Flickr_Exception('Invalid API class: ' . $class);
        }

        $instance = new $class();
        return $instance;
    }
}

?>
