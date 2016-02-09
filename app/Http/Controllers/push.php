<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Hash;
use Request;
use Auth;
use View;
use PushNotification;

class push extends Controller
{
    //
    public function sendPush()
    {
        $input = Request::all();
        $deviceToken = $input['deviceToken'];
        $mensaje = $input['msj'];


        /*$collection = PushNotification::app('appNameAndroid')
        ->to($deviceToken);
        $collection->adapter->setAdapterParameters(['sslverifypeer' => false]);
        $collection->send($mensaje);
        return $input;*/
        define("GOOGLE_API_KEY", "AIzaSyD1g2l-rMWpsHnyxc-0knxKVTCVIsRRXP4");
        $url = 'https://gcm-http.googleapis.com/gcm/send';

        $fields = array(
            'registration_ids' => array($deviceToken),
            'data' => array("product" => "shirt"),
        );

        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        //print_r($headers);
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);
        return $result;
    }

    public function register()
    {
        $input = Request::all();
        return $input;
    }
}
