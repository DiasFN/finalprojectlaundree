<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class PaymentsCT extends Controller
{
    public function create(Request $request){

        $params = array(
            'transaction_details' => array(
                'order_id' => Str::uuid(),
                'gross_amount' => $request->price,
            ),
            'item_details' => array(
                array(
                    'price' => $request->price,
                    'quantity' => 1,
                    'name' => $request->item_name,
                )
            ),
            'customer_details' => array(
                'first_name' => $request->customer_first_name,
                'email' => $request->customer_email,
            ),
            // 'enabled_payments' => array('credit_card', 'bca_va', 'bni_va', 'bri_va')
        );

        $serverKey = env('MIDTRANS_SERVER_KEY');
        $auth = base64_encode($serverKey . ':');

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => "Basic $auth",
        ])->post('https://app.sandbox.midtrans.com/snap/v1/transactions', $params);

        $responseBody = json_decode($response->body());

        if ($response->failed()) {
            return response()->json([
                'message' => 'Failed to create transaction',
                'error' => $responseBody,
            ], $response->status());
        }

        // save to db
        $payment = new Payments;
        $payment->order_id = $params['transaction_details']['order_id'];
        $payment->status = 'pending';
        $payment->price = $request->price;
        $payment->customer_first_name = $request->customer_first_name;
        $payment->customer_email = $request->customer_email;
        $payment->item_name = $request->item_name;
        $payment->checkout_link = $responseBody->redirect_url;
        $payment->save();

        return response()->json($responseBody);
    }

    public function webhook(Request $request){
        $auth = base64_encode(env('MIDTRANS_SERVER_KEY'));
    
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => "Basic $auth",
        ])->get('https://api.sandbox.midtrans.com/v2/'.$request->order_id.'/status');
    
        $responseBody = json_decode($response->body());
    
        // Check if response has order_id property
        if (!isset($responseBody->order_id)) {
            return response()->json(['error' => 'Invalid response from Midtrans'], 400);
        }
    
        // check to db
        $payment = Payments::where('order_id', $responseBody->order_id)->firstOrFail();
    
        if ($payment->status === 'settlement' || $payment->status === 'capture'){
            return response()->json('Payment has been already processed');
        }
    
        switch ($responseBody->transaction_status) {
            case 'capture':
                $payment->status = 'capture';
                break;
            case 'settlement':
                $payment->status = 'settlement';
                break;
            case 'pending':
                $payment->status = 'pending';
                break;
            case 'deny':
                $payment->status = 'deny';
                break;
            case 'expire':
                $payment->status = 'expire';
                break;
            case 'cancel':
                $payment->status = 'cancel';
                break;
            default:
                return response()->json(['error' => 'Unknown transaction status'], 400);
        }
    
        $payment->save();
    
        return response()->json('success');
    }
    
}
