<?php

//Pass trought index
define("_EXE", 1);

//Configuration
file_exists("config.php") or die("Can't find config.php");
include "config.php";

//Composer autoload
file_exists("vendor/autoload.php") or die("Composer required");
require "vendor/autoload.php";

//Registry init
$registry = new Registry();
