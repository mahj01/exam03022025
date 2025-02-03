<?php

namespace app\controllers;
use app\models\EspeceModel;
use FLight;

class EspeceController extends BaseController{

    public $especeModel ;
    public function __construct($db) {
        $this->especeModel = new EspeceModel($db);
    }

    public function getAllEspece(){
        $especes = $this->especeModel->getAllEspece();
        $this->render();
    }
}