<?php

namespace App\Telcos;

class BoomCast implements TelcoInterface
{

    public function sendSms(object $data): TelcoResponse
    {
        // TODO: Implement sendSms() method.
    }

    public function processResponse($response): TelcoResponse
    {
        // TODO: Implement processResponse() method.
    }

    public function makeParams($data)
    {
        // TODO: Implement makeParams() method.
    }
}