<?php
//PHP
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', 1);
date_default_timezone_set('Europe/Madrid');
ini_set("session.gc_maxlifetime","140000");

//Config
$_config['title'] = "";
$_config['defaultLang'] = "en_GB";
$_config['template'] = "bootstrap";
$_config['defaultApp'] = "";
$_config['defaultLimit'] = 30;
$_config['debug'] = true;

//Mail
$_config['mailHost'] = "";
$_config['mailPort'] = "";
$_config['mailSecure'] = "";
$_config['mailUsername'] = "";
$_config['mailPassword'] = "";
$_config['mailFromAdress'] = "";
$_config['mailFromName'] = "";

//Database
$_config['dbHost'] = "localhost";
$_config['dbUser'] = "root";
$_config['dbPass'] = "";
$_config['dbName'] = "crawlers";

//Urls/Paths
$_config['path'] = dirname(__FILE__);
$_config['host'] = $_SERVER["SERVER_NAME"];
$_config['dir'] = str_replace("index.php", "", $_SERVER["SCRIPT_NAME"]);
$_config['url'] = "http://".$_config['host'].$_config['dir'];
