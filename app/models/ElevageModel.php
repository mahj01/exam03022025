<?php

namespace app\models;
use PDO;
use PDOException;

class ElevageModel extends BaseModel{
    public function __construct($db){
        parent::__construct($db);
    }

    public function supprimerDonnees($nombreAnimauxAConserver) {
        try {
            // Démarrer une transaction
            $this->db->beginTransaction();

            // Supprimer les enregistrements des tables d'historique
            $this->db->exec("DELETE FROM elevage_HistoriqueAlimentation");
            $this->db->exec("DELETE FROM elevage_HistoriqueAchatNourriture");
            $this->db->exec("DELETE FROM elevage_HistoriqueAchatAnimal");
            $this->db->exec("DELETE FROM elevage_HistoriqueVente");
            $this->db->exec("DELETE FROM elevage_HistoriquePoids");

            // Supprimer les enregistrements de la table TransactionCaisse
            $this->db->exec("DELETE FROM elevage_TransactionCaisse");

            // Supprimer les enregistrements de la table AnimalDecede
            $this->db->exec("DELETE FROM elevage_AnimalDecede");

            // Supprimer les animaux après avoir conservé $nombreAnimauxAConserver enregistrements
            $sql = "DELETE FROM elevage_Animal
                    WHERE id NOT IN (
                        SELECT id
                        FROM (
                            SELECT id
                            FROM elevage_Animal
                            ORDER BY id DESC
                            LIMIT :nombreAnimauxAConserver
                        ) AS tmp
                    )";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':nombreAnimauxAConserver', (string)$nombreAnimauxAConserver, PDO::PARAM_INT);
            $stmt->execute();

            // Supprimer les enregistrements des tables EspeceSupprime et NourritureSupprime
            $this->db->exec("DELETE FROM elevage_EspeceSupprime");
            $this->db->exec("DELETE FROM elevage_NourritureSupprime");
            
            $sql = "DELETE FROM elevage_Nourriture
            WHERE id NOT IN (
                SELECT id
                FROM (
                    SELECT id
                    FROM elevage_Nourriture
                    ORDER BY id DESC
                    LIMIT :nombreNourritureAConserver
                ) AS tmp
            )";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':nombreNourritureAConserver', (string)$nombreAnimauxAConserver, PDO::PARAM_INT);
    $stmt->execute();

            // Valider la transaction
            $this->db->commit();

            return "Suppression des données terminée avec succès.";
        } catch (PDOException $e) {
            // En cas d'erreur, annuler la transaction
            $this->db->rollBack();
            return "Erreur lors de la suppression des données : " . $e->getMessage();
        }
    }
}