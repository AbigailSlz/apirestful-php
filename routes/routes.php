<?php

//RUTA -> /api/
require_once "helpers/permissions.php";

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


    $Token = new Token();
    $Permissions = new Permissions();
    //Validar cada ruta 
    switch(strtolower($method).':'.$routeName){
    
        case 'post:usuarios':
                      
            //Verificar token
            $token = $Token->verifyJWT($_SERVER['HTTP_AUTHORIZATION']);
                   
            if($token){
                
                //Validar los permisos del rol
                $permission = $Permissions->verify_rol($token->data->rol,strtolower($method));
              
                if($permission){
                    //Realizar acción
                    $register = new UsersController();
                    $register -> create();   

                }else{
                    //Denegar acceso
                    $response = array(
                        "status" => 403,
                        "error" => "Acceso denegado",
                    );
                    http_response_code(403);
                    echo json_encode($response, true);
                    return;
                }                

            }         

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





