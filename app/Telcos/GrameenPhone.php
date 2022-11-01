<?php
namespace App\Telcos;
use App\Enums\SmsStatus;
use App\Libs\HttpClient;

class GrameenPhone implements TelcoInterface 
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

        $response = $httpClient->doPost( config("Telcos.gp.api_url"), $params);
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

        if($res->error_code == 0){
            $telRes->status = SmsStatus::SUCCESS;
            $telRes->telcoMsgId = $res->smsInfoId ?? "";
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
        return json_encode([
            "username"      => $data['username'],
            "password"      => $data['password'],
            "apicode"       => $data['apicode'],
            "msisdn"        => $data['msisdn'],
            'countrycode'   => $data['country_code'],
            "cli"           => $data['cli'],
            "messagetype"   => $data['message_type'],
            'message'       => $data['message'],
            "messageid"     => $data['message_id'],
        ]);
    }
    
}