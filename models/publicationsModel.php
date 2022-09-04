<?php

require_once "conexion.php";

class PublicationsModel extends Connection{

    public function create($data){
        
        //Conectar a la base de datos
        $conexion = $this->connect_db();

        //Preparar la consulta
        $query = mysqli_prepare($conexion, "INSERT INTO publications(titulo,descripcion,id_user) VALUES(?,?,?)");
        
        // Comprobamos si la preparación se finalizó con éxito o hubo error 
        if ($query === false) {
          
            return false;
        }

        //Pasar los parámetros
        $query->bind_param("ssi",$data["titulo"],$data["descripcion"],$data["id_user"]);

        //Ejecutar la consulta
        $query->execute();

        // Comprobamos si la ejecución se finalizó con éxito o hubo error 
        if ($query === false) {

           return false;

        } else {
             return true;
        }
    }

    public function update($data){
        
        //Conectar a la base de datos
        $conexion = $this->connect_db();

        //Preparar la consulta
        $query = mysqli_prepare($conexion, "UPDATE publications SET titulo=?, descripcion=? WHERE id_publicacion=?");
        
        // Comprobamos si la preparación se finalizó con éxito o hubo error 
        if ($query === false) {
          
            return false;
        }

        //Pasar los parámetros
        $query->bind_param("ssi",$data["titulo"],$data["descripcion"],$data["id_publicacion"]);

        //Ejecutar la consulta
        $query->execute();

        // Comprobamos si la ejecución se finalizó con éxito o hubo error 
        if ($query === false) {

           return false;

        } else {
             return true;
        }
    }

    public function search_publication($id_publicacion){
 
        //Conectar a la base de datos
        $conexion = $this->connect_db();

        //Preparar la consulta
        $query = mysqli_prepare($conexion, "SELECT id_publicacion, estado FROM publications WHERE id_publicacion = ?");
       
        // Comprobamos si la preparación se finalizó con éxito o hubo error 
        if ($query === false) {
          
            return false;
        }

        //Pasar los parámetros
        $query->bind_param("i",$id_publicacion);

        //Ejecutar la consulta
        $query->execute();
        
        // Comprobamos si la ejecución se finalizó con éxito o hubo error 
        if ($query === false) {

           return false;

        } else {

            return $query->get_result();
        }
    }

    public function read(){
 
        //Conectar a la base de datos
        $conexion = $this->connect_db();

        //Preparar la consulta
        $query = mysqli_prepare($conexion, "SELECT id_publicacion, titulo, descripcion, fecha_creacion, estado, users.id_user, users.nombre, users.rol FROM publications LEFT JOIN users ON publications.id_user = users.id_user WHERE estado=1");
       
        // Comprobamos si la preparación se finalizó con éxito o hubo error 
        if ($query === false) {
          
            return false;
        }

        //Ejecutar la consulta
        $query->execute();
        
        // Comprobamos si la ejecución se finalizó con éxito o hubo error 
        if ($query === false) {

           return false;

        } else {

            return $query->get_result();
        }
    }

    public function change_status($id_publicacion){
        
        //Conectar a la base de datos
        $conexion = $this->connect_db();

        //Preparar la consulta
        $query = mysqli_prepare($conexion, "UPDATE publications SET estado=? WHERE id_publicacion=?");
        
        // Comprobamos si la preparación se finalizó con éxito o hubo error 
        if ($query === false) {
          
            return false;
        }

        $estado=0;

        //Pasar los parámetros
        $query->bind_param("ii",$estado,$id_publicacion);

        //Ejecutar la consulta
        $query->execute();

        // Comprobamos si la ejecución se finalizó con éxito o hubo error 
        if ($query === false) {

           return false;

        } else {
             return true;
        }
    }
}