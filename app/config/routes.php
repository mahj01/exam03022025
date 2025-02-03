<?php

use app\controllers\AnimalController;
use app\controllers\NourritureController;

$animalController = new AnimalController();
$nourritureController = new NourritureController();
// Antonio route
$router->get('/',function () {
	Flight::redirect('dashboard');
});

$router->get('/dashboard',[$animalController,'dashboard']);
$router->get('/stock-nourriture',[$nourritureController,'stockNourriture']);
// Antonio route


//CRUD ESPECE
$router->get('/animaux', 'AnimalController@index');
//FIN CRUD ESPECE
