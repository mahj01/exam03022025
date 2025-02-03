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

    

}