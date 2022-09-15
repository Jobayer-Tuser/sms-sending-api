<?php
namespace App\Telcos;

use App\Libs\HttpClient;

class Banglalink implements TelcoInterface 
{
    /**
     * Undocumented function
     *
     * @param Object $data
     * @return TelcoResponse
     */
    public function sendSms($data) : TelcoResponse
    {
        $params = $this->makeParams($data);
        $httpClient = new HttpClient();

        $header = [
            "Accept" => "application/json",
            "Content-Type" => "application/json"
        ];

        $response = $httpClient->doPost(config("Telcos.gp.api_url"), $params, $header);
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

        if ($res->error_code == 0) {
            $telRes->status = SmsStatus::SUCCESS;
            $telRes->telcoMsgId = $res->smsInfo[0]->smsID ?? "";
        }

        return $telRes;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function makeParams($data)
    {

    }
    
}