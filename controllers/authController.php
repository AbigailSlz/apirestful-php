<?php

require_once "vendor/autoload.php";
require_once "functions/validations.php";
require_once "helpers/jwt.php";


class AuthController{

    public function login(){

        //Obtener datos por json y decodificarlos
        $rawinput = file_get_contents("php://input");
        $json = json_decode($rawinput);

        //Validar si es petición post o json
        if($json){
            //Verificar si existe la variable esperada
            $correo   = isset($json->correo) ? $json->correo:'';
            $password = isset($json->password) ? $json->password:'';
        }else{
            $correo   = isset($_POST["correo"])? $_POST["correo"]:'';
            $password = isset($_POST["password"])? $_POST["password"]:'';
        }
       
        //Validar caracteres
        $correo = validation_string($correo,'email','correo');
        $password = validation_string($password,'password','password');

        //Dar formato a los errores
        $errors = [];
        if($correo["error"] ||  $password["error"]){
            array_push($errors,$correo["error"]);
            array_push($errors,$password["error"]);
        }
        $formattedErrors = array ("errors" => array_values(array_filter($errors)));
      
        //Si no existen errores continuar con la ejecución
        if(!$formattedErrors["errors"]){

            //Dar formato al password 
            $salt = 'secretpswd';
            $pass = md5($password["value"].$salt);

            //Buscar usuario concidente
            $Usuarios = new usersModel();
            $usuarios = $Usuarios->login($correo["value"], $pass);
            
            //Validar si se obtuvo un usuario

            if($usuarios->num_rows){

                foreach($usuarios as $key){

                    $data = array(
                        "nombre" =>$key["nombre"],
                        "apellidos" => $key["apellidos"],
                        "correo" => $key["correo"],
                        "rol" => $key["rol"]
                    );

                    //Generar el token
                    $Token = new token();
                    $token = $Token->generateJWT($key["id_user"], $key["rol"]);

                }

                $response = array(
                    "status" => 200,
                    "usuario" => $data,
                    "token" => $token
                );
            
                http_response_code(200);
                echo json_encode($response, true);
                return;

            }else{
                $response = array(
                    "status" => 400,
                    "error" => "Usuario o contraseña icorrectos",
                );
            
                http_response_code(400);
                echo json_encode($response, true);
                return;
            }

        }else{
            
            http_response_code(400);
            echo json_encode($formattedErrors, true);
            return;

        }
      
    }
}