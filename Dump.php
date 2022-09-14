<?php

function setNonmaskSenderInfo($maskId = null)
    {
        $sender = null;
        if ($maskId) {
            $sender =  DB::table('config_telco_senders')
                ->select(
                    'config_telco_senders.telco_username',
                    'config_telco_senders.telco_password',
                    'config_telco_senders.sender_number',
                    'config_telco_senders.telco_id',
                    'config_telco_senders.id as sender_id',
                    'config_telco_senders.callback_token',
                    'Telcos.telco_code',
                    'Telcos.telco_name',
                    'Telcos.telco_mask_sms_rate',
                    'Telcos.telco_nonmask_sms_rate',
                    'Telcos.telco_isms_rate',
                    'Telcos.telco_options',
                    'Telcos.telco_prefix',
                    'Telcos.api_request_limit'
                )
                ->leftJoin('Telcos','Telcos.id','=','config_telco_senders.telco_id')
                ->leftJoin('mask_telco_sender_routes','mask_telco_sender_routes.config_telco_sender_id','=','config_telco_senders.id')
                ->where('config_telco_senders.default_nonmask_gateway','Active')
                ->where('config_telco_senders.status','Active')
                ->where('Telcos.status','Active')
                ->where('config_telco_senders.status','Active')
                ->where('mask_telco_sender_routes.default_nonmask', true)
                ->where('mask_telco_sender_routes.status', "Active")
                ->where('mask_telco_sender_routes.mask_id', $maskId)
                ->orderBy('nonmask_gateway_priority', 'asc')
                ->first();
        }

        // @todo: need to replace count
        if (!$sender) {
            $sender = TelcoSender::getDefaultNonmaskSender();
        }

        if (isset($sender->telco_username) && isset($sender->telco_password) && isset($sender->telco_id)) {
            $this->_userid = decrypt($sender->telco_username);
            $this->_password = decrypt($sender->telco_password);
            $this->_telcoid = $sender->telco_id;
            $this->telco_options = $sender->telco_options;
            $this->telcoMaskSmsRate = $sender->telco_mask_sms_rate;
            $this->telcoNonmaskSmsRate = $sender->telco_nonmask_sms_rate;
            $this->_telco_prefix = strtoupper($sender->telco_prefix);
            $this->_sendernumber = $sender->sender_number;
            $this->_senderid = $sender->sender_id;
            $this->_mask_type = 'Nonmask';
            $this->_mask_name = '88' . substr($sender->sender_number, -11);
            $this->_api_limit = $sender->api_request_limit;
            $this->localization = LocalizationTypeEnum::Local;
            $this->callbackToken = $sender->callback_token;
            return true;
        }

        return false;
    }


    public function setInternationalSmsSenderInfo()
    {
        $sender = TelcoSender::getDefaultInternationalSmsSender();

        if (isset($sender->telco_username) && isset($sender->telco_password) && isset($sender->telco_id)) {
            $this->_userid = decrypt($sender->telco_username);
            $this->_password = decrypt($sender->telco_password);
            $this->_telcoid = $sender->telco_id;
            $this->telco_options = $sender->telco_options;
            $this->telcoMaskSmsRate = $sender->telco_mask_sms_rate;
            $this->telcoNonmaskSmsRate = $sender->telco_nonmask_sms_rate;
            $this->telcoISmsRate = $sender->telco_isms_rate;
            $this->_telco_prefix = strtoupper($sender->telco_prefix);
            $this->_sendernumber = $sender->sender_number;
            $this->_senderid = $sender->sender_id;
            $this->_mask_type = 'Nonmask'; // TODO: In Internation SMS, mask sms also allowed for certain gateway.
            $this->_mask_name = '88' . substr($sender->sender_number, -11);
            $this->_api_limit = $sender->api_request_limit;
            $this->localization = LocalizationTypeEnum::Foreign;
            return true;
        }
        return false;
    }

    function setSenderInfo($sender)
    {
        $maskTelcoSender = MaskTelcoSender::whereHas('telcoSender', function ($query) {
            $query->where('status', 'Active');
        })
            ->whereHas('telco', function ($query) {
                $query->where('status', 'Active');
            })
            ->where('mask_id', '=', $sender->mask_id)
            ->where('config_telco_sender_id', '=', $sender->sender_id)
            ->where('status', 'Active')
            ->first();

        if (!$maskTelcoSender instanceof MaskTelcoSender) {

            $this->setNonmaskSenderInfo($sender->mask_id);

        } else {

            if (isset($sender->telco_username) && isset($sender->telco_username) && isset($sender->telco_id)) {
                if ($sender->telco_prefix == '015') {
                    $this->_userid = decrypt($sender->mask_username);
                    $this->_password = decrypt($sender->mask_password);
                } else {
                    $this->_userid = decrypt($sender->telco_username);
                    $this->_password = decrypt($sender->telco_password);
                }
                $this->_telcoid = $sender->telco_id;
                $this->telco_options = $sender->telco_options;
                $this->telcoMaskSmsRate = $sender->telco_mask_sms_rate;
                $this->telcoNonmaskSmsRate = $sender->telco_nonmask_sms_rate;
                $this->_telco_prefix = strtoupper($sender->telco_prefix);
                $this->_api_limit = $sender->api_request_limit;
                $this->_sendernumber = $sender->sender_number;
                $this->_senderid = $sender->sender_id;
                $this->_mask_type = $sender->mask_type;
                $this->_message_type = $sender->message_type;
                $this->_mask_name = ($this->_mask_type == 'Mask') ? $sender->mask_name : '88' . substr($this->_sendernumber, -11);
                $this->localization = LocalizationTypeEnum::Local;
                return true;
            }
            return false;
        }

    }