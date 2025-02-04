<?php
namespace app\models;
use PDO;
use Exception;
class TransactionCaisseModel extends BaseModel
{
  
    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function getMontantActuel($date) {
        $sql = "SELECT montant FROM elevage_TransactionCaisse WHERE dateTransaction = :date";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':date', $date);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return !empty($result) ? $result[0]['montant'] : 0;
    }

    public function getRevenusTotal(){
        $sql = "SELECT sum(montant) montant from elevage_TransactionCaisse where montant > 0";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute()->fetch();
    }

    public function getEvolutionCapital($date1, $date2){
        $sql = "SELECT montant from elevage_TransactionCaisse where dateTransaction >= ? and dateTransaction <= ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1,$date1);
        $stmt->bindValue(2,$date2);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    public function achatAnimal($idEspece, $poidsInitial, $poidsActuel, $nomAnimal, $montantAchat, $dateAchat) {
        try {

            // Insérer dans la table elevage_Animal
            $queryInsertAnimal = "INSERT INTO elevage_Animal (idEspece, PoidsInitial, PoidsActuel, NomAnimal) 
                                  VALUES (:idEspece, :poidsInitial, :poidsActuel, :nomAnimal)";
            $stmtInsertAnimal = $this->db->prepare($queryInsertAnimal);
            $stmtInsertAnimal->bindValue(':idEspece', $idEspece, PDO::PARAM_INT);
            $stmtInsertAnimal->bindValue(':poidsInitial', (string)$poidsInitial);
            $stmtInsertAnimal->bindValue(':poidsActuel', (string)$poidsActuel);
            $stmtInsertAnimal->bindValue(':nomAnimal', $nomAnimal);

            $stmtInsertAnimal->execute();
            // if (!$stmtInsertAnimal->execute()) {
            //     throw new Exception("Erreur lors de l'insertion dans la table elevage_Animal.");
            // }

            // Récupérer l'ID de l'animal inséré
            $idAnimal = $this->db->lastInsertId();

            // Insérer dans la table elevage_HistoriqueAchatAnimal
            $queryInsertHistoriqueAchat = "INSERT INTO elevage_HistoriqueAchatAnimal (idAnimal, dateAchat, montant) 
                                           VALUES (:idAnimal, :dateAchat, :montant)";
            $stmtInsertHistoriqueAchat = $this->db->prepare($queryInsertHistoriqueAchat);
            $stmtInsertHistoriqueAchat->bindValue(':idAnimal', $idAnimal);
            $stmtInsertHistoriqueAchat->bindValue(':dateAchat', $dateAchat);
            $stmtInsertHistoriqueAchat->bindValue(':montant', (string)$montantAchat);

            $stmtInsertHistoriqueAchat->execute();
            // if (!$stmtInsertHistoriqueAchat->execute()) {
            //     throw new Exception("Erreur lors de l'insertion dans la table elevage_HistoriqueAchatAnimal.");
            // }

            // Mettre à jour la caisse avec type=2 pour l'achat d'un animal
            $this->majCaisse($montantAchat * -1, 2, $dateAchat);

            return true;

        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    // Méthode pour effectuer l'achat de nourriture
    public function achatNourriture( $idNourriture, $quantite, $prixUnitaire, $dateAchat) {
        try {
            // Insérer dans la table elevage_HistoriqueAchatNourriture
            $montantTotal = $quantite * $prixUnitaire; // Calcul du montant total
            $queryInsertHistoriqueAchatNourriture = "INSERT INTO elevage_HistoriqueAchatNourriture (dateAchat, quantite, idNourriture, prixUnitaire) 
                                                     VALUES (:dateAchat, :quantite, :idNourriture, :prixUnitaire)";
            $stmtInsertHistoriqueAchatNourriture = $this->db->prepare($queryInsertHistoriqueAchatNourriture);
            $stmtInsertHistoriqueAchatNourriture->bindValue(':dateAchat', $dateAchat);
            $stmtInsertHistoriqueAchatNourriture->bindValue(':quantite', $quantite);
            $stmtInsertHistoriqueAchatNourriture->bindValue(':idNourriture', $idNourriture);
            $stmtInsertHistoriqueAchatNourriture->bindValue(':prixUnitaire', $prixUnitaire);

            $stmtInsertHistoriqueAchatNourriture->execute();
            // if (!$stmtInsertHistoriqueAchatNourriture->execute()) {
            //     throw new Exception("Erreur lors de l'insertion dans la table elevage_HistoriqueAchatNourriture.");
            // }

            // Mettre à jour la caisse avec type=1 pour l'achat de nourriture
            $this->majCaisse($montantTotal * -1, 1, $dateAchat);

            return true;

        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    // Méthode pour effectuer la vente d'un animal
    public function venteAnimal($idAnimal, $montantVente, $dateVente) {
        try {

            // Insérer dans la table elevage_HistoriqueVente
            $queryInsertHistoriqueVente = "INSERT INTO elevage_HistoriqueVente (idAnimal, dateVente, montant) 
                                           VALUES (:idAnimal, :dateVente, :montant)";
            $stmtInsertHistoriqueVente = $this->db->prepare($queryInsertHistoriqueVente);
            $stmtInsertHistoriqueVente->bindValue(':idAnimal', $idAnimal);
            $stmtInsertHistoriqueVente->bindValue(':dateVente', $dateVente);
            $stmtInsertHistoriqueVente->bindValue(':montant', (string)$montantVente);

            if (!$stmtInsertHistoriqueVente->execute()) {
                throw new Exception("Erreur lors de l'insertion dans la table elevage_HistoriqueVente.");
            }

            // Mettre à jour la caisse avec type=3 pour la vente d'un animal
            $this->majCaisse($montantVente, 3, $dateVente);

            return true;

        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    // Méthode privée pour mettre à jour la caisse
    private function majCaisse($montant, $typeId, $dateTransaction) {
        try {
            // Récupérer le montant actuel précédent depuis la dernière transaction
            $queryGetMontantActuelPrecedent = "SELECT montantActuel FROM elevage_TransactionCaisse ORDER BY id DESC LIMIT 1";
            $stmtGetMontantActuelPrecedent = $this->db->query($queryGetMontantActuelPrecedent);
            $montantActuelPrecedent = 0; // Initialiser à 0 si aucune transaction n'existe encore
            if ($row = $stmtGetMontantActuelPrecedent->fetch(PDO::FETCH_ASSOC)) {
                $montantActuelPrecedent = $row['montantActuel'];
            }

            // Calculer le nouveau montant actuel
            $nouveauMontantActuel = $montantActuelPrecedent + $montant;

            // Insérer dans la table elevage_TransactionCaisse
            $queryInsertTransaction = "INSERT INTO elevage_TransactionCaisse (dateTransaction, typeId, montant, montantActuel) 
                                       VALUES (:dateTransaction, :typeId, :montant, :montantActuel)";
            $stmtInsertTransaction = $this->db->prepare($queryInsertTransaction);
            $stmtInsertTransaction->bindValue(':dateTransaction', $dateTransaction);
            $stmtInsertTransaction->bindValue(':typeId', (string)$typeId);
            $stmtInsertTransaction->bindValue(':montant', (string)$montant);
            $stmtInsertTransaction->bindValue(':montantActuel', (string)$nouveauMontantActuel);

            if (!$stmtInsertTransaction->execute()) {
                throw new Exception("Erreur lors de l'insertion dans la table elevage_TransactionCaisse.");
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getTransactionsByDate($date) {
        $sql = "SELECT * FROM elevage_TransactionCaisse WHERE dateTransaction <= :date";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':date', $date);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertCapital($data) {
        $sql = "SELECT montantActuel FROM elevage_TransactionCaisse ORDER BY dateTransaction DESC LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $previousMontantActuel = $result ? $result['montantActuel'] : 0;

        $data['montantActuel'] = $data['montant'] + $previousMontantActuel;

        $sql = "INSERT INTO elevage_TransactionCaisse (montant, dateTransaction, typeId, montantActuel) 
                VALUES (:montant, :dateTransaction, :typeId, :montantActuel)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':montant', (string)$data['montant']);
        $stmt->bindValue(':dateTransaction', (string)$data['dateTransaction']);
        $stmt->bindValue(':typeId', (string)$data['typeId']);
        $stmt->bindValue(':montantActuel', (string)$data['montantActuel']);
        $stmt->execute();
    }

}