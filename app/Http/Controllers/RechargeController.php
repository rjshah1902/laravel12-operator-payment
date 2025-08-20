<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Models\Recharge;
use App\Models\ApiLog;

class RechargeController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'operator'        => 'required|string|max:100',
            'contact_number'  => 'required|digits:10',
            'recharge_amount' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $recharge = Recharge::create([
            'user_id'         => auth()->id(),
            'operator'        => $request->operator,
            'contact_number'  => $request->contact_number,
            'recharge_amount' => $request->recharge_amount,
        ]);

        $this->saveApiCall($recharge);

        return redirect()->back()->with('success', 'Recharge Created Successfully');
    }

    public function saveApiCall($recharge){
        $apiBody =  [
            'member_id'    => '9876543210',
            'api_password' => '1234',
            'api_pin'      => '1234',
            'number'       => $recharge->contact_number,
            'amount'       => $recharge->recharge_amount,
            'operator'     => $recharge->operator,
        ];

        $response = Http::get("https://supay.in/recharge_api/recharge", $apiBody);

        if ($response->successful()) {
            $recharge->update(['payment_status' => 'paid']);
        } else {
            $recharge->update(['payment_status' => 'failed']);
        }

        ApiLog::create([
            'user_id'         => auth()->id(),
            'api_for'         => "operator-recharge",
            'request_body'    => json_encode($apiBody),
            'response_body'   => $response->body(),
        ]);
    }
}
