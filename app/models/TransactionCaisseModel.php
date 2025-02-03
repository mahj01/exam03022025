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

    public function getDepenseTotal($date){
        $sql = "SELECT sum(montant) depense from elevage_TransactionCaisse where dateTransaction <= ? and (typeTransaction = 1 OR typeTransaction = 2)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1,$date);
        return $stmt->fetch();
    }

    public function getDepenseNourriture($date){
        $sql = "SELECT sum(montant) depense from elevage_TransactionCaisse where dateTransaction <=? and typeTransaction = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1,$date);
        return $stmt->fetch();
    }

    public function getDepenseAchatAnimal($date){
        $sql = "SELECT sum(montant) depense from elevage_TransactionCaisse where dateTransaction <=? and typeTransaction = 2";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1,$date);
        return $stmt->fetch();
    }

    public function getPourcentageDepense($date){
        $depenseTotal = $this->getDepenseTotal($date)["depense"];
        $depenseNourriture = $this->getDepenseNourriture($date)["depense"];
        $depenseAchatAnimal = $this->getDepenseAchatAnimal($date)["depense"];
        $pourcentageNourriture = ($depenseNourriture/$depenseTotal)*100;
        $pourcentageAchatAnimal = ($depenseAchatAnimal/$depenseTotal)*100;
        return ["achatNourriture" => $pourcentageNourriture, "achatAnimal" => $pourcentageAchatAnimal];
    }


}