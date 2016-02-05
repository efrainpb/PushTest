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

        PushNotification::app('appNameAndroid')
            ->to($deviceToken)
            ->send($mensaje);
        return $input;
    }
}
