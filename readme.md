## Push Notification iOS y Android desde Laravel

Envía Push notification a ios y Android.

## Send Push Notification Android

Para Android se utiliza curl y sólo hay que sustituir la GOOGLE_API_KEY

Send

{
    deviceToken: ###################,
    msj: Un mensaje para la push notification
}

## Send Push Notification ios

Para iOS hay que sustituir el certificado .pem en public y la clave de el mismo en $passphrase

Si se está en ambiente de desarrollo hay que envíar a ssl://gateway.sandbox.push.apple.com:2195

Si se está en ambiente de producción hay que envíar a ssl://gateway.push.apple.com:2195

{
    deviceToken: ###################,
    msj: Un mensaje para la push notification
}