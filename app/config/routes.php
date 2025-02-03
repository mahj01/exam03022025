<?php


use app\controllers\AnimalController;
use app\controllers\EspeceController;

$animalController = new AnimalController();
$especeController = new EspeceController();

$router->get('/', function () {
	echo '<a href="lien" >lien</a>';
});
$router->get('/lien',function () {
	echo '<a href="../">mverna</a>';
});


// Antonio route
$router->get('/dashboard',[$animalController,'dashboard']);


//CoNTROLLERS
$especeController = new EspeceController();
//FIN CONTROLLERS


//CRUD ESPECE
$router->get('/especes', [$especeController, 'getAllEspece']);
//FIN CRUD ESPECE
