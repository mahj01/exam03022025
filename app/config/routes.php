<?php
use app\controllers\AnimalController;
use app\controllers\NourritureController;
use app\controllers\EspeceController;

$animalController = new AnimalController();
$nourritureController = new NourritureController();
$animalController = new AnimalController();
$especeController = new EspeceController();
// Antonio route
$router->get('/',function () {
	Flight::redirect('dashboard');
});

$router->get('/dashboard',[$animalController,'dashboard']);
$router->get('/stock-nourriture',[$nourritureController,'stockNourriture']);

// Antonio route
$router->get('/dashboard',[$animalController,'dashboard']);

//CoNTROLLERS
$especeController = new EspeceController();
//FIN CONTROLLERS



//CRUD ESPECE
$router->get('/especes', [$especeController, 'getAllEspece']);
//FIN CRUD ESPECE
