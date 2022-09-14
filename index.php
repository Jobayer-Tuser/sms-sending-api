<?php
require_once(__DIR__ . "/inc/bootstrap.php");

use App\Controllers\TelcoRoute;

$telcoRoute = new TelcoRoute();
$getMaskingTelco = $telcoRoute->getMaskingTelco(2, "017");

 echo '<pre>';
 print_r($getMaskingTelco);
 echo '</pre>';
//
// $getNonMaskTelco = $telcoRoute->getNonMaskTelco(3);
// echo "<pre>";
// print_r($getNonMaskTelco);
// echo "</pre>";


