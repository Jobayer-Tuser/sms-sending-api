<?php

namespace App\Libs;

class HttpClient {

    public function doGet(string $url) : string
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => config('curl.otp_timeout'),
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                "Accept" => "application/json",
                "Content-Type" => "application/json"
            ]
        ));

        $response = curl_exec($curl);

        if (curl_errno()) {
            writeErrorLog(curl_error($curl));
        }

        curl_close($curl);
        return $response;
    }

    public function doPost(string $url , Object $data) : string
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => config('curl.otp_timeout'),
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => [
                "Accept" => "application/json",
                "Content-Type" => "application/json"
            ],
            CURLOPT_POSTFIELDS => $data
        ));

        $response = curl_exec($curl);
        if (curl_errno()) {
            writeErrorLog(curl_error($curl));
        }
        curl_close($curl);
        return $response;
    }
}