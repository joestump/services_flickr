<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Flickr API's photos geo class
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

require_once 'Services/Flickr/Common.php';

/**
 * Services_Flickr_Photos_Geo
 *
 * @category   Services
 * @package    Services_Flickr
 * @author     Joe Stump <joe@joestump.net> 
 * @copyright  1997-2006 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: @package_version@
 * @link       http://pear.php.net/package/Services_Flickr
 */
class Services_Flickr_Photos_Comments extends Services_Flickr_Common
{
    protected $group = 'photos.geo';
    protected $apiMap = array(
                'getLocation'               => array('photo_id' => true),

                'getPerms'                  => array('photo_id' => true),
        
                'removeLocation'            => array('photo_id' => true),

                'setLocation'               => array('photo_id' => true,
                                                     'lat' => true,
                                                     'lon' => true,
                                                     'accuracy' => true),

                'setPerms'                  => array('photo_id' => true,
                                                     'is_public' => true,
                                                     'is_contact' => true,
                                                     'is_friend' => true,
                                                     'is_family' => true)

    );
}

?>
