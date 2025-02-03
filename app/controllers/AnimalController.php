<?php

namespace app\controllers;


use app\models\AnimalModel;

use Flight;
class AnimalController
{
    public function dashboard() {
        Flight::render('index');
    }
}