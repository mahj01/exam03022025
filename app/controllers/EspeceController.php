<?php

namespace app\controllers;
use app\models\EspeceModel;
use Flight;

class EspeceController extends BaseController{

    public function __construct() {
        
    }

    public function getAllEspece(){
        $especes = Flight::especeModel()->getAllEspece();
        $data = ['page' => 'liste-espece-content', 'especes'=>$especes];
        Flight::render('template',$data);
        
    }

    public function goToModifyPage($id){
        $espece = Flight::especeModel()->getEspeceById($id);
        $data = ['page' => 'modify-espece-content', 'espece'=>$espece];
        Flight::render('template',$data);
    }

    public function updateEspece($id){
        $data = [
            'NomEspece' => Flight::request()->data->NomEspece,
            'PoidsMinVente' => Flight::request()->data->PoidsMinVente,
            'PoidsMax' => Flight::request()->data->PoidsMax,
            'PrixParKg' => Flight::request()->data->PrixParKg,
            'NbJoursAvantDeMourir' => Flight::request()->data->NbJoursAvantDeMourir
        ];
        Flight::especeModel()->updateEspece($id, $data);
        Flight::redirect('/especes');
    }
}