<?php

//Controladores
require_once 'controllers/routesController.php';
require_once 'controllers/usersController.php';

//Modelos
require_once 'models/usersModel.php';

$routes = new RoutesController();
$routes -> index();

