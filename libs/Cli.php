<?php
class Cli
{
    private function out($data)
    {
        echo $data;
    }

    public static function output($text, $type = null, $debug = false)
    {
        self::out(self::line($text, $type, $debug));
    }

    public static function finish($text, $type = null, $debug = false)
    {
        die(self::line($text."\n", $type, $debug));
    }

    public static function outputMessages()
    {
        $messages = Registry::getMessages();
        if (count($messages)) {
            foreach ($messages as $message) {
                if ($message->message) {
                    self::output($message->message, $message->type);
                }
            }
        }
    }

    public static function line($text, $type = null, $debug = false)
    {
        if ($debug && DEBUG==false) {
            return false;
        }
        $out = null;
        switch (strtolower($type)) {
            case "title":
                $text = "\n [+] ".$text;
                  $out = "[1;36m"; //Light Cyan
                break;
            case "notice":
                $text = "  +  ".$text;
                $out = "[0;34m"; //Blue
                break;
            case "success":
                $text = "  |  ".$text;
                $out = "[0;32m"; //Green
                break;
            case "failure":
            case "error":
                $text = "  |  ".$text;
                $out = "[0;31m"; //Red
                break;
            case "warning":
                $text = "  |  ".$text;
                $out = "[0;33m"; //Yellow
                break;
            case "info":
                $text = "  |  ".$text;
                break;
            case "debug":
                $text = "  -  ".$text;
                break;
            case "help":
                $text = " ".$text;
                $out = "[0;31m"; //Red
                break;
            default:
                $text = $text;
                break;
        }
        if ($text) {
            if ($out) {
                return chr(27).$out.$text.chr(27)."[0m\n";
            } else {
                return $text."\n";
            }
        }
    }

}
