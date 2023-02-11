<?php

namespace App\Controllers;

use App\Enums\SmsStatus;
use stdClass;
use App\Libs\Eloquent;
use App\Libs\Log;
use App\Telcos\{Teletalk, Banglalink, BoomCast, Grameenphone, Robi};
use Exception;

class Sender
{
    private string $requestTime;
    private string $responseTime;
    private object $db;
    private object $telcoRoute;

    public function __construct()
    {
        $this->db = Eloquent::getInstance();
        $this->telcoRoute = new TelcoRoute();
    }

    public function ProcessSms($request) : string  
    {
        try{
            Log::info("request:".json_encode($request));

            $telPrefix = substr($request['msisdn'],-11,3);
            $route = $this->telcoRoute->getTelcoRoute($request['mask_id'], $request['mask_type'], $telPrefix);
            Log::info("telco_route:".json_encode($route));
            $telco = $this->getTelcoInstance($route->telco_name);

            $this->requestTime = date("Y-m-d H:i:s");
            $telcoResponse =  $telco->sendSms($request, $route);

            $this->responseTime = date("Y-m-d H:i:s");

            if (isset($telcoResponse->status) && $telcoResponse->status == SmsStatus::SUCCESS) {
                $status = SmsStatus::SUCCESS;
                $this->updateSms($request, $route);
            } else {
                $status = SmsStatus::ATTEMPTED;
            }

            $this->saveTelcoResponse($request, $route, $telcoResponse);
            return json_encode(["status" => $status,"referenceId" => $telcoResponse->telcoMsgId]);

        } catch ( Exception $e){
           writeErrorLog("sender error:".$e->getMessage());
            return json_encode(["status" => SmsStatus::ERROR, "referenceId" => ""]);
        }
    }


    private function getTelcoInstance(string $telcoName) : object
    {
        switch(strtoupper($telcoName)) {
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
                throw new \Exception("Telco Not Found");
                break;
        }
        return $telco;
    }

    private function updateSms($request, $route) : void
    {   
        try{
            $sql = "update ".$request['sms_table']. " set sender_telco_id='".$route->telco_id."',sender_id=".$route->sender_id;
            $sql .= " where id = ".$request['id'];
            writeInfoLog($sql);
            
            $this->db->query($sql);
        } catch(Exception $ex){
            writeErrorLog("sms update error:".$ex->getMessage());
        }
  
    }

    private function saveTelcoResponse($request, $route, $telcoResponse) : void
    {   
        $tableName                      = "sms_response_logs";
        $columnValue["campaign_id"]        = $request['campaign_id'];
        $columnValue["telco_id"]        = $route->telco_id;
        $columnValue["sender_id"]       = $route->sender_id;
        $columnValue["sms_uid"]         = $request['sms_uid'];
        $columnValue["msisdn"]         = $request['msisdn'];
        $columnValue["status"]          = ($telcoResponse->status == "FAILED") ? 0 : 1;
        $columnValue["request_params"]  = $telcoResponse->telcoRequest;
        $columnValue["response"]        = $telcoResponse->telcoResponse;
        $columnValue["request_time"]    = $this->requestTime;
        $columnValue["response_time"]   = $this->responseTime;
        $columnValue["created_at"]      = date("Y-m-d H:i:s");
        
        $queryResult = $this->db->insertData($tableName, $columnValue);
    }
}