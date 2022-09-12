<?php

namespace App;

use stdClass;
use Lib\Eloquent;
use App\TelcoRoute;
use Telcos\{Teletalk, Banglalink, Grameenphone, Robi};

class Sender{

    public function ProcessSms($request) // $request 
    {

        //TODO:: get sender info from database

        $route = new TelcoRoute();

        $route = $route->getTelcoRoute($request->mask_id,$request->mask_type,$request->telco_prefix);
    
        $data = [];

        $telco = $this->getTelcoInstance($route->tel_prefix);

        // var_dump($telco);
        

        $telcoResponse =  $telco->sendSms([
            ""
        ]);

        if (/*$telcoResponse->status == "success"*/ true) {

        }

    }


    private function getTelcoInstance(string $telPrefix) : object
    {
        switch($telPrefix) {
            case "018" :
                $telco =  new Robi();
                break;
            case "019" :
                $telco =  new Banglalink();
                break;
            case "017" : 
                $telco =  new GrameenPhone();
                break;
            case "014" : 
                $telco =  new Teletalk();
                break;
            default:
                throw new \Exception("");
                break;
        }
        return $telco;
    }

    private function sendSms($data) : Object
    {
        return new stdClass();
    }

}