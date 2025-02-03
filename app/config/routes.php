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



//CRUD ESPECE
$router->get('/especes', [$especeController, 'getAllEspece']);
$router->get('/especes/add', [$especeController, 'goToAddPage']);
$router->get('/especes/edit/@id:\d+', [$especeController, 'goToModifyPage']);
$router->post('/especes/traitementModifier/@id:\d+', [$especeController, 'updateEspece']);
$router->post('/especes/traitementAjout', [$especeController, 'addEspece']);
$router->get('/especes/delete/@id:\d+', [$especeController, 'deleteEspece']);
//FIN CRUD ESPECE

//CRUD NOURRITURE
$router->get('/nourritures', [$nourritureController, 'getAllNourriture']);
$router->get('/nourritures/edit/@id:\d+', [$nourritureController, 'goToModifyPage']);
$router->post('/nourritures/traitementModifier/@id:\d+', [$nourritureController, 'updateNourriture']);
$router->post('/nourritures/traitementAjout', [$nourritureController, 'addNourriture']);
$router->get('/nourritures/delete/@id:\d+', [$nourritureController, 'deleteNourriture']);
//FIN CRUD NOURRITURE
