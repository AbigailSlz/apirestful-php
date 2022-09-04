<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Token{

    public function generateJWT($userId, $rol){

        $startTime = time();
        $key = 'secretKeyApiTokenGeniat2022';
        $encrypt = 'HS256';

        $token = array(
            "iat" => $startTime, //Tiempo en el que inició el token
            "exp" => $startTime + (60*1440), //Tiempo en el que expirará el token (24 hras)
            "data" => [
                "id_user" => $userId,
                "rol" => $rol,
            ]
        );
        
        $jwt = JWT::encode($token, $key, $encrypt);
        return $jwt;
    }

    public function verifyJWT($token){
        $key = 'secretKeyApiTokenGeniat2022';
        $encrypt = 'HS256';

        try{

            if(empty($token)){

                $response = array(
                    "status" => 400,
                    "error" => "No hay un token en la petición",
                );
            
                http_response_code(400);
                echo json_encode($response, true);
                return;
            }
    
            $decoded = JWT::decode($token, new Key($key, $encrypt));
            return $decoded;
            
        }catch(Exception $e){

            $response = array(
                "status" => 400,
                "error" => "Token inválido",
            );
        
            http_response_code(400);
            echo json_encode($response, true);
            return false;
        }
        
    }
}