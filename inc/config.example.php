<?php

return [
    "database" => [
        "host" => "localhost",
        "port" => "3306",
        "user" => "root",
        "password" => "superV@nexuS22",
        "db_name" => "superb_smsbd"
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
    ],
    "log_path" => "./logs",
    "rabitmq" => [
        "host" => "localhost",
        "port" => 5672,
        "username" => "guest",
        "password" => "guest",
    ]
];
