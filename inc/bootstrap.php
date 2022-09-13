<?php

error_reporting(E_ALL); //to show errors
ini_set('display_errors', TRUE); //Sets the value of a configuration option
ini_set('display_startup_errors', TRUE);
define('BASE_PATH', realpath(dirname(__FILE__,2)));

$GLOBALS['config'] = require(BASE_PATH . '/inc/config.php');
require(BASE_PATH . "/vendor/autoload.php");
require(BASE_PATH . "/helpers/helper.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");





