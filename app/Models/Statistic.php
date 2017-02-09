<?php

namespace App\Models;

use App\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class Statistic
{
    protected $redis;
    protected $timestamp;
    protected $request;
    protected $client;
    protected $key;

    public function __construct($request)
    {
        $this->redis = Redis::Connection();
        $this->timestamp = time();
        $this->request = $request;
        $this->key = 'session_'.$this->request->session()->getId().'_'.time();
    }

    public function addClient($client)
    {
        $client['date'] = $this->timestamp;
        $this->client = new Client($client);
        Redis::set($this->key, serialize($this->client));
    }
}
