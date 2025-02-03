<?php
namespace app\models;
use PDO;
class TransactionCaisseModel extends BaseModel
{
    private $db;
    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function getMontantActuel(){
        $sql = "SELECT coalesce(montantActuel,0) montantActuel from elevage_TransactionCaisse where id = ?";
        $lastId = $this->db->lastInsertId();
        if($lastId != 0 || $lastId != ""){
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(1,$lastId);
        }
        return $stmt->fetch();
    }

    public function getDepensesTotal(){
        $sql = "SELECT sum(montant) montant from elevage_TransactionCaisse where montant < 0";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute()->fetch();
        
    }

    public function getRevenusTotal(){
        $sql = "SELECT sum(montant) montant from elevage_TransactionCaisse where montant > 0";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute()->fetch();
    }

    public function evolutionCapital($date){
        $sql = "SELECT montant from elevage_TransactionCaisse where dateTransaction >= ? and dateTransaction <= ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1,$date);
        $stmt->bindValue(2,$date);
        return $stmt->execute()->fetch();

    }


}