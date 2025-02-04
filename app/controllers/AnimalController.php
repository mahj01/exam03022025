<?php

namespace app\controllers;

use app\models\AnimalModel;
use Flight;

class AnimalController
{
    public function dashboard() {
        $data = ['page'=>'dashboard'];
        Flight::render('template',$data);
    }

    public function goToAchatPage() {
        $especes = Flight::especeModel()->getAllEspece();
        $data = ['page' => 'achat-animal-content', 'especes' => $especes];
        Flight::render('template', $data);
    }

    public function achatAnimal() {
        $NomAnimal = Flight::request()->data->NomAnimal;
        $Espece = Flight::request()->data->Espece;
        $Poids = Flight::request()->data->Poids;
        $Prix = Flight::request()->data->Prix;
        $DateAchat = Flight::request()->data->DateAchat;
        
            Flight::transactionCaisseModel()->achatAnimal($Espece, $Poids,$Poids,$NomAnimal,  $Prix, $DateAchat);
       
        
        Flight::redirect('/');
    }
}