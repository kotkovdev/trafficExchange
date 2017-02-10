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
        Redis::lpush('ref:'.$this->client->referer, $this->key);
    }

    public function getStatistic(array $params)
    {
        return $this->getAllStatistic();
    }

    public function getAllStatistic()
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
            $hosts = array();
            foreach($clients as $client){
                $client = unserialize($client);
                $search = array_search($client->url, $urls);
                //$hSearch = array_search($client->host, $hosts);
                if(is_array($urls) && $search === false /*&& is_array($hosts) && $hSearch === false*/){
                    $urls[] = $client->url;
                    $hosts[] = $client->host;
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

    private function calcViews($data)
    {
        $return = array();
        foreach($data as $dt){
            $dt_name = explode(':', $dt)[1];
            $hits = Redis::command('lrange', [$dt, 0, 100]);
            $return[$dt_name]['name'] = $dt_name;
            $return[$dt_name]['hits'] = count($hits);
            $return[$dt_name]['cookies'] = 0;
            $return[$dt_name]['hosts'] = 0;
            foreach($hits as $hit){
                $clients = array();
                $client = unserialize(Redis::get($hit));
                $vizits = Redis::command('lrange', ['cookie:'.$client->cookies, 0, 1000]);
                foreach($vizits as $vizit){
                    $clients[] = Redis::get($vizit);
                }
                $urls = array();
                foreach($clients as $client){
                    $client = unserialize($client);
                    $search = array_search($client->url, $urls);
                    if(is_array($urls) && $search === false){
                        $urls[] = $client->url;
                        $return[$dt_name]['cookies'] += 1;
                    }
                }
                unset($urls);
                unset($clients);
                break;
            }
            foreach($hits as $hit){
                $clients = array();
                $client = unserialize(Redis::get($hit));
                $vizits = Redis::command('lrange', ['host:'.$client->host, 0, 1000]);
                foreach($vizits as $vizit){
                    $clients[] = Redis::get($vizit);
                }
                $urls = array();
                $hosts = array();
                foreach($clients as $client){
                    $client = unserialize($client);
                    $search = array_search($client->url, $urls);
                    //$hSearch = array_search($client->host, $hosts);
                    if(is_array($urls) && $search === false /*&& is_array($hosts) && $hSearch === false*/){
                        $urls[] = $client->url;
                        $hosts[] = $client->host;
                        $return[$dt_name]['hosts'] += 1;
                    }
                }
                unset($urls);
                unset($clients);
                break;
            }
        }
        return $return;
    }

    public function getBrowserStatistic()
    {
        $browsers = Redis::keys('browser:*');
        return $this->calcViews($browsers);
    }

    public function getRegionStatistic()
    {
        $regions = Redis::keys('region:*');
        return $this->calcViews($regions);
    }

    public function getOSStatistic()
    {
        $oss = Redis::keys('os:*');
        return $this->calcViews($oss);
    }

    public function getRefStatistic()
    {
        $refs = Redis::keys('ref:*');
        return $this->calcViews($refs);
    }
}
