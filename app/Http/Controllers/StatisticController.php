<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Client;
use App\Http\Requests;
use Illuminate\Support\Facades\Redis;

class StatisticController extends Controller
{
    public function addClient(Request $request)
    {
        $data = $request->all();
        $client = array();
        $client['location'] = $data;
        $client['host'] = $_SERVER['HTTP_REFERER'];
        $client['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
        $client['date'] = time();
        $client = new Client($client);

        Redis::connection();
        Redis::set('session_'.$request->session()->getId().'_'.time(), serialize($client));
        Redis::lpush('key_test', (string)time());
        return Redis::get('session_'.$request->session()->getId().'_'.time());
    }
}
