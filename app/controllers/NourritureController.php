<?php

namespace app\controllers;

use app\models\NourritureModel;
use Flight;

class NourritureController extends BaseController
{
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
        $data = ['page' => 'modify-nourriture-content', 'nourriture' => $nourriture];
        Flight::render('template', $data);
    }

    public function updateNourriture($id)
    {
        $data = [
            'NomNourriture' => Flight::request()->data->NomNourriture,
            'Quantite' => Flight::request()->data->Quantite
        ];
        Flight::nourritureModel()->updateNourriture($id, $data);
        Flight::redirect('/nourritures');
    }

    public function addNourriture()
    {
        $data = [
            'NomNourriture' => Flight::request()->data->NomNourriture,
            'Quantite' => Flight::request()->data->Quantite
        ];
        Flight::nourritureModel()->insert($data);
        Flight::redirect('/nourritures');
    }

    public function deleteNourriture($id)
    {
        Flight::nourritureModel()->delete($id);
        Flight::redirect('/nourritures');
    }
}
