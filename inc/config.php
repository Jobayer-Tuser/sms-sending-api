<?php

return [
    "database" => [
        "host" => "localhost",
        "port" => "",
        "user" => "root",
        "password" => "RootPass!@",
        "db_name" => "sms_gateway_rdb"
    ],
    "Telcos" => [
        "gp" => [
            "api_url" => "//gpcmp.grameenphone.com/ecmapigw/webresources/ecmapigw.v2"
        ],
        "teletalk" => [
            "single_api" => "//bulkmsg.teletalk.com.bd/api/sendSMS"
        ],
        "boomcast" =>[
            "api_url" => "http://api.boom-cast.com/boomcast/WebFramework/boomCastWebService/externalApiSendTextMessage.php"
        ]
    ],
    "curl" => [
        "con_timeout" => 30,
        "opt_timeout" => 30
    ]
];
