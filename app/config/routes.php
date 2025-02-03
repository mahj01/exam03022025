<?php

use app\controllers\AnimalController;

$animalController = new AnimalController();

// Antonio route
$router->get('/',function () {
	Flight::redirect('dashboard');
});

$router->get('/dashboard',[$animalController,'dashboard']);
// Antonio route



//CRUD ESPECE
$router->get('/animaux', 'AnimalController@index');
//FIN CRUD ESPECE
