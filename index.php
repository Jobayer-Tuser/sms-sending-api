<?php
require(__DIR__ . "/vendor/autoload.php");
require(__DIR__ . '/inc/config.php');

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

use App\TelcoRoute;

$telcoRoute = new TelcoRoute();
$getMaskingTelco = $telcoRoute->getMaskingTelco(2, "017");

// echo '<pre>';
// print_r($getMaskingTelco);
// echo '</pre>';

 $getNonMaskTelco = $telcoRoute->getNonMaskTelco(3);
 echo "<pre>";
 print_r($getNonMaskTelco);
 echo "</pre>";


