<?php

namespace App;

class Client
{
    protected $location;
    protected $host;
    protected $userAgent;
    protected $date;
    protected $ip;

    public function __construct(array $data)
    {
        $this->location      = $data['location'];
        $this->referer          = $data['referer'];
        $this->userAgent     = $data['userAgent'];
        $this->date          = $data['date'];
        $this->host            = $data['host'];
    }
}