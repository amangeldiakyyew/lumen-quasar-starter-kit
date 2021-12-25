<?php

function res($message, $data = false, $statusCode = 200)
{
    $response = [
        'message' => $message,
    ];
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            $response[$key] = $value;
        }
    }
    return response($response, $statusCode);
}

function public_path($path = null)
{
    $publicPath = rtrim(rtrim(app('path.public'), '/'), '\\') . '/';
    $path = ltrim($path, '/');
    return $publicPath . $path;
}


function isJson($string) {
    $decoded = @json_decode($string);
    if ( !is_object($decoded) && !is_array($decoded) ) {
        return false;
    }
    return (json_last_error() == JSON_ERROR_NONE);
}

