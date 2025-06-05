<?php
namespace controllers\log;

class Logger
{
    public static function AddLog(string $message) :void
    {
        $date = date('d.m.y H:i:s');
        $note = $date . " " . $message . "\n";
        $logPath = "controllers/log/log";
        file_put_contents($logPath, $note, FILE_APPEND);
    }

    public static function AddErrorLog(string $message) : void
    {
        $date = date('d.m.y H:i:s');
        $note = $date . " " . $message . "\n";
        $logPath = 'controllers/log/errorLog';
        file_put_contents($logPath, $note, FILE_APPEND);
    }

}