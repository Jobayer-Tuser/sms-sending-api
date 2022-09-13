<?php

namespace Telcos;

interface TelcoInterface 
{
    public function sendSms(Object $data): TelcoResponse;
    public function processResponse($response) : TelcoResponse;
    public function makeParams($data);
}