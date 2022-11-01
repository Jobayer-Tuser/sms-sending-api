<?php
namespace App\Telcos;

class TelcoResponse {
    public string $status;
    public $telcoResponse;
    public $telcoRequest;
    public $telcoMsgId = "";
    public $smsData;
    public $balance;
}