<?php

use app\controllers\AnimalController;

$animalController = new AnimalController();

$router->get('/',function () {
	Flight::redirect('dashboard');
});

$router->get('/dashboard',[$animalController,'dashboard']);



//CRUD ESPECE
$router->get('/animaux', 'AnimalController@index');
//FIN CRUD ESPECE
