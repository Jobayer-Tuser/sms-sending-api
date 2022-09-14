<?php

namespace Lib;

class HttpClient {

    public function doGet(string $url, array $header) : string
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
            CURLOPT_HTTPHEADER => $header
        ));

        $response = curl_exec($curl);

        if (curl_errno()) {
            writeErrorLog(curl_error($curl));
        }

        curl_close($curl);
        echo $response;

    }

    public function doPost(string $url , Object $data, array $header) : string
    {
        $header = [ 'Content-Type: application/json' ]; // for json post data
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => '',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => config('curl.otp_timeout'),
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_POSTFIELDS => []
        ));

        $response = curl_exec($curl);
        if (curl_errno()) {
            writeErrorLog(curl_error($curl));
        }
        curl_close($curl);
        return $response;
        
    }

    public function request(string $method, string $url, array $data, array $header) : string
    {
        $json_string = json_encode($data);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => config('curl.otp_timeout'),
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_POSTFIELDS => $data,
        ));

        $response = curl_exec($curl);

        if (curl_errno()) {
            writeErrorLog(curl_error($curl));
        }

        curl_close($curl);
        return $response;

    }
}