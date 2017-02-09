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
        $data['referer'] = $_SERVER['HTTP_REFERER'];
        $data['host'] = $_SERVER['REMOTE_ADDR'];
        $data['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
        
        $statistic = new Models\Statistic($request);
        $statistic->addClient($data);
    }
}
