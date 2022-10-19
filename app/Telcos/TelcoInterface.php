<?php

namespace App\Telcos;

interface TelcoInterface 
{
    public function sendSms($request, $route);//: TelcoResponse;
    public function processResponse($response) : TelcoResponse;
    public function makeParams($request, $route);
}