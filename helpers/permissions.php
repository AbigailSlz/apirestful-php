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
            case 'medioalto':
  
                if($method == 'post') {
                    return true;
                }else{
                    return false;
                }

                break;
            case 'altomedio':
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
            default:
                return false;
            break;
        }
    }

}