<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Statistic;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        if($request->session()->get('user_status')[0] != 'admin'){
            return redirect('/auth');
        }
        $statistic = new Statistic($request);
        $stat = array();
        $stat['browsers'] = $statistic->getBrowserStatistic();
        $stat['OS'] = $statistic->getOSStatistic();
        $stat['regions'] = $statistic->getRegionStatistic();
        $stat['refs'] = $statistic->getRefStatistic();
        $content = view('admin.main', $stat);
        return view('admin.template', array('content' => $content));
    }
}
