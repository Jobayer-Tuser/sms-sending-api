<?php

namespace App\Telcos;

use App\Enums\SmsStatus;
use App\Libs\HttpClient;

class BoomCast implements TelcoInterface
{

    public function sendSms($request, $route)//: TelcoResponse
    {
        $params = $this->makeParams($request, $route);
        $httpClient = new HttpClient();

        $response = $httpClient->doPost(config("Telcos.boomcast.api_url"), $params);
        var_dump($response);
        
        $telcoRes = $this->processResponse($response);
        $telcoRes->telcoRequest = $params;
        return $telcoRes;
    }

    public function processResponse($response): TelcoResponse
    {
        $res = json_decode($response);
        $telRes = new TelcoResponse();
        $telRes->telcoResponse = $response;
        $telRes->status = SmsStatus::FAILED;

        if(isset($res[0]->success) && $res[0]->success == 1){
            $telRes->status = SmsStatus::SUCCESS;
            $telRes->telcoMsgId = $res[0]->msgId ?? "";
        }
        return $telRes;
    }

    public function makeParams($request, $route)
    {
        $msgType = (mb_detect_encoding($request['sms']) == "ASCII") ? "TEXT":"UNICODE";
        return http_build_query([
            "userName" => $route->telco_username,
            "password" => $route->telco_password,
            "masking"  => (strtolower($route->telco_mask_type) == "nonmask") ? "NOMASK" : $route->mask,
            "message"  => $request['sms'],
            "MsgType" =>  $msgType,
            "receiver" => $request['misdn'],
        ]);
    }
}