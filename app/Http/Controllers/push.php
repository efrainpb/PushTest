<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Hash;
use Request;
use Auth;
use View;

class push extends Controller
{

    public function sendPush()
    {
        $input = Request::all();
        $deviceToken = $input['deviceToken'];
        $mensaje = urldecode($input['msj']);
        $id = $input['id'];
        $action = $input['action'];

        define("GOOGLE_API_KEY", "AIzaSyDMTcK3dTniG11HU8IovSInhPE_uR0YbLI");
        $url = 'https://gcm-http.googleapis.com/gcm/send';

        $fields = array(
            'registration_ids' => array($deviceToken),
            'data' => array(
                "title"=>"Superchamba",
                "message" => $mensaje),
            "collapse_key" => $id
        );

        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);
        if ($result === FALSE)
            die('Curl error: '.curl_error($ch));

        curl_close($ch);
        return $result;
    }

    public function register()
    {
        $input = Request::all();
        return $input;
    }

    public function pushIOS()
    {
        $input = Request::all();
        $message = $input['msj'];
        $message = urldecode($message);
        $passphrase = '6243mu33';
        $development = true;
        if($development){
            $apns_url = 'ssl://gateway.sandbox.push.apple.com:2195';
            $cert = realpath('scapp.pem');
        }
        else {
            $apns_url = 'ssl://gateway.push.apple.com:2195';
            $cert = realpath('scapp_production.pem');
        }
        $payload = '{
        "aps" :
            {
                "alert" : "'.$message.'",
                "badge" : "q",
                "sound" : "default"
            }
         }';

        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $cert);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

        $fp = stream_socket_client($apns_url, $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

        if (!$fp)
        {
            return;
        }
        else
        $dev_array = array($input['deviceToken']);

        foreach ($dev_array as $device_token)
        {
            $msg =  chr(0) .
                pack("n", 32) .
                pack('H*', str_replace(' ', '', $device_token)) .
                pack("n", strlen($payload)) .
                $payload;
            $response = fwrite($fp, $msg);
        }
        fclose($fp);
        return $response;
    }
}
