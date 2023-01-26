<?php

namespace App\Enums;

class SmsStatus extends BaseEnum
{
    public const SUCCESS = "SUCCESS";
    public const ATTEMPTED = "ATTEMPTED";
    public const FAILED = "FAILED";
    public const ERROR = "ERROR";
}