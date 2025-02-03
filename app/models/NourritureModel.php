<?php

namespace app\models;

use PDO;

class NourritureModel extends BaseModel
{
    
    public function __construct($db)
    {
        parent::__construct($db);
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

    public function getGain($id){
        $sql = "SELECT pourcentageGAin from elevage_Nourriture where id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1,$id);
        return $stmt->fetch();
    }

    public function getAllNourriture()
    {
        $sql = "SELECT * FROM elevage_Nourriture WHERE id NOT IN (SELECT idNourriture FROM elevage_NourritureSupprime)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNourritureById($id)
    {
        $criteria = ['id' => $id];
        return $this->findBy($criteria, 'elevage_Nourriture')[0];
    }

    public function updateNourriture($id, $data)
    {
        $criteria = ['id' => $id];
        return $this->update($criteria, $data, 'elevage_Nourriture');
    }

    public function markAsDeleted($id)
    {
        $data = ['idNourriture' => $id];
        return $this->insert($data, 'elevage_NourritureSupprime');
    }
}
