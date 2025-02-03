<?php

namespace app\models;


class NourritureModel
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function stockNourriture()
    {
        $sql = "SELECT HAN.idNourriture id, EN.NomNourriture nom,sum(HAN.quantite)-sum(coalesce(HA.quantite,0)) qte_restant
                from elevage_HistoriqueAchatNourriture HAN
                left join elevage_HistoriqueAlimentation HA
                on HAN.idNourriture=HA.idNourriture
                join elevage_Nourriture EN
                on EN.id = HAN.idNourriture
                group by HAN.idNourriture";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}
