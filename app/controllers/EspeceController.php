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
}