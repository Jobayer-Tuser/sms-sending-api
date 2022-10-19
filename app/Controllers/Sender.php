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

        $route = $route->getTelcoRoute($request['mask_id'], $request['mask_type'], $request['telco_prefix']);

        $telco = $this->getTelcoInstance($route->telco_name);

        return $telcoResponse =  $telco->sendSms($request, $route);

        if ($telcoResponse->status == SmsStatus::SUCCESS) {

        }

        $this->insertDataToSmsReport($request);
        $this->saveTelcoResponse($request);
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

    private function sendSms($data) : Object
    {
        return new stdClass();
    }

    public function insertDataToSmsReport($request) : void
    {
        $tableName = "sms_report";
        $columnValue = [];
        foreach ($request as $key => $value){
            $columnValue[$key] = $value;
        }
        $queryResult = $this->db->insertData($tableName, $columnValue);
        // echo $queryResult['LAST_INSERT_ID'];
        // echo $queryResult['NO_OF_ROW_INSERTED'];
        echo "<pre>";
        print_r($queryResult);
        echo "</pre>";

        # INSERT DATA #
        /*$tableName = "sms_report";
        $columnValue["old_id"] = $request->id;
        $columnValue["client_id"] =$request->id;
        $columnValue["client_channel"] = $request->client_channel;
        $columnValue["sms_uid"] = $request->sms_uid;
        $columnValue["campaign_id"] = null;
        $columnValue["campaign_type"] = null;
        $columnValue["mask_type"] = null;
        $columnValue["localization"] = null;
        $columnValue["sender_number"] = null;
        $columnValue["telco_rate"] = null;
        $columnValue["receiver_number"] = null;
        $columnValue["message_body"] = null;
        $columnValue["message_type"] = null;
        $columnValue["message_qty"] = null;
        $columnValue["telco_message_qty"] = null;
        $columnValue["sms_status"] = null;
        $columnValue["handset_delivery"] = null;
        $columnValue["sent_time"] = null;
        $columnValue["schedule_time"] = null;
        $columnValue["is_sent"] = null;
        $columnValue["no_of_attempt"] = null;
        $columnValue["telco_response_id"] = null;
        $columnValue["created_at"] = null;
        $columnValue["updated_at"] = null;
        $queryResult = $this->db->insertData($tableName, $columnValue);
        echo $queryResult['LAST_INSERT_ID'];
        echo $queryResult['NO_OF_ROW_INSERTED'];*/
    }

    private function saveTelcoResponse($request){

    }

}