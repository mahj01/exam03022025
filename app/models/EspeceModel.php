<?php

namespace app\models;
use Exception;
use PDO;

class EspeceModel extends BaseModel{
    protected $db;
    
    public function __construct($db){
        parent::__construct($db);
    }
    
    public function getAllEspece(){
        $sql = "SELECT * FROM elevage_Espece WHERE id NOT IN (SELECT idEspece FROM elevage_EspeceSupprime)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEspeceById($id){
        return $this->findBy(['id' => $id],'elevage_Espece')[0];
    }

    public function addEspece($data){
        return $this->insert($data,'elevage_Espece');
    }

    public function updateEspece($id, $data){
        return $this->update(['id' => $id], $data,'elevage_Espece');
    }

    public function deleteEspece($id){
        return $this->delete($id,'elevage_Espece');
    }

    public function markAsDeleted($id)
    {
        $data = ['idEspece' => $id];
        return $this->insert($data, 'elevage_EspeceSupprime');
    }

    public function getPrixParKg($id){
        $sql = "SELECT PrixParKg from elevage_Espece where id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1,$id);
        return $stmt->fetch();
    }
}