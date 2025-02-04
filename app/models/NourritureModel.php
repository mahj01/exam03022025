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

    public function stockNourritureById($id)
{
    // SQL query with named placeholder
    $sql = "SELECT (SUM(HAN.quantite) - SUM(COALESCE(HA.quantite, 0))) AS qte
            FROM elevage_HistoriqueAchatNourriture HAN
            LEFT JOIN elevage_HistoriqueAlimentation HA
                ON HAN.idNourriture = HA.idNourriture
            JOIN elevage_Nourriture EN
                ON EN.id = HAN.idNourriture
            WHERE HAN.idNourriture = :id
            GROUP BY HAN.idNourriture";

    // Prepare the SQL statement
    $stmt = $this->db->prepare($sql);

    // Bind the parameter to the SQL query
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    // Execute the statement
    $stmt->execute();

    // Fetch the result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Return the quantity ('qte') if it exists, or 0 if no result is found
    return isset($result['qte']) ? $result['qte'] : 0;
}


    public function getGain($id)
    {
        $sql = "SELECT pourcentageGain from elevage_Nourriture where id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        return $stmt->fetch()["pourcentageGain"];
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

    public function getPrixUnitaire($id)
    {
        $sql = "SELECT prixUnitaire from elevage_Nourriture where id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        return $stmt->fetch();
    }
}
