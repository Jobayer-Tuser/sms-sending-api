<?php
namespace App\Controllers;

use App\Libs\Eloquent;

class TelcoRoute {

    private object $db;

    public function __construct()
    {
        $this->db = Eloquent::getInstance();
    }

    public function getTelcoRoute(int $maskId, string $maskType, string $telPrefix) 
    {
        if ($maskType == "Mask") {
            $route = $this->getMaskingTelco($maskId, $telPrefix);
            if ($route) {
                return $route;
            }
        }

        $route = $this->getNonMaskTelco($maskId);
        
        if (!$route) {
            $route = $this->getDefaultNonmaskTelco();
        }
        return $route;
    }

    public function getMaskingTelco(int $maskId, string $telPrefix)
    {
        $sql = 'SELECT 
                    mtsr.mask_name,
                    mtsr.telco_id,
                    mtsr.telco_mask_type,
                    cts.telco_username,
                    cts.telco_password,
                    cts.sender_number,
                    cts.id AS sender_id,
                    t.telco_prefix  

                FROM `mask_telco_sender_routes` AS mtsr 
                LEFT JOIN config_telco_senders AS cts 
                    ON mtsr.config_telco_sender_id = cts.id
                LEFT JOIN `telcos` AS t 
                    ON t.id =  mtsr.telco_id
                WHERE t.telco_prefix = "'. $telPrefix .'"
                    AND mtsr.mask_id = "'. $maskId.'" 
                    AND mtsr.status = "Active" 
                    AND cts.status = "Active" 
                    AND t.status = "Active" 
                    AND mtsr.telco_mask_type = "Mask"';

        return $this->db->getFirst($sql);

    }


    public function getNonMaskTelco(int $maskId)
    {
        $sql = 'SELECT 
                    mtsr.mask_name,
                    mtsr.telco_id,
                    cts.telco_username,
                    cts.telco_password,
                    cts.sender_number,
                    cts.id AS sender_id,
                    "Nonmask" AS telco_mask_type,
                    t.telco_prefix,
                    t.telco_name

                FROM `mask_telco_sender_routes` AS mtsr 
                LEFT JOIN config_telco_senders AS cts 
                    ON mtsr.config_telco_sender_id = cts.id
                LEFT JOIN Telcos AS t 
                    ON t.id =  mtsr.telco_id
                WHERE mtsr.mask_id = "'. $maskId .'" 
                    AND mtsr.status = "Active" 
                    AND cts.status = "Active" 
                    AND t.status = "Active" 
                    AND mtsr.telco_mask_type = "Nonmask"
                    AND mtsr.default_nonmask = 1';

        return $this->db->getFirst($sql);
    }


    public function getDefaultNonMaskTelco()
    {
        $sql = 'SELECT 
                    "" AS mask_name,
                    cts.telco_id,
                    cts.telco_username,
                    cts.telco_password,
                    cts.sender_number,
                    cts.id AS sender_id ,
                    "Nonmask" AS telco_mask_type,
                    t.telco_prefix ,
                    t.telco_name

                FROM `mask_telco_sender_routes` AS mtsr 
                LEFT JOIN config_telco_senders AS cts 
                    ON mtsr.config_telco_sender_id = cts.id
                LEFT JOIN telcos AS t ON t.id =  mtsr.telco_id
                WHERE cts.status = "Active" 
                    AND t.status = "Active" 
                    AND cts.default_nonmask_gateway = 1';

        return  $this->db->getFirst($sql);
    }

    public function getTelcoLogs()
    {
        
    }

}