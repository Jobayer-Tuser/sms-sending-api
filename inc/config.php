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
            "api_url" => ""
        ],
        "teletalk" => [
            "single_api" => "https://bulkmsg.teletalk.com.bd/api/sendSMS"
        ]
    ],
    "curl" => [
        "con_timeout" => 30,
        "opt_timeout" => 30
    ]
];
