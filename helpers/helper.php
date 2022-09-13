<?php
use Lib\Config;
function config($path)
{
    return Config::get($path);
}

if(!function_exists('writeInfoLog')) {
    function writeInfoLog ($log, $dir = "") {
        \Lib\Log::info($log, $dir);
    }
}

if(!function_exists('writeErrorLog')) {
    function writeErrorLog ($log, $dir = "") {
        \Lib\Log::error($log, $dir);
    }
}

if(!function_exists('writeDebugLog')) {
    function writeDebugLog ($log, $dir = "") {
        \Lib\Log::debug($log, $dir);
    }
}