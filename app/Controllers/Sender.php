<?php

namespace App\Controllers;

use App\Enums\SmsStatus;
use stdClass;
use App\Libs\Eloquent;
use App\Telcos\{Teletalk, Banglalink, Grameenphone, Robi};

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

        $route = $route->getTelcoRoute($request->mask_id,$request->mask_type,$request->telco_prefix);
    
        $data = [];

        $telco = $this->getTelcoInstance($route->tel_prefix);

        $telcoResponse =  $telco->sendSms([
            ""
        ]);

        if ($telcoResponse->status == SmsStatus::SUCCESS) {

        }

        $this->insertDataToSmsReport($request);
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

    private function insertDataToSmsReport($request) : void
    {
        # INSERT DATA #
        $tableName = "sms_report";
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
        echo $queryResult['NO_OF_ROW_INSERTED'];
    }

}