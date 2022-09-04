<?php

use Firebase\JWT\JWT;

class token{

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

        if(empty($token)){

            return "Invalid token";
        }

        $decode = JWT::decode($token, $key, $encrypt);
        return $decode;
    }
}