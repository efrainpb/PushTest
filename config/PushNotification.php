<?php


array(
    'iOS'     => [
        'environment' => env('IOS_PUSH_ENV', 'development'),
        'certificate' => env('IOS_PUSH_CERT', __DIR__ . '/ios-push-notification-certificates/development/certificate.pem'),
        'passPhrase'  => env('IOS_PUSH_PASSWORD', '291923Job'),
        'service'     => 'apns'
    ],

    'android' => [
        'environment' => env('ANDROID_PUSH_ENV', 'development'),
        'apiKey'      => env('ANDROID_PUSH_API_KEY', 'AIzaSyALv2cuCCz9zItQF6RJPadSxFvJw--gDrA'),
        'service'     => 'gcm'
    ]
);
