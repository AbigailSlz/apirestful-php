<?php

class Permissions{

    public function verify_rol($rol, $method){
              
        switch($rol){
            case 'basico':

                return false;
      
                break;
            case 'medio':

                if($method == 'get') {
                    return true;
                }else{
                    return false;
                }

                break;
            case 'medio-alto':
  
                if($method == 'post') {
                    return true;
                }else{
                    return false;
                }

                break;
            case 'alto-medio':
                if($method == 'post' || $method == 'get' || $method =='put') {
                    return true;
                }else{
                    return false;
                }
                break;
            case 'alto':
                if($method == 'post' || $method == 'get' || $method =='put' || $method == 'delete') {
                    return true;
                }else{
                    return false;
                }
                break;
        }
    }

}