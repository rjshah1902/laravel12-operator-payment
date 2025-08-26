<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApiLog;

class DashboardController extends Controller
{
    public function index()
    {
        $apiLogs = ApiLog::where(array('status'=>1))->with(['recharge','user'])->get();

        return view('dashboard', compact('apiLogs'));
    }
}
