<?php

namespace App\Lib;

class SimpleLogger
{
    public static function log($message = "")
    {
        $date = date("d-m-Y");
        file_put_contents(APP_ROOT . "/log_file.text", $date . ": " . $message, FILE_APPEND);
    }

    public static function debug($message = "")
    {
        $date = date("d-m-Y");
        file_put_contents(APP_ROOT . "/debug_file.text", $date . ": " . $message, FILE_APPEND);
    }
}