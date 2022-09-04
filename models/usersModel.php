<?php

require_once "conexion.php";

class usersModel extends Connection{

    public function create($data){
        
        //Conectar a la base de datos
        $conexion = $this->connect_db();

        //Preparar la consulta
        $query = mysqli_prepare($conexion, "INSERT INTO users(nombre,apellidos,correo,pass,rol) VALUES(?,?,?,?,?)");
        // Comprobamos si la preparación se finalizó con éxito o hubo error 
        if ($query === false) {
          
            return false;
        }

        //Pasar los parámetros
        $query->bind_param("sssss",$data["nombre"],$data["apellido"],$data["correo"],$data["pass"],$data["rol"]);

        //Ejecutar la consulta
        $query->execute();

        // Comprobamos si la ejecución se finalizó con éxito o hubo error 
        if ($query === false) {

           return false;

        } else {
             return true;
        }
    }

    public function search_user($email){
 
        //Conectar a la base de datos
        $conexion = $this->connect_db();

        //Preparar la consulta
        $query = mysqli_prepare($conexion, "SELECT correo FROM users WHERE correo = ?");
        // Comprobamos si la preparación se finalizó con éxito o hubo error 
        if ($query === false) {
          
            return false;
        }

        //Pasar los parámetros
        $query->bind_param("s",$email);

        //Ejecutar la consulta
        $query->execute();
        
        // Comprobamos si la ejecución se finalizó con éxito o hubo error 
        if ($query === false) {

           return false;

        } else {

            return $query->get_result()->num_rows;
        }
    }

}