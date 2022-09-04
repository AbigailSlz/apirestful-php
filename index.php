<?php
header('Content-type: application/json');
//Controladores
require_once 'controllers/routesController.php';
require_once 'controllers/usersController.php';
require_once 'controllers/authController.php';


//Modelos
require_once 'models/usersModel.php';

$routes = new RoutesController();
$routes -> index();

