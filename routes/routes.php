<?php

//RUTA -> /api/

//Obtener la URI en array y filtrarlo  
$routeArray = array_filter(explode("/", $_SERVER["REQUEST_URI"]));
//Contar la longitud del arreglo
$length = count($routeArray);


//Si la longitud es menor a 1, enviar mensaje de error
if($length <= 1){
    
    $response = array(
        "status" => 404,
        "error" => "URL no encontrada",
    );

    http_response_code(404);
    echo json_encode($response, true);

}else{

    //Obtener el nombre de la ruta y el método utilizado
    $routeName = $routeArray[2];
    $method = isset($_SERVER["REQUEST_METHOD"]) ? $_SERVER["REQUEST_METHOD"]: '';

    //Validar cada ruta 
    switch(strtolower($method).':'.$routeName){
    
        case 'post:usuarios':

           $register = new UsersController();
           $register -> create();

            break;
        case 'post:login':

            $Auth = new AuthController();
            $Auth -> login();
 
            break;
        default:
            http_response_code(404);
            echo "Cannot ". $method ." ".$routeName;
            break;
    }
}





