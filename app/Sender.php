<?php

namespace App;

use Enum\SmsStatus;
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

        if ($telcoResponse->status == SmsStatus::SUCCESS) {

        }

        $db = Eloquent::getInstance();
        $sql = "update sms_logs set "
        $db->insertData('sms_report',[

            'old_id' => $request->id,
            'client_id' => $request->id,
            'client_channel' => $request->client_channel,
            'sms_uid' => $request->sms_uid,
            'campaign_id' => "",
            'campaign_type' => "",
            'mask_type' => "",
            'localization' => "",
            'sender_number' => "",
            'telco_rate' => "",
            'receiver_number' => "",
            'message_body' => "",
            'message_type' => "",
            'message_qty' => "",
            'telco_message_qty' => "",
            'sms_status' => "",
            'handset_delivery' => "",
            'sent_time' => "",
            'schedule_time' => "",
            'is_sent' => "",
            'no_of_attempt' => "",
            'telco_response_id' => "",
            'created_at' => "",
            'updated_at' => ""
        ]);

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