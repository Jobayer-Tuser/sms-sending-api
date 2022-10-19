<?php
require_once(__DIR__ . "/inc/bootstrap.php");

use App\Controllers\TelcoRoute;
use App\Controllers\Sender;

$sender =  new Sender();
$sender->ProcessSms($_POST);

 # msisdn sms uuid mask_type id


// $getMaskingTelco = $telcoRoute->getMaskingTelco(2, "017");
// echo '<pre>';
// print_r($getMaskingTelco);
// echo '</pre>';
//
// $getNonMaskTelco = $telcoRoute->getNonMaskTelco(3);
// echo "<pre>";
// print_r($getNonMaskTelco);
// echo "</pre>";