<?php

namespace App;

class Client
{
    protected $location;
    protected $host;
    protected $userAgent;
    protected $date;

    public function __construct(array $data)
    {
        $this->location      = $data['location'];
        $this->host          = $data['host'];
        $this->userAgent     = $data['userAgent'];
        $this->date          = $data['date'];
    }
}