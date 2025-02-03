<?php

namespace app\controllers;

use Flight;

class NourritureController {
    public function __construct()
    {
    }

    public function stockNourriture()
    {
        $stockNourriture = Flight::nourritureModel()->stockNourriture();
        $data = ['page' => 'stock-nourriture', 'stockNourriture' => $stockNourriture];
        Flight::render('template', $data);
    }

    public function getAllNourriture()
    {
        $nourritures = Flight::nourritureModel()->getAllNourriture();
        $data = ['page' => 'liste-nourriture-content', 'nourritures' => $nourritures];
        Flight::render('template', $data);
    }

    public function goToModifyPage($id)
    {
        $nourriture = Flight::nourritureModel()->getNourritureById($id);
        $especes = Flight::especeModel()->getAllEspece();
        $data = ['page' => 'modify-nourriture-content', 'nourriture' => $nourriture, 'especes' => $especes];
        Flight::render('template', $data);
    }

    public function goToAddPage()
    {
        $especes = Flight::especeModel()->getAllEspece();
        $data = ['page' => 'ajout-nourriture-content', 'especes' => $especes];
        Flight::render('template', $data);
    }

    public function updateNourriture($id)
    {
        $data = [
            'NomNourriture' => Flight::request()->data->NomNourriture,
            'pourcentageGain' => Flight::request()->data->pourcentageGain,
            'idEspece' => Flight::request()->data->idEspece
        ];
        Flight::nourritureModel()->updateNourriture($id, $data);
        Flight::redirect('/nourritures');
    }

    public function addNourriture()
    {
        $data = [
            'NomNourriture' => Flight::request()->data->NomNourriture,
            'pourcentageGain' => Flight::request()->data->pourcentageGain,
            'idEspece' => Flight::request()->data->idEspece
        ];
        Flight::nourritureModel()->insert($data);
        Flight::redirect('/nourritures');
    }

    public function deleteNourriture($id)
    {
        Flight::nourritureModel()->markAsDeleted($id);
        Flight::redirect('/nourritures');
    }
}
