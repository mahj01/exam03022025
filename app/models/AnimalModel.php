<?php
namespace app\models;
use PDO;
class AnimalModel extends BaseModel
{

    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function getDeadCount(){
        $sql = "SELECT count(*) from elevage_AnimalDecede";
        $stmt = $this->db->query($sql);
        return $stmt->fetch();
    }

    public function getDeadCountByDate($date){
        $sql = "SELECT count(*) from elevage_AnimalDecede where dateDeces <= ?";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1,date);
        return $stmt->fetchAll();
    }

    
}