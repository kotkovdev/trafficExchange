<?php

namespace App\Models;

use Illuminate\Support\ServiceProvider;

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
        $this->key = 'session:s'.$this->request->session()->getId().'_'.time();
    }

    public function addClient($client)
    {
        $client['date']     = $this->timestamp;
        $client['os']       = \BrowserDetect::detect()['osFamily'];
        $client['browser']  = \BrowserDetect::detect()['browserFamily'];

        $this->client = new Client($client);
        Redis::set($this->key, serialize($this->client));
        Redis::lpush('browser:'.$client['browser'], $this->key);
        Redis::lpush('os:'.$client['os'], $this->key);
        Redis::lpush('country:'.$client['location']['country'], $this->key);
        Redis::lpush('region:'.$client['location']['region'], $this->key);
        Redis::lpush('city:'.$client['location']['city'], $this->key);
        Redis::lpush('cookie:'.$this->client->cookies, $this->key);
        Redis::lpush('host:'.$this->client->host, $this->key);
    }

    public function getStatistic(array $params)
    {
        switch($params['type']){
            case 'browsers':
                return $this->getBrowsersStatistic();
                break;
            case 'regions':
                return $this->getRegionStatistic();
                break;
        }
    }

    public function getBrowsersStatistic()
    {
        $browsers = Redis::keys('browser:*');
        $return = array();
        $clients = array();
        foreach($browsers as $browser) {
            $hits = Redis::command('lrange', [$browser, 0, 100]);
            foreach($hits as $hit) {
                $client = unserialize(Redis::get($hit));
                $clients[] = $client;
            }
        }
        $return['clients'] = $clients;
        return $return;
    }

    public function getRegionStatistic()
    {
        $regions = Redis::keys('Region:*');
        $return = array();
        $clients = array();
        foreach($regions as $region) {
            $hits = Redis::command('lrange', [$region, 0, 100]);
            foreach($hits as $hit) {
                $client = unserialize(Redis::get($hit));
                $clients[] = $client;
            }
        }
        $return['clients'] = $clients;
        return $return;
    }

    public function getHostStatistic()
    {
        $hosts = Redis::keys('host:*');
        $return = array();
        foreach($hosts as $host) {
            $clients = array();
            $client = Redis::command('lrange', [$host, 0, 10000]);
            foreach($client as $cl){
                $clients[] = Redis::get($cl);
            }
            $urls = array();
            foreach($clients as $client){
                $client = unserialize($client);
                $search = array_search($client->url, $urls);
                if(is_array($urls) && $search === false){
                    $urls[] = $client->url;
                    $return[] = $client;
                }
            }
            unset($urls);
            unset($clients);
        }
        return $return;
    }

    public function getCookieStatistic()
    {
        $cookies = Redis::keys('cookie:*');
        $return = array();
        foreach($cookies as $cookie) {
            $clients = array();
            $client = Redis::command('lrange', [$cookie, 0, 10000]);
            foreach($client as $cl){
                $clients[] = Redis::get($cl);
            }
            $urls = array();
            foreach($clients as $client){
                $client = unserialize($client);
                $search = array_search($client->url, $urls);
                if(is_array($urls) && $search === false){
                    $urls[] = $client->url;
                    $return[] = $client;
                }
            }
            unset($urls);
            unset($clients);
        }
        return $return;
    }
}
