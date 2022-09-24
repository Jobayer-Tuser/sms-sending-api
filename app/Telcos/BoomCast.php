<?php

namespace App\Telcos;

use App\Enum\SmsStatus;
use App\Libs\HttpClient;

class BoomCast implements TelcoInterface
{

    public function sendSms(object $data): TelcoResponse
    {
        $params = $this->makeParams($data);
        $httpClient = new HttpClient();

        $response = $httpClient->doPost( config("Telcos.boomcast.api_url"), $params);
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
            $telRes->telcoMsgId = $res[0]->msgid ?? "";
        }
        return $telRes;
    }

    public function makeParams($data)
    {
        return json_decode([
            "username" => $data['username'],
            "password" => $data['password'],
            "masking"  => $data['masking'],
            "message"  => $data['message'],
            "MsgType" => $data['message_type'],
            "Receiver" => $data['receiver'],
        ]);
    }
}