<?php

namespace App\Controllers;

use App\Enums\SmsStatus;
use stdClass;
use App\Libs\Eloquent;
use App\Telcos\{Teletalk, Banglalink, BoomCast, Grameenphone, Robi};

class Sender
{
    private object $db;
    public function __construct()
    {
        $this->db = Eloquent::getInstance();
    }

    public function ProcessSms($request) // $request 
    {
        //TODO:: get sender info from database

        $route = new TelcoRoute();

        $telPrefix = substr($request['msisdn'],-11,3);

        $route = $route->getTelcoRoute($request['mask_id'], $request['mask_type'], $telPrefix);

        $telco = $this->getTelcoInstance($route->telco_name);

        $telcoResponse =  $telco->sendSms($request, $route);
        $resp = json_decode($telcoResponse->telco_response);
        // var_dump($telcoResponse);
        if ($telcoResponse->status == SmsStatus::SUCCESS) {
           
        }
    }


    private function getTelcoInstance(string $telcoName) : object
    {
        switch($telcoName) {
            case "ROBI" :
                $telco =  new Robi();
                break;
            case "AIRTEL" :
                $telco =  new Banglalink();
                break;
            case "TELETALK" : 
                $telco =  new GrameenPhone();
                break;
            case "BANGLALINK" : 
                $telco =  new Teletalk();
                break;
            case "BOOMCAST" : 
                $telco =  new BoomCast();
                break;
            default:
                throw new \Exception("");
                break;
        }
        return $telco;
    }
}