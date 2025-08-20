<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Models\Recharge;
use App\Models\ApiLog;
use App\Services\RazorpayService;

class RechargeController extends Controller
{
    
    protected $razorpay;

    public function __construct(RazorpayService $razorpay)
    {
        $this->razorpay = $razorpay;
    }

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

        /* $this->saveApiCall($recharge); */

        return $this->createOrder($recharge);
        /* return redirect()->back()->with('success', 'Recharge Created Successfully'); */
    }

    public function createOrder(Recharge $recharge)
    {
        
        $orderId = 'order_'.$recharge->id;

        $order = $this->razorpay->createOrder($recharge->recharge_amount * 100, $orderId);

        return view('payment.checkout', [
            'recharge' => $recharge,
            'order_id' => $order['id'],
            'amount'   => $recharge->recharge_amount * 100,
            'key'      => env('RAZORPAY_KEY'),
        ]);
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

    public function verifyPayment(Request $request)
    {
        try {
            $attributes = [
                'razorpay_order_id'   => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature'  => $request->razorpay_signature,
            ];

            $this->razorpay->verifySignature($attributes);

            $recharge = Recharge::findOrFail($request->recharge_id);
            $recharge->update(['payment_status' => 'paid']);

            $this->saveApiCall($recharge);

            return response()->json(['success' => true, 'message' => 'Payment successful & recharge initiated.']);

        } catch (\Exception $e) {

            $recharge = Recharge::findOrFail($request->recharge_id);
            $recharge->update(['payment_status' => 'failed']);
            return response()->json(['success' => false, 'message' => 'Payment failed.']);
        
        }
    }

}
