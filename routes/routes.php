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
        case 'post:publicaciones':

            //Verificar token
            $token = $Token->verifyJWT($_SERVER['HTTP_AUTHORIZATION']);
        
            if($token){
                
                //Validar los permisos del rol
                $permission = $Permissions->verify_rol($token->data->rol,strtolower($method));
                
                if($permission){
                    //Realizar acción
                    $Publication = new PublicationsController();
                    $Publication -> create($token->data->id_user);   

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
        case 'put:publicaciones':

            if(isset($routeArray[3]) && is_numeric($routeArray[3])){
                // Verificar token
                $token = $Token->verifyJWT($_SERVER['HTTP_AUTHORIZATION']);
            
                if($token){
                    
                    //Validar los permisos del rol
                    $permission = $Permissions->verify_rol($token->data->rol,strtolower($method));
                    
                    if($permission){
                        //Realizar acción
                        $Publication = new PublicationsController();
                        $Publication -> update($routeArray[3]);   

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
            }else{
                //Denegar acceso
                $response = array(
                    "status" => 404,
                    "error" => "ID no válido",
                );
                http_response_code(404);
                echo json_encode($response, true);
                return;
            }         
    
            break;
        case 'delete:publicaciones':

            if(isset($routeArray[3]) && is_numeric($routeArray[3])){
                // Verificar token
                $token = $Token->verifyJWT($_SERVER['HTTP_AUTHORIZATION']);
            
                if($token){
                    
                    //Validar los permisos del rol
                    $permission = $Permissions->verify_rol($token->data->rol,strtolower($method));
                    
                    if($permission){
                        //Realizar acción
                        $Publication = new PublicationsController();
                        $Publication -> delete($routeArray[3]);   

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
            }else{
                //Denegar acceso
                $response = array(
                    "status" => 404,
                    "error" => "ID no válido",
                );
                http_response_code(404);
                echo json_encode($response, true);
                return;
            }         
    
            break;
        default:
            http_response_code(404);
            echo "Cannot ". $method ." ".$routeName;
            break;
    }
}





