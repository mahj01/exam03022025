<?php

namespace app\controllers;

use Flight;

class AnimalController
{
    public function dashboard() {
        Flight::render('index');
    }
}