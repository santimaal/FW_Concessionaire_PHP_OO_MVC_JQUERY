<?php
// $path = $_SERVER['DOCUMENT_ROOT'] . "/concessionaire/framework/";
include(MODEL_PATH . 'jwt.class.php');

function tokendecode($token)
{
    $jwt = parse_ini_file(MODEL_PATH ."jwt.ini");
    $secret = $jwt['secret'];
    $token = $token;

    $JWT = new JWT;
    $json = $JWT->decode($token, $secret);
    $json = json_decode($json, TRUE);
    return $json;
}

function tokencreate($username)
{
    $jwt = parse_ini_file(MODEL_PATH . "jwt.ini");
    $header = $jwt['header'];
    $secret = $jwt['secret'];
    $payload = '{"iat":"' . time() . '","exp":"' . (time() + (60 * 60)) . '","username":"' . $username . '"}';

    $jwt = new JWT;
    $token = $jwt->encode($header, $payload, $secret);
    return $token;
}
