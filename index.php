<?php
header('Content-type: application/json');
//Controladores
require_once 'controllers/routesController.php';
require_once 'controllers/usersController.php';
require_once 'controllers/authController.php';
require_once 'controllers/publicationsController.php';



//Modelos
require_once 'models/usersModel.php';
require_once 'models/publicationsModel.php';


$routes = new RoutesController();
$routes -> index();

