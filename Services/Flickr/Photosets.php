<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Flickr API's photosets class
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
 * Services_Flickr_Photosets
 *
 * @category   Services
 * @package    Services_Flickr
 * @author     Joe Stump <joe@joestump.net> 
 * @copyright  1997-2006 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: @package_version@
 * @link       http://pear.php.net/package/Services_Flickr
 */
class Services_Flickr_Photosets extends Services_Flickr_Common
{
    protected $group = 'photosets';
    protected $apiMap = array(
                'addPhoto'                  => array('photoset_id' => true,
                                                     'photo_id' => true),

                'create'                    => array('title' => true,
                                                     'description' => false,
                                                     'primary_photo_id' => true),

                'delete'                    => array('photoset_id' => true),

                'editMeta'                  => array('photoset_id' => true,
                                                     'title' => true,
                                                     'description' => false),

                'editPhotos'                => array('photoset_id' => true,
                                                     'primary_photo_id' => true,
                                                     'photo_ids' => true),

                'getContext'                => array('photo_id' => true,
                                                     'photoset_id' => true),

                'getInfo'                   => array('photoset_id' => true),

                'getList'                   => array('user_id' => true),

                'getPhotos'                 => array('photoset_id' => true,
                                                     'extras' => true,
                                                     'privacy_filter' => false),

                'orderSets'                 => array('photoset_ids' => true),
    
                'removePhoto'               => array('photoset_id' => true,
                                                     'photo_id' => true)
    );
}

?>
