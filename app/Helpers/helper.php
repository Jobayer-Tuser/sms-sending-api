<?php
use App\Libs\Log;
use App\Libs\Config;

function config($path)
{
    return Config::get($path);
}

if(!function_exists('writeInfoLog')) {
    function writeInfoLog ($log, $dir = "") {
        Log::info($log, $dir);
    }
}

if(!function_exists('writeErrorLog')) {
    function writeErrorLog ($log, $dir = "") {
        Log::error($log, $dir);
    }
}

if(!function_exists('writeDebugLog')) {
    function writeDebugLog ($log, $dir = "") {
        Log::debug($log, $dir);
    }
}