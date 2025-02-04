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
}
