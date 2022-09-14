<?php

namespace Lib;


class Log
{
    /**
     * @param $log
     */
    private static function write($log, $dir = "")
    {
        try {
            if (true) {
                if (!empty($dir)) {
                    $dir = $dir."/";
                }
                $folder_name = rtrim(config('log_path'),'/') .'/'.$dir. date('Ym')."/";

                if (!file_exists($folder_name)) {
                    mkdir($folder_name, 0775, true);
                }

                $date = date('YmdH');
                $filename = $folder_name . $date . ".log";
                $logtime = date('H:i:s');
                $logwritedata = "[" . $logtime . " ] " . $log . "\r\n";
                $fh = fopen($filename, 'a');// or die("can't open file");
                fwrite($fh, $logwritedata);
                fclose($fh);
            }
        } catch (\Exception $exception) {
            //
        }
    }

    /**
     * @param $message
     */
    public static function info($log, $dir = "")
    {
        $log = "INFO:: ".$log;
        self::write($log, $dir = "");
    }

    /**
     * @param $message
     */
    public static function error($log,$dir = "")
    {
        $log = "ERROR:: ".$log;
        self::write($log, $dir = "");
    }
    /**
     * @param $message
     */
    public static function debug($log, $dir = "")
    {
        $log = "DEBUG:: ".$log;
        self::write($log, $dir = "");
    }
}
