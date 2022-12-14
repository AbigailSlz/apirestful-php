<?php

function validation_string($value, $type, $campo){

    switch($type){
        case 'string':
                
            if(!empty($value)){

                if(preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚÑñ ]+$/', $value)){
                   
                    $response = array(
                        "status" => true,
                        "value" => $value,
                        "error" => "",
                    );
                
                    return $response;

                }else{

                    $response = array(
                        "status" => false,
                        "value"=> "",
                        "error" => "Error en el campo ".$campo.", solo se permiten letras",
                    );
                
                    return $response;

                }
               
            }else{

                $response = array(
                    "status" => false,
                    "value"=> "",
                    "error" => "Error en el campo ".$campo.", no se permiten valores vacíos",
                );
            
                return $response;
            }
            
            break;
            case 'rol':
                
                if(!empty($value)){
    
                    if(preg_match('/^[a-z]+$/', $value)){
                       
                        $response = array(
                            "status" => true,
                            "value" => $value,
                            "error" => "",
                        );
                    
                        return $response;
    
                    }else{
    
                        $response = array(
                            "status" => false,
                            "value"=> "",
                            "error" => "Error en el campo ".$campo.", solo se permiten letras",
                        );
                    
                        return $response;
    
                    }
                   
                }else{
    
                    $response = array(
                        "status" => false,
                        "value"=> "",
                        "error" => "Error en el campo ".$campo.", no se permiten valores vacíos",
                    );
                
                    return $response;
                }
                
                break;
            case 'publication':
                
                if(!empty($value)){
    
                    if(preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚÑñ0123456789,.""@ ]+$/', $value)){
                       
                        $response = array(
                            "status" => true,
                            "value" => $value,
                            "error" => "",
                        );
                    
                        return $response;
    
                    }else{
    
                        $response = array(
                            "status" => false,
                            "value"=> "",
                            "error" => "Error en el campo ".$campo.", solo se permiten caracteres alfanuméricos",
                        );
                    
                        return $response;
    
                    }
                   
                }else{
    
                    $response = array(
                        "status" => false,
                        "value"=> "",
                        "error" => "Error en el campo ".$campo.", no se permiten valores vacíos",
                    );
                
                    return $response;
                }
                
                break;
        case 'email':

            if(!empty($value)){

                if(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $value)){
                    $response = array(
                        "status" => true,
                        "value" => $value,
                        "error" => "",
                    );
                
                    return $response;
                }else{
                    $response = array(
                        "status" => false,
                        "value"=> "",
                        "error" => "Error en el campo ".$campo.", correo no válido",
                    );
                
                    return $response;
                }

            }else{
                
                $response = array(
                    "status" => false,
                    "value"=> "",
                    "error" => "Error en el campo ".$campo.", no se permiten valores vacíos",
                );
            
                return $response;

            }

            break;
        case 'password':
            if(!empty($value)){

               
                $response = array(
                    "status" => true,
                    "value" => $value,
                    "error" => "",
                );
            
                return $response;
            
            }else{
                
                $response = array(
                    "status" => false,
                    "value"=> "",
                    "error" => "Error en el campo ".$campo.", no se permiten valores vacíos",
                );
            
                return $response;

            }

            break;
        default:
            
            $response = array(
                "status" => false,
                "value"=> "",
                "error" => "Validación no encontrada",
            );
        
            return $response;
            break;
    }
}