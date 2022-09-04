<?php

class PublicationsController{

    public function create($id_user){

        //Obtener datos por json y decodificarlos
        $rawinput = file_get_contents("php://input");
        $json = json_decode($rawinput);

        //Validar si es petición post o json
        if($json){
            //Verificar si existe la variable esperada
            $titulo   = isset($json->titulo) ? $json->titulo:'';
            $descripcion = isset($json->descripcion) ? $json->descripcion:'';
        }else{
            $titulo   = isset($_POST["titulo"])? $_POST["titulo"]:'';
            $descripcion = isset($_POST["descripcion"])? $_POST["descripcion"]:'';
        }
        
        //Validar caracteres
        $titulo = validation_string($titulo,'publication','titulo');
        $descripcion = validation_string($descripcion,'publication','descripcion');

        //Dar formato a los errores
        $errors = [];
        if($titulo["error"] ||  $descripcion["error"]){
            array_push($errors,$titulo["error"]);
            array_push($errors,$descripcion["error"]);
        }
        $formattedErrors = array ("errors" => array_values(array_filter($errors)));
        
        //Si no existen errores continuar con la ejecución
        if(!$formattedErrors["errors"]){

            $data = array(
                "titulo" => $titulo["value"],
                "descripcion" => $descripcion["value"],
                "id_user" => $id_user,
            );

            //Crear la publicación
            $Pulication = new PublicationsModel();
            $publication = $Pulication->create($data);
        
            //Enviar mensaje del resultado de la operación
            if($publication){
                $response = array(
                    "status" => 200,
                    "message" => "Publicación registrada correctamente"
                );
            
                http_response_code(200);
                echo json_encode($response, true);
                return;

            }else{
                $response = array(
                    "status" => 500,
                    "error" => "Error al insertar la publicación",
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

    public function update($id_publication){

        //Obtener datos por json y decodificarlos
        $rawinput = file_get_contents("php://input");
        $json = json_decode($rawinput);

        //Validar si es petición post o json
        if($json){
            //Verificar si existe la variable esperada
            $titulo   = isset($json->titulo) ? $json->titulo:'';
            $descripcion = isset($json->descripcion) ? $json->descripcion:'';
        }else{
            $titulo   = isset($_POST["titulo"])? $_POST["titulo"]:'';
            $descripcion = isset($_POST["descripcion"])? $_POST["descripcion"]:'';
        }
        
        //Validar caracteres
        $titulo = validation_string($titulo,'publication','titulo');
        $descripcion = validation_string($descripcion,'publication','descripcion');

        //Dar formato a los errores
        $errors = [];
        if($titulo["error"] ||  $descripcion["error"]){
            array_push($errors,$titulo["error"]);
            array_push($errors,$descripcion["error"]);
        }
        $formattedErrors = array ("errors" => array_values(array_filter($errors)));
        
        //Si no existen errores continuar con la ejecución
        if(!$formattedErrors["errors"]){

            //Verificar si la publicación existe
            $Publication = new PublicationsModel();
            $publication = $Publication->search_publication($id_publication);

            if(!$publication->num_rows){
                $response = array(
                    "status" => 404,
                    "error" => "No se encontró la publicación",
                );
            
                http_response_code(404);
                echo json_encode($response, true);
                return;
            }


            foreach($publication as $key){

                if($key["estado"] == 0){
                    $response = array(
                        "status" => 404,
                        "error" => "Publicación no encontrada",
                    );
                
                    http_response_code(404);
                    echo json_encode($response, true);
                    return;
                }else{

                    $data = array(
                        "titulo" => $titulo["value"],
                        "descripcion" => $descripcion["value"],
                        "id_publicacion" => $id_publication
                    );
        
                    //Actualizar la publicación
                   
                    $publication = $Publication->update($data);
                
                    //Enviar mensaje del resultado de la operación
                    if($publication){
                        $response = array(
                            "status" => 200,
                            "message" => "Publicación actualizada correctamente"
                        );
                    
                        http_response_code(200);
                        echo json_encode($response, true);
                        return;
        
                    }else{
                        $response = array(
                            "status" => 500,
                            "error" => "Error al actualizar la publicación",
                        );
                    
                        http_response_code(500);
                        echo json_encode($response, true);
                        return;
                    }
                    
                }
            

            }

        }else{
            
            http_response_code(400);
            echo json_encode($formattedErrors, true);
            return;

        }
    }

    public function change_status($id_publication){

        //Cambiar de estado la publicación
        $Publication = new PublicationsModel();

         //Verificar si la publicación existe
         $Publication = new PublicationsModel();
         $publication = $Publication->search_publication($id_publication);

         if(!$publication->num_rows){
             $response = array(
                 "status" => 404,
                 "error" => "No se encontró la publicación",
             );
         
             http_response_code(404);
             echo json_encode($response, true);
             return;
         }

         foreach($publication as $key){

            if($key["estado"] == 0){
                $response = array(
                    "status" => 404,
                    "error" => "La publicación ya se encuentra desactivada",
                );
            
                http_response_code(404);
                echo json_encode($response, true);
                return;
            }else{

                $publication = $Publication->change_status($id_publication);

                //Enviar mensaje del resultado de la operación
                if($publication){
                    $response = array(
                        "status" => 200,
                        "message" => "Publicación desactivada correctamente"
                    );
                
                    http_response_code(200);
                    echo json_encode($response, true);
                    return;
        
                }else{
                    $response = array(
                        "status" => 500,
                        "error" => "Error al desactivar la publicación",
                    );
                
                    http_response_code(500);
                    echo json_encode($response, true);
                    return;
                }
            }
        }
    }
    public function read(){

        //Listar las publicaciones
        $Publication = new PublicationsModel();
        $publication = $Publication->read();
               
        //Enviar mensaje del resultado de la operación
        if($publication){
            
            $values['totalPublicaciones'] = $publication->num_rows;
            foreach($publication as $key){
              
                $data["id_publicacion"] = $key["id_publicacion"];
                $data["titulo"] = $key["titulo"];
                $data["descripcion"] = $key["descripcion"];
                $data["fecha_creacion"] = $key["fecha_creacion"];
                $data["usuario"] = array(
                    "nombre" => $key["nombre"],
                    "rol" => $key["rol"]
                );
                
                $values['publicaciones'][] = $data;
                
            }
 
            http_response_code(200);
            echo json_encode($values, true);       

            return;

        }else{
            $response = array(
                "status" => 500,
                "error" => "Error al listar las publicaciones",
            );
        
            http_response_code(500);
            echo json_encode($response, true);
            return;
        }
    }
    
}