<?php

namespace App\Telcos;
use App\Enums\SmsStatus;

class Teletalk implements TelcoInterface 
{
    /**
     * Undocumented function
     *
     * @param Object $data
     * @return TelcoResponse
     */
    public function sendSms(Object $data) : TelcoResponse
    {
        $params = $this->makeParams($data);  
        $httpClient = new HttpClient();

        $header = [
            "Accept" => "application/json",
            "Content-Type" => "application/json"
        ];

        $response = $httpClient->doPost( config('Telcos.teletalk.single_api'), $params, $header);

        $telcoRes = $this->processResponse($response);
        $telcoRes->telcoRequest = $params;
        return $telcoRes;
    }

    /**
     * Undocumented function
     *
     * @param [type] $response
     * @return TelcoResponse
     */
    public function processResponse($response): TelcoResponse
    {
        $res = json_decode($response);
        $telRes = new TelcoResponse();
        $telRes->telcoResponse = $response;
        $telRes->status = SmsStatus::FAILED;

        if ($res->error_no == 0) {
            $telRes->status = SmsStatus::SUCCESS;
            $telRes->telcoMsgId = $res->smsInfo[0]->smsID ?? "";
        }

        return new TelcoResponse();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function makeParams($data)
    {
        return json_encode([
          "auth" => [
              "username" => $data['username'],
              "password" => $data['password'],
              "acode" => $data['accode']
          ],
          "smsInfo" => [
              "message" => $data['sms'],
              "masking" => "",
              "msisdn" => [$data['msisdn']]
          ]
        ]);
    }
}