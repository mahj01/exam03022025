<?php

namespace app\controllers;


use app\models\NourritureModel;

use Flight;

class NourritureController
{
    public function stockNourriture()
    {
        $stockNourriture = Flight::nourritureModel()->stockNourriture();
        $data = ['page' => 'stock-nourriture', 'stockNourriture' => $stockNourriture];
        Flight::render('template', $data);
    }
}
