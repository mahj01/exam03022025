<?php

namespace app\controllers;

use app\models\AnimalModel;
use app\models\EspeceModel;
use Flight;

class AnimalController
{
    public function goToAchatPage()
    {
        $especes = Flight::especeModel()->getAllEspece();
        $data = ['page' => 'achat-animal-content', 'especes' => $especes];
        Flight::render('template', $data);
    }

    public function achatAnimal()
    {
        $NomAnimal = Flight::request()->data->NomAnimal;
        $Espece = Flight::request()->data->Espece;
        $Poids = Flight::request()->data->Poids;
        $autovente =Flight::request()->data->Autovente;
        $Prix = Flight::especeModel()->getPrixUnitaire($Espece)['prixUnitaire'];
        $DateAchat = Flight::request()->data->DateAchat;
        Flight::transactionCaisseModel()->achatAnimal($Espece, $Poids, $Poids, $NomAnimal,  $Prix, $DateAchat,$autovente);
        Flight::redirect('/');
    }
}
