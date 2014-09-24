<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', 1);

//Configuration
include 'config.php';

//Composer autoload
require 'vendor/autoload.php';

//Pharser options
$options = array(
    'action' => array(
        'description'   => 'Action',
        'type'          => Pharse::PHARSE_STRING,
        'required'        => true,
        'short'            => 'a',
    ),
);
$arguments = Pharse::options($options);

//Action switch
switch ($arguments["action"]) {
    case 'cars':
        Grabber_Segundamano::grabList("http://www.segundamano.es/coches-de-segunda-mano-tarragona/");
    break;
    case 'houses':
        Grabber_Fotocasa::grabList("http://www.fotocasa.es/viviendas/tarragona-capital/alquiler/listado?opi=1&ftg=true&fss=true&cu=es-es&mode=3&craap=1&fs=false");
    break;
}
