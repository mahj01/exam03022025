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
}