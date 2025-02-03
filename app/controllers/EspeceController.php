<?php

namespace app\controllers;
use app\models\EspeceModel;
use Flight;

class EspeceController extends BaseController{

    public function __construct() {
        
    }

    public function getAllEspece(){
        $especes = Flight::especeModel()->getAllEspece();
        $this->render('listeEspeceContent', 'template', 'Liste Especes', ['especes' => $especes]);
    }

    public function goToModifyPage($id){
        $espece = Flight::especeModel()->getEspeceById($id);
        $this->render('modifyEspeceContent', 'template', 'Modifier Espece', ['espece' => $espece]);
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