<?php

namespace app\controllers;

use Flight;

class EspeceController
{

    public function __construct() {}

    public function getAllEspece()
    {
        $especes = Flight::especeModel()->getAllEspece();
        $data = ['page' => 'liste-espece-content', 'especes' => $especes];
        Flight::render('template', $data);
    }

    public function goToModifyPage($id)
    {
        $espece = Flight::especeModel()->getEspeceById($id);
        $data = ['page' => 'modify-espece-content', 'espece' => $espece];
        Flight::render('template', $data);
    }

    function goToAddPage()
    {
        $data = ['page' => 'ajout-espece-content'];
        Flight::render('template', $data);
    }

    public function updateEspece($id)
    {
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

    public function addEspece()
    {
        $data = [
            'NomEspece' => Flight::request()->data->NomEspece,
            'PoidsMinVente' => Flight::request()->data->PoidsMinVente,
            'PoidsMax' => Flight::request()->data->PoidsMax,
            'PrixParKg' => Flight::request()->data->PrixParKg,
            'NbJoursAvantDeMourir' => Flight::request()->data->NbJoursAvantDeMourir,
            'prixUnitaire' => $_POST['prixUnitaire']
        ];
        Flight::especeModel()->addEspece($data);
        Flight::redirect('/especes');
    }

    public function deleteEspece($id)
    {
        Flight::especeModel()->markAsDeleted($id);
        Flight::redirect('/especes');
    }
}
