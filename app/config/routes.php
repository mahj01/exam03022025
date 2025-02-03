<?php
$router->get('/', function () {
	echo '<a href="lien" >lien</a>';
});
$router->get('/lien',function () {
	echo '<a href="../">mverna</a>';
});




//CRUD ESPECE
$router->get('/animaux', 'AnimalController@index');
//FIN CRUD ESPECE