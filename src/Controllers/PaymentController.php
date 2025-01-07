<?php

namespace Sarowar\Bkash\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sarowar\Bkash\Facades\Bkash;


class PaymentController extends Controller
{

    public function index()
    {
        return view('bkash::bkash_payment');

    }

    public function createPayment()
    {

        $callbackURL='http://127.0.0.1:8000/success';
        $requestbody = array(
            'mode' => '0011',
            'amount' => '20',
            'currency' => 'BDT',
            'intent' => 'sale',
            'payerReference' => '01619777283',
            'merchantInvoiceNumber' => 'commonPayment0011',
            'callbackURL' => $callbackURL
        );
        $requestbodyJson = json_encode($requestbody);
        $response=Bkash::create_payment($requestbodyJson);
//return $response;
        if (isset($response['bkashURL'])) {
            return redirect($response['bkashURL']);
        }

        return redirect()->back();

    }

    public function success(Request $request)
    {
//        $tokenResponse = Bkash::token();
       $response= Bkash::exicutepay($request);

//       $response1=Bkash::querypayment($request);

        return $response;
    }
}
