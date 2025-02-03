<?php
namespace app\models;
use PDO;
use Flight;
use Exception;
class AnimalModel extends BaseModel
{
    
    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function getDeadCount(){
        $sql = "SELECT count(*) nbMorts from elevage_AnimalDecede";
        $stmt = $this->db->query($sql);
        return $stmt->fetch();
    }

    public function getDeadCountByDate($date){
        $sql = "SELECT count(*) nbMorts from elevage_AnimalDecede where dateDeces <= ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1,$date);
        return $stmt->fetch();
    }

    public function getDernierJourAlim($idAnimal){
        $sql = "select dateAlimentation from elevage_HistoriqueAlimentation where idAnimal=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1,$idAnimal);
        return $stmt->fetch();
    }

    public function getNbJourSansManger($idAnimal){
        $dernierJour = $this->getDernierJourAlim($idAnimal)["dateAlimentation"];
    }
    
    public function getPoidsInit($idAnimal){
        $sql = "select PoidsInitial from elevage_Animal where idAnimal=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1,$idAnimal);
        return $stmt->fetch();
    }

    public function getPoidsActuel($idAnimal){
        $sql = "select PoidsActuel from elevage_Animal where idAnimal=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1,$idAnimal);
        return $stmt->fetch();
    }

    public function getAlimentation($idAnimal,$date){
        $sql = "select coalesce(id,0) alimentation from elevage_HistoriqueAlimentation where idAnimal = ? and dateAlimentation = ?";
        $stmt = $this->db->prepare($sql);    
        $stmt->bindValue(1,$idAnimal);
        $stmt->bindValue(2,$date);
        return $stmt->fetch();
    }

    public function getPerteParJour($idAnimal){
        $sql = "select PerteParJour from elevage_Espece EE join (select idEspece from elevage_Animal where id = ?) EA on EE.id = EA.idEspece";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1,$idAnimal);
        return $stmt->fetch();
    }

    public function getPoidsByDate($idAnimal,$date){
        $sql = "select poids from elevage_HistoriquePoids where idAnimal = ? and dateStockage = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1,$idAnimal);
        $stmt->bindValue(2,$date);
        return $stmt->fetch();
    }

    public function nourrir($idAnimal,$idNourriture){
        $sql = "INSERT INTO elevage_HistoriquePoids values (null,?,?,curdate())";
        $poidsActuel = $this->getPoidsActuel($idAnimal); 
        $newPoids = $poidsActuel*(1+Flight::nourritureModel()->getGain($idNourriture)/100);
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1,$idAnimal);
        $stmt->bindValue(2,$newPoids);
        $stmt->execute();
    }

    public function skipNourrir($idAnimal,$idNourriture){
        $sql = "INSERT INTO elevage_HistoriquePoids values (null,?,?,curdate())";
        $poidsActuel = $this->getPoidsActuel($idAnimal)["PoidsActuel"]; 
        $newPoids = $poidsActuel*(1-$this->getPerteParJour($idAnimal)["PerteParJour"]/100);
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1,$idAnimal);
        $stmt->bindValue(2,$newPoids);
        $stmt->execute();
    }

    public function getEstimationValeur($idAnimal,$date){

        $prixParKg = Flight::especeModel()->getPrixParKg()["PrixParKg"];
        $poids = $this->getPoidsByDate($idAnimal,$date)["poids"];

        return $prixParKg*$poids;
    }

    public function getEstimationByEspece($date,$idEspece){
        $somme = 0;
        $sql = "SELECT idAnimal from elevage_Animal where idEspece = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1,$idEspece);
        $rs = $stmt->execute()->fetchAll();
        for($i=0; $i<count($rs);$i++){
            $somme += $this->getEstimationValeur($rs[$i]["idAnimal"],$date);
        }
        return $somme;

    }


    public function getEvolutionPoids($idAnimal,$date){
        $sql = "select dateStockage, poids from elevage_HistoriquePoids where dateStockage <= ? AND idAnimal = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1,$date);
        $stmt->bindValue(2,$idAnimal);
        return $stmt->fetchAll();
    }







    
}