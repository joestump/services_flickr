<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Flickr API's photos class
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
 * Services_Flickr_Photos
 *
 * @category   Services
 * @package    Services_Flickr
 * @author     Joe Stump <joe@joestump.net> 
 * @copyright  1997-2006 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: @package_version@
 * @link       http://pear.php.net/package/Services_Flickr
 */
class Services_Flickr_Photos extends Services_Flickr_Common
{
    protected $group = 'photos';
    protected $apiMap = array(
                'addTags'                   => array('photo_id' => true,
                                                     'tags' => true),

                'delete'                    => array('photo_id' => true),

                'getAllContexts'            => array('photo_id' => true),

                'getContactsPhotos'         => array('count' => false,
                                                     'just_friends' => false,
                                                     'single_photo' => false,
                                                     'include_self' => false,
                                                     'extras' => false),

                'getContactsPublicPhotos'   => array('user_id' => true,
                                                     'count' => false,
                                                     'just_friends' => false,
                                                     'single_photo' => false,
                                                     'include_self' => false,
                                                     'extras' => false),

                'getContext'                => array('photo_id' => true),
    
                'getCounts'                 => array('dates' => false,
                                                     'taken_dates' => false),

                'getExif'                   => array('photo_id' => true,
                                                     'secret' => false),

                'getInfo'                   => array('photo_id' => true,
                                                     'secret' => 'true'),

                'getNotInSet'               => array('min_upload_date' => false,
                                                     'max_upload_date' => false,
                                                     'min_taken_date' => false,
                                                     'max_taken_date' => false,
                                                     'privacy_filter' => false,
                                                     'extras' => false,
                                                     'per_page' => false,
                                                     'page' => false),
                
                'getPerms'                  => array('photo_id' => true),

                'getRecent'                 => array('extras' => false,
                                                     'per_page' => false,
                                                     'page' => false),

                'getSizes'                  => array('photo_id' => true),

                'getUntagged'               => array('min_upload_date' => false,
                                                     'max_upload_date' => false,
                                                     'min_taken_date' => false,
                                                     'max_taken_date' => false,
                                                     'privacy_filter' => false,
                                                     'extras' => false,
                                                     'per_page' => false,
                                                     'page' => false),

                'getWithGeoData'            => array('min_upload_date' => false,
                                                     'max_upload_date' => false,
                                                     'min_taken_date' => false,
                                                     'max_taken_date' => false,
                                                     'privacy_filter' => false,
                                                     'sort' => false,
                                                     'extras' => false,
                                                     'per_page' => false,
                                                     'page' => false),

                'getWithoutGeoData'         => array('min_upload_date' => false,
                                                     'max_upload_date' => false,
                                                     'min_taken_date' => false,
                                                     'max_taken_date' => false,
                                                     'privacy_filter' => false,
                                                     'sort' => false,
                                                     'extras' => false,
                                                     'per_page' => false,
                                                     'page' => false),

                'removeTag'                 => array('tag_id' => true),
            
                'search'                    => array('user_id' => false,
                                                     'tags' => false,
                                                     'tag_mode' => false,
                                                     'text' => false,
                                                     'min_upload_date' => false,
                                                     'max_upload_date' => false,
                                                     'min_taken_date' => false,
                                                     'max_taken_date' => false,
                                                     'license' => false,
                                                     'sort' => false,
                                                     'privacy_filter' => false,
                                                     'bbox' => false,
                                                     'accuracy' => false,
                                                     'extras' => false,
                                                     'per_page' => false,
                                                     'page' => false),

                'setDates'                  => array('photo_id' => true,
                                                     'date_posted' => false,
                                                     'date_taken' => false,
                                                     'date_taken_granularity' => false),
                
                'setMeta'                   => array('photo_id' => true,
                                                     'title' => true,
                                                     'description' => true),

                'setPerms'                  => array('photo_id' => true,
                                                     'is_public' => true,
                                                     'is_friend' => true,
                                                     'is_family' => true,
                                                     'perm_comment' => true,
                                                     'perm_addmeta' => true),

                'setTags'                   => array('photo_id' => true,
                                                     'tags' => true)
    );

    /**
     * Save a Flickr image locally
     *
     * Pass a photo element to this function and it will download the image
     * and write it into the file name given. You can optionally define which
     * size of the photo you wish to save.
     *
     * @access      public
     * @param       object      $photo      Photo to save
     * @param       object      $size       Size of photo to save
     * @param       string      $file       File to save contents to
     * @return      mixed       PEAR_Error or size of file written
     */
    public function save(SimpleXmlElement $photo, $file, $size = '')
    {
        $path = dirname($file);
        if (!is_writeable($path) || !is_dir($path)) {
            throw new Services_Flickr_Exception('Invalid path provided: ' . $path);
        }

        $url = 'http://static.flickr.com/' . $photo['server'] . 
               '/' . $photo['id'] . '_' . $photo['secret']; 
               
        if (strlen($size)) {
            $url .= '_' . $size;
        }
        
        $url .= '.jpg';

        $download = file_get_contents($url);
        if ($download === false) {
            throw new Services_Flickr_Exception('Invalid image URL: ' . $url);
        }

        $result = file_put_contents($file, $download);
        if ($result === false) {
            throw new Services_Flickr_Exception('Could not save to file: '.$file);
        }

        return $result;
    }
}

?>
