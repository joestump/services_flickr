<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Flickr API's common base class
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category    Services
 * @package     Services_Flickr
 * @author      Joe Stump <joe@joestump.net> 
 * @copyright   1997-2006 The PHP Group
 * @license     http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version     CVS: $Id:$
 * @link        http://pear.php.net/package/Services_Flickr
 */

require_once 'PEAR/Exception.php';
require_once 'Services/Flickr.php';

/**
 * A method is not implemented
 *
 * @global      int         SERVICES_FLICKR_ERROR_NOT_IMPLEMENTED
 */
define('SERVICES_FLICKR_ERROR_NOT_IMPLEMENTED',         -1);

/**
 * You provided invalid options
 *
 * @global      int         SERVICES_FLICKR_ERROR_INVALID_OPTIONS
 */
define('SERVICES_FLICKR_ERROR_INVALID_OPTIONS',         -2);

/**
 * You did not provide a valid API Key
 *
 * @global      int         SERVICES_FLICKR_ERROR_API_KEY
 * @link        http://www.flickr.com/services/api/key.gne
 */
define('SERVICES_FLICKR_ERROR_INVALID_API_KEY',         -4);

/**
 * Flickr's XML response wasn't valid XML or some other error
 *
 * @global      int         SERVICES_FLICKR_ERROR_INVALID_RESPONSE
 * @link        http://www.flickr.com/services/api/key.gne
 */
define('SERVICES_FLICKR_ERROR_INVALID_RESPONSE',        -8);

/**
 * An error occurred on request
 * 
 * @global      int         SERVICES_FLICKR_ERROR_REQUEST
 */
define('SERVICES_FLICKR_ERROR_REQUEST',                -16);

/**
 * Services_Flickr_Common
 *
 * @category    Services
 * @package     Services_Flickr
 * @author      Joe Stump <joe@joestump.net> 
 * @copyright   1997-2006 The PHP Group
 * @license     http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version     Release: @package_version@
 * @link        http://pear.php.net/package/Services_Flickr
 */
abstract class Services_Flickr_Common
{
    /**
     * $apiURI
     *
     * @access      protected
     * @var         string      $apiURI     The URI of the Flickr REST API
     * @link        http://www.flickr.com/services/api/explore/
     */
    protected $apiURI = 'http://api.flickr.com/services/rest/';

    /**
     * __call
     *
     * @access      public
     * @param       string      $function   Name of function
     * @param       array       $args       Arguments for function
     */
    public function __call($function, $args)
    {
        if (!strlen(Services_Flickr::$apiKey)) {
            throw new Services_Flickr_Exception('You must specify an API Key', SERVICES_FLICKR_ERROR_INVALID_API_KEY);
        }

        if (!isset($this->apiMap[$function])) {
            throw new Services_Flickr_Exception('Unsupported or invalid API method: '. $function, SERVICES_FLICKR_ERROR_NOT_IMPLEMENTED);
        }

        $options = array();
        if (count($args) > 1) {
            throw new Services_Flickr_Exception('Only a single argument, $options, is allowed for all API methods', SERVICES_FLICKR_ERROR_INVALID_OPTIONS);
        } else {
            if (isset($args[0])) {
                $options = $args[0];
            }
        }

        $sets = array('api_key=' . Services_Flickr::$apiKey,
                      'method=flickr.' . $this->group . '.' . $function);

        if (count($options)) {
            foreach ($this->apiMap[$function] as $opt => $required) {
                if ($required == true && !isset($options[$opt])) {
                    throw new Services_Flickr_Exception('Required options not provided: '.$opt, SERVICES_FLICKR_ERROR_INVALID_OPTIONS);
                }

                if (isset($options[$opt])) {
                    $value = $options[$opt];

                    // Flickr has a lot of fields that are comma deliminated.
                    // We allow you to pass an array() to these fields and then
                    // add the comma delimination automatically.
                    if (is_array($options[$opt])) {
                        $value = implode(',', $options[$opt]);
                    } 

                    $sets[] = $opt.'='.urlencode($value);
                }
            }
        }

        $url = $this->apiURI . '?' . implode('&', $sets);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        if ($result === false) {
            throw new Services_Flickr_Exception('curl: ' . curl_error($ch), SERVICES_FLICKR_ERROR_REQUEST, $url);
        } 
        curl_close($ch);

        $xml = @simplexml_load_string($result);
        if (!$xml instanceof SimpleXmlElement) {
            throw new Services_Flickr_Exception('An invalid response was returned', SERVICES_FLICKR_ERROR_INVALID_RESPONSE, $url);    
        }

        if (isset($xml->err)) {
            $code = intval($xml->err['code']);
            $msg  = strval($xml->err['msg']);
            throw new Services_Flickr_Exception($msg, $code, $url); 
        }

        return $xml;
    }

    /**
     * signature
     *
     * This function can be used to retrieve just the api_sig for a given 
     * request. 
     *
     * @author      Joe Stump <joe@joestump.net>
     * @access      public
     * @param       array       $options        Full list of options in request
     * @return      string      The api_sig field
     */
    public function signature($options)
    {
        if (!strlen(Services_Flickr::$sharedSecret)) {
            throw new Services_Flickr_Exception('You must provide a valid shared secret to use authentication / sign requests');
        }

        $signature  = Services_Flickr::$sharedSecret;
        ksort($options);
        foreach ($options as $key => $val) {
            $signature .= $key . $val;
        }

        return md5($signature);
    }
}

?>
