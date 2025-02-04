<?php
namespace app\models;
use PDO;
use Flight;
class AnimalModel extends BaseModel
{
    private $db;
    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function getDeadCount(){
        $sql = "SELECT count(*) nbMorts from elevage_AnimalDecede";
        $stmt = $this->db->query($sql);
        return $stmt->fetch();
    }

    public function getEspece($id){
        $sql = "SELECT idEspece from eleve_Animal where id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1,$id);
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

    public function nourrir($idAnimal,$idNourriture,$dateAlim){
        $especeId = $this->getEspece($idAnimal)["idEspece"];
        $qteJournaliere = Flight::especeModel()->getQteJournaliereById($especeId);
        $stock = Flight::nourritureModel()->stockNourritureById($idNourriture)["qte_restant"];
        if($stock>=$qteJournaliere){
            $sql1 = "INSERT INTO elevage_HistoriqueAlimentation values (null,?,?,?,?)"; 
            $stmt = $this->db->prepare($sql1);
            $stmt->bindValue(1,$idAnimal);
            $stmt->bindValue(2,$dateAlim);
            $stmt->bindValue(3,$qteJournaliere);
            $stmt->bindValue(4,$idNourriture);
            $stmt->execute();

            $sql = "INSERT INTO elevage_HistoriquePoids values (null,?,?,curdate())";
            $poidsActuel = $this->getPoidsActuel($idAnimal); 
            $newPoids = $poidsActuel*(1+Flight::nourritureModel()->getGain($idNourriture)/100);
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(1,$idAnimal);
            $stmt->bindValue(2,$newPoids);
            $stmt->execute();
        }else{
            $this->skipNourrir($idAnimal,$idNourriture);
        }

    }

    public function getNourriture($idAnimal){
        $idEspece = $this->getEspece($idAnimal);
        $sql = "SELECT id FROM elevage_Nourriture where idEspece = ? limit 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1,$idEspece);
        return $stmt->execute()->fetch();
    }

    public function getAllAnimalsAlive(){
        $sql = "SELECT idAnimal from elevage_Animal not in (SELECT idAnimal from elevage_AnimalDecede)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute()->fetchAll();

    }

    public function simuler($date){
        $dateDepart = new \DateTime();
        $listeAnimaux = $this->getAllAnimalsAlive();
        while($dateDepart<=$date){
            for($i=0;$i<count($listeAnimaux);$i++){
                $idAnimal = $listeAnimaux[$i]["idAnimal"];
                $idNourriture = $this->getNourriture($idAnimal);
                $this->nourrir($idAnimal,$idNourriture,$dateDepart);
            }
            $dateDepart->modify("+1 day");
        }
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