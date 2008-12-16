<?php

class Services_Flickr_Exception extends PEAR_Exception
{
    private $lastCall = '';

    public function __construct($message = null, $code = 0, $lastCall = '')
    {
        parent::__construct($message, $code);
        $this->lastCall = $lastCall;
    }

    public function getLastCall()
    {
        return $this->lastCall;
    }
}

?>
