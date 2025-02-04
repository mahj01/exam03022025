<?php

namespace app\controllers;

use app\models\ElevageModel;
use Flight;

class ElevageController
{
    public function __construct()
    {
    }

    public function reinitialiser(){
        $nombreAnimauxAConserver = 3;
        Flight::elevageModel()->supprimerDonnees($nombreAnimauxAConserver);
        Flight::redirect('/');
    }

    public function dashboard() {
        $date = new \DateTime('2025-02-03');
        $montantActuel = Flight::transactionCaisseModel()->getEvolutionCapital($date, $date->modify('+1 day'));
        var_dump($montantActuel) ;
        //$data = ['page' => 'dashboard', 'montantActuel' => $montantActuel];
        //Flight::render('template', $data);
    }
}
