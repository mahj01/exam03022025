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
        $imgError = Flight::uploadModel()->checkError($_FILES['photo']);
        if ($imgError!=0) {
            Flight::redirect('/especes/add/?uploadImmgError='.$imgError);
        }
        $imageChemin = Flight::uploadModel()->uploadImg($_FILES['photo']);
        $data = [
            'NomEspece' => Flight::request()->data->NomEspece,
            'PoidsMinVente' => Flight::request()->data->PoidsMinVente,
            'PoidsMax' => Flight::request()->data->PoidsMax,
            'PrixParKg' => Flight::request()->data->PrixParKg,
            'NbJoursAvantDeMourir' => Flight::request()->data->NbJoursAvantDeMourir,
            'prixUnitaire' => $_POST['prixUnitaire'],
            'cheminImage'=>$imageChemin
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
