<?php
require_once(__DIR__ . "/inc/bootstrap.php");

use App\Controllers\Sender;

$data = json_decode(file_get_contents('php://input'), true);
$sender =  new Sender();
echo $sender->ProcessSms($data);
// $senderResponse = $sender->ProcessSms($_REQUEST);
// var_dump($senderResponse);
// var_dump($data);
// echo json_encode($data);

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