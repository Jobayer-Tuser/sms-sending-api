<?php
require_once(__DIR__ . "/inc/bootstrap.php");

use App\Controllers\Sender;

$data = json_decode(file_get_contents('php://input'), true);
$sender =  new Sender();
// $sender->ProcessSms($data);
$sender->ProcessSms($_REQUEST);

// var_dump($data);
// echo json_encode($data);