<?php
namespace Telcos;
use stdClass;

class Robi implements TelcoInterface 
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

        $url = '';
        $params = new stdClass();
        $header = [];

        $response = $httpClient->doPost( $url, $params, $header);

        return $this->processResponse($response);

    }

    /**
     * Undocumented function
     *
     * @param [type] $response
     * @return TelcoResponse
     */
    public function processResponse($response): TelcoResponse
    {
        return new TelcoResponse();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function makeParams()
    {

    }
    
}