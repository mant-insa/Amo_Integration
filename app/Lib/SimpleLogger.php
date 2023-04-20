<?php

namespace App\Lib;

class SimpleLogger
{
    public static function log($message = "")
    {
        $date = date("d-m-Y H:i:s");
        $res = file_put_contents(APP_ROOT . "/log_file.txt", $date . ": " . $message . PHP_EOL, FILE_APPEND);
    }

    public static function debug($message = "")
    {
        $date = date("d-m-Y H:i:s");
        $res = file_put_contents(APP_ROOT . "/debug_file.txt", $date . ": " . $message . PHP_EOL, FILE_APPEND);
    }
}