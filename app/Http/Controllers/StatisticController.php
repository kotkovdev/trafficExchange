<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models;

class StatisticController extends Controller
{
    public function addClient(Request $request)
    {
        $location = $request->all();
        $data['location'] = $location;
        $data['referer'] = parse_url($location['referer'])['host'];
        $data['host'] = $location['ip'];
        $data['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
        $data['cookies'] = $_COOKIE['client'];
        $data['url'] = $location['url'];
        $statistic = new Models\Statistic($request);
        $statistic->addClient($data);
    }

    public function getStatistic(Request $request)
    {
        $statistic = new Models\Statistic($request);
        $stat = $statistic->getStatistic(array('type' => 'browsers'));
        $stat['hosts'] = $statistic->getHostStatistic();
        $stat['cookies'] = $statistic->getCookieStatistic();
        $stat['hits_count'] = count($stat['clients']);
        $stat['hosts_count'] = count($stat['hosts']);
        $content = view('admin.statistic', $stat);
        return view('admin.template', array('content' => $content));
    }
}
