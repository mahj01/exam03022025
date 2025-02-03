<?php

namespace app\models;
use Exception;
use PDO;

class EspeceModel extends BaseModel{
    public function __construct($db){
        parent::__construct($db);
    }
    
    public function getAllEspece(){
        return $this->selectAll('*','elevage_Espece');
    }

    public function getEspeceById($id){
        return $this->getById($id,'elevage_Espece');
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
}