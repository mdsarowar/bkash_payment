<?php

namespace Sarowar\Bkash\Services;
class BkashManager
{

    public function token()
    {
        session()->forget('bkash_token');
        session()->forget('bkash_token_type');
        session()->forget('bkash_refresh_token');

//        if (session()->has('bkash_token')) {
//            return session()->get('bkash_token');
//        }

        $request_data = array(
            'app_key'=>config('bkash.app_key'),
            'app_secret'=>config('bkash.app_secret'),
        );
        $url = curl_init(config('bkash.base_url').'/tokenized/checkout/token/grant');
//        $url = curl_init('https://tokenized.sandbox.bka.sh/v1.2.0-beta/tokenized/checkout/token/grant');
        $request_data_json=json_encode($request_data);

        // Headers
        $header = [
            'Content-Type:application/json',
            'username: ' . config('bkash.username'),
            'password: ' . config('bkash.password'),
        ];
        curl_setopt($url,CURLOPT_HTTPHEADER, $header);
        curl_setopt($url,CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url,CURLOPT_POSTFIELDS, $request_data_json);
        curl_setopt($url,CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

        $resultdata = curl_exec($url);
        curl_close($url);
        $response=json_decode($resultdata,true);
        if (isset($response['id_token']) && isset($response['token_type']) && isset($response['refresh_token'])){
            session()->put('bkash_token', $response['id_token']);
            session()->put('bkash_token_type', $response['token_type']);
            session()->put('bkash_refresh_token', $response['refresh_token']);
        }
        return $response;
    }

    public function create_payment($data)
    {

         $this->token();
        $auth = session()->get('bkash_token');

        $url = curl_init(config('bkash.base_url').'/tokenized/checkout/create');

        $header = array(
            'Content-Type:application/json',
            'Authorization:' . $auth,
            'X-APP-Key:'.config('bkash.app_key')
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $data);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $resultdata = curl_exec($url);
        curl_close($url);

        $response = json_decode($resultdata, true);
        return $response;

    }

    public function exicutepay($data)
    {
        $paymentID = $data->paymentID;
        $this->token();
        $auth = session()->get('bkash_token');
//        $auth = session()->get('refresh_token');

        $post_token = array(
            'paymentID' => $paymentID
        );
        $url = curl_init(config('bkash.base_url').'/tokenized/checkout/execute');
        $posttoken = json_encode($post_token);

        $header = array(
            'Content-Type:application/json',
            'Authorization:' . $auth,
            'X-APP-Key:'.config('bkash.app_key')
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $posttoken);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $resultdata = curl_exec($url);

        curl_close($url);

        $obj = json_decode($resultdata);
        return $obj;
    }

    public function querypayment($data)
    {
        $paymentID=$data->paymentID;
        $requestbody = array(
            'paymentID' => $paymentID
        );
        $requestbodyJson = json_encode($requestbody);

        $this->token();
        $token = session()->get('bkash_token');


        $url=curl_init(config('bkash.base_url').'/tokenized/checkout/payment/status');
        $header=array(
            'Content-Type:application/json',
            'authorization:'.$token,
            'x-app-key:'.config('bkash.app_key')
        );


        curl_setopt($url,CURLOPT_HTTPHEADER, $header);
        curl_setopt($url,CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $requestbodyJson);
        curl_setopt($url,CURLOPT_FOLLOWLOCATION, 1);
        $resultdatax=curl_exec($url);

        curl_close($url);
        $obj = json_decode($resultdatax);
        return $obj;

    }
}
