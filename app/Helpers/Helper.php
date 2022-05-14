<?php

function successParser($data, $code = 200)
{
    $data['status'] = 'success';
    $data['code'] = $code;
    return response()->json($data, $code);
}

function errorParser($data, $code)
{
    $data['status'] = 'error';
    $code = (int) $code;
    if ($code < 200 || $code > 500) :
        $code = 500;
    endif;
    $data['code'] = $code;
    return response()->json($data, $code);
}

function generateRandomNumber($number = 8)
{
    $token = substr(str_shuffle("1234567890"), 0, $number);
    return $token;
}

function generateRandomString($string = 8)
{
    $token = substr(str_shuffle("123456789ABCDEFGHIJKLMOPQRSTUWXYZ"), 0, $string);
    return $token;
}
