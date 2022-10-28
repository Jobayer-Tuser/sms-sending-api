<?php
require_once(__DIR__ . "/inc/bootstrap.php");

use App\Controllers\TelcoRoute;
use App\Controllers\Sender;

$data = json_decode(file_get_contents('php://input'), true);
$sender =  new Sender();
$sender->ProcessSms($data);

// var_dump($data);
// echo json_encode($data);


// var_dump($_POST);

// echo '[{"id" : 1, "userId": 122, "title" : "title}]';

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