<?php

namespace App;

class Client
{
    public $location;
    public $host;
    public $userAgent;
    public $date;
    public $referer;
    public $os;
    public $browser;
    public $cookies;
    public $url;

    public function __construct(array $data)
    {
        $this->location      = $data['location'];
        $this->referer       = $data['referer'];
        $this->userAgent     = $data['userAgent'];
        $this->date          = $data['date'];
        $this->host          = $data['host'];
        $this->os            = $data['os'];
        $this->browser       = $data['browser'];
        $this->cookies       = $data['cookies'];
        $this->referer       = $data['referer'];
        $this->url           = $data['url'];
    }
}