<?php

class Connection {
    
    
    public function connect_db(){

   
            //Variables para la conexión
            $db_host="localhost";
            $db_usuario="root";
            $db_password = "";
            $db_base ="geniat";

            //Cadena conexión
            $connection = new mysqli($db_host,$db_usuario,$db_password,$db_base);
            
            if($connection->connect_errno){

                $response = array(
                    "status" => 500,
                    "error" => "Falló al conectar a la base de datos ".$connection->connect_errno." ".$connection->connect_error
                );
                http_response_code(500);
                echo json_encode($response, true);
                exit();
            }

            //Especificar la codificación de caracteres
            $connection->set_charset('utf8');

            return $connection;
    }
}