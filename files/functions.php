<?php
function curl($url, $post="")
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.41 Safari/537.36');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    if ($post) {
        curl_setopt($ch, CURLOPT_POST , true);
        @curl_setopt($ch, CURLOPT_POSTFIELDS , $post);
    }
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $exec = curl_exec($ch);
    curl_close($ch);

    return $exec;
}

function get_between($string,$start,$end)
{
    $string ="".$string;
    $ini = strpos($string, $start);
    if($ini==0) return "";
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;

    return substr($string, $ini, $len);
}

function spanishMonthsToEnglish($string)
{
    $spanish = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
    $english = array ("January", "February" ,"March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

    return str_replace($spanish, $english, $string);
}

function betterTrim($string)
{
    return preg_replace("/[^A-Za-z0-9 ]/", '', $string);
}
