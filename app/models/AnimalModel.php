<?php
namespace app\models;
use PDO;
use Flight;
use DateTime;
class AnimalModel extends BaseModel
{
  
    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function getDeadCount(){
        $sql = "SELECT count(*) nbMorts from elevage_AnimalDecede";
        $stmt = $this->db->query($sql);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getEspece($id){
        $sql = "SELECT idEspece from eleve_Animal where id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1,$id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getDeadCountByDate($date){
        $sql = "SELECT count(*) nbMorts from elevage_AnimalDecede where dateDeces <= ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1,$date);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function getDernierJourAlim($idAnimal){
        $sql = "select dateAlimentation from elevage_HistoriqueAlimentation where idAnimal=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1,$idAnimal);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function getNbJourSansManger($idAnimal){
        $dernierJour = $this->getDernierJourAlim($idAnimal);
        return $dernierJour;
    }
    
    public function getPoidsInit($idAnimal){
        $sql = "select PoidsInitial from elevage_Animal where idAnimal=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1,$idAnimal);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getPoidsActuel($idAnimal){
        $sql = "select PoidsActuel from elevage_Animal where id=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1,(string)$idAnimal);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getAlimentation($idAnimal,$date){
        $sql = "select coalesce(id,0) alimentation from elevage_HistoriqueAlimentation where idAnimal = ? and dateAlimentation = ?";
        $stmt = $this->db->prepare($sql);    
        $stmt->bindValue(1,$idAnimal);
        $stmt->bindValue(2,$date);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function getPerteParJour($idAnimal){
        $sql = "select PerteParJour from elevage_Espece EE join (select idEspece from elevage_Animal where id = ?) EA on EE.id = EA.idEspece";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1,$idAnimal);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getPoidsByDate($idAnimal,$date){
        $sql = "select poids from elevage_HistoriquePoids where idAnimal = ? and dateStockage = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1,(string)$idAnimal);
        $stmt->bindValue(2,$date);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function nourrir($idAnimal,$idNourriture,$dateAlim){
        $especeId = $this->getEspece($idAnimal)["idEspece"];
        $qteJournaliere = Flight::especeModel()->getQteJournaliereById($especeId);
        $stock = Flight::nourritureModel()->stockNourritureById($idNourriture)["qte_restant"];
        if(0==0){
            $sql1 = "INSERT INTO elevage_HistoriqueAlimentation (idAnimal,dateAlimentation,quantite,idNourriture) values (?,?,?,?)"; 
            $stmt1 = $this->db->prepare($sql1);
            $stmt1->bindValue(1,$idAnimal);
            $stmt1->bindValue(2,$dateAlim);
            $stmt1->bindValue(3,$qteJournaliere);
            $stmt1->bindValue(4,$idNourriture);
            $stmt1->execute();

            $sql = "INSERT INTO elevage_HistoriquePoids values (0,?,?,curdate())";
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
        $idEspece = $this->getEspece($idAnimal)["idEspece"];
        $sql = "SELECT id FROM elevage_Nourriture where idEspece = ? limit 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1,$idEspece);
        return $stmt->execute()->fetch();
    }

    public function getAllAnimalsAlive(){
        $sql = "SELECT R2.id idAnimal,ABS(EE.PoidsMinVente-R2.PoidsActuel) delta from elevage_Espece EE join (SELECT id,idEspece,PoidsActuel from elevage_Animal EA WHERE id not in (SELECT idAnimal from elevage_AnimalDecede)) R2 on EE.id=R2.idEspece order by delta asc";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();

    }

    public function simuler($date){
        $dateDepart = new DateTime("2025-02-03");
        $dateFin = new DateTime($date);
        $dateFin->format("Y-m-d");
        $listeAnimaux = $this->getAllAnimalsAlive();
        while($dateDepart<=$dateFin){
            for($i=0;$i<count($listeAnimaux);$i++){
                $idAnimal = $listeAnimaux[$i]["idAnimal"];
                $idNourriture = $this->getNourriture($idAnimal)["id"];
                $this->nourrir($idAnimal,$idNourriture,$dateDepart);
            }
            $dateDepart->modify("+1 day");
        }
    }

    public function skipNourrir($idAnimal,$idNourriture){
        $sql = "INSERT INTO elevage_HistoriquePoids (idAnimal,dateAlimentation,quantite,idNourriture) values (?,?,curdate())";
        $poidsActuel = $this->getPoidsActuel($idAnimal)["PoidsActuel"]; 
        $newPoids = $poidsActuel*(1-$this->getPerteParJour($idAnimal)["PerteParJour"]/100);
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1,$idAnimal);
        $stmt->bindValue(2,$newPoids);
        $stmt->execute();
    }

    public function getEstimationValeur($idAnimal,$date,$idEspece){

        $prixParKg = Flight::especeModel()->getPrixParKg($idEspece);
        $poids = $this->getPoidsByDate($idAnimal,$date);

        return $prixParKg*$poids;
    }

    public function getEstimationByEspece($date,$idEspece){
        $somme = 0;
        $sql = "SELECT idAnimal from elevage_Animal where idEspece = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1,$idEspece);
        $rs = $stmt->execute()->fetchAll();
        for($i=0; $i<count($rs);$i++){
            $somme += $this->getEstimationValeur($rs[$i]["idAnimal"],$date,$idEspece);
        }
        return $somme;

    }


    public function getEvolutionPoids($idAnimal,$date){
        $sql = "select dateStockage, poids from elevage_HistoriquePoids where dateStockage <= ? AND idAnimal = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1,$date);
        $stmt->bindValue(2,$idAnimal);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function isAlive($id){
        $sql = "SELECT id from elevage_AnimalDecede where idAnimal = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1,$id);
        $stmt->execute();
        $stmt->fetch();
        return $stmt->rowCount();
    }

    public function getAnimalsByDate($date) {
        $sql = "SELECT ea.* FROM elevage_Animal ea 
                LEFT JOIN elevage_HistoriqueAchatAnimal ehaa ON ea.id = ehaa.idAnimal 
                WHERE ehaa.DateAchat <= :date OR ehaa.DateAchat IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':date', $date);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAnimalById($id) {
        $sql = "SELECT * FROM elevage_Animal WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}