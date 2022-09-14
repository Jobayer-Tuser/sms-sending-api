<?php

namespace Lib;


namespace Lib;
class Config
{
    public static function get($path = null)
    {
        if ($path) {
            $config = $GLOBALS['config'];
            $path = explode('.', $path);
            foreach ($path as $abit) {
                if (isset($config[$abit])) {
                    $config = $config[$abit];
                }
            }
            return $config;
        }
        return '';
    }
}