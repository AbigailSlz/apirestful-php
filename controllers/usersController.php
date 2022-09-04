<?php

require_once "functions/validations.php";

class UsersController{

    public function create(){

        //Obtener datos por json y decodificarlos
        $rawinput = file_get_contents("php://input");
        $json = json_decode($rawinput);

        //Validar si es petición post o json
        if($json){
            //Verificar si existe la variable esperada
            $nombre   = isset($json->nombre) ? $json->nombre:'';
            $apellido = isset($json->apellido) ? $json->apellido:'';
            $correo   = isset($json->correo)? $json->correo:'';
            $rol      = isset($json->rol)? $json->rol:'';
        }else{
            $nombre   = isset($_POST["nombre"])? $_POST["nombre"]:'';
            $apellido = isset($_POST["apellido"])? $_POST["apellido"]:'';
            $correo   = isset($_POST["correo"])? $_POST["correo"]:'';
            $rol      = isset($_POST["rol"])? $_POST["rol"]:'';
        }
       
        //Validar caracteres
        $nombre = validation_string($nombre,'string','nombre');
        $apellido = validation_string($apellido,'string','apellido');
        $correo = validation_string($correo,'email','correo');
        $rol = validation_string($rol,'string','rol');

        //Dar formato a los errores
        $errors = [];
        if($nombre["error"] ||  $apellido["error"] || $apellido["error"]){
            array_push($errors,$nombre["error"]);
            array_push($errors,$apellido["error"]);
            array_push($errors,$correo["error"]);
            array_push($errors,$rol["error"]);
        }
        $formattedErrors = array ("errors" => array_values(array_filter($errors)));
      
        //Si no existen errores continuar con la ejecución
        if(!$formattedErrors["errors"]){

            //Validar que no exista un correo igual
            $Usuarios = new usersModel();
            $usuarios = $Usuarios->search_user($correo["value"]);

            if($usuarios){
                $response = array(
                    "status" => 400,
                    "error" => "El correo proporcionado ya existe, por favor coloque otro",
                );
            
                http_response_code(400);
                echo json_encode($response, true);
                return;
            }
            //Generar password 
            $salt = 'secretpswd';
            $pass = md5('90SY@@v9tDc'.$salt);

            $data = array(
                "nombre" => $nombre["value"],
                "apellido" => $apellido["value"],
                "pass" => $pass,
                "correo" => $correo["value"],
                "rol" => $rol["value"],
            );

            //Crear el usuario
            $Usuarios = new usersModel();
            $usuarios = $Usuarios->create($data);
        
            //Enviar mensaje del resultado de la operación
            if($usuarios){
                $response = array(
                    "status" => 200,
                    "message" => "Usuario registrado correctamente"
                );
            
                http_response_code(200);
                echo json_encode($response, true);
                return;

            }else{
                $response = array(
                    "status" => 500,
                    "error" => "Error al insertar un usuario",
                );
            
                http_response_code(500);
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